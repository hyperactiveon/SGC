<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Ajrc\Helper\Login;
use Ajrc\Helper\Sessions;
use Ajrc\Model\Usuario;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    
    return $this->renderer->render($response, 'index.phtml', $args);
});


//========================| LOGIN / LOGOUT |=========================================================
//FORMULÁRIO DE LOGIN
$app->get('/account-login', function (Request $request, Response $response, array $args) {

    //USUÁRIO JÁ LOGADO VAI DIRETO PARA O DASHBOARD
    if(strlen( trim( json_encode( Sessions::getData() ) ) ) > 15){
        return $response->withRedirect($this->router->pathFor('account-profile', [], []));
    }

    //DESTROI A SESSAO EXISTENTE FORÇANDO NOVO LOGIN
    Sessions::unregister( "USER_DATA_ID" );
    
    return $this->renderer->render($response, 'public/account/login.phtml', $args);
})->setName('account-login');


//RECEBE OS DADOS ENVIADOS DO FORMULÁRIO DE LOGIN DA ÁREA ADMINISTRATIVA
$app->post('/account-login', function (Request $request, Response $response, array $args) {
    if( Login::validar() ) {

        if(Sessions::isAdmin() || Sessions::isFuncionario()) //se admin ou funcionario, dashboard
        {
            return $response->withRedirect($this->router->pathFor('dashboard', [], []));
        }
        else //cliente é direcionado para a página da sua conta
        {
            return $response->withRedirect($this->router->pathFor('account-profile', [], []));
        }
    
    } 
    else 
    {
        return $response->withRedirect($this->router->pathFor('account-login', [], ['msg'=>'Usuário Inexistente']));
    }

});


//LOGOUT
$app->get('/account-logout', function (Request $request, Response $response, array $args) {

    //DESTROI A SESSÃO E REDIRECIONA PARA O FORMULÁRIO DE LOGIN
    Sessions::unregister( "USER_DATA_ID" );

    return $response->withRedirect($this->router->pathFor('account-login', [], []));

})->setName('account-logout');

//========================| FIM: LOGIN / LOGOUT |=========================================================



$app->get('/account-profile', function (Request $request, Response $response, array $args) {

    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    if(!Sessions::Validator()) { return $response->withRedirect($this->router->pathFor('account-login', [], [])); }
    //----
    
    return $this->renderer->render($response, 'public/account/profile.phtml', $args);
})->setName('account-profile');

