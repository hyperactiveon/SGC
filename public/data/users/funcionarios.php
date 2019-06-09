<?php
require '../../../vendor/autoload.php';

session_start();

use Ajrc\Helper\Sessions;
use Ajrc\Model\Usuario;

//DIRECIONA USUÁRIO NÃO LOGADO AO FORM DE LOGIN E VERIFICA SE É ADMIN OU FUNCIONÁRIO
if(!Sessions::Validator() || !Sessions::UserPermissionsValidateCms()){ header("location:../.././account-login"); }
//----

//RETORNA O ARQUIVO COMO JSON, FORMATO UTILIZADO PELO DATATABLES
header('Content-Type: application/json;charset=utf-8');

?>

{ 
    "data": 
        [ 
            <?php Usuario::ListAllAdmins("funcionario=1"); ?>    
           
        ]
}