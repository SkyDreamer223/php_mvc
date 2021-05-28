<?php

    namespace App\Controller\Pages;

    use \App\Utils\View;

    Class Home extends Page{

        /**
         *Methode qui retourne le contenu(view) de l'homepage
         *
         * @return string
         */
        public static function getHome(){
            
            //VIEW DE HOME
            $content = View::render('pages/page',[
                'name' => 'Saturnino Monteiro',
                'description' => 'Github: https://github.com/SkyDreamer223'
            ]);
            
            //RETOURNE LA VIEW DE LA PAGE
            return parent::getPage('Saturnino GitHub', $content);
        }
    }