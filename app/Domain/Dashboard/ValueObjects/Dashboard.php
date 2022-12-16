<?php declare(strict_types=1);

namespace App\Domain\Posts\ValueObjects;

use DateTimeImmutable;
use Exception;

class Dashboard {

	public function __construct(
		private int $postCount,
		private string $userName
	)
	{	}

		/**
		 * Get the value of postCount
		 */
		public function getPostCount(): int
		{
				return $this->postCount;
		}

		/**
		 * Get the value of userName
		 */
		public function getUserName(): string
		{
				return $this->userName;
		}

	public function toArray(): array
	{
		return [
			'post_count' => $this->postCount,
			'username' => $this->userName,
		];
	}
}