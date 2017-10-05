<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ComentarioCreateRequest;
use App\Http\Requests\ComentarioUpdateRequest;
use App\Repositories\ComentarioRepository;
use App\Validators\ComentarioValidator;


class ComentariosController extends Controller
{

    /**
     * @var ComentarioRepository
     */
    protected $repository;

    /**
     * @var ComentarioModel
     */
    protected $model;

    public function __construct(ComentarioRepository $repository)
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
        $comentarios = $this->repository->all();

        return response()->json([
            'data' => $comentarios,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ComentarioCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ComentarioCreateRequest $request)
    {
        try {
            $comentario = $this->repository->create($request->all());

            $response = [
                'message' => 'Comentario criado com sucsso.',
                'data'    => $comentario->toArray(),
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
        $comentario = $this->repository->find($id);

        return response()->json([
            'data' => $comentario,
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
        $comentario = $this->repository->find($id);

        return view('comentarios.edit', compact('comentario'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  ComentarioUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(ComentarioUpdateRequest $request, $id)
    {
        try {
            $comentario = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Comentario alterado com sucesso.',
                'data'    => $comentario->toArray(),
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
            'message' => 'Comentario excluído com sucesso.',
            'deleted' => $deleted,
        ]);
    }
}
