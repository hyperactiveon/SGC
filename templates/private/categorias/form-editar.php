<?php

    use Ajrc\Model\Categoria;

    $id = (int) trim($data["form"]); //id do usuário
    $f = Categoria::List($id);
    
    if(empty($f)){
        echo "Categoria inexistente!";
        exit();
    }
    
    $required = " required ";

?>

<div class="col-sm-12 col-xs-12">
    <div class="panel panel-info">
        <div class="panel-heading"><h3 class="panel-title">Editar Categoria - <?php echo strtoupper($f->titulo); ?></h3></div>
        <div class="panel-body">
            <form class="form users-new" data-toggle="validator" data-disable="false" role="form" method="POST" action="./categorias">
                <input type="hidden" name="operacao" value="update">
                <input type="hidden" name="id" id="id" value="<?php echo $f->id; ?>">
                <div class="container-fluid float-left">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label for="titulo">Título da Categoria</label>
                                        <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                        <input data-error="Campo de preenchimento obrigatório!" class="form-control" type="text" name="titulo" id="titulo" value="<?php echo $f->titulo; ?>" placeholder="Título da Categoria" <?php echo $required; ?>>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                </div>
                                
                            </div>
                            
                        </div>
                        <div class="col-xs-12" style="padding:20px">
                            <button class="btn btn-success btn-block">SALVAR</button>
                        </div>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>