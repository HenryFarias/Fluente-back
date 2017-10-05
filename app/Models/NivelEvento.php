<?php

/**
 * Date: Thu, 17 Aug 2017 18:36:42 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class NivelEvento
 * 
 * @property int $id
 * @property int $nivel_id
 * @property int $evento_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Evento $evento
 * @property \App\Models\Nivei $nivei
 *
 * @package App\Models
 */
class NivelEvento extends Model implements Transformable
{
    use TransformableTrait;
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'nivel_evento';

	protected $casts = [
		'nivel_id' => 'int',
		'evento_id' => 'int'
	];

	protected $fillable = [
		'nivel_id',
		'evento_id'
	];

	public function evento()
	{
		return $this->belongsTo(\App\Models\Evento::class);
	}

	public function nivei()
	{
		return $this->belongsTo(\App\Models\Nivei::class, 'nivel_id');
	}
}