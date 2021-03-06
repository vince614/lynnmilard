<?php
namespace App\Controllers;

use App\App;
use App\Entity\UserEntity;
use App\Models\UserModel;
use App_Core_Exception;
use Core\Controllers\Controller;
use Core\Form\FormValidation;
use Core\Utils\Ajax;
use Core\Utils\Request;

/**
 * Class RegisterController
 * @package App\Controller
 */
class RegisterController extends Controller
{

    const REGISTER_REQUEST_TYPE = "register";

    /**
     * @var UserModel
     */
    protected $userModel;

    /**
     * @var FormValidation
     */
    protected $formValidation;

    public function __construct($path, $params = null)
    {
        $this->userModel = App::getModel('user');
        $this->formValidation = new FormValidation();
        parent::__construct($path, $params);
    }

    /**
     * @throws App_Core_Exception
     */
    public function beforeRender()
    {
        $this->checkPostRequest();
        $this->setStylesheetPath('register.css');
        $this->setScript('Form.js', Controller::MODULE_PATH, Controller::MODULE_TYPE);
        $this->setScript('register.js', Controller::FUNCTION_PATH, Controller::MODULE_TYPE);
        $this->meta->setTitle('Création de compte');

        $this->formValidation
            ->generateToken()
            ->saveTokenInSession('register')
            ->saveTokenInApp('register');
        parent::beforeRender(); // TODO: Change the autogenerated stubs
    }

    /**
     * Check post request
     * @throws App_Core_Exception
     */
    public function checkPostRequest()
    {
        if (!$this->request->isPost()) return;
        $ajaxObject = new Ajax($this->request->getPost());
        switch ($ajaxObject->getRequestType()) {
            case self::REGISTER_REQUEST_TYPE:
                $datas = $ajaxObject->getRequestDatas();

                // Validate form
                $this->validateForm($datas);
                if ($error = $this->formValidation->getError()) {
                    $ajaxObject->error($error);
                    $ajaxObject->sendResponse();
                }

                /** @var UserEntity $user */
                $user = $this->userModel->getEntity($this->userModel->_entityName, [
                    'name'          => $datas['username'],
                    'email'         => $datas['email'],
                    'password'      => sha1($datas['password']),
                    'created_at'    => time()
                ]);

                // Check if email exist email
                if ($this->userModel->load($user->getEmail(), 'email')) {
                    $ajaxObject->error("Cet adresse mail est déjà relié à un compte, veuillez en choisir une autre");
                    break;
                }

                $created = $this->userModel->create($user, $this->userModel->_tableName);
                $created ?
                    $ajaxObject->success("Vous êtes bien inscrit !") :
                    $ajaxObject->error("Une erreur c'est produite, veuillez réessayer");
        }
        $ajaxObject->sendResponse();
    }

    /**
     * Validate form
     *
     * @param $datas
     */
    public function validateForm($datas)
    {
        $this->formValidation
            ->verifyFormToken('register', $datas['formToken'])
            ->validateEmail($datas['email'])
            ->validatePassword($datas['password']);
    }

}