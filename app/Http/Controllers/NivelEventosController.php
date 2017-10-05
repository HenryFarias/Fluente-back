<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\NivelEventoCreateRequest;
use App\Http\Requests\NivelEventoUpdateRequest;
use App\Repositories\NivelEventoRepository;
use App\Validators\NivelEventoValidator;


class NivelEventosController extends Controller
{

    /**
     * @var NivelEventoRepository
     */
    protected $repository;

    /**
     * @var NivelEventoModel
     */
    protected $model;

    public function __construct(NivelEventoRepository $repository)
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
        $nivelEventos = $this->repository->all();

        return response()->json([
            'data' => $nivelEventos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NivelEventoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(NivelEventoCreateRequest $request)
    {
        try {
            $nivelEvento = $this->repository->create($request->all());

            $response = [
                'message' => 'NivelEvento criado com sucsso.',
                'data'    => $nivelEvento->toArray(),
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
        $nivelEvento = $this->repository->find($id);

        return response()->json([
            'data' => $nivelEvento,
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
        $nivelEvento = $this->repository->find($id);

        return view('nivelEventos.edit', compact('nivelEvento'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  NivelEventoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(NivelEventoUpdateRequest $request, $id)
    {
        try {
            $nivelEvento = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'NivelEvento alterado com sucesso.',
                'data'    => $nivelEvento->toArray(),
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
            'message' => 'NivelEvento excluído com sucesso.',
            'deleted' => $deleted,
        ]);
    }
}
