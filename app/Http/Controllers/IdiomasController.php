<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\IdiomaCreateRequest;
use App\Http\Requests\IdiomaUpdateRequest;
use App\Repositories\IdiomaRepository;
use App\Validators\IdiomaValidator;


class IdiomasController extends Controller
{

    /**
     * @var IdiomaRepository
     */
    protected $repository;

    /**
     * @var IdiomaModel
     */
    protected $model;

    public function __construct(IdiomaRepository $repository)
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
        $idiomas = $this->repository->all();

        return response()->json([
            'data' => $idiomas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  IdiomaCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(IdiomaCreateRequest $request)
    {
        try {
            $idioma = $this->repository->create($request->all());

            $response = [
                'message' => 'Idioma criado com sucsso.',
                'data'    => $idioma->toArray(),
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
        $idioma = $this->repository->find($id);

        return response()->json([
            'data' => $idioma,
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
        $idioma = $this->repository->find($id);

        return view('idiomas.edit', compact('idioma'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  IdiomaUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(IdiomaUpdateRequest $request, $id)
    {
        try {
            $idioma = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Idioma alterado com sucesso.',
                'data'    => $idioma->toArray(),
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
            'message' => 'Idioma excluído com sucesso.',
            'deleted' => $deleted,
        ]);
    }
}
