<?php
    use Ajrc\Model\Usuario;
    use Ajrc\Model\Banco;

    //----| RETORNA TODOS USUÁRIOS FUNCIONARIOS E ADMINS PARA UTILIZAR COM TITULARES DE CONTA |----
    $titular = null;
    $result = Usuario::ListAll("id, nome","WHERE funcionario='1' OR admin='1'");
    foreach($result as $u){
        $titular.= "<option value='".$u->id."'>".$u->nome."</option>"; 
    };
    //----

    //----| RETORNA TODOS BANCOS |----
    $banco = null;
    $result = Banco::ListAll("id, cod_instituicao, nome","ORDER BY nome ASC");
    foreach($result as $b){
        $banco.= "<option value='".$b->id."'>".$b->cod_instituicao." - ".$b->nome."</option>"; 
    };
    //----

    $required = " required ";

?>

<div class="col-sm-12 col-xs-12">
    <div class="panel panel-info">
        <div class="panel-heading"><h3 class="panel-title">Cadastrar Nova Conta:</h3></div>
        <div class="panel-body">
            <form class="form users-new" data-toggle="validator" data-disable="false" role="form" method="POST" action="./contas">
                <input type="hidden" name="operacao" value="insert">
                <div class="container-fluid float-left">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="titulo">TÍTULO DA CONTA</label>
                                        <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                        <input data-error="Campo de preenchimento obrigatório!" class="form-control" type="text" name="titulo" id="titulo" placeholder="Título" <?php echo $required; ?>>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="">TIPO DA CONTA</label><br>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="cc" name="tipo_conta" value="CONTA CORRENTE" <?php echo $required; ?>>
                                            <label for="cc">CONTA CORRENTE</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="cp" name="tipo_conta" value="CONTA POUPANCA" <?php echo $required; ?>>
                                            <label for="cp">POUPANÇA</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="cs" name="tipo_conta" value="CONTA SLARIO" <?php echo $required; ?>>
                                            <label for="cs">CONTA SALÁRIO</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="cd" name="tipo_conta" value="CONTA DIGITAL" <?php echo $required; ?>>
                                            <label for="cd">DIGITAL</label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="agencia">AGÊNCIA</label>
                                        <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-address-card"></i></div>
                                        <input class="form-control" type="text" name="agencia" id="agencia" placeholder="Número da Agência Bancária" data-error="Campo de preenchimento obrigatório!" <?php echo $required; ?>>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="saldo">SALDO</label>
                                        <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-money"></i></div>
                                        <input class="form-control" type="text" name="saldo" id="saldo" placeholder="Saldo da Conta Bancária" data-error="Campo de preenchimento obrigatório!" <?php echo $required; ?>>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    
                                    <div class="form-group">
                                        <label for="tbu_titular">TITULAR DA CONTA</label>
                                        <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                        <select class="selectpicker" name="tbu_titular" id="tbu_titular" data-error="Campo obrigatório!" <?php echo $required; ?>>
                                            <option value="">selecione</option>
                                            <?php echo $titular; ?>
                                        </select>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="tbfb_banco">BANCO</label>
                                        <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-bank"></i></div>
                                        <select class="selectpicker" name="tbfb_banco" id="tbfb_banco" data-error="Campo obrigatório!" <?php echo $required; ?>>
                                            <option value="">selecione</option>
                                            <?php echo $banco; ?>
                                        </select>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="numero">NÚMERO DA CONTA</label>
                                        <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-bank"></i></div>
                                        <input data-error="Campo de preenchimento obrigatório!" class="form-control" type="text" name="numero" id="numero" placeholder="Número da Conta Bancária" <?php echo $required; ?>>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">STATUS DA CONTA</label><br>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="ativo" name="ativo" value="1" checked <?php echo $required; ?>>
                                            <label for="ativo">Ativa</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="inativo" name="ativo" value="0" <?php echo $required; ?>>
                                            <label for="ativo">Inativa</label>
                                        </div>
                                    </div>


                                </div>

                            </div>
                            
                        </div>
                        <div class="col-xs-12" style="padding:20px">
                            <button class="btn btn-success btn-block">CADASTRAR</button>
                        </div>
                        
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>