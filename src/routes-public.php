<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Ajrc\Helper\Login;
use Ajrc\Helper\Sessions;
use Ajrc\Model\Usuario;

// Routes
//========================| PÁGINA PRINCIPAL |=========================================================
$app->get('/', function (Request $request, Response $response, array $args) {
    
    return $this->renderer->render($response, 'public/home/index.phtml', $args);
    
})->setName('home-page');
//========================| FIM : PÁGINA PRINCIPAL |=========================================================


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
        else //cliente é direcionado para a página HOME PAGE / PÁGINA PRINCIPAL
        {
            return $response->withRedirect($this->router->pathFor('home-page', [], []));
        }
    
    } 
    else 
    {
        return $response->withRedirect($this->router->pathFor('account-login', [], ['msg'=>base64_encode('Usuário Inexistente')]));
    }

});

//LOGOUT
$app->get('/account-logout', function (Request $request, Response $response, array $args) {

    //DESTROI A SESSÃO E REDIRECIONA PARA PÁGINA PRINCIPAL DO SITE
    Sessions::unregister( "USER_DATA_ID" );

    return $response->withRedirect($this->router->pathFor('home-page', [], []));

})->setName('account-logout');

//========================| FIM: LOGIN / LOGOUT |=========================================================

//========================| REGISTRE-SE |=========================================================
//RECEBE OS DADOS ENVIADOS DO FORM DE INSERÇÃO NA ÁREA PÚBLICA - PROFILE DO USUÁRIO
$app->post('/account-insert', function (Request $request, Response $response, array $args) {

    Usuario::Insert();

    return $response->withRedirect($this->router->pathFor('account-login', [], ["msg"=>base64_encode("Cadastro realizado com sucessso!<br>Realize login, por favor!")]));

});
//----

//RECEBE OS DADOS ENVIADOS DO FORMULÁRIO DE REGISTRA-SE NA ÁREA PÚBLICA E EXIBE O FORM DE INSERÇÃO
$app->post('/account-register', function (Request $request, Response $response, array $args) {
    
    //VERIFICA SE JÁ EXISTE REGISTRO DO E-MAIL NO BANCO DE DADOS
    $ja_cadastrado = Usuario::CheckExistsEmail( trim($_POST["email"]) );
    //----

    if(is_object($ja_cadastrado)) { //SE JÁ EXISTIR

        return $response->withRedirect($this->router->pathFor('account-login', [], ["msg"=>base64_encode("<strong>E-mail já cadastrado em nosso sistema!</strong><br>Recupere sua senha clicando no link \"Esqueceu sua senha?\"")]));
   
    } else {

        return $this->renderer->render($response, 'public/account/register.phtml', $args);
    }

});
//----

$app->get('/account-profile', function (Request $request, Response $response, array $args) {

    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    if(!Sessions::Validator()) { return $response->withRedirect($this->router->pathFor('account-login', [], [])); }
    //----
    
    return $this->renderer->render($response, 'public/account/profile.phtml', $args);

})->setName('account-profile');


