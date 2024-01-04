<?php
    /**
     * App core class
     * Create URLs and loads core controller
     * Url format: /controller/method/params
     */

     class Core {
         protected $currentController = 'Index';
         protected $currentMethod = 'index';
         protected $params = [];

         public function __construct() {

            $url = $this->getUrl();

            // Look for first value in controller
            if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
                // If exists, set as controller
                $this->currentController = ucwords($url[0]);
                //Unset 0 index
                unset($url[0]);
            }

            // Require controller
            require_once '../app/controllers/' . $this->currentController . '.php';
            
            // Instantiate controller class ($pages = new Pages);
            $this->currentController = new $this->currentController;

            // Check for subpaths
            if(isset($url[1])) {
                

                if(method_exists($this->currentController, $url[1])) {
                    $this->currentMethod = $url[1];
                    // Unset index 1
                    unset($url[1]);
                }
            }

            // Get params from url
            $this->params = $url ? array_values($url) : [];

            // Call callback with array of params
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
 
        }
         public function getUrl() {
             if(isset($_GET['url'])) {
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
             }
         }
     }