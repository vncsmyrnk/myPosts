<?php

/**
 *  Author: vncsmyrnk
 * 	Credits: @bradtraversy
 *  Date: 07/11/2020
 * 
 *  Controller Base. Carrega models e views
 * 
 */

 class Controller {

    // Carrega model
    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    // Carrega view
    public function view($view, $data = []) {
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die('View does not exist.');
        }
    }
 }