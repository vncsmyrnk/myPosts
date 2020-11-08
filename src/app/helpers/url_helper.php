<?php

function redirect($page) {
    header('location: ' . URLROOT . $page);
}

function redirectToLogin() {
    redirect('/users/login');
}