<?php

class SHT_CMS {

    private $version;
    private $domain;
    private $errors;
    private $preloader;
    private $cache;
    private $author;

    function __construct() {
        $this->version = "0.1.7";
        $this->domain = $_SERVER['HTTP_HOST'];
        $this->errors = 1;
        $this->preloader = 0;
        $this->cache = 0;
        $this->author = "ShtHappens796";

        date_default_timezone_set("Europe/Athens");

        if ($this->errors) {
            // Error reporting
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }

        if (session_status() == PHP_SESSION_NONE) {
            // Start the session if it wasn't already started
            session_start();
        }

        if (isset($_SESSION["lastvisit"])) {
            // Returning visitor
            if ($_SESSION["lastvisit"] < date("U") + 86400) {
                // Returning visitor that came here recently (less than a day ago)
                $_SESSION["lastvisit"] = date("U");
                $this->cache = 1;
            }
        }
        else {
            // New visitor
            $_SESSION["lastvisit"] = date("U");
            $this->cache = 0;
            $this->preloader = 1;
        }
        // Until login script is created
        $_SESSION["login"] = "ShtHappens796";

    }

    public function getVersion() {
        return $this->version;
    }

    public function getDomain() {
        return $this->domain;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getPreloader() {
        return $this->preloader;
    }

    public function getCache() {
        return $this->cache;
    }

    public static function escape_form_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function response($data) {
        echo $data;
        die();
    }

    public static function log($action, $data) {
        $logs_folder = $_SERVER['DOCUMENT_ROOT']."/data/logs/";
        $latest_log = $logs_folder . "latest.log";
        if (!file_exists($logs_folder)) {
            // Logs folder does not exist; create
            mkdir($logs_folder);
        }

        $date = date("M d Y H:i:s");
        $message = $date . " $action: $data.\n";

        if (file_exists($latest_log)) {
            // Latest log exists
            $log_data = file_get_contents($latest_log);
            $log_data .= $message;
        }
        else {
            $log_data = $message;
        }
        file_put_contents($latest_log, $log_data);
    }

    public static function page_title($data) {
        // Returns formatted page title
        return "SHT ＼ $data";
    }

    public static function push_assets($version) {
        $assets = array(
            "/css/style.css?v=$version" => "style",
            "/js/init.js?v=$version" => "script",
            "/css/materialize.min.css?v=$version" => "style",
            "/js/materialize.min.js?v=$version" => "script"
        );

        $counter = count($assets);

        foreach ($assets as $asset => $as) {
            $counter--;
            $string = "Link: <$asset>; rel=preload; as=$as";
            header($string, false);
        }
    }

    public static function slugify($data) {
        // replace non letter or digits by -
        $data = preg_replace('~[^\pL\d]+~u', '-', $data);
        // transliterate
        $data = iconv('utf-8', 'us-ascii//TRANSLIT', $data);
        // remove unwanted characters
        $data = preg_replace('~[^-\w]+~', '', $data);
        // trim
        $data = trim($data, '-');
        // remove duplicate -
        $data = preg_replace('~-+~', '-', $data);
        // lowercase
        $data = strtolower($data);

        if (empty($data)) {
            return null;
        }
        return $data;
    }

}

$sht = new SHT_CMS;


$sht->push_assets($sht->getVersion());

?>
