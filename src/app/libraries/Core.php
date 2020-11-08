<?php

/**
 * 	Author: vncsmyrnk
 * 	Credits: @bradtraversy
 * 	Date: 07/11/2020
 * 
 * 	App Core Class
 * 	Creates Url & loads core controller
 * 	Url Format: /controller/method/params
 */

class Core {
	protected $currentController = 'Pages';
	protected $currentMethod = 'index';
	protected $params = [];

	public function __construct() {
		$url = $this->getUrl();

		// Busca controller de acordo com a url
		if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
			$this->currentController = ucwords($url[0]);
			unset($url[0]);
		}

		// Require Controller
		require_once '../app/controllers/' . $this->currentController . '.php';

		// Instancia Controller
		// Nota: separar variaveis depois
		$this->currentController = new $this->currentController;

		// Busca método
		if (isset($url[1]) && method_exists($this->currentController, $url[1])) {
			$this->currentMethod = $url[1];
			unset($url[1]);
		}

		// Obtem parametros
		$this->params = !empty($url) ? array_values($url) : [];

		// Chama método
		call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

	}

	public function getUrl() {
		if (isset($_GET['url'])){
			$url = rtrim($_GET['url'], '/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$url = explode('/', $url);
			return $url;
		}
	}

}
