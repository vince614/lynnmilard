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
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $email;

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
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param $created_at
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setUsername($name)
    {
        $this->username = $name;
        return $this;
    }

    /**
     * @param $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param int $is_admin
     * @return UserEntity
     */
    public function setIsAdmin($is_admin)
    {
        $this->is_admin = $is_admin;
        return $this;
    }

    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}