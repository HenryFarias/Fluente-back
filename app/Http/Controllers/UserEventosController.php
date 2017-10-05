<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UserEventoCreateRequest;
use App\Http\Requests\UserEventoUpdateRequest;
use App\Repositories\UserEventoRepository;
use App\Validators\UserEventoValidator;


class UserEventosController extends Controller
{

    /**
     * @var UserEventoRepository
     */
    protected $repository;

    /**
     * @var UserEventoModel
     */
    protected $model;

    public function __construct(UserEventoRepository $repository)
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
        $userEventos = $this->repository->all();

        return response()->json([
            'data' => $userEventos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserEventoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserEventoCreateRequest $request)
    {
        try {
            $userEvento = $this->repository->create($request->all());

            $response = [
                'message' => 'UserEvento criado com sucsso.',
                'data'    => $userEvento->toArray(),
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
        $userEvento = $this->repository->find($id);

        return response()->json([
            'data' => $userEvento,
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
        $userEvento = $this->repository->find($id);

        return view('userEventos.edit', compact('userEvento'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UserEventoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(UserEventoUpdateRequest $request, $id)
    {
        try {
            $userEvento = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'UserEvento alterado com sucesso.',
                'data'    => $userEvento->toArray(),
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
            'message' => 'UserEvento excluído com sucesso.',
            'deleted' => $deleted,
        ]);
    }
}
