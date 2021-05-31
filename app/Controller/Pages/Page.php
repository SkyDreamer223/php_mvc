<?php

    namespace App\Controller\Pages;

    use \App\Utils\View;

    Class Page {

        private static function getHeader() {
            return View::render('pages/header');
        }

        private static function getFooter() {
            return View::render('pages/footer');
        }

        public static function getPage($title, $content){
            return View::render('pages/page',[
                'title'     => $title,
                'header'    => self::getHeader(),
                'content'   => $content,
                'footer'    => self::getFooter()
            ]);
        }

        /**
         * Methode pour rendre le layout de pagination
         *
         * @param Request $request
         * @param Pagination $obPagination
         * @return string
         */
        public static function getPagination($request, $obPagination){

            $pages = $obPagination->getPages();
            
            //VERIFIER S'IL Y A PLUS D'UNE PAGE
            if(count($pages) <= 1) return '';

            $links = '';

            //URL SANS GET
            $url = $request->getRouter()->getCurrentUrl();
            

            //GET
            $queryParams = $request->getQueryParams();

            //LINK RENDERING
            foreach($pages as $page){
                //CHANGE LA PAGE
                $queryParams['page'] = $page['page'];
            
                //LINK
                $link  = $url.'?'.http_build_query($queryParams);
                
                //VIEW
                $links .= View::render('pages/pagination/link',[
                    'page' => $page['page'],
                    'link' => $link,
                    'active' => $page['current'] ? 'active' : ''
                ]);
            }

            return View::render('pages/pagination/box',[
                'links' => $links
            ]);

        }    
    }