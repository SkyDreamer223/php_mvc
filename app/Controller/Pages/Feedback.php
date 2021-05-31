<?php

    namespace App\Controller\Pages;

    use \App\Utils\View;
    use \App\Model\Entity\Feedback as EntityFeedback;
    use \WilliamCosta\DatabaseManager\Pagination;

    Class Feedback extends Page{


        /**
         * Methode qui fait le rendu des messages
         *
         * @param Request $request
         * @param Pagination $obPagination
         * @return string
         */
        private static function getFeedbackItems($request, &$obPagination){

            $items = '';

            $nbFeedback = EntityFeedback::getFeedbacks(null, null, null, 'COUNT(*) AS qtd')->fetchObject()->qtd;

            $queryParams = $request->getQueryParams();
            
            $currentPage = $queryParams['page'] ?? 1;

            $obPagination = new Pagination($nbFeedback, $currentPage, 2);

         

            $results = EntityFeedback::getFeedbacks(null, 'id DESC', $obPagination->getLimit());
            
            while($obFeedback = $results->fetchObject(EntityFeedback::class)){
                
                $items .= View::render('pages/feedback/item', [
                    'nom'       => $obFeedback->nom,
                    'message'   => $obFeedback->message,
                    'date'      => $obFeedback->date
                ]);

                }

            

            return $items;
        }

        /**
         *Methode qui retourne le contenu(view) de l'homepage
         *
         * @param Request $request
         * @return string
         */
        public static function getFeedbacks($request){
            
            
            
            $content = View::render('pages/feedback',[
                'items' => self::getFeedbackItems($request, $obPagination),
                'pagination' => parent::getPagination($request, $obPagination)
            ]);
            
            //RETOURNE LA VIEW DE LA PAGE
            return parent::getPage('Feedback - SkyDreamer', $content);
        }

        /**
         * Methode qui insere les feedbacks
         *
         * @param Request $request
         * @return string
         */
        public static function insertFeedback($request){

            $postVars = $request->getPostVars();

            $obFeedback = new EntityFeedback;
            $obFeedback->nom = $postVars['nom'];
            $obFeedback->message = $postVars['message'];
            $obFeedback->insert();

            
            return self::getFeedbacks($request);
        }
    }