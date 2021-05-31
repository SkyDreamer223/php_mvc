<?php

namespace App\Http;

class Request {

    /**
     * mehtode http
     *
     * @var string
     */
    private $httpMethod;

    /**
     * uri de la page
     *
     * @var string
     */
    private $uri;

    /**
     * Parrametres de l'URL($_GET)
     *
     * @var array
     */
    private $queryParams = [];

    /**
     * Variables POST de la page ($_POST)
     *
     * @var array
     */
    private $postVars = [];

    /**
     * Header request
     *
     * @var array
     */
    private $headers = [];

    /**
     * Router
     *
     * @var Router
     */
    private $router;

    /**
     * Constructeur de la classe
     */
    public function __construct($router){
        $this->router = $router;
        $this->queryParams  = $_GET ?? [];
        $this->postVars     = $_POST ?? [];
        $this->headers      = getallheaders();
        $this->httpMethod   = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
        

    }

    private function setUri(){
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';

        $xUri = explode('?',$this->uri);
        $this->uri = $xUri[0];
    }

    public function getRouter(){
        return $this->router;
    }

    public function getHttpMethod(){
        return $this->httpMethod;
    }

    public function getUri(){
        return $this->uri;
    }

    public function getHeaders(){
        return $this->headers;
    }

    public function getQueryParams(){
        return $this->queryParams;
    }

    public function getPostVars(){
        return $this->postVars;
    }

}