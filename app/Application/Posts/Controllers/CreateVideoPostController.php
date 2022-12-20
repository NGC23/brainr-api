<?php declare(strict_types=1);

namespace App\Application\Posts\Controllers;

use App\Application\Posts\Requests\CreatePostRequest;
use App\Domain\Posts\Contracts\IPostRepository;
use App\Domain\Posts\Exceptions\PostRepositoryException;
use App\Domain\Posts\ValueObjects\MediaPost;
use App\Domain\Posts\ValueObjects\Post;
use App\Domain\Posts\ValueObjects\VideoPost;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
class CreateVideoPostController extends Controller {
	public function __construct(
		private IPostRepository $iPostRepository
	)
	{ 
		$this->middleware('auth:api');
	}

	public function post(CreatePostRequest $request): JsonResponse 
	{
		$data = $request->validated();
		$userId = (string) Auth::id();

		if (empty($userId)) {
			return response()->json([
				'success' => false,
				'message' => "User id not set, incomplete request",
				], 
				400
			);
		}

		try {
			$this->iPostRepository->create(
				new MediaPost(
					$data['name'],
					$data['caption'],
					$data['upload'],
					Post::VIDEO_TYPE,
					$userId,
					explode(
						',', 
						$data['tags']
					)
				)
			);
		} catch (PostRepositoryException $e) {
			return response()->json([
					'success' => false,
					'message' => "Issue adding post at this time",
				], 
				500
			);
		}

	 	return response()->json([],201);
	}
}