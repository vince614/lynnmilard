<?php
namespace Core\Controllers;

use Core\Utils\Meta;
use Core\Utils\Render;

/**
 * Class Controller
 * @package Controllers\Core
 */
class Controller
{
    /**
     * Blocks
     */
    const HEADER_BLOCK  = 'header';
    const NAVBAR_BLOCK  = 'navBar';
    const FOOTER_BLOCK  = 'footer';
    const SCRIPTS_BLOCK = 'scripts';

    /**
     * Path types
     */
    const ASSETS_PATH = "/assets/js/";
    const FUNCTION_PATH = "/assets/js/function/";
    const MODULE_PATH = "/assets/js/module/";
    const ROOT_PATH = "/";

    /**
     * Js script types
     */
    const JAVASCRIPT_TYPE = "text/javascript";
    const MODULE_TYPE = "module";


    /**
     * Variables
     * @var $vars array
     */
    public $vars = [];

    /**
     * Params in request
     * @var array
     */
    public $params = [];

    /**
     * View
     * @var string
     */
    private $_view;

    /**
     * @var string
     */
    public $path;

    /**
     * @var array
     */
    protected $_stylesheetsPaths = [];

    /**
     * @var array
     */
    protected $_scripts = [];

    /**
     * @var array
     */
    public $result = [];

    /**
     * @var Meta
     */
    public $meta;

    /**
     * Controller constructor.
     * @param $path
     * @param null $params
     */
    public function __construct($path, $params = null)
    {
        $this->path = $path;
        $this->params = $params;
        $this->meta = new Meta();
        $this->index();
    }

    /**
     * Index
     */
    public function index()
    {
        if (!isset($this->path)) new ErrorController(Render::ERROR_404_PATH);
        $this->beforeRender();
        new Render($this->path, $this->vars, $this);
        $this->afterRender();
    }

    /**
     * Before render
     */
    protected function beforeRender()
    {
        $this->setStylesheetPath('theme.css');
        $this->setBlock(self::HEADER_BLOCK);
        $this->setBlock(self::NAVBAR_BLOCK);
    }

    /**
     * Before render
     */
    protected function afterRender()
    {
        $this->setBlock(self::FOOTER_BLOCK);
        $this->setBlock(self::SCRIPTS_BLOCK);
    }

    /**
     * Set block
     *
     * @param $block
     * @return $this
     */
    public function setBlock($block): Controller
    {
        $blockFile = ROOT . '/App/Views/Blocks/' . str_replace('.', '/', $block) . '.phtml';
        if (is_file($blockFile)) {
            require $blockFile;
        }
        return $this;
    }

    /**
     * Set variables
     *
     * @param $index
     * @param $value
     * @return Controller
     */
    public function setVar($index, $value): Controller
    {
        $this->vars[$index] = $value;
        return $this;
    }

    /**
     * Redirect if page not found
     */
    public function notFound()
    {
        header('HTTP/1.0 404 Not Found');
        exit;
    }

    /**
     * Redirect if don't have accès
     */
    public function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');
        exit;
    }

    /**
     * Set stylesheet path
     *
     * @param $path
     * @param bool $isAssets
     * @return Controller
     */
    public function setStylesheetPath($path, bool $isAssets = true): Controller
    {
        if ($isAssets) {
            $this->_stylesheetsPaths[] = '/assets/css/' . $path;
        } else {
            $this->_stylesheetsPaths[] = '/' . $path;
        }
        return $this;
    }

    /**
     * Set scripts path
     *
     * @param $fileName
     * @param $path
     * @param string $type
     * @return Controller
     */
    public function setScript($fileName, $path, string $type = self::JAVASCRIPT_TYPE): Controller
    {
        $this->_scripts[] = [
            'path' => $path . $fileName,
            'type' => $type
        ];
        return $this;
    }

    /**
     * Get stylesheet paths
     *
     * @return array
     */
    public function getStylesheetsPaths(): array
    {
        return $this->_stylesheetsPaths;
    }

    /**
     * Get scripts paths
     *
     * @return array
     */
    public function getScripts(): array
    {
        return $this->_scripts;
    }

}