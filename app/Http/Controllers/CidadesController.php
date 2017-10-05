<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CidadeCreateRequest;
use App\Http\Requests\CidadeUpdateRequest;
use App\Repositories\CidadeRepository;
use App\Validators\CidadeValidator;


class CidadesController extends Controller
{

    /**
     * @var CidadeRepository
     */
    protected $repository;

    /**
     * @var CidadeModel
     */
    protected $model;

    public function __construct(CidadeRepository $repository)
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
        $cidades = $this->repository->all();

        return response()->json([
            'data' => $cidades,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CidadeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CidadeCreateRequest $request)
    {
        try {
            $cidade = $this->repository->create($request->all());

            $response = [
                'message' => 'Cidade criado com sucsso.',
                'data'    => $cidade->toArray(),
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
        $cidade = $this->repository->find($id);

        return response()->json([
            'data' => $cidade,
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
        $cidade = $this->repository->find($id);

        return view('cidades.edit', compact('cidade'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  CidadeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(CidadeUpdateRequest $request, $id)
    {
        try {
            $cidade = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Cidade alterado com sucesso.',
                'data'    => $cidade->toArray(),
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
            'message' => 'Cidade excluído com sucesso.',
            'deleted' => $deleted,
        ]);
    }
}
