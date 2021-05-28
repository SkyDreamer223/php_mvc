<?php

    namespace App\Controller\Pages;

    use \App\Utils\View;

    Class Page {

        public static function getPage($title, $content){
            return View::render('pages/page',[
                'title' => $title,
                'content' =>$content
            ]);
        }
    }