<?php declare(strict_types=1);

namespace App\Domain\Posts\Contracts;
use App\Domain\Posts\Exceptions\PostRepositoryException;
use App\Domain\Posts\ValueObjects\Post;
use App\Domain\User\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface IPostRepository {

 /**
  * Creates a post
  *
  * @param Post $post
  * @return void
	* @throws PostRepositoryException
  */
 public function create(Post $post): void;


 /**
	* Undocumented function
	*
	* @param User $user
	* @return array
	* @throws PostRepositoryException
	*/
	public function getAllPosts(User $user): array;

}