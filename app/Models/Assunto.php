<?php

/**
 * Date: Thu, 17 Aug 2017 18:36:41 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Assunto
 * 
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $eventos
 * @property \Illuminate\Database\Eloquent\Collection $questionarios
 *
 * @package App\Models
 */
class Assunto extends Model implements Transformable
{
    use TransformableTrait;
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $fillable = [
		'name'
	];

	public function eventos()
	{
		return $this->hasMany(\App\Models\Evento::class);
	}

	public function questionarios()
	{
		return $this->hasMany(\App\Models\Questionario::class);
	}
}