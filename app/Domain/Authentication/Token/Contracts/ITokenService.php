<?php declare(strict_types=1);

namespace App\Domain\Authentication\Token\Contracts;
use Illuminate\Http\JsonResponse;

interface ITokenService {

 /**
  * Gets jwt token resposne for user
  *
  * @param string $token
  * @return JsonResponse
  */
 public function respondWithToken(string $token): JsonResponse;

}