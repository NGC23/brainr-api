<?php declare(strict_types=1);

namespace App\Application\Posts\Controllers;

use App\Domain\Posts\Contracts\IPostRepository;
use App\Domain\Posts\Exceptions\PostRepositoryException;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class GetCreatorPostsController extends Controller
{
 public function __construct(
	private IPostRepository $iPostRepository
 )
 {
   $this->middleware('auth:api');
 }

 public function get(): JsonResponse
 {
		try {
			$this->iPostRepository->getAllPosts(auth()->user());
		} catch (PostRepositoryException $e) {

		}
 }
 
}