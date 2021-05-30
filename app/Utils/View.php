<?php

namespace App\Utils;

Class View {

    private static $vars = [];

    /**
     * Methode qui initialise les données de la classe
     *
     * @param array $vars
     * @return void
     */
    public static function init($vars = []){
        self::$vars = $vars;
    }

    

    /**
     * Methode qui retourne le contenu d'une view
     * 
     * @param string $view
     * @return string
     */
    private static function getContentView($view){

        $file = __DIR__.'/../../src/view/'.$view.'.html';
        
        return file_exists($file) ? file_get_contents($file) : '';

    }

    /**
     * Methode qui retourne le contenu rendu d'une view
     *
     * @param string $view
     * @param array $vars (string, numeric)
     * @return string
     */
    public static function render($view, $vars = []){

        $contentView = self::getContentView($view);

        $vars = array_merge(self::$vars, $vars);

        $keys =  array_keys($vars);
        $keys = array_map(function($item){
            return '{{'.$item.'}}';
        },$keys);
        
        return str_replace($keys, array_values($vars), $contentView);
        
    }

}