<?php


namespace Core\Utils;

/**
 * Class Meta
 * @package Core\Utils
 */
class Meta
{

    /**
     * @var string
     */
    public $title;

    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title . ' | BLOG PHP';
    }

}