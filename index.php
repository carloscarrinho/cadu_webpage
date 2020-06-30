<?php
ob_start();

require __DIR__ . "/vendor/autoload.php";


/**
 * BOOTSTRAP
 */
use CoffeeCode\Router\Router;

$route = new Router(url(), "@");


/**
 * WEB ROUTES
 */
$route->namespace("Source\App");
$route->get("/", "Web@home");
$route->get("/about", "Web@about");


/**
 * ERROR ROUTES
 */
$route->namespace("Source\App")->group("ops");
$route->get("/{errcode}", "Web@error");


/**
 * 
 */
$route->dispatch();


/**
 * ERROR REDIRECT
 */
if($route->error()){
    $route->redirect("/ops/{$route->error()}");
}


ob_end_flush();