<?php

namespace App\Http\Controllers;

use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\SeguidoreCreateRequest;
use App\Http\Requests\SeguidoreUpdateRequest;
use App\Repositories\SeguidoreRepository;
use App\Validators\SeguidoreValidator;


class SeguidoresController extends Controller
{

    /**
     * @var SeguidoreRepository
     */
    protected $repository;

    /**
     * @var SeguidoreModel
     */
    protected $model;

    public function __construct(SeguidoreRepository $repository)
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
        $seguidores = $this->repository->all();

        return response()->json([
            'data' => $seguidores,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SeguidoreCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SeguidoreCreateRequest $request)
    {
        try {
            $seguidore = $this->repository->create($request->all());

            $response = [
                'message' => 'Seguidore criado com sucsso.',
                'data'    => $seguidore->toArray(),
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
        $seguidore = $this->repository->find($id);

        return response()->json([
            'data' => $seguidore,
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
        $seguidore = $this->repository->find($id);

        return view('seguidores.edit', compact('seguidore'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  SeguidoreUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(SeguidoreUpdateRequest $request, $id)
    {
        try {
            $seguidore = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Seguidore alterado com sucesso.',
                'data'    => $seguidore->toArray(),
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
            'message' => 'Seguidore excluído com sucesso.',
            'deleted' => $deleted,
        ]);
    }
}
