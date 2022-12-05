<?php declare(strict_types=1);

namespace App\Infrastructure\User\Repositories;

use App\Domain\User\Contracts\IUserRepository;
use App\Domain\User\Exceptions\UserRepositoryException;
use App\Domain\User\ValueObjects\User;
use App\Domain\User\Models\User As UserEntity;
use Exception;

class UserRepository implements IUserRepository {

 public function create(User $user): void 
 {
   try {
    UserEntity::create([
     'name' => $user->getName(),
     'email' => $user->getEmail(),
     'password' => $user->getPassword(),
    ]);
   } catch (Exception $e) {
    throw new UserRepositoryException(
     "Failed creating user with error: {$e->getMessage()}",
     $e->getCode(),
     $e
    );
   }
 }

 public function delete(): void
 {
  
 }
 
}