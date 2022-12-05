<?php declare(strict_types=1);

namespace App\Application\Account\Controllers;

use App\Domain\User\Contracts\IUserRepository;
use App\Domain\User\Exceptions\UserRepositoryException;
use App\Domain\User\ValueObjects\User;
use App\Http\Controllers\Controller;
use App\Application\Account\Requests\SignUpRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class SignUpController extends Controller
{
 public function __construct(private IUserRepository $iUserRepository)
 {
 }

	public function post(SignUpRequest $request): JsonResponse
	{
		$data = $request->validated();

		try {
		$this->iUserRepository->create(
				new User(
					$data['name'],
					$data['email'],
					bcrypt($data['password'])
				)
			);
		} catch(UserRepositoryException $e) {
			Log::error(
				"Sign up Error:{$e->getMessage()}",
				[
					'exception' => $e
				]
			);
			return new JsonResponse(
				[
					'success' => false,
					'message' => $e->getMessage()
				], 
				500
			);
		}
		Log::info("User account created");
		return new JsonResponse(
			[
				'success' => true,
				'message' => 'User signed up!'
			],
			201
		);
	}
 
}