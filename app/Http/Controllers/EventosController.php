<?php

namespace App\Http\Controllers;

use App\Repositories\CidadeRepository;
use App\Repositories\IdiomaRepository;
use App\Repositories\NivelRepository;
use App\Repositories\EnderecoRepository;
use App\Repositories\UserEventoRepository;
use App\Repositories\UserEventoRepositoryEloquent;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\EventoCreateRequest;
use App\Http\Requests\EventoUpdateRequest;
use App\Repositories\EventoRepository;


class EventosController extends Controller
{

    /**
     * @var EventoRepository
     */
    protected $repository;

    /**
     * @var EventoModel
     */
    protected $model;

    private $nivel;
    private $idioma;

    public function __construct(EventoRepository $repository, NivelRepository $nivel, IdiomaRepository $idioma)
    {
        $this->repository = $repository;
        $this->model = $repository->getModel();
        $this->nivel = $nivel;
        $this->idioma = $idioma;
    }

    public function getAll($idUser)
    {
        return response()->json([
            'data' => $this->repository->getAllForMaps($idUser),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventos = $this->repository->with(['endereco'])->findByField('publico_ou_privado','publico');

        return response()->json([
            'data' => $eventos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EventoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EventoCreateRequest $request, CidadeRepository $cidadeRepository, EnderecoRepository $enderecoRepository, UserEventoRepository $userEventoDono, UserRepository $user)
    {
        try {
            $cidade = $cidadeRepository->getModel()->where('name', $request->endereco['cidade']['name'])->first();
            $enderecoRepository->getModel()->fill($request->endereco);
            $enderecoRepository->getModel()->cidade()->associate($cidade);
            $enderecoRepository->getModel()->save();

            $this->model->fill($request->all());

            $this->model->endereco()->associate($enderecoRepository->getModel());
            $this->model->nivel()->associate($this->nivel->getModel()->where('name', $request->nivel['name'])->first());
            $this->model->idioma()->associate($this->idioma->getModel()->where('name', $request->idioma['name'])->first());

            $this->model->save();

            $userEventoDono->dono = 1;
            $userEventoDono->getModel()->evento()->associate($this->model);
            $userEventoDono->getModel()->user()->associate($user->find($request->dono['id']));
            $userEventoDono->getModel()->save();

            if (!empty($request->professor['name'])) {
                $userEventoProfessor = App::make('App\\Repositories\\UserEventoRepository');
                $userEventoProfessor->professor = true;
                $userEventoProfessor->getModel()->evento()->associate($this->model);
                $userEventoProfessor->getModel()->user()->associate($user->getModel()->where('name', $request->professor['name'])->first());
                $userEventoProfessor->getModel()->save();
            }

            $response = [
                'message' => 'Evento criado com sucesso.',
                'data'    => $this->model,
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
        $evento = $this->repository->find($id);

        return response()->json([
            'data' => $evento,
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
        $evento = $this->repository->find($id);

        return view('eventos.edit', compact('evento'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  EventoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(EventoUpdateRequest $request, $id)
    {
        try {
            $evento = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Evento alterado com sucesso.',
                'data'    => $evento->toArray(),
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
            'message' => 'Evento excluído com sucesso.',
            'deleted' => $deleted,
        ]);
    }
}
