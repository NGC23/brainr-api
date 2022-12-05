<?php declare(strict_types=1);

namespace App\Domain\Posts\ValueObjects;

class MediaPost extends Post {
	public function __construct(
		private string $name,
		private string $description,
		private array $tags,
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
		 * Get the value of tags
		 */
		public function getTags(): array
		{
				return $this->tags;
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
				'tags' => implode(',',$this->tags),
				'upload' => $this->upload,
				'type' => $this->type,
				'userId' => $this->userId
			];
		}
}