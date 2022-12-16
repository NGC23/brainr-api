<?php

namespace App\Domain\Posts\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Post extends Model
{
	use HasFactory, Notifiable, HasUuids;

	 /**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'description',
		'tags',
		'open_post_till',
		'upload',
		'type',
		'user_id'
	];

	public function user(): HasOne
	{
		return $this->hasOne('App\Domain\User\Models\User');
	}
}
