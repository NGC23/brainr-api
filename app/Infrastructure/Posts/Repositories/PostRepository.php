<?php declare(strict_types=1);

namespace App\Infrastructure\Posts\Repositories;

use App\Domain\Posts\Contracts\IPostRepository;
use App\Domain\Posts\Exceptions\PostRepositoryException;
use App\Domain\Posts\Models\Post As PostEntity;
use App\Domain\Posts\ValueObjects\Post;
use Exception;
use Illuminate\Support\Facades\Log;

class PostRepository implements IPostRepository {

	public function create(Post $post): void 
	{
		try {
			PostEntity::create($post->toArray());
		} catch (Exception $e) {
			Log::error(
				"Error saving post for user {$post->getUserId()}",
				[
					'error' => $e->getMessage()
				]
			);
			throw new PostRepositoryException(
				"Failed creating post with error: {$e->getMessage()} for type: {$post->getType()} for userID: {$post->getUserId()}",
				(int) $e->getCode(),
				$e
			);
		}
	}

 public function delete(): void
 {
  
 }
 
}