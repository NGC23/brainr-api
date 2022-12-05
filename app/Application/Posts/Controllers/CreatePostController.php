<?php declare(strict_types=1);

namespace App\Application\Posts\Controllers;

use App\Application\Posts\Requests\CreatePostRequest;
use App\Domain\Posts\Contracts\IPostRepository;
use App\Domain\Posts\Exceptions\PostRepositoryException;
use App\Domain\Posts\ValueObjects\MediaPost;
use App\Domain\Posts\ValueObjects\Post;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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
			return new JsonResponse([
					'success' => false,
					'message' => "Issue adding post at this time",
				], 
				500
			);
		}

		return new JsonResponse([],201);
	}

	private function determineTypePost(array $data): Post
	{
		switch ($data['type']) {
			case Post::VIDEO_TYPE:
			case Post::IMAGE_TYPE:
			case Post::PODCAST_TYPE:
				return new MediaPost(
					$data['name'],
					$data['description'],
					explode(
						',', 
						$data['tags']
					),
					$data['upload'],
					$data['type'],
					Auth::id(),
				);
			case Post::DOCUMENT_TYPE:
				//NA
			break;
			case Post::QA_TYPE:
			break;
		}
	}
}