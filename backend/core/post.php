<?php
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
?>
