<?php

    namespace App\Controller\Pages;

    use \App\Utils\View;
    use \App\Model\Entity\Organization;

    Class About extends Page{

        /**
         *Methode qui retourne le contenu(view) de l'homepage
         *
         * @return string
         */
        public static function getHome(){

            $obOrganization = new Organization;

            
            
            //VIEW DE HOME
            $content = View::render('pages/about',[
                'name'          => $obOrganization->name,
                'description'   => $obOrganization->description,
                'site'          => $obOrganization->site
            ]);
            
            //RETOURNE LA VIEW DE LA PAGE
            return parent::getPage('About - SkyDreamer', $content);
        }
    }