<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\EstadoCreateRequest;
use App\Http\Requests\EstadoUpdateRequest;
use App\Repositories\EstadoRepository;
use App\Validators\EstadoValidator;


class EstadosController extends Controller
{

    /**
     * @var EstadoRepository
     */
    protected $repository;

    /**
     * @var EstadoModel
     */
    protected $model;

    public function __construct(EstadoRepository $repository)
    {
        $this->repository = $repository;
        $this->model = $repository->getModel();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $estados = $this->repository->all();

        return response()->json([
            'data' => $estados,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EstadoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EstadoCreateRequest $request)
    {
        try {
            $estado = $this->repository->create($request->all());

            $response = [
                'message' => 'Estado criado com sucsso.',
                'data'    => $estado->toArray(),
            ];

            return response()->json($response);
        } catch (ValidatorException $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $estado = $this->repository->find($id);

        return response()->json([
            'data' => $estado,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estado = $this->repository->find($id);

        return view('estados.edit', compact('estado'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  EstadoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(EstadoUpdateRequest $request, $id)
    {
        try {
            $estado = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Estado alterado com sucesso.',
                'data'    => $estado->toArray(),
            ];

            return response()->json($response);
        } catch (ValidatorException $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        return response()->json([
            'message' => 'Estado excluído com sucesso.',
            'deleted' => $deleted,
        ]);
    }
}
