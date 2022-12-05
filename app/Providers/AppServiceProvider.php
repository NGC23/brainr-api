<?php

namespace App\Providers;

use App\Domain\Authentication\Token\Contracts\ITokenService;
use App\Domain\Posts\Contracts\IPostRepository;
use App\Domain\User\Contracts\IUserRepository;
use App\Infrastructure\Posts\Repositories\PostRepository;
use App\Infrastructure\User\Repositories\UserRepository;
use App\Services\Authentication\Token\TokenService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
     //Declaring Services and binding to interfaces
     	$this->app->bind(
						ITokenService::class, 
						TokenService::class
					);
     //Declaring Repositories and binding to interfaces
     	$this->app->bind(
						IUserRepository::class, 
						UserRepository::class
					);

			$this->app->bind(
				IPostRepository::class, 
				PostRepository::class
			);
     //Controller Injections
     // $this->app->when(LoginController::class)->needs(ITokenService::class);
     // $this->app->when(SignUpController::class)->needs(UserRepository::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
