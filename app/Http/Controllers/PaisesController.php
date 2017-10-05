<?php

namespace App\Http\Controllers;

use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PaisCreateRequest;
use App\Http\Requests\PaisUpdateRequest;
use App\Repositories\PaisRepository;


class PaisesController extends Controller
{

    /**
     * @var PaisRepository
     */
    protected $repository;

    /**
     * @var PaisModel
     */
    protected $model;

    public function __construct(PaisRepository $repository)
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
        $paises = $this->repository->all();

        return response()->json([
            'data' => $paises,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PaisCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PaisCreateRequest $request)
    {
        try {
            $paise = $this->repository->create($request->all());

            $response = [
                'message' => 'Paise criado com sucsso.',
                'data'    => $paise->toArray(),
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
        $pais = $this->repository->find($id);

        return response()->json([
            'data' => $pais,
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
        $paise = $this->repository->find($id);

        return view('paises.edit', compact('paise'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  PaisUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(PaisUpdateRequest $request, $id)
    {
        try {
            $pais = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Pais alterado com sucesso.',
                'data'    => $pais->toArray(),
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
            'message' => 'Paise excluído com sucesso.',
            'deleted' => $deleted,
        ]);
    }
}
