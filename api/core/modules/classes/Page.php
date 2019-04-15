<?php

$pages = array();

class Page {

    public $url;
    public $name;
    public $template;
    public $blueprint;
    public $children;
    public $visible;
    public $current;

    private $properties = array();

    function __construct($url, $name, $template, $blueprint, $parent = null) {
        global $pages;

        $this->url = $url;
        $this->name = $name;
        $this->template = $template;
        $this->blueprint = $blueprint;
        $this->visible = true;
        $this->current = false;

        if ($parent) {
            //$pages[$parent] = $parent;
            $parent_obj = &$pages[$parent];
            $parent_obj->children[] = $this;
        }
        else {
            $this->children = array();
        }
        $pages[$url] = $this;
    }

    function prop($property, $value = null) {
        if ($value) {
            $this->properties[$property] = $value;
        }
        else if (isset($this->properties[$property])) {
            return $this->properties[$property];
        }
        else {
            return false;
        }
    }

}

class HiddenPage extends Page {

    function __construct($url, $name, $template, $blueprint, $parent = null) {
        parent::__construct($url, $name, $template, $blueprint, $parent);
        $this->visible = false;
    }

}
