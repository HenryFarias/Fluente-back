<?php

/**
 * Date: Thu, 17 Aug 2017 18:36:42 +0000.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Evento
 * 
 * @property int $id
 * @property string $name
 * @property string $local
 * @property string $publico_ou_privado
 * @property \Carbon\Carbon $data
 * @property float $duracao
 * @property string $descricao
 * @property int $cidade_id
 * @property int $user_id
 * @property int $assunto_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Assunto $assunto
 * @property \App\Models\Cidade $cidade
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $comentarios
 * @property \Illuminate\Database\Eloquent\Collection $nivel_eventos
 * @property \Illuminate\Database\Eloquent\Collection $users
 *
 * @package App\Models
 */
class Evento extends Model implements Transformable
{
    use TransformableTrait;
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $casts = [
		'cidade_id' => 'int',
		'user_id' => 'int',
		'assunto_id' => 'int'
	];

	protected $dates = [
		'data'
	];

	protected $fillable = [
		'name',
		'publico_ou_privado',
		'data',
		'duracao',
		'descricao',
		'endereco_id',
		'user_id',
		'assunto_id'
	];

    // <MUTATORS>
    public function setDataAttribute($data)
    {
        $this->attributes['data'] = Carbon::parse($data);
    }
    // </MUTATORS>

	public function assunto()
	{
		return $this->belongsTo(\App\Models\Assunto::class);
	}

	public function endereco()
	{
		return $this->belongsTo(\App\Models\Endereco::class);
	}

    public function nivel()
    {
        return $this->belongsTo(\App\Models\Nivel::class);
    }

    public function idioma()
    {
        return $this->belongsTo(\App\Models\Idioma::class);
    }

	public function comentarios()
	{
		return $this->hasMany(\App\Models\Comentario::class);
	}

//	public function nivel_eventos()
//	{
//		return $this->hasMany(\App\Models\NivelEvento::class);
//	}

	public function users()
	{
		return $this->belongsToMany(\App\Models\User::class, 'user_evento', 'evento_id', 'user_id');
	}
}