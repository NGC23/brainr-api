<?php declare(strict_types=1);

namespace App\Services\Authentication\Token;

use App\Domain\Authentication\Token\Contracts\ITokenService;
use Illuminate\Http\JsonResponse;

class TokenService implements ITokenService {
  public function respondWithToken(string $token): JsonResponse
  {
      return response()->json([
          'access_token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth()->factory()->getTTL() * 60
      ]);
  }
}