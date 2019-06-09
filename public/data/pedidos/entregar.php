<?php 

require '../../../vendor/autoload.php';

session_start();

use Ajrc\Helper\Sessions;
use Ajrc\Model\Pedido;

//DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN E VERIFICA SE É ADMIN OU FUNCIONÁRIO
if(!Sessions::Validator() || !Sessions::UserPermissionsValidateCms()){ header("location:../.././account-login"); }
//----

header('Content-Type: application/json;charset=utf-8');

?>

{ 
    "data": 
        [ 
            <?php Pedido::ListAllCms("","WHERE estagio_atual='CONFIRMED'"); ?>    
           
        ]
}
