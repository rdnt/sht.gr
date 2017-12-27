<?php

class SHT_CMS {

    private $version;
    private $domain;
    private $errors;
    private $preloader;
    private $cache;
    private $author;
    private $directories;

    function __construct() {
        $this->version = "0.1.7";
        $this->domain = $_SERVER['HTTP_HOST'];
        $this->errors = 1;
        $this->preloader = 0;
        $this->cache = 0;
        $this->author = "ShtHappens796";
        $base_dir = $_SERVER['DOCUMENT_ROOT'];
        $this->directories = array(
            "accounts" => $base_dir . "/data/accounts/",
            "logs" => $base_dir . "/data/logs/",
            "posts" => $base_dir . "/data/posts/",
            "temp" => $base_dir . "/data/temp/"
        );

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

    static function escape_form_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    static function response($data) {
        echo $data;
        //var_dump($_SESSION);//die();
    }

    public function getDir($dir) {
        return $this->directories[$dir];
    }

    static function log($action, $data, $ip = null) {
        $logs_folder = $_SERVER['DOCUMENT_ROOT']."/data/logs/";
        $latest_log = $logs_folder . "latest.log";
        if (!file_exists($logs_folder)) {
            // Logs folder does not exist; create
            mkdir($logs_folder);
        }

        $date = date("M d Y H:i:s");

        if ($ip) {
            $address = " from " . $ip;
        }
        else {
            $address = null;
        }

        $message = $date . " $action: $data$address.\n";

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

    static function page_title($data) {
        // Returns formatted page title
        return "SHT ＼ $data";
    }

    static function push_assets($version) {
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

    static function slugify($data) {
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

    static function setcookie($username) {
        $sht = new SHT_CMS;
        $user_path = $sht->getDir("accounts") . "$username.json";
        $user = file_get_contents($user_path);
        $userdata = json_decode($user, true);
        $uuid = uniqid();
        $secret = rtrim(base64_encode(md5(microtime())),"=");
        $userdata['rememberme'][$uuid] = $secret;
        file_put_contents($user_path, json_encode($userdata, JSON_PRETTY_PRINT));
        setcookie('rememberme', $username . " " . $uuid, time()+60*60*24*7, '/', $sht->getDomain());
    }

}

class POST implements JsonSerializable {
    private $title;
    private $slug;
    private $description;
    private $author;
    private $content;
    private $date_created;
    private $date_updated;
    private $reactions;
    private $comments;

    function __construct($title = null, $description = null, $author = null, $content = null) {
        $this->title = $title;
        $this->slug = SHT_CMS::slugify($title);
        $this->description = $description;

        $this->author = $author;

        $this->date_created = date("Ymd_His");
        $this->date_updated = date("Ymd_His");

        $this->reactions = 0;
        $this->comments = array();

        $this->content = $content;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getContent() {
        return $this->content;
    }

    public function getDateCreated() {
        return $this->date_created;
    }

    public function jsonSerialize() {
        $json = array(
            "title"        => $this->title,
            "slug"         => $this->slug,
            "description"  => $this->description,
            "author"       => $this->author,
            "date_created" => $this->date_created,
            "date_updated" => $this->date_updated,
            "reactions"    => $this->reactions,
            "comments"     => $this->comments,
            "content"      => $this->content
        );

        return $json;
    }

    public function import($input) {
        $this->title = $input["title"];

        $this->slug = $input["slug"];
        $this->description = $input["description"];

        $this->author = $input["author"];

        $this->date_created = $input["date_created"];
        $this->date_updated = $input["date_updated"];

        $this->reactions = $input["reactions"];
        $this->comments = $input["comments"];

        $this->content = $input["content"];
    }

    static function decode($path) {
        $post_data = file_get_contents($path);
        $post_data = json_decode($post_data, true);
        $post = new POST();
        $post->import($post_data);
        return $post;
    }

    public function printDate($from_format, $to_format) {
        $date_obj = date_create_from_format($from_format, $this->getDateCreated());
        $date = $date_obj->format($to_format);
        return $date;
    }

    static function compare($a, $b) {
        $adate = $a->getDateCreated();
        $bdate = $b->getDateCreated();

        $adate_obj = date_create_from_format("Ymd_His", $a->getDateCreated());
        $bdate_obj = date_create_from_format("Ymd_His", $b->getDateCreated());
        $adate = intval($adate_obj->format("U"));
        $bdate = intval($bdate_obj->format("U"));

        if ($adate < $bdate) {
            return 1;
        }
        else if ($adate > $bdate) {
            return -1;
        }
        else {
            return 0;
        }
    }


}

$sht = new SHT_CMS;


$sht->push_assets($sht->getVersion());

?>
