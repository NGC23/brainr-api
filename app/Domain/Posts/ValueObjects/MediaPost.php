<?php declare(strict_types=1);

namespace App\Domain\Posts\ValueObjects;

class MediaPost extends Post {
	public function __construct(
		private string $name,
		private string $description,
		private string $upload,
		private string $type,
		private string $userId,
		private array $tags=[],
	)
	{	
		parent::__construct(
			$name, 
			$description, 
			$type, 
			$userId
		);
	}
	
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

	public function withUpload(string $uploadPath): self
	{
		$clone = clone $this;
		$clone->upload = $uploadPath;
		return $clone;
	}

	public function toArray(): array
	{
		return [
			'name' => $this->name,
			'description' => $this->description,
			'upload' => $this->upload,
			'type' => $this->type,
			'tags' => implode(',',$this->tags),
			'user_id' => $this->userId
		];
	}
}