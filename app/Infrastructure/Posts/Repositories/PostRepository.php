<?php declare(strict_types=1);

namespace App\Infrastructure\Posts\Repositories;

use App\Domain\Posts\Contracts\IPostRepository;
use App\Domain\Posts\Exceptions\PostRepositoryException;
use App\Domain\Posts\Models\Post As PostEntity;
use App\Domain\Posts\ValueObjects\Post;
use App\Domain\User\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class PostRepository implements IPostRepository {

	/**
	 * @inheritDoc
	 */
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
		Log::info("Post created for userID: {$post->getUserId()}");
	}

	/**
	 * @inheritDoc
	 */
	public function getAllPosts(User $user): array
	{
		try {
			$posts = $user->posts;
		} catch (Exception $e) {
			Log::error(
				"Error fetching post for user {$user->id}",
				[
					'error' => $e->getMessage()
				]
			);
			throw new PostRepositoryException(
				"Failed fetching post with error: {$e->getMessage()} for userID: {$user->id}",
				(int) $e->getCode(),
				$e
			);
		}
		Log::info("Post retrieved for userID: {$user->getUserId()}");
		//is it worth to cast to VO's when we will have to cast back to array to serve to user ?
		return $posts->toArray();
	}
 
}