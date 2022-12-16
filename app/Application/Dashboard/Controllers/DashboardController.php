<?php declare(strict_types=1);

namespace App\Application\Dashboard\Controllers;

use App\Domain\Posts\Contracts\IPostRepository;
use App\Domain\Posts\Exceptions\PostRepositoryException;
use App\Domain\Posts\ValueObjects\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
 public function __construct(
	private IPostRepository $iPostRepository
 )
 {
   $this->middleware('auth:api');
 }

 public function get(): JsonResponse
 {
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
			$dashboardModel = new Dashboard(
				(int) count($this->iPostRepository->getAllPosts($user)),
				$user->email
			);
		} catch (PostRepositoryException $e) {
			return response()->json(
				[
					'success' => false,
					'message' => 'Error loading dash content',
				], 500);
		}

		return response()->json(
			[
				'success' => true,
				'data' => $dashboardModel->toArray(),
			], 200);
 }
 
}