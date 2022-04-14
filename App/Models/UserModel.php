<?php
namespace App\Models;

use App\Entity\UserEntity;
use Core\Models\Model;
use Core\Utils\Request;

/**
 * Class UserModel
 * @package App\Models
 */
class UserModel extends Model
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * UserModel constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->_tableName   = $name;
        $this->_entityName  = $name;
        $this->request = new Request();
        parent::__construct();
    }

    /**
     * Login user
     *
     * @param UserEntity $user
     * @return $this
     */
    public function login(UserEntity $user)
    {
        $this->request->setSessionData('user', [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail()
        ]);
        return $this;
    }

    /**
     * Logout
     *
     * @return $this
     */
    public function logout()
    {
        $this->request->unsetSession('user');
        return $this;
    }

    /**
     * Get user session
     *
     * @return bool|UserEntity
     */
    public function getUserSession()
    {
        if ($userSession = $this->request->getSession('user')) {
            return $this->load($userSession['id']);
        }
        return false;
    }
}