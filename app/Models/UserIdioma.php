<?php

/**
 * Date: Thu, 17 Aug 2017 18:36:42 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class UserIdioma
 * 
 * @property int $id
 * @property int $idioma_id
 * @property int $user_id
 * @property int $nivel_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Idioma $idioma
 * @property \App\Models\Nivei $nivei
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class UserIdioma extends Model implements Transformable
{
    use TransformableTrait;
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'user_idioma';

	protected $casts = [
		'idioma_id' => 'int',
		'user_id' => 'int',
		'nivel_id' => 'int'
	];

	protected $fillable = [
		'idioma_id',
		'user_id',
		'nivel_id'
	];

	public function idioma()
	{
		return $this->belongsTo(\App\Models\Idioma::class);
	}

	public function nivel()
	{
		return $this->belongsTo(\App\Models\Nivel::class, 'nivel_id');
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}
}