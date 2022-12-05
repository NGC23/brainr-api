<?php

namespace App\Domain\User\Contracts;
use App\Domain\User\Exceptions\UserRepositoryException;
use App\Domain\User\ValueObjects\User;

interface IUserRepository {
	/**
		* Create a user
		*
		* @param User $user
		* @return void
		* @throws UserRepositoryException
		*/
	public function create(User $user): void;
}