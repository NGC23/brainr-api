<?php declare(strict_types=1);

namespace App\Domain\Posts\ValueObjects;

class MediaPost extends Post {
	public function __construct(
		private string $name,
		private string $description,
		private string $upload,
		private string $type,
		private string $userId
	)
	{	
		parent::__construct(
			$name, 
			$description, 
			$type, 
			$userId
		);
	}
		/**
		 * Get the value of upload
		 */
		public function getUpload(): string
		{
				return $this->upload;
		}

		public function toArray(): array
		{
			return [
				'name' => $this->name,
				'description' => $this->description,
				'upload' => $this->upload,
				'type' => $this->type,
				'user_id' => $this->userId
			];
		}
}