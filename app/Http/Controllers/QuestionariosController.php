<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\QuestionarioCreateRequest;
use App\Http\Requests\QuestionarioUpdateRequest;
use App\Repositories\QuestionarioRepository;
use App\Validators\QuestionarioValidator;


class QuestionariosController extends Controller
{

    /**
     * @var QuestionarioRepository
     */
    protected $repository;

    /**
     * @var QuestionarioModel
     */
    protected $model;

    public function __construct(QuestionarioRepository $repository)
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
        $questionarios = $this->repository->all();

        return response()->json([
            'data' => $questionarios,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  QuestionarioCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionarioCreateRequest $request)
    {
        try {
            $questionario = $this->repository->create($request->all());

            $response = [
                'message' => 'Questionario criado com sucsso.',
                'data'    => $questionario->toArray(),
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
        $questionario = $this->repository->find($id);

        return response()->json([
            'data' => $questionario,
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
        $questionario = $this->repository->find($id);

        return view('questionarios.edit', compact('questionario'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  QuestionarioUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(QuestionarioUpdateRequest $request, $id)
    {
        try {
            $questionario = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Questionario alterado com sucesso.',
                'data'    => $questionario->toArray(),
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
            'message' => 'Questionario excluído com sucesso.',
            'deleted' => $deleted,
        ]);
    }
}
