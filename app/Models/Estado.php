<?php

/**
 * Date: Thu, 17 Aug 2017 18:36:42 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Estado
 * 
 * @property int $id
 * @property string $name
 * @property int $pais_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Paise $paise
 * @property \Illuminate\Database\Eloquent\Collection $cidades
 *
 * @package App\Models
 */
class Estado extends Model implements Transformable
{
    use TransformableTrait;
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $casts = [
		'pais_id' => 'int'
	];

	protected $fillable = [
		'name',
		'pais_id'
	];

	public function paise()
	{
		return $this->belongsTo(\App\Models\Paise::class, 'pais_id');
	}

	public function cidades()
	{
		return $this->hasMany(\App\Models\Cidade::class);
	}
}