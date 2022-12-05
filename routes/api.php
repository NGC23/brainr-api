<?php

use App\Application\Account\Controllers\AuthenticationTokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Application\Account\Controllers\LoginController;
use App\Application\Account\Controllers\LogoutController;
use App\Application\Account\Controllers\SignUpController;
use App\Application\Posts\Controllers\CreatePostController;
use App\Application\Posts\Controllers\GetCreatorPostsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group([

 'middleware' => 'api',
 'prefix' => 'brainr-api'

], function ($router) {
/*
* AUTHENTICATION
*/
 $router->post('login', [LoginController::class, 'post'])->name('login');
 $router->post('sign-up', [SignUpController::class, 'post'])->name('sign-up');
 $router->post('logout', [LogoutController::class, 'post']);
 $router->post('refresh', [AuthenticationTokenController::class, 'refresh']);
 $router->post('me', [AuthenticationTokenController::class, 'me']);
/*
* POST ROUTES
*/
$router->post('posts/create', [CreatePostController::class, 'post'])->name('createPost');
$router->get('posts', [GetCreatorPostsController::class, 'get'])->name('getCreatorPosts');

});

