<?php declare(strict_types=1);

namespace App\Domain\Posts\ValueObjects;

use DateTimeImmutable;
use Exception;

class Post {
	const VIDEO_TYPE = 'video';
	const QA_TYPE = 'qa';
	const PODCAST_TYPE = 'podcast';
	const DOCUMENT_TYPE = 'document';
	const IMAGE_TYPE = 'image';
	public function __construct(
		private string $name,
		private string $description,
		private string $type,
		private string $userId,
		private ?string $id = null
	)
	{	}

	/**
	 * Get the value of name
	 */
	public function getName(): string
	{
			return $this->name;
	}

	/**
	 * Get the value of description
	 */
	public function getDescription(): string
	{
			return $this->description;
	}

	/**
	 * Get the value of type
	 */
	public function getType(): string
	{
			return $this->type;
	}

	/**
	 * Get the value of userId
	 */
	public function getUserId(): string
	{
			return $this->userId;
	}

	/**
	 * Get the value of id
	 *
	 * @return ?string
	 */
	public function getId(): ?string
	{
			return $this->id;
	}

	public function withId(string $id): self
	{
		$clone = clone $this;
		$clone->id = $id;
		return $clone;
	}

	//For the IDE's sake, should of used a interface
	public function toArray(): array
	{
		return [];
	}
}