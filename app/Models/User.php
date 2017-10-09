<?php

/**
 * Date: Thu, 17 Aug 2017 18:36:42 +0000.
 */

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $sobrenome
 * @property string $foto
 * @property int $idade
 * @property string $sexo
 * @property int $telefone
 * @property int $celular
 * @property string $endereco
 * @property string $email
 * @property string $formacao
 * @property string $habilidades
 * @property string $password
 * @property int $cidade_id
 * @property int $notificacao_id
 * @property int $perfil_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Cidade $cidade
 * @property \App\Models\Notificaco $notificaco
 * @property \App\Models\Perfi $perfi
 * @property \Illuminate\Database\Eloquent\Collection $comentarios
 * @property \Illuminate\Database\Eloquent\Collection $eventos
 * @property \Illuminate\Database\Eloquent\Collection $seguidores
 * @property \Illuminate\Database\Eloquent\Collection $idiomas
 *
 * @package App\Models
 */
class User extends Authenticatable implements Transformable
{
    use Notifiable, TransformableTrait;
    use TransformableTrait;
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $casts = [
		'idade' => 'int',
		'telefone' => 'int',
		'celular' => 'int',
		'cidade_id' => 'int',
		'notificacao_id' => 'int',
		'perfil_id' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'name',
		'sobrenome',
		'foto',
		'idade',
		'sexo',
		'telefone',
		'celular',
		'email',
		'formacao',
		'habilidades',
		'password',
		'cidade_id',
		'notificacao_id',
		'perfil_id'
	];

    // <MUTATORS>
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
    // </MUTATORS>

	public function notificacao()
	{
		return $this->belongsTo(\App\Models\Notificacao::class, 'notificacao_id');
	}

	public function perfil()
	{
		return $this->belongsTo(\App\Models\Perfil::class, 'perfil_id');
	}

	public function comentarios()
	{
		return $this->hasMany(\App\Models\Comentario::class);
	}

	public function eventos()
	{
		return $this->belongsToMany(\App\Models\Evento::class, 'user_evento')
					->withPivot('id', 'aceite_professor', 'deleted_at')
					->withTimestamps();
	}

	public function seguidores()
	{
		return $this->hasMany(\App\Models\Seguidores::class, 'userSeguido_id');
	}

	public function idiomas()
	{
		return $this->belongsToMany(\App\Models\Idioma::class, 'user_idioma')
					->withPivot('id', 'nivel_id', 'deleted_at')
					->withTimestamps();
	}

	public function enderecos()
	{
		return $this->hasMany(\App\Models\Endereco::class, 'user_id');
	}
}