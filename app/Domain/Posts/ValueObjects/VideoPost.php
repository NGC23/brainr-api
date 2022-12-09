<?php declare(strict_types=1);

namespace App\Domain\Posts\ValueObjects;

use App\Domain\Posts\ValueObjects\MediaPost;

class VideoPost extends MediaPost {
	private const TYPE = 'video';
	public function __construct(
		private string $name,
		private string $description,
		private array $tags,
		private string $upload,
		private string $type,
		private string $userId
	) {	
		parent::__construct(
			$name, 
			$description, 
			$upload, 
			self::TYPE, 
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
				'user_id' => $this->userId
			];
		}
}