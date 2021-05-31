<?php

use \App\Http\Response;
use \App\Controller\Pages;

$obRouter->get('/', [
    function(){
        return new Response(200, Pages\Home::getHome());
    }
]);

$obRouter->get('/about', [
    function(){
        return new Response(200, Pages\About::getAbout());
    }
]);

$obRouter->get('/page/{idPage}/{action}', [
    function($idPage, $action){
        return new Response(200, 'Page '.$idPage.' - '.$action);
    }
]);

$obRouter->get('/feedback', [
    function($request){
        return new Response(200, Pages\Feedback::getFeedbacks($request));
    }
]);

$obRouter->post('/feedback', [
    function($request){
        return new Response(200, Pages\Feedback::insertFeedback($request));
    }
]);