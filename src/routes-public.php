<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Ajrc\Helper\Login;
use Ajrc\Helper\Sessions;
use Ajrc\Model\Usuario;
use Ajrc\Model\ListaDesejo;
use Ajrc\Model\Carrinho;



// Routes
//----| PÁGINA PRINCIPAL |----
$app->get('/', function (Request $request, Response $response, array $args) {
    
    return $this->renderer->render($response, 'public/home/index.phtml', $args);
    
})->setName('home-page');
//----

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
            $rota = 'home-page';
            if(strpos(trim($_POST["pagina_atual"]), "/cart")>0 || strpos(trim($_POST["pagina_origem"]), "/cart")>0){
                $rota = 'cart';
            }
            return $response->withRedirect($this->router->pathFor($rota, [], []));
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
//----
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

    if(is_object($ja_cadastrado) && $ja_cadastrado->total>0) { //SE JÁ EXISTIR

        return $response->withRedirect($this->router->pathFor('account-login', [], ["msg"=>base64_encode("<strong>E-mail já cadastrado em nosso sistema!</strong><br>Recupere sua senha clicando no link \"Esqueceu sua senha?\"")]));
   
    } else {

        return $this->renderer->render($response, 'public/account/register.phtml', $args);
    }

});
//----

//RECEBE OS DADOS ENVIADOS DO FORMULÁRIO RECUPERAR SENHA (ESQUECI MINHA SENHA)
$app->post('/account-recpass', function (Request $request, Response $response, array $args) {
    
    //VERIFICA SE JÁ EXISTE REGISTRO DO E-MAIL NO BANCO DE DADOS
    $ja_cadastrado = Usuario::CheckExistsEmail( trim($_POST["email"]) );
    //----

    if(is_object($ja_cadastrado) && $ja_cadastrado->total>0) { //SE JÁ EXISTIR
        $enviarEmailRecuperacao = \Ajrc\Helper\Email::sendEmailRecuperacaoSenha($ja_cadastrado->nome, trim($_POST["email"]));
        if($enviarEmailRecuperacao["status"]==200) {
            echo \Ajrc\Helper\AlertBootStrap4::get("success",$enviarEmailRecuperacao["message"],6000);
        } else {
            echo \Ajrc\Helper\AlertBootStrap4::get("danger","Tivemos um problema!<br>Tente novamente mais tarde",6000);
        } 
    } else {
        echo \Ajrc\Helper\AlertBootStrap4::get("danger",trim($_POST["email"]) . " NÃO cadastrado!",6000);
    }

});
//----

$app->get('/account-profile', function (Request $request, Response $response, array $args) {

    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    if(!Sessions::Validator()) { return $response->withRedirect($this->router->pathFor('account-login', [], [])); }
    //----
    
    return $this->renderer->render($response, 'public/account/profile.phtml', $args);

})->setName('account-profile');

//----| LISTA DE PEDIDOS: EXIBE UMA LISTA COM TODOS OS PEDIDOS DO USUÁRIO |----
$app->get('/account-orders', function (Request $request, Response $response, array $args) {

    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    if(!Sessions::Validator()) { return $response->withRedirect($this->router->pathFor('account-login', [], [])); }
    //----
    
    return $this->renderer->render($response, 'public/account/pedidos.phtml', $args);

})->setName('account-orders');
//----

//----| DETALHES PEDIDOS: EXIBE TODA INFORMAÇÃO PERTINENTE AO PEDIDO SELECIONADO |----
$app->get('/account-order-details[-{id}]', function (Request $request, Response $response, array $args) {

    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    if(!Sessions::Validator()) { return $response->withRedirect($this->router->pathFor('account-login', [], [])); }
    //----
    
    return $this->renderer->render($response, 'public/account/pedido-detalhes-cliente.phtml', $args);

})->setName('account-orders');
//----

//----| IMPRIMIR DETALHES PEDIDOS: |----
$app->get('/account-orderprint-details[-{id}]', function (Request $request, Response $response, array $args) {

    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    if(!Sessions::Validator()) { return $response->withRedirect($this->router->pathFor('account-login', [], [])); }
    //----
    
    return $this->renderer->render($response, 'public/account/pedido-detalhes-cliente-imprimir.phtml', $args);

})->setName('account-orders');
//----

//----| LISTA DE DESEJOS: EXIBE A LISTA DE DESEJOS DENTRO DO PERFIL DO USUÁRIO |---- NÃO CONCLUÍDO
$app->get('/account-whishlist', function (Request $request, Response $response, array $args) {

    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    if(!Sessions::Validator()) { 
        return $response->withRedirect($this->router->pathFor('account-login', [], [])); 
    }
    //----
    
    return $this->renderer->render($response, 'public/account/listadesejos.phtml', $args);

});
//----

