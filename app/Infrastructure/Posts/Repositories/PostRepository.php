<?php declare(strict_types=1);

namespace App\Infrastructure\Posts\Repositories;

use App\Domain\Posts\Contracts\IPostRepository;
use App\Domain\Posts\Exceptions\PostRepositoryException;
use App\Domain\Posts\Models\Post As PostEntity;
use App\Domain\Posts\ValueObjects\MediaPost;
use App\Domain\Posts\ValueObjects\Post;
use App\Domain\User\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostRepository implements IPostRepository {
	//TODO: This will become mediaPost repo

	/**
	 * @inheritDoc
	 */
	public function create(MediaPost $post): void 
	{
		try {
			log::info("image name return", ['context' => $this->savePostMedia($post)]);
			$post = $post->withUpload($this->savePostMedia($post));
			log::info("post", ['context' => $post->toArray()]);
		} catch(PostRepositoryException) {
			Log::error("Something went wrong with upload for userID {$post->getUserId()}");
		}

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
			$posts = $user->posts()->orderBy('created_at', 'DESC')->get();
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
		Log::info("Posts retrieved for userID: {$user->id}");
		//is it worth to cast to VO's when we will have to cast back to array to serve to user ?
		return $posts->toArray();
	}

	/**
	 * @inheritDoc
	 */
	public function getPostById(
		User $user, 
		string $postId
	): Post {
		try {
			$post = $user->posts()->where('id', '=', $postId)->get();
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
		Log::info("Post - {$postId} retrieved for userID: {$user->id}");
		//is it worth to cast to VO's when we will have to cast back to array to serve to user ?
		return array_map(function (array $post) {
			return new MediaPost(
				$post['name'],
				$post['description'],
				$this->retrievePostMedia($post['upload']),
				$post['type'],
				$post['user_id'],
				explode(',', $post['tags']),
				$post['id']
			);
		}, $post->toArray())[0];
	}


	/*
	* //TODO: Extract all functions below to media repository
	* 
	*/

	private function retrievePostMedia(string $fileName): string
	{
		Log::info("Retrieving post media - {$fileName}");

		try {
			$file = Storage::disk('local')->get($fileName);
		} catch (Exception $e) {
			Log::error("Could not retrieve post media - {$fileName}");
			throw new PostRepositoryException(
				"Could not retrive post Media", 
				0, 
				$e
			);
		}

		Log::info("Retrieved post media - {$fileName}");
		return base64_encode($file);
	}

	/*
	* Returns filename
	*/
	private function savePostMedia(MediaPost $post): string
	{
		switch ($post->getType()) {
			case Post::VIDEO_TYPE:
				Log::info("saving media type video for post for userId: {$post->getUserId()}");
				Log::info("method not implemented yet, expect error");
				throw new PostRepositoryException("Not implemented");;
			
			case Post::IMAGE_TYPE:
				Log::info("saving media type image for post for userId: {$post->getUserId()}");
				return $this->saveImage($post->getUpload());
		}

		Log::error("media not saved for post for userId: {$post->getUserId()}");
		throw new PostRepositoryException("No valid media type found for upload");
	}

	private function saveImage(string $base64File): string
	{
		$extension = explode('/', explode(':', substr($base64File, 0, strpos($base64File, ';')))[1])[1];   // .jpg .png .pdf
		$replace = substr($base64File, 0, strpos($base64File, ',')+1); 
		$image = str_replace($replace, '', $base64File); 
		$image = str_replace(' ', '+', $image); 
		$imageName = Str::random(10).'.'.$extension;
	
		try {
			Log::info("Saving {$imageName}");
			Storage::disk('local')->put($imageName, base64_decode($image));
		} catch (Exception $e) {
			throw new PostRepositoryException("Error uploading media");
		}

		return $imageName;
	}

	private function saveVideo(): string
	{
		return '';
	}
 
}