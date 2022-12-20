<?php declare(strict_types=1);

namespace App\Domain\Posts\Contracts;
use App\Domain\Posts\Exceptions\PostRepositoryException;
use App\Domain\Posts\ValueObjects\MediaPost;
use App\Domain\Posts\ValueObjects\Post;
use App\Domain\User\Models\User;

interface IPostRepository {

 /**
  * Creates a post
  *
  * @param MediaPost $post
  * @return void
	* @throws PostRepositoryException
  */
 public function create(MediaPost $post): void;


 /**
	* Gets all posts
	*
	* @param User $user
	* @return array
	* @throws PostRepositoryException
	*/
	public function getAllPosts(User $user): array;

	/**
	 * Gets post by id
	 *
	 * @param User $user
	 * @param string $postId
	 * @return Post
	 * @throws PostRepositoryException
	 */
	public function getPostById(
		User $user, 
		string $postId
	): Post;

}