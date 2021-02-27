<?php
/**
* Copyright © CarlosCarrinho, Inc. All rights reserved.
* See COPYING.txt for license details.
*/
ob_start();

require __DIR__ . "/vendor/autoload.php";

use Cadu\App\Controllers\UserController;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Instantiate App
 *
 * In order for the factory to work you need to ensure you have installed
 * a supported PSR-7 implementation of your choice e.g.: Slim PSR-7 and a supported
 * ServerRequest creator (included with Slim PSR-7)
 */
$app = AppFactory::create();

// Add Routing Middleware
$app->addRoutingMiddleware();

/**
 * Add Error Handling Middleware
 *
 * @param bool $displayErrorDetails -> Should be set to false in production
 * @param bool $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool $logErrorDetails -> Display error details in error log
 * which can be replaced by a callable of your choice.

 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(true, false, false);


// Define app routes

#######################
### WEBSITE ROUTES ###
#######################

$app->get('/', function (Request $req, Response $res) {
    $payload = json_encode(['success' => 'Hello world']);
    $res->getBody()->write($payload);
    return $res->withHeader('Content-Type', 'application/json');
});


#######################
### MORPHEUS ROUTES ###
#######################

$app->post('/morpheus/users/create', function (Request $req, Response $res) {
    $payload = json_decode($req->getBody()->getContents());
    $controller = new UserController();
    $result = $controller->addUser((array)$payload);
    $res->getBody()->write(json_encode($result));
    return $res->withHeader('Content-Type', 'application/json');
});

$app->get('/morpheus/users/{id}', function (Request $req, Response $res, $params) {
    $userId = $req->getAttribute('id');

    $result = (new UserController())->getUser($userId);

    $res->getBody()->write(json_encode($result));
    return $res->withHeader('Content-Type', 'application/json');
});

// Run app
$app->run();

ob_end_flush();
