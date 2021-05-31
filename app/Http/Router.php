<?php

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;

class Router {

    /**
     * Url complet du project
     *
     * @var string
     */
    private $url = '';

    /**
     * Prefix de toutes les routes
     *
     * @var string
     */ 
    private $prefix = '';

    /**
     * Index des routes
     *
     * @var array
     */
    private $routes = [];


    /**
     * Instance Request
     *
     * @var Request
     */
    private $request;


    /**
     * Constructeur
     *
     * @param string $url
     * @return void
     */
    public function __construct($url){
        $this->request = new Request;
        $this->url = $url;
        $this->setPrefix();
    }

    /**
     * Methode qui define le prefix de l'url
     *
     * @return void
     */
    private function setPrefix(){
        $parseUrl = parse_url($this->url);
        $this->prefix = $parseUrl['path'] ?? '';
        
    }

    /**
     * Methode qui rajoute une route dans la classe
     *
     * @param string $method
     * @param string $route
     * @param array $params
     * @return void
     */
    private function addRoute($method, $route, $params = []){
        //VALIDER LES PARAMETTRES
        
        foreach($params as $key => $value){
            if($value instanceof Closure){
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        $params['variables'] = [];
        $patternVariable = '/{(.*?)}/';
        if(preg_match_all($patternVariable, $route, $matches)){

            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }


        $patternRoute = '/^'.str_replace('/','\/', $route).'$/';

        $this->routes[$patternRoute][$method] = $params;

        
        
    }

    /**
     * Methode qui define une route GET
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function get($route, $params = []){

        $this->addRoute('GET', $route, $params);

    }

    /**
     * Methode qui define une route POST
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function post($route, $params = []){

        $this->addRoute('POST', $route, $params);

    }

    /**
     * Methode qui define une route PUT
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function put($route, $params = []){

        $this->addRoute('PUT', $route, $params);

    }

    /**
     * Methode qui define une route DELETE
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function delete($route, $params = []){

        $this->addRoute('DELETE', $route, $params);

    }

    /**
     * Methode qui retourne uri sans prefix
     *
     * @return string
     */
    private function getUri(){
        
        $uri = $this->request->getUri();

        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        return end($xUri);


    }

    /**
     * Methode retourne la route actuel
     *
     * @return array
     */
    private function getRoute(){

        $uri = $this->getUri();

        $httpMethod = $this->request->getHttpMethod();

        foreach($this->routes as $patternRoute => $methods){

            if(preg_match($patternRoute, $uri, $matches)){
                
                if(isset($methods[$httpMethod])){

                    unset($matches[0]);
                    
                    //KEYS

                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;
                    
                    
                    return $methods[$httpMethod];
                }

                throw new Exception('Methode non permis', 405);
            }

        }

        throw new Exception('URL non trouvé', 404);
    }

    /**
     * Methode qui execute la route actuel
     *
     * @return void
     */
    public function run(){

        try {

            $route = $this->getRoute();

            
            
            if(!isset($route['controller'])){
                throw new Exception('l\'Url ne peut pas être traité', 500);
            }

            $args = [];

            //REFLECTION
            $reflection = new ReflectionFunction($route['controller']);

            foreach($reflection->getParameters() as $parameter){
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
                
            }

            return call_user_func_array($route['controller'], $args);

        }catch(Exception $e){
            return new Response($e->getCode(), $e->getMessage());
        }

    }

}