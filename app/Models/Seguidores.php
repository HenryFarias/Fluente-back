<?php

/**
 * Date: Thu, 17 Aug 2017 18:36:42 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Seguidore
 * 
 * @property int $id
 * @property bool $aprovacao
 * @property int $user_id
 * @property int $userSeguido_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class Seguidores extends Model implements Transformable
{
    use TransformableTrait;
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $casts = [
		'aprovacao' => 'bool',
		'user_id' => 'int',
		'userSeguido_id' => 'int'
	];

    protected $table = "seguidores";

	protected $fillable = [
		'aprovacao',
		'user_id',
		'userSeguido_id'
	];

//	public function user()
//	{
//		return $this->belongsTo(\App\Models\User::class, 'userSeguido_id');
//	}
}