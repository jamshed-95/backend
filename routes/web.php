<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/', function () use ($router) {
    return "call To Admin";
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/addBlog', 'ApiController@addBlog');
    $router->post('/addBlogContent', 'ApiController@addBlogContent');
    $router->post('/addFeedBack', 'ApiController@addFeedBack');

});


$router->group(['prefix' => 'get'], function () use ($router) {

    $router->get('/blogs', 'LandingController@getBlogs');
    $router->get('/blogContent/{id}', 'LandingController@blogContent');
});


$router->group(['prefix' => 'mail'], function () use ($router) {
    $router->post('/follow/{email}', 'MailController@mailer');
    $router->post('/subscribe/{email}', 'MailController@sendToBubble');
});





