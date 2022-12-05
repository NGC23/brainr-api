<?php declare(strict_types=1);

namespace App\Domain\User\ValueObjects;

use DateTimeImmutable;

class User {

 public function __construct(
  private string $name,
  private string $email,
  private string $password,
  private ?string $id=null,
  private ?UserInformation $userInformation=null
 ) {}

  /**
   * Get the value of name
   */
  public function getName(): string
  {
    return $this->name;
  }

  /**
   * Get the value of email
   */
  public function getEmail(): string
  {
    return $this->email;
  }

  /**
   * Get the value of password
   */
  public function getPassword(): string
  {
    return $this->password;
  }

  /**
   * Get the value of id
   */
  public function getId(): string
  {
    return $this->id;
  }
	
  /**
   * Get the value of userInformation
   */
  public function getUserInformation(): UserInformation
  {
    return $this->userInformation;
  }
}