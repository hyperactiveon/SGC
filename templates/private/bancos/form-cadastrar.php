<?php

    $required = " required ";

?>

<div class="col-sm-12 col-xs-12">
    <div class="panel panel-info">
        <div class="panel-heading"><h3 class="panel-title">Cadastrar Novo Banco:</h3></div>
        <div class="panel-body">
            <form class="form users-new" data-toggle="validator" data-disable="false" role="form" method="POST" action="./bancos">
                <input type="hidden" name="operacao" value="insert">
                <div class="container-fluid float-left">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="razao_social">Código da Instituição (FEBRABAN)</label>
                                        <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-address-card"></i></div>
                                        <input data-error="Campo de preenchimento obrigatório!" class="form-control" type="text" name="cod_instituicao" id="cod_instituicao" placeholder="Código" <?php echo $required; ?>>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    
                                    <div class="form-group">
                                        <label for="nome_fantasia">Nome da Instituição</label>
                                        <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                        <input data-error="Campo de preenchimento obrigatório!" class="form-control" type="text" name="nome" id="nome" placeholder="Nome" <?php echo $required; ?>>
                                        </div>
                                        <div class="help-block with-errors"></div>
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