<?php

/**
 * Date: Thu, 17 Aug 2017 18:36:42 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Nivel
 * 
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $nivel_eventos
 * @property \Illuminate\Database\Eloquent\Collection $user_idiomas
 *
 * @package App\Models
 */
class Nivel extends Model implements Transformable
{
    use TransformableTrait;
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $table = 'niveis';

	protected $fillable = [
		'name'
	];

	public function nivel_eventos()
	{
		return $this->hasMany(\App\Models\NivelEvento::class, 'nivel_id');
	}

	public function user_idiomas()
	{
		return $this->hasMany(\App\Models\UserIdioma::class, 'nivel_id');
	}
}