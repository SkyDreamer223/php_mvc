<?php

namespace App\Http;

class Response {
    
    /**
     * Code de status HTTP
     *
     * @var integer
     */
    private $httpCode = 200;

    /**
     * Header response
     *
     * @var array
     */
    private $headers = [];

    /**
     * Type de contenu
     *
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * Contenu de la response
     *              
     * @var mixed
     */
    private $content;

    /**
     * Constructeur
     *
     * @param integer $httpCode
     * @param mixed $content
     * @param string $contentType
     */
    public function __construct($httpCode, $content, $contentType = 'text/html'){
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    public function setContentType($contentType){
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Methode qui ajoute des variables à l'header
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function addHeader($key, $value) {
        $this->headers[$key] = $value;
    }

    private function sendHeaders(){
        //STATUS
        http_response_code($this->httpCode);

        foreach ($this->headers as $key => $value){
            header($key.': '.$value);
        }
    }

    /**
     * Methode qui return la reponse à l'utilisateur
     */
    public function sendResponse(){

        //ENVOIE LES HEADERS
        $this->sendHeaders();
        switch ($this->contentType){
            case 'text/html': echo $this->content;exit;

        }
    }

}