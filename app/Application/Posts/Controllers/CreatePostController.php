<?php declare(strict_types=1);

namespace App\Application\Posts\Controllers;

use App\Application\Posts\Requests\CreatePostRequest;
use App\Domain\Posts\Contracts\IPostRepository;
use App\Domain\Posts\Exceptions\PostRepositoryException;
use App\Domain\Posts\ValueObjects\MediaPost;
use App\Domain\Posts\ValueObjects\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Exception;

class CreatePostController extends Controller {
	public function __construct(
		private IPostRepository $iPostRepository
	)
	{ 
		$this->middleware('auth:api');
	}

	public function post(CreatePostRequest $request): JsonResponse 
	{
		$data = $request->validated();
		$post = $this->determineTypePost($data);
		try {
			$this->iPostRepository->create($post);
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

	private function determineTypePost(array $data): Post
	{
		$userId = (string) Auth::id();

		if (empty($userId)) {
			throw new Exception("user not authorised to take this action");
		}

		switch ($data['type']) {
			case Post::VIDEO_TYPE:
			case Post::IMAGE_TYPE:
			case Post::PODCAST_TYPE:
				return new MediaPost(
					$data['name'],
					$data['description'],
					$data['upload'],
					$data['type'],
					$userId
				);
			case Post::DOCUMENT_TYPE:
				return new Post('','','','');
			case Post::QA_TYPE:
				return new Post('','','','');
			default:
				return new Post('','','','');

		}
	}
}