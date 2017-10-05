<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\NiveiCreateRequest;
use App\Http\Requests\NiveiUpdateRequest;
use App\Repositories\NiveiRepository;
use App\Validators\NiveiValidator;


class NiveisController extends Controller
{

    /**
     * @var NiveiRepository
     */
    protected $repository;

    /**
     * @var NiveiModel
     */
    protected $model;

    public function __construct(NiveiRepository $repository)
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
        $niveis = $this->repository->all();

        return response()->json([
            'data' => $niveis,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NiveiCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(NiveiCreateRequest $request)
    {
        try {
            $nivei = $this->repository->create($request->all());

            $response = [
                'message' => 'Nivei criado com sucsso.',
                'data'    => $nivei->toArray(),
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
        $nivei = $this->repository->find($id);

        return response()->json([
            'data' => $nivei,
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
        $nivei = $this->repository->find($id);

        return view('niveis.edit', compact('nivei'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  NiveiUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(NiveiUpdateRequest $request, $id)
    {
        try {
            $nivei = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Nivei alterado com sucesso.',
                'data'    => $nivei->toArray(),
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
            'message' => 'Nivei excluído com sucesso.',
            'deleted' => $deleted,
        ]);
    }
}
