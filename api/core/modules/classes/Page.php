<?php

$pages = array();

class Page {

    public $url;
    public $name;
    public $template;
    public $blueprint;
    public $children;

    function __construct($url, $name, $template, $blueprint, $parent = null) {
        global $pages;
        $this->url = $url;
        $this->name = $name;
        $this->template = $template;
        $this->blueprint = $blueprint;
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

}
