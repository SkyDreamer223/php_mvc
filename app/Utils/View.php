<?php

namespace App\Utils;

Class View {

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
     * @return string
     */
    public static function render($view){

        $contentView = self::getContentView($view);
        return $contentView;
    }
}