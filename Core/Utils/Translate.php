<?php
namespace Core\Utils;

class Translate
{
    /** @var string  */
    const DEFAULT_FILE = "main";

    /** @var string  */
    private $_locale = "fr";

    /** @var string */
    private $_tranlateFile;

    /**
     * Translates HTML5 elements.
     *
     * @param $html
     * @param null $var
     * @return string
     */
    public function __($html, $var = null): string
    {
        // Return default language
        if ($var !== null && $this->_locale === "en") {
            return str_replace('%', $var, $html);
        }
        if ($this->_locale === "en") {
            return $html;
        }

        // Return if file don't exist
        $fileName = $this->getTranlateFile() ?: self::DEFAULT_FILE;
        $file = ROOT . "/App/Traduction/" . $this->_locale . "/" . $fileName . ".csv";
        if (!file_exists($file)) {
            return $html;
        }

        // Open file and return the translation
        if (($handle = fopen($file, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000)) !== false) {
                if (!$var) {
                    if (mb_strtolower($data[0]) === mb_strtolower($html)) {
                        return $data[1];
                    }
                } else {
                    $text = explode('%', mb_strtolower($html));
                    if (strpos(mb_strtolower($data[0]),
                            mb_strtolower($text[0])) !== false && strpos(mb_strtolower($data[0]),
                            mb_strtolower($text[1])) !== false) {
                        return str_replace('%', $var, $data[1]);
                    }
                }
            }
            return $html;
        }
        return $html;
    }

    /**
     * @param $locale
     * @return $this
     */
    public function setLocale($locale): Translate
    {
        $this->_locale = $locale;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTranlateFile()
    {
        return $this->_tranlateFile;
    }

    /**
     * @param $tranlateFile
     * @return $this
     */
    public function setTranlateFile($tranlateFile): Translate
    {
        $this->_tranlateFile = $tranlateFile;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->_locale;
    }
}