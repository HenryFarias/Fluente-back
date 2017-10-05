<?php

/**
 * Date: Thu, 17 Aug 2017 18:36:42 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class UserEvento
 * 
 * @property int $id
 * @property bool $aceite_professor
 * @property int $evento_id
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Evento $evento
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class UserEvento extends Model implements Transformable
{
    use TransformableTrait;
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'user_evento';

	protected $casts = [
		'aceite_professor' => 'bool',
		'evento_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'aceite_professor',
		'evento_id',
		'user_id'
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