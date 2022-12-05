<?php declare(strict_types=1);

namespace App\Application\Account\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class LogoutController extends Controller
{
  public function __construct()
  {
   $this->middleware('auth:api');
  }
   /**
   * Log the user out (Invalidate the token).
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function post(): JsonResponse
  {
    auth()->logout();
    return response()->json(['message' => 'Successfully logged out']);
  }
}