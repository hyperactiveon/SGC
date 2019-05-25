<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Ajrc\Model\Usuario;
use Ajrc\Helper\Login;
use Ajrc\Helper\Sessions;

// Routes

$app->get('/login', function (Request $request, Response $response, array $args) {
    
    //USUÁRIO JÁ LOGADO VAI DIRETO PARA O DASHBOARD
    if(strlen( trim( json_encode( Sessions::getData() ) ) ) > 15){
        return $response->withRedirect($this->router->pathFor('dashboard', [], []));
    }

    //DESTROI A SESSAO EXISTENTE FORÇANDO NOVO LOGIN
    Sessions::unregister( "USER_DATA_ID" );
    
    return $this->renderer->render($response, 'private/login/index.phtml', $args);

})->setName('login');


$app->get('/logout', function (Request $request, Response $response, array $args) {

    //DESTROI A SESSÃO E REDIRECIONA PARA O FORMULÁRIO DE LOGIN
    Sessions::unregister( "USER_DATA_ID" );

    return $response->withRedirect($this->router->pathFor('login', [], []));

})->setName('logout');


//RECEBE OS DADOS ENVIADOS DO FORMULÁRIO DE LOGIN DA ÁREA ADMINISTRATIVA
$app->post('/login', function (Request $request, Response $response, array $args) {
    
    if(Login::validar()) {
        return $response->withRedirect($this->router->pathFor('dashboard', [], []));
    } else {
        return $response->withRedirect($this->router->pathFor('login', [], ['msg'=>'Usuário Inexistente']));
    }

});


//DASHBOARD
$app->get('/dashboard', function (Request $request, Response $response, array $args) {
    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    if(strlen( trim( json_encode( Sessions::getData() ) ) ) < 15){
        return $response->withRedirect($this->router->pathFor('login', [], []));
    }

    if( !in_array(base64_decode('admin') ,Sessions::Permissions()) ) {
        echo "O kra não poderá ver esta página";

        //pensar no redirect
    }
    
    return $this->renderer->render($response, 'private/dashboard/index.phtml', $args);

})->setName('dashboard');


//LISTAGEM DE USUÁRIOS
$app->get('/usuarios', function (Request $request, Response $response, array $args) {

    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    if(strlen( trim( json_encode( Sessions::getData() ) ) ) < 15){
        return $response->withRedirect($this->router->pathFor('login', [], []));
    }
    
    return $this->renderer->render($response, 'private/usuarios/index.phtml', $args);

})->setName('usuarios');


//INSERIR NOVO USUÁRIO
$app->post('/usuarios', function (Request $request, Response $response, array $args) {

    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    if(strlen( trim( json_encode( Sessions::getData() ) ) ) < 15){
        return $response->withRedirect($this->router->pathFor('login', [], []));
    }
    
    return Usuario::Insert();
    //return $this->renderer->render($response, 'private/usuarios/index.phtml', $args);

})->setName('usuario-inserir');


//LISTAGEM DE USUÁRIO ESPECÍFICO
$app->get('/usuario[-{id}]', function (Request $request, Response $response, array $args) {

    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    if(strlen( trim( json_encode( Sessions::getData() ) ) ) < 15){
        return $response->withRedirect($this->router->pathFor('login', [], []));
    }

    return $this->renderer->render($response, 'private/usuarios/index.phtml', $args);
    //return Usuario::ListAll();

})->setName('usuario');

//ATUALIZAR DADOS DO USUÁRIO
$app->post('/usuario[-{id}]', function (Request $request, Response $response, array $args) {

    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    if(strlen( trim( json_encode( Sessions::getData() ) ) ) < 15){
        return $response->withRedirect($this->router->pathFor('login', [], []));
    }
    
    return Usuario::Update();

})->setName('usuario-atualizar');



