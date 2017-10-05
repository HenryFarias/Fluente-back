<?php

/**
 * Date: Thu, 17 Aug 2017 18:36:41 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Comentario
 * 
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int $evento_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Evento $evento
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class Comentario extends Model implements Transformable
{
    use TransformableTrait;
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $casts = [
		'user_id' => 'int',
		'evento_id' => 'int'
	];

	protected $fillable = [
		'name',
		'user_id',
		'evento_id'
	];

	public function evento()
	{
		return $this->belongsTo(\App\Models\Evento::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}
}