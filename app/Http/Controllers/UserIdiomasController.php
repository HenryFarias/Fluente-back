<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UserIdiomaCreateRequest;
use App\Http\Requests\UserIdiomaUpdateRequest;
use App\Repositories\UserIdiomaRepository;
use App\Validators\UserIdiomaValidator;


class UserIdiomasController extends Controller
{

    /**
     * @var UserIdiomaRepository
     */
    protected $repository;

    /**
     * @var UserIdiomaModel
     */
    protected $model;

    public function __construct(UserIdiomaRepository $repository)
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
        $userIdiomas = $this->repository->all();

        return response()->json([
            'data' => $userIdiomas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserIdiomaCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserIdiomaCreateRequest $request)
    {
        try {
            $userIdioma = $this->repository->create($request->all());

            $response = [
                'message' => 'UserIdioma criado com sucsso.',
                'data'    => $userIdioma->toArray(),
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
        $userIdioma = $this->repository->find($id);

        return response()->json([
            'data' => $userIdioma,
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
        $userIdioma = $this->repository->find($id);

        return view('userIdiomas.edit', compact('userIdioma'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UserIdiomaUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(UserIdiomaUpdateRequest $request, $id)
    {
        try {
            $userIdioma = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'UserIdioma alterado com sucesso.',
                'data'    => $userIdioma->toArray(),
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
            'message' => 'UserIdioma excluído com sucesso.',
            'deleted' => $deleted,
        ]);
    }
}
