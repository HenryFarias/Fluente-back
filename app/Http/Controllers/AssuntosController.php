<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AssuntoCreateRequest;
use App\Http\Requests\AssuntoUpdateRequest;
use App\Repositories\AssuntoRepository;
use App\Validators\AssuntoValidator;


class AssuntosController extends Controller
{

    /**
     * @var AssuntoRepository
     */
    protected $repository;

    /**
     * @var AssuntoModel
     */
    protected $model;

    public function __construct(AssuntoRepository $repository)
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
        $assuntos = $this->repository->all();

        return response()->json([
            'data' => $assuntos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AssuntoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AssuntoCreateRequest $request)
    {
        try {
            $assunto = $this->repository->create($request->all());

            $response = [
                'message' => 'Assunto criado com sucsso.',
                'data'    => $assunto->toArray(),
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
        $assunto = $this->repository->find($id);

        return response()->json([
            'data' => $assunto,
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
        $assunto = $this->repository->find($id);

        return view('assuntos.edit', compact('assunto'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  AssuntoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(AssuntoUpdateRequest $request, $id)
    {
        try {
            $assunto = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Assunto alterado com sucesso.',
                'data'    => $assunto->toArray(),
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
            'message' => 'Assunto excluído com sucesso.',
            'deleted' => $deleted,
        ]);
    }
}
