<?php
namespace Core\Form;

use App\App;
use App_Core_Exception;
use Core\Utils\Request;

/**
 * Class FormValidation
 * @package Core\Form
 */
class FormValidation
{
    /**
     * Const
     */
    const TOKEN_LENGTH = 50;
    const PASSWORD_MIN_LENGTH = 5;
    const RESUME_MAX_LENGTH = 300;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $error;

    /**
     * FormValidation constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * Generate token
     *
     * @return $this
     */
    public function generateToken()
    {
        $characters = '0123456789abcdefghijklmnopqrs092u3tuvwxyzaskdhfhf9882323ABCDEFGHIJKLMNksadf9044OPQRSTUVWXYZ.';
        $charactersLength = strlen($characters);
        $randomString = "";
        for ($i = 0; $i < self::TOKEN_LENGTH; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $this->token = $randomString;
        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Save token in session
     *
     * @param $name
     * @return FormValidation
     */
    public function saveTokenInSession($name)
    {
        $this->request->setSessionData(
            'token_' . $name,
            $this->token
        );
        return $this;
    }

    /**
     * @param $name
     * @return $this
     * @throws App_Core_Exception
     */
    public function saveTokenInApp($name)
    {
        App::register(
            'token_' . $name,
            $this->token
        );
        return $this;
    }

    /**
     * Verify form
     *
     * @param $name
     * @param $token
     * @return FormValidation
     */
    public function verifyFormToken($name, $token)
    {
        $formSessionToken = $this->request->getSession('token_' . $name);
        $formToken = $token;
        if ($formToken && $formSessionToken) {
            if ($formToken === $formSessionToken) {
                return $this;
            }
        }
        $this->error = "Form token is invalid";
        return $this;
    }

    /**
     * Validate email
     *
     * @param $email
     * @return FormValidation
     */
    public function validateEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this;
        }
        $this->error = "Merci de rentrez un email valide.";
        return $this;
    }

    /**
     * Validate password
     *
     * @param $password
     * @return FormValidation
     */
    public function validatePassword($password)
    {
        if (strlen($password) >= self::PASSWORD_MIN_LENGTH) {
            return $this;
        }
        $this->error = "Votre mot de passe dois contenir plus de " . self::PASSWORD_MIN_LENGTH . " caractères.";
        return $this;
    }

    /**
     * Check passwords
     *
     * @param $password
     * @param $comfirmPassword
     * @return FormValidation
     */
    public function checkPasswords($password, $comfirmPassword)
    {
        if ($password === $comfirmPassword) {
            return $this;
        }
        $this->error = "Vos mot de passes ne correspodent pas.";
        return $this;
    }

    /**
     * Check resume
     *
     * @param $resume
     * @return $this
     */
    public function checkResume($resume)
    {
        if (strlen($resume) < self::RESUME_MAX_LENGTH) {
            return $this;
        }
        $this->error = "Votre résumé dois contenir moins de " . self::PASSWORD_MIN_LENGTH . " caractères.";
        return $this;
    }

    /**
     * Get error
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }
}