<?php

class Pages extends Controller {

    public function __construct() {}

    public function index() {
        $data = [
            'title' => 'myPosts',
            'description' => 'Simple social network built on the php-mvc framework.',
        ];

        $this->view('pages/index', $data);
    }

    public function about() {
        $data = [
            'title' => 'About Us',
            'description' => 'App to share posts.',
        ];

        $this->view('pages/about', $data);
    }
}