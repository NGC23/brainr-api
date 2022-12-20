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
		private ?string $id=null
	)
	{	
		parent::__construct(
			$name, 
			$description, 
			$type, 
			$userId,
			$id
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

	public function withUpload(string $upload): self
	{
		$clone = clone $this;
		$clone->upload = $upload;
		return $clone;
	}

	public function toArray(): array
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'description' => $this->description,
			'upload' => $this->upload,
			'type' => $this->type,
			'tags' => implode(',',$this->tags),
			'user_id' => $this->userId
		];
	}
}