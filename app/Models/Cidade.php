<?php

/**
 * Date: Thu, 17 Aug 2017 18:36:41 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Cidade
 * 
 * @property int $id
 * @property string $name
 * @property int $estado_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Estado $estado
 * @property \Illuminate\Database\Eloquent\Collection $eventos
 * @property \Illuminate\Database\Eloquent\Collection $users
 *
 * @package App\Models
 */
class Cidade extends Model implements Transformable
{
    use TransformableTrait;
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $casts = [
		'estado_id' => 'int'
	];

	protected $fillable = [
		'name',
		'estado_id'
	];

	public function estado()
	{
		return $this->belongsTo(\App\Models\Estado::class);
	}

	public function eventos()
	{
		return $this->hasMany(\App\Models\Evento::class);
	}

	public function endereco()
    {
        return $this->hasOne(\App\Models\Endereco::class);
    }
}