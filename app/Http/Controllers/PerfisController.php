<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PerfiCreateRequest;
use App\Http\Requests\PerfiUpdateRequest;
use App\Repositories\PerfiRepository;
use App\Validators\PerfiValidator;


class PerfisController extends Controller
{

    /**
     * @var PerfiRepository
     */
    protected $repository;

    /**
     * @var PerfiModel
     */
    protected $model;

    public function __construct(PerfiRepository $repository)
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
        $perfis = $this->repository->all();

        return response()->json([
            'data' => $perfis,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PerfiCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PerfiCreateRequest $request)
    {
        try {
            $perfi = $this->repository->create($request->all());

            $response = [
                'message' => 'Perfi criado com sucsso.',
                'data'    => $perfi->toArray(),
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
        $perfi = $this->repository->find($id);

        return response()->json([
            'data' => $perfi,
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
        $perfi = $this->repository->find($id);

        return view('perfis.edit', compact('perfi'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  PerfiUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(PerfiUpdateRequest $request, $id)
    {
        try {
            $perfi = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Perfi alterado com sucesso.',
                'data'    => $perfi->toArray(),
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
            'message' => 'Perfi excluído com sucesso.',
            'deleted' => $deleted,
        ]);
    }
}
