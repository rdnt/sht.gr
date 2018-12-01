<?php

// Trait that handles blueprint-based page rendering
trait Renderer {

    // Protected title-related datamembers
    protected $name;
    protected $separator;
    protected $title;
    // Private page rendering datamembers
    protected $page;
    protected $blueprint;
    protected $content;

    /**
     * Returns the page title
     *
     * @return string The page title
     */
    function getTitle() {
        return escape($this->title);
    }

    /**
     * Returns the current page's name
     *
     * @return string Current page's name
     */
    function getPage() {
        return $this->page;
    }

    /**
     * Formats the current page's title
     */
    function formatTitle() {
        $this->title = $this->name . " " . $this->separator . " " . $this->page;
    }

    /**
     * Overrides the current page path
     *
     * @param string $page The page path to force
     */
    function setCurrentPage($url) {
        $pages = array_merge($this->pages, $this->errors);
        $data = $pages[$url];
        $this->current_page = $url;
        $this->page = $data[0];
        $this->content = $data[1];
        $this->blueprint = $data[2];
        // Re-format the title since the page data was changed
        $this->formatTitle();
    }

    function throwError($code) {
        http_response_code($code);
        $this->setCurrentPage("/error/$code");
    }

    function findCurrentPage() {
        $folder = $this->getProjectFolder();
        $pages = array_merge($this->pages, $this->errors);
        // Loop all pages
        foreach ($pages as $url => $data) {
            // If URL starts with a hash it is a dropdown and index 3 is an
            // array with the dropdown items
            if (substr($folder . $url, 0, 1) === '#') {
                foreach ($data[3] as $inner_url => $inner_data) {
                    if ($this->getCurrentPage() === $inner_url) {
                        $this->page = $inner_data[0];
                        $this->content = $inner_data[1];
                        $this->blueprint = $inner_data[2];
                    }
                }
            }
            else if ($this->getCurrentPage() === $folder . $url) {
                $this->page = $data[0];
                $this->content = $data[1];
                $this->blueprint = $data[2];
            }
        }
    }

    function pageExists($page) {
        return array_key_exists($page, $this->pages);
    }

    function includePage() {
        $path = $this->getRoot() . "/includes/blueprints/" . $this->blueprint . ".php";
        if (!file_exists($path)) {
            $path = $this->getRoot() . "/includes/blueprints/default.php";
            $this->log("RENDERER", "Page blueprint file $this->blueprint.php doesn't exist. Using default blueprint.");
        }
        $shell = $this->shell;
        $$shell = $this;
        require_once $path;
    }

    function isAPICall($actual_page) {
        $parameters = explode("/", $actual_page);
        array_shift($parameters);
        if ($parameters[0] == "api") {
            return true;
        }
        return false;
    }

    function prepareEndpoint() {
        echo "endpoint";
    }

    function serveResource() {
        echo "resource";
    }



    /**
     * Renders a page based on its blueprint's format
     */
    function renderPage() {
        // Find the current page
        $this->findCurrentPage();
        // Acquire the first segment of the requested path
        $dir = $this->getProjectFolder();
        $url = substr($this->getCurrentPage(), strlen($dir));


        $location = strtok($url, '?');
        $path = $this->getRoot() . $location;


        //echo "location: $location<br>";
        //echo "path: $path<br>";

        $this->formatTitle();






        if (!$this->canAccess($location)) {
            $this->throwError(403);
            $path = $this->getRoot() . "/includes/blueprints/" . $this->blueprint . ".php";
        }
        else {
            if ($this->pageExists($location)) {
                $path = $this->getRoot() . "/includes/blueprints/" . $this->blueprint . ".php";
                if (!file_exists($path)) {
                    $this->throwError(501);
                    $path = $this->getRoot() . "/includes/blueprints/" . $this->blueprint . ".php";
                }
            }
            else if ($this->isAPICall($location)) {
                $path = $path . ".php";
            }
            else if (!file_exists($path)) {
                $this->throwError(404);
                $path = $this->getRoot() . "/includes/blueprints/" . $this->blueprint . ".php";
            }
        }
        $shell = $this->shell;
        $$shell = $this;
        require_once $path;






















    }

    /**
     * Loads a component on the page's content
     *
     * @param string $component The component to load
     */
    function loadComponent($component) {
        $shell = $this->shell;
        $$shell = $this;
        require_once($this->getRoot() . "/includes/components/$component.php");
    }

    /**
     * Inserts the main content into the page
     */
    function loadContent() {
        // Create a variable variable reference to the shell object
        // in order to be able to access the shell object by its name and not
        // $this when in page context
        $shell = $this->shell;
        $$shell = $this;
        $path = $this->getRoot() . "/includes/pages/" . $this->content . ".php";
        if (file_exists($path)) {
            require_once $path;
        }
        else {
            $this->log("RENDERER", "Page content file $this->content.php doesn't exist.");
        }
    }

    /**
     * Echoes a formatted style include
     *
     * @param string $style The style filename
     */
    function loadStyle($style) {
        $style = escape($style);
        $project_dir = escape($this->getProjectFolder());
        $commit_hash = escape($this->getCommitHash());
        echo "<link href=\"$project_dir/css/$style?v=$commit_hash\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\"/>\n";
    }

    /**
     * Echoes a formatted script tag
     *
     * @param string $script The script filename
     */
    function loadScript($script) {
        $script = escape($script);
        $project_dir = escape($this->getProjectFolder());
        $commit_hash = escape($this->getCommitHash());
        echo "<script src=\"$project_dir/js/$script?v=$commit_hash\"></script>\n";
    }

    /**
     * Queues a script to be included after the scripts component is loaded
     *
     * @param string $script The script filename
     */
    function queueScript($script) {
        $this->script_queue[] = $script;
    }

    /**
     * Echoes all the queued scripts as formatted script tags
     */
    function appendScripts() {
        foreach ($this->script_queue as $script) {
            $this->loadScript($script);
        }
    }

}

?>
