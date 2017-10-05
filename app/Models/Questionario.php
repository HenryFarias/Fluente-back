<?php

/**
 * Date: Thu, 17 Aug 2017 18:36:42 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Questionario
 * 
 * @property int $id
 * @property string $name
 * @property int $assunto_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\Assunto $assunto
 *
 * @package App\Models
 */
class Questionario extends Model implements Transformable
{
    use TransformableTrait;
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $casts = [
		'assunto_id' => 'int'
	];

	protected $fillable = [
		'name',
		'assunto_id'
	];

	public function assunto()
	{
		return $this->belongsTo(\App\Models\Assunto::class);
	}
}