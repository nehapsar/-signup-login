<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\controllers\LoginController;
$app = new \Slim\App();

$app->post('/add' , function (Request $request,Response $response,$args){
    $data=$request->getParsedBody();
    $userObj = new \App\controllers\LoginController();
    $result =$userObj->createUser($data["name"],$data["userName"],$data["password"],$data["mobileNumber"]);
    return $response->withJson($result);
});

$app->get('/user/{username}', function (Request $request, Response $response, $args) {
    $username = $args['username'];
    $userObj = new \App\controllers\LoginController();
    $userData = $userObj->getUserByUsername($username);
    return $response->withJson($userData);
});

$app->get('/userAll', function (Request $request, Response $response, $args) {
    $userObj = new \App\controllers\LoginController();
    $userData = $userObj->getAllUserInformation();
    return $response->withJson($userData);
});

$app->run();

