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
     * Constructeur de la classe
     */
    public function __construct(){
        $this->queryParams  = $_GET ?? [];
        $this->postVars    = $_POST ?? [];
        $this->headers      = getallheaders();
        $this->httpMethod   = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri          = $_SERVER['REQUEST_URI'] ?? '';

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