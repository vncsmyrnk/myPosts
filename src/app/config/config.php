<?php

/**
 *  
 *  Configuração de váriaveis de ambiente
 * 
 *  Define: Seta variáveis diponíveis dentro da aplicação
 */


// DB Params
define('DB_HOST', 'db');
define('DB_USER', 'postgres');
define('DB_PASSWORD', 'postgres-admin');
define('DB_NAME', 'myposts');

// App Root
define('APPROOT', dirname(dirname(__FILE__)));

// Url root
define('URLROOT', 'http://localhost');

// Site root
define('SITENAME', 'myPosts');

// App Version
define('APPVERSION', '0.1.0');