//----| LISTA DE DESEJOS: EXIBE A LISTA DE DESEJOS DENTRO DO PERFIL DO USUÁRIO |---- NÃO CONCLUÍDO
$app->post('/add-whislist', function (Request $request, Response $response, array $args) {
    
    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    if(!Sessions::Validator()) { return "{'status':'0','message':'Vc nnão tem permissão'}"; exit(); }
    //----
    
    ListaDesejo::Insert();

});
//----

//----| PRODUTO: EXIBE OS DADOS DO PRODUTO SELECIONADO |----
$app->get('/produto[-{id}]', function (Request $request, Response $response, array $args) {

    $args["uri"] = $request->getUri()->getPath();
    return $this->renderer->render($response, 'public/produtos/produto.phtml', $args);

});
//----

//----| CARRINHO: TUDO QUE ENVOLVA A AÇÃO DO CLIENTE (INSERIR, ALTERAR E EXCLUIR) |----
$app->any('/cart[-{id:[0-9]+}[-{titulo}]]',function(Request $request, Response $response, array $args){

    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    //if(!Sessions::Validator()) { return $response->withRedirect($this->router->pathFor('account-login', [], [])); }
    //----

    if($request->getMethod()=="POST") 
    {
        if( array_key_exists("passo",$_POST) ) { 
            
            switch($_POST["passo"]) {
                case 1: //EXIBE OS DADOS DO CLIENTE PARA ENTREGA
                    return $this->renderer->render($response, 'public/checkout/entrega.phtml', $args);
                    break;
                case 2: //EXIBE AS FORMAS DE PAGAMENTO PARA ESCOLHA DO CLIENTE
                    return $this->renderer->render($response, 'public/checkout/formaspagto.phtml', $args);
                    break;
                case 3: //ENVIA OS DADOS DO PAGAMENTO PARA O PAGSEGURO - BOLETO
                    return $this->renderer->render($response, 'public/checkout/finalizacao-boleto.phtml', $args);
                    break;
                case 4: //ENVIA OS DADOS DO PAGAMENTO PARA O PAGSEGURO - CARTÃO DE CRÉDITO
                    return $this->renderer->render($response, 'public/checkout/finalizacao-cartaocredito.phtml', $args);
                    break;
                case 5: //REMOVER ITEM DO CARRINHO
                    echo Carrinho::Delete ( (int) trim($_POST['carrinho_id']), (int) $_POST['produto_id'] );
                    exit();
                    break;
                default:
                    return $this->renderer->render($response, 'public/checkout/carrinho.phtml', $args);
            }

        }

    }
    else if($request->getMethod()=="GET") //EXIBE O CARRINHO COM A LISTA DE PRODUTOS ADICIONADOS OU NÃO (VAZIO)
    {
        return $this->renderer->render($response, 'public/checkout/carrinho.phtml', $args);
    }
   

})->setName("cart");
//----

$app->post('/getFrete',function(Request $request, Response $response, array $args) {

    //DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN
    if(!Sessions::Validator()) { echo "Você não tem permissão!"; exit(); }
    //----
    return Ajrc\Helper\Correios::GetFreteGuzzle($_POST['cep'],$_POST['dados']);
})->setName("getfrete");

//----| CATEGORIA: EXIBE TODOS OS PRODUTOS DA CATEGORIA SELECIONADA |----
$app->get('/categoria[-{id:[0-9]+}[-{order}[-{titulo}]]]',function(Request $request, Response $response, array $args){

    return $this->renderer->render($response, 'public/categorias/index.phtml', $args);

})->setName("categoria");
//----

//----| CONTATO : FALE CONOSCO |----
$app->any('/contate-nos',function(Request $request, Response $response, array $args){

    if($request->getMethod()=="POST") 
    {
        $rs = \Ajrc\Model\Contato::sendFaleConosco();
        echo $rs["message"];
        exit();
    }

    return $this->renderer->render($response, 'public/contato/index.phtml', $args);

})->setName("contato");
//----

//----| BUSCADOR : RECEBE O TERMO PROCURADO |----
$app->post('/buscador',function(Request $request, Response $response, array $args){
 
    return $this->renderer->render($response, 'public/buscador/index.phtml', $args);

})->setName("buscador");
//----

//----| 404: PAGE NOT FOUND |----
$app->get('/{params:.*}', function ($request, $response, $args) {
   echo "Not found?";
   return $this->renderer->render($response, 'public/404.phtml', $args);
})->setName("notfound");
//----

