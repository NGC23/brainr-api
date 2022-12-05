<?php declare(strict_types=1);

namespace App\Application\Posts\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class GetCreatorPostsController extends Controller
{
 public function __construct()
 {
   $this->middleware('auth:api');
 }

 public function get(): JsonResponse
 {
  return new JsonResponse(['message' => 'Auth JWT aint working']);
 }
 
}