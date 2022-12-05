<?php declare(strict_types=1);

namespace App\Domain\Posts\Contracts;
use App\Domain\Posts\Exceptions\PostRepositoryException;
use App\Domain\Posts\ValueObjects\Post;

interface IPostRepository {

 /**
  * Creates a post
  *
  * @param Post $post
  * @return void
	* @throws PostRepositoryException
  */
 public function create(Post $post): void;

}