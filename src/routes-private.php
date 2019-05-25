<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Ajrc\Model\Usuario;
use Ajrc\Helper\Login;
use Ajrc\Helper\Sessions;

if(strlen( trim( json_encode( Sessions::getData() ) ) ) < 15){
    header("location: ./login");
}

// Routes

//========================| LOGIN / LOGOUT |=========================================================
//FORMULÁRIO DE LOGIN
$app->get('/login', function (Request $request, Response $response, array $args) {
    
    //USUÁRIO JÁ LOGADO VAI DIRETO PARA O DASHBOARD
    if(strlen( trim( json_encode( Sessions::getData() ) ) ) > 15){
        return $response->withRedirect($this->router->pathFor('dashboard', [], []));
    }

    //DESTROI A SESSAO EXISTENTE FORÇANDO NOVO LOGIN
    Sessions::unregister( "USER_DATA_ID" );
    
    return $this->renderer->render($response, 'private/login/index.phtml', $args);

})->setName('login');

//RECEBE OS DADOS ENVIADOS DO FORMULÁRIO DE LOGIN DA ÁREA ADMINISTRATIVA
$app->post('/login', function (Request $request, Response $response, array $args) {
    
    if( Login::validar() ) {
        return $response->withRedirect($this->router->pathFor('dashboard', [], []));
    } else {
        return $response->withRedirect($this->router->pathFor('login', [], ['msg'=>'Usuário Inexistente']));
    }

});

//LOGOUT
$app->get('/logout', function (Request $request, Response $response, array $args) {

    //DESTROI A SESSÃO E REDIRECIONA PARA O FORMULÁRIO DE LOGIN
    Sessions::unregister( "USER_DATA_ID" );

    return $response->withRedirect($this->router->pathFor('login', [], []));

})->setName('logout');

//========================| FIM: LOGIN / LOGOUT |=========================================================


//========================| DASHBOARD |=========================================================
//DASHBOARD
$app->get('/dashboard', function (Request $request, Response $response, array $args) {
    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    if(strlen( trim( json_encode( Sessions::getData() ) ) ) < 15){
        return $response->withRedirect($this->router->pathFor('login', [], []));
    }

    if( !in_array(base64_decode('admin') ,Sessions::Permissions()) ) {
        echo "O kra não poderá ver esta página";
    }
    
    return $this->renderer->render($response, 'private/dashboard/index.phtml', $args);

})->setName('dashboard');

//========================| FIM: DASHBOARD |=========================================================


//========================| USUÁRIO |=========================================================


$app->any('/usuarios[-{form}]', function (Request $request, Response $response, array $args) {

    if($request->getMethod()=="POST") 
    {

        if( array_key_exists("operacao",$_POST) ) { 
            
            switch($_POST["operacao"]) {
                case "insert":
                    $args = Usuario::Insert();
                    break;
                case "update":
                    //var_dump($_POST);
                    //exit();
                    $args = Usuario::Update();
                    break;
            }

        }
        
    }

    return $this->renderer->render($response, 'private/usuarios/index.phtml', $args);

});

/*
//LISTAGEM DE USUÁRIOS
$app->get('/usuarios', function (Request $request, Response $response, array $args) {

    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    if(strlen( trim( json_encode( Sessions::getData() ) ) ) < 15){
        return $response->withRedirect($this->router->pathFor('login', [], []));
    }
    
    return $this->renderer->render($response, 'private/usuarios/index.phtml', $args);

})->setName('usuarios');

//OPERAÇÃO NO BANCO DE DADOS DE INSERIR NOVO USUÁRIO
$app->post('/usuarios', function (Request $request, Response $response, array $args) {

    if(strlen( trim( json_encode( Sessions::getData() ) ) ) < 15){
        return $response->withRedirect($this->router->pathFor('login', [], []));
    }
    
    $resultado = Usuario::Insert();
    var_dump($resultado);

});


//FORMULÁRIO DE EDIÇÃO DE DADOS DE USUÁRIO ESPECÍFICO
$app->get('/usuario[-{id}]', function (Request $request, Response $response, array $args) {

    if(strlen( trim( json_encode( Sessions::getData() ) ) ) < 15){
        return $response->withRedirect($this->router->pathFor('login', [], []));
    }

    return $this->renderer->render($response, 'private/usuarios/index.phtml', $args);

})->setName('usuario-editar');

//ATUALIZAR DADOS DO USUÁRIO
$app->post('/usuario', function (Request $request, Response $response, array $args) {

    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    if(strlen( trim( json_encode( Sessions::getData() ) ) ) < 15){
        return $response->withRedirect($this->router->pathFor('login', [], []));
    }
    
    $resultado = Usuario::Update();
    if($resultado["status"]){ echo "<br><br>Blz<br><br>"; }
    var_dump($resultado);

});

*/

//========================| FIM: USUÁRIO |=========================================================

