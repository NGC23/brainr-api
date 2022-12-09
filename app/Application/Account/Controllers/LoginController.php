<?php declare(strict_types=1);

namespace App\Application\Account\Controllers;

use App\Domain\Authentication\Token\Contracts\ITokenService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{

 public function __construct(private ITokenService $iTokenService)
 {
 }

 /**
  * Login function for users
  *
  * @return JsonResponse
  */
 public function post(): JsonResponse
 {
     $credentials = request(['email', 'password']);
     //According to the docblocs and return types of function it suppose to return a bool, 
     // but this returns a string on success and bool on failure
     if (! $token = auth()->attempt($credentials)) {
         return response()->json([
					'error' => 'Unauthorized', 
					'message' => 'Incorrect login details provided'
				], 401
			);
     }
     
     return $this->iTokenService->respondWithToken((string) $token);
 }

}