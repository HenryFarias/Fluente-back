<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\NotificacoCreateRequest;
use App\Http\Requests\NotificacoUpdateRequest;
use App\Repositories\NotificacoRepository;
use App\Validators\NotificacoValidator;


class NotificacosController extends Controller
{

    /**
     * @var NotificacoRepository
     */
    protected $repository;

    /**
     * @var NotificacoModel
     */
    protected $model;

    public function __construct(NotificacoRepository $repository)
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
        $notificacos = $this->repository->all();

        return response()->json([
            'data' => $notificacos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NotificacoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(NotificacoCreateRequest $request)
    {
        try {
            $notificaco = $this->repository->create($request->all());

            $response = [
                'message' => 'Notificaco criado com sucsso.',
                'data'    => $notificaco->toArray(),
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
        $notificaco = $this->repository->find($id);

        return response()->json([
            'data' => $notificaco,
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
        $notificaco = $this->repository->find($id);

        return view('notificacos.edit', compact('notificaco'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  NotificacoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(NotificacoUpdateRequest $request, $id)
    {
        try {
            $notificaco = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Notificaco alterado com sucesso.',
                'data'    => $notificaco->toArray(),
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
            'message' => 'Notificaco excluído com sucesso.',
            'deleted' => $deleted,
        ]);
    }
}
