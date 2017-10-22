<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Endereco;
use App\Models\User;
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

    public function getAllForMaps($idUser)
    {
        return response()->json([
            'data' => $this->repository->getAllForMaps($idUser),
        ]);
    }

    public function getAll($idUser)
    {
        return response()->json([
            'data' => $this->repository->getAll($idUser),
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
    public function store(EventoCreateRequest $request, Cidade $cidade, Endereco $endereco, User $user)
    {
        try {
            $arrayIds = [];

            $cidade = $cidade->where('name', $request->endereco['cidade']['name'])->first();
            $endereco->fill($request->endereco);
            $endereco->cidade()->associate($cidade);
            $endereco->save();

            $this->model->fill($request->all());

            if (!empty($request->professor['name'])) {
                $this->model->professor()->associate($user->where('id', $request->professor['id'])->first());
            }

            $this->model->endereco()->associate($endereco);
            $this->model->nivel()->associate($this->nivel->getModel()->where('id', $request->nivel['id'])->first());
            $this->model->idioma()->associate($this->idioma->getModel()->where('id', $request->idioma['id'])->first());
            $this->model->dono()->associate($user->find($request->dono['id']));

            $this->model->save();

            foreach ($request->users as $user) {
                $arrayIds[] = $user['id'];
            }

            $this->model->users()->attach($arrayIds);

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
        $evento = $this->repository->with(['dono', 'nivel', 'endereco', 'idioma', 'users', 'professor'])->find($id);

        return response()->json([
            'data' => $evento,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  EventoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(EventoUpdateRequest $request, $id, Endereco $endereco,  Cidade $cidade, User $user)
    {
        try {
            $arrayIds = [];

            $evento = $this->repository->update($request->all(), $id);

            if ($evento->endereco->id != $request->endereco_id) {
                $cidade = $cidade->where('name', $request->endereco['cidade']['name'])->first();
                $endereco->fill($request->endereco);
                $endereco->cidade()->associate($cidade);
                $endereco->save();
                $evento->endereco()->associate($endereco);
            }

            $professor = $user->where('id', $request->professor['id'])->first();

            if (!empty($request->professor['id']) && $evento->professor_id != $professor->id) {
                $evento->professor()->associate($user->where('id', $request->professor['id'])->first());
            } else {
                $evento->professor()->dissociate($user->where('id', $request->professor['id'])->first());
            }

            $evento->nivel()->associate($this->nivel->getModel()->where('id', $request->nivel['id'])->first());
            $evento->idioma()->associate($this->idioma->getModel()->where('id', $request->idioma['id'])->first());
            $evento->save();

            foreach ($request->users as $user) {
                $arrayIds[] = $user['id'];
            }

            $evento->users()->sync($arrayIds);

            $response = [
                'message' => 'Evento alterado com sucesso.',
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
        $evento = $this->repository->find($id);
        $idUser = $evento->dono->id;
        $this->repository->delete($id);

        return response()->json([
            'message' => 'Evento excluído com sucesso.',
            'data' => $this->repository->getAll($idUser),
        ]);
    }
}
