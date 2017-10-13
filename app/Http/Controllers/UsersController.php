<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Validators\UserValidator;
use App\Repositories\UserRepository;
use App\Repositories\IdiomaRepository;
use App\Repositories\NivelRepository;
use App\Repositories\NotificacaoRepository;
use App\Repositories\CidadeRepository;
use App\Repositories\EnderecoRepository;
use App\Repositories\UserIdiomaRepository;
use App\Repositories\PerfilRepository;


class UsersController extends Controller
{

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserModel
     */
    protected $model;

    private $idioma;
    private $nivel;
    private $notificacao;

    public function __construct(UserRepository $repository, IdiomaRepository $idioma, NivelRepository $nivel, NotificacaoRepository $notificacao)
    {
        $this->repository = $repository;
        $this->model = $repository->getModel();

        $this->idioma = $idioma;
        $this->nivel = $nivel;
        $this->notificacao = $notificacao;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $users = $this->repository->all();

        return response()->json([
            'data' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request, CidadeRepository $cidadeRepository, EnderecoRepository $enderecoRepository, UserIdiomaRepository $userIidiomaRepository, PerfilRepository $perfilRepository)
    {
        try {
            $cidade = $cidadeRepository->getModel()->where('name', $request->endereco['cidade']['name'])->first();
            $enderecoRepository->getModel()->fill($request->endereco);

            if (empty($request->formacao)) {
                $perfil = $perfilRepository->find(2);
            } else {
                $perfil = $perfilRepository->find(3);
            }

            $enderecoRepository->getModel()->cidade()->associate($cidade);
            $enderecoRepository->getModel()->save();

            $this->model->fill($request->all());

            $this->model->endereco()->associate($enderecoRepository->getModel());
            $this->model->perfil()->associate($perfil);

            $this->model->save();

//            $userIidiomaRepository->getModel()->user()->associate($this->model);
//            $userIidiomaRepository->getModel()->idioma()->associate($this->idioma->getModel()->where('name', $request->idioma['name'])->first());
//            $userIidiomaRepository->getModel()->nivel()->associate($this->nivel->getModel()->where('name', $request->nivel['name'])->first());
//            $userIidiomaRepository->getModel()->save();

            $response = [
                'message' => 'Usuário criado com sucesso.',
                'data'    => $this->model,
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return response()->json([
                'code'   => $e->getCode(),
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function create()
    {
        $data = [
            "idiomas" => $this->idioma->all(),
            "niveis" => $this->nivel->all(),
            "professores" => $this->repository->getAllProfessores(),
        ];

        return response()->json([
            'data' => $data,
        ]);
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
        $user = $this->repository->find($id);

        return response()->json([
            'data' => $user,
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
        $user = $this->repository->find($id);

        return view('users.edit', compact('user'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        try {
            $user = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'User alterado com sucesso.',
                'data'    => $user->toArray(),
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
            'message' => 'User excluído com sucesso.',
            'deleted' => $deleted,
        ]);
    }
}
