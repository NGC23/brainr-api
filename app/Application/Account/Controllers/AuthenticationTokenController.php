<?php declare(strict_types=1);

namespace App\Application\Account\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class AuthenticationTokenController extends Controller
{

 public function __construct()
 {
  $this->middleware('auth:api');
 }

  /**
   * Get the authenticated User.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function me(): JsonResponse
  {
      return response()->json(auth()->user());
  }

   /** 
   * Refresh a token.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function refresh(): JsonResponse
  {
      return $this->respondWithToken(auth()->refresh());
  }

  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function respondWithToken($token): JsonResponse //MOVE TO SERVICE, FUNCTION IS USED 2 TIMES
  {
      return response()->json([
          'access_token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth()->factory()->getTTL() * 60
      ]);
  }
}