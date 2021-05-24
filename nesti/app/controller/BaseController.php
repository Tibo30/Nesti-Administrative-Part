<?php
require_once(BASE_DIR.PATH_VIEW . 'View.php');

abstract class BaseController
{
    protected View $_view;
    protected $_url;
    protected $_data = [];

    /**
     * Constructor
     */
    public function __construct($url)
    {

        if (isset($_GET["url"]) && ((($url[0] != "connection") && ($url[0] != "recipe") && ($url[0] != "article") && ($url[0] != "user") && ($url[0] != "statistic")) || ($url[0] == "statistic" && count($url) > 1))) {
            throw new Exception('Page introuvable');
        } else {
            if (($url[0] == "recipe" || $url[0] == "article" || $url[0] == "user" || $url[0] == "connection") && count($url) > 1) {
                $this->_url = $url[0] . "_" . $url[1];
            } else {
                $this->_url = $url[0];
            }
            $this->initialize();
        }
    }

    /**
     * return a view from View class
     */
    public function getView(): View
    {
        if (isset($this->_view)) {
            return $this->_view;
        }
    }

    /**
     * get the data to extract
     */
    public function getData()
    {
        if (isset($this->_data) && !empty($this->_data)) {
            return $this->_data;
        }
    }

    protected abstract function initialize();
}
