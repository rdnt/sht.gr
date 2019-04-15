<?php

trait Posts {

    public $totalPostsPerPage = -1;
    public $currentPost;
    public $currentPage = 1;

    function getCurrentPost() {
        return $this->currentPost;
    }

    function getBlogPageCount() {
        $count = $this->getPostsCount();
        $totalPages = (int)($count / $this->totalPostsPerPage) + 1;
        return $totalPages;
    }

    function getPosts($limit = 0, $offset = 0) {
        if ($this->totalPostsPerPage != null && $limit >= 0) {
            $limit = $this->totalPostsPerPage;
        }
        if ($this->currentPage) {
            $offset = ($this->currentPage - 1) * $limit;
        }
        if ($limit == -1) {
            // Get all posts
            $sql = "SELECT *
                    FROM posts;
            ";
            $response = $this->query($sql);
        }
        else {
            $sql = "SELECT *
                    FROM posts
                    LIMIT ?
                    OFFSET ?;
            ";
            $response = $this->query($sql, "ii", $limit, $offset);
        }
        $posts = array();
        foreach ($response as $id => $data) {
            $posts[$id] = new Post($data);
        }
        return $posts;
    }

    function getPost($id) {
        if (is_int($id)) {

            $sql = "SELECT *
                    FROM posts
                    WHERE id = ?;
            ";
            $data = $this->query($sql, "i", $id)[$id];

            if ($data) {
                $data['id'] = $id;
                return new Post($data);
            }
            else {
                $this->log("DATABASE", "Failed to load post with id = $id.");
            }
        }
        return false;
    }

    function getPostFromSlug($slug) {
        $sql = "SELECT *
                FROM posts
                WHERE slug LIKE ?;
        ";
        $data = $this->query($sql, "s", $slug);

        if ($data) {
            return new Post(reset($data));
        }
        else {
            return false;
        }
    }

    function newPost($data) {
        if (is_array($data)) {

            $timestamp = time();
            $data['slug'] = $this->slugify($data['title']);
            $sql = "INSERT INTO posts
                    (title, description, slug, content, timestamp)
                    VALUES
                    (?, ?, ?, ?, ?);
            ";
            $response = $this->query($sql, "ssssi", $data['title'], $data['description'], $data['slug'], $data['content'], $timestamp);
            if ($response) {
                $data['id'] = $this->lastInsertID();
                $data['timestamp'] = $timestamp;
                return new Post($data);
            }
            else {
                $this->log("DATABASE", "Failed to insert new post.");
            }
        }
        return false;
    }

    function getPostsCount() {
        $sql = "SELECT count(*)
                FROM posts;
        ";
        $data = $this->query($sql);
        return (int)$data;
    }

}

class Post {

    private $id;
    private $title;
    private $description;
    private $slug;
    private $content;
    private $timestamp;

    function __construct($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
    }

    function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

}
