<?php declare(strict_types=1);

namespace App\Application\Posts\Controllers;

use App\Domain\Posts\Contracts\IPostRepository;
use App\Domain\Posts\Exceptions\PostRepositoryException;
use App\Domain\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class GetPostByIdController extends Controller
{
 public function __construct(
	private IPostRepository $iPostRepository
 )
 {
   $this->middleware('auth:api');
 }

 public function get(string $postId): JsonResponse
 {
		$post = [];
		$user = auth()->user();

		if (
				is_null($user) ||
				empty($user)
			) {
				return response()->json([
					'success' => false,
					'message' => 'User cannot be retrieved at this moment',
				], 401);
		}

		try {
			$post = $this->iPostRepository->getPostById(
				$user, 
				$postId
			);
		} catch (PostRepositoryException $e) {
			return response()->json(
				[
					'success' => false,
					'message' => 'Cannot retrieve posts at this time',
				], 500);
		}

		return response()->json(
			[
				'success' => true,
				'data' => $post->toArray(),
			], 200);
 }
 
}