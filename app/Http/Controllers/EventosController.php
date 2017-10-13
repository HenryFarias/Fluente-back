<?php

namespace App\Http\Controllers;

use App\Interfaces\CidadeRepository;
use App\Interfaces\IdiomaRepository;
use App\Interfaces\NivelRepository;
use App\Repositories\EnderecoRepository;
use App\Repositories\UserEventoRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\EventoCreateRequest;
use App\Http\Requests\EventoUpdateRequest;
use App\Repositories\EventoRepository;
use App\Validators\EventoValidator;


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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $eventos = $this->repository->all();

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
    public function store(EventoCreateRequest $request, CidadeRepository $cidadeRepository, EnderecoRepository $enderecoRepository, UserEventoRepository $userEvento)
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

            $userEvento->getModel()->user()->associate($this->model);
            $userEvento->getModel()->idioma()->associate($this->idioma->getModel()->where('name', $request->idioma['name'])->first());
            $userEvento->getModel()->nivel()->associate($this->nivel->getModel()->where('name', $request->nivel['name'])->first());
            $userEvento->getModel()->save();

            $response = [
                'message' => 'Evento criado com sucsso.',
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
