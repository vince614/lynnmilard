<?php

namespace Core\Utils;

use App\App;
use App_Core_Exception;

/**
 * Class Ajax
 * @package Core\Utils
 */
class Ajax
{
    /**
     * @var mixed
     */
    protected $request;

    /**
     * @var array
     */
    public $result = [];

    /**
     * Ajax constructor.
     * @param $request
     * @throws App_Core_Exception
     */
    public function __construct($request)
    {
        $this->request = $request;
        if (!$this->isValidRequest()) {
            App::throwException('Request type is not defined');
        }
    }

    /**
     * Is valid request
     *
     * @return bool
     */
    public function isValidRequest()
    {
        return isset($this->request['type']) &&
            !empty($this->request['type']);
    }

    /**
     * Get request type
     *
     * @return string
     */
    public function getRequestType()
    {
        return $this->request['type'];
    }

    /**
     * @return mixed
     */
    public function getRequestDatas()
    {
        return $this->request;
    }


    /**
     * Error message
     *
     * @param $msg
     * @return $this
     */
    public function error($msg)
    {
        $this->result['error'] = $msg;
        return $this;
    }

    /**
     * Success message
     *
     * @param $msg
     * @return $this
     */
    public function success($msg)
    {
        $this->result['success'] = $msg;
        return $this;
    }

    /**
     * Send response
     */
    public function sendResponse()
    {
        header("Content-Type: application/json");
        http_response_code(200);
        $JSON = json_encode($this->result);
        echo $JSON;
        exit;
    }

}