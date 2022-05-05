<?php
namespace App\Entity;

use Core\Entity\Entity;

/**
 * Class UserEntity
 * @package App\Entity
 */
class UserEntity extends Entity
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $first_name;

    /**
     * @var string
     */
    private $last_name;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var int
     */
    private $age;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var string
     */
    private $avatar;

    /**
     * @var int
     */
    private $created_at;

    /**
     * @var int
     */
    private $is_admin;

    /**
     * @return int
     */
    public function getId(): int
    {
        return (int) $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getCreatedAt(): int
    {
        return (int) $this->created_at;
    }

    /**
     * @return bool
     */
    public function getIsAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id): UserEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param $created_at
     * @return $this
     */
    public function setCreatedAt($created_at): UserEntity
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setUsername($name): UserEntity
    {
        $this->username = $name;
        return $this;
    }

    /**
     * @param $email
     * @return $this
     */
    public function setEmail($email): UserEntity
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param int $is_admin
     * @return UserEntity
     */
    public function setIsAdmin(int $is_admin): UserEntity
    {
        $this->is_admin = $is_admin;
        return $this;
    }

    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password): UserEntity
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param $firstName
     * @return $this
     */
    public function setFirstName($firstName): UserEntity
    {
        $this->first_name = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return UserEntity
     */
    public function setLastName(string $last_name): UserEntity
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param int $age
     * @return UserEntity
     */
    public function setAge(int $age): UserEntity
    {
        $this->age = $age;
        return $this;
    }

    /**
     * @param string $gender
     * @return UserEntity
     */
    public function setGender(string $gender): UserEntity
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     * @return UserEntity
     */
    public function setAvatar(string $avatar): UserEntity
    {
        $this->avatar = $avatar;
        return $this;
    }
}