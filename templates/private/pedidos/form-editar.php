<?php

use Ajrc\Helper\Sessions;
use Ajrc\Model\Carrinho;
use Ajrc\Model\Pedido;

$id_carrinho = trim($data["form"]);
$pedido = Pedido::getAccountListOrdersDetailsPublic( $id_carrinho );

$codigo_pedido = $pedido[0]->codigo_pedido;
$forma_pagto = ($pedido[0]->forma_pagto=="boleto")?"Boleto Bancário":"Cartão de Crédito:<br>".$pedido[0]->total_parcelas." parcelas x R\$ ".number_format($pedido[0]->valor_parcela,2,',','.');
$modalidade_frete = $pedido[0]->modalidade_frete;
$valor_frete = $pedido[0]->valor_frete;
$valor_total = $pedido[0]->valor_total;
$valor_subtotal = $valor_total-$valor_frete;
$estagio_atual = $pedido[0]->estagio_atual;
$de = explode("-",$pedido[0]->endereco_frete);
$endereco_frete = $de[0];
$complemento_frete = ($de[1]!=" ")?$de[1]."<br>":null;
$bairro_frete = $de[2];
$cidadeUf_frete = $de[3];

$endereco_entrega = $endereco_frete . $complemento_frete.$bairro_frete."<br>".$cidadeUf_frete."<br>";
if($modalidade_frete=="LOCAL"){ $endereco_entrega = "Ocorrerá a retirada na Loja!"; }

$sttPedidos = ["AGUARDANDO PAGAMENTO"=>"AUTHORIZED","PAGO"=>"CONFIRMED","ENTREGANDO"=>"SHIPPING","ENTREGUE"=>"SHIPPED","FINALIZADO"=>"FINISHED","CANCELADO"=>"DECLINED"];
$selSttPedidos = '<select id="sttPedidos" name="estagio_atual" class="form-control" style="background:#fff">';
foreach($sttPedidos as $k=>$i){
  $sel = null;
  if($estagio_atual==$i){ $sel = " selected";}
  $selSttPedidos.= '<option value="'.$i.'"'.$sel.'>'.$k.'</option>';
}
$selSttPedidos.= '</select>';

?>
<div class="col-sm-12 col-xs-12">
    <div class="panel panel-info">
        <div class="panel-heading"><h3 class="panel-title">Editar Pedido - <?php echo $pedido[0]->codigo_pedido; ?></h3></div>
        <div class="panel-body">
    <!-- Main Content -->
            
            <div class="card" style="padding:30px">
                <div class="card-body" style="padding:30px">
                <form method="POST" style="padding:10px">
                <input type="hidden" name="operacao" value="update">
                <input type="hidden" name="id_carrinho" value="<?php echo $id_carrinho; ?>">
                    <!--h3 class="text-center my-0"><small class="mb-0">Código do Pedido:</small><br><?php echo $pedido[0]->codigo_pedido; ?></h3-->
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                            <label for="sttPedidos">STATUS DO PEDIDO</label>
                            <?php  echo $selSttPedidos; ?>
                        </div>
                        <div class="form-group text-right">
                            <a class="btn btn-primary btn-sm rounded-pill" href="./account-orderprint-details-<?php echo $id_carrinho; ?>" target="_blank">Imprimir</a>
                            <button type="submit" class="btn btn-success btn-large rounded-pill" id="btnSalvar" href="#" style="padding:10px"><strong>SALVAR</strong></button>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                    <table class="table table-dark">
                        <tbody>
                        <?php 
                                $valor_total_sem_juros = 0.00;
                                foreach($pedido as $item) { 
                        ?>
                        <tr>
                            <td class="cart-title">
                            <a href="./produto-<?php echo $item->produto_id; ?>" class="h6 bold d-inline-block h3" title="<?php echo $item->produto_titulo; ?>"><?php echo $item->produto_titulo; ?></a>
                            <div class="small"><b>Preço Unitário</b>: R$ <?php echo number_format(($item->preco_item),2,',','.'); ?></div>
                            </td>
                            <td class="cart-qty nostretch">Qtde: <?php echo $item->qtde_item; ?></td>
                            <td class="cart-price text-right"><span class="roboto-condensed bold">R$ <?php echo number_format(($item->qtde_item*$item->preco_item),2,',','.'); ?></span></td>
                        </tr>
                        <?php 
                                echo '<input type="hidden" name="produtos_id[]" value="'.$item->produto_id.'">';
                                echo '<input type="hidden" name="qtde_itens[]" value="'.$item->qtde_item.'">';
                                $valor_total_sem_juros+=($item->qtde_item*$item->preco_item);
                                } 
                                $porcentagem_juros = ($pedido[0]->forma_pagto!="boleto")?round((100-($valor_total_sem_juros*100)/$valor_total),2):null;
                        ?>
                        </tbody>
                    </table>
                    </div>
                  <div class="text-right">
                    <table class="table">
                        <tbody>
                          <tr>
                            <td>Subtotal</td>
                            <td style="width:150px" class="roboto-condensed bold">R$ <?php echo number_format($valor_subtotal,2,',','.'); ?></td>
                          </tr>
                          <tr>
                            <td>Frete / Entrega</td>
                            <td><?php echo $modalidade_frete; ?> <span class="roboto-condensed bold">(R$  <?php echo number_format($valor_frete,2,',','.'); ?>)</span></td>
                          </tr>
                          <tr>
                            <td class="bold h4">TOTAL</td>
                            <td class="roboto-condensed bold text-success h4">R$ <?php echo number_format($valor_total,2,',','.'); ?></td>
                          </tr>
                        </tbody>
                      </table>
                      <hr>
                  </div>

                  <div class="row mb-2">
                    <div class="col-lg-6">
                      <h5 class="bold"><u>Endereço de Entrega:</u></h5>
                      <?php echo $endereco_entrega; ?>
                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0">
                      <h5 class="bold"><u>Forma de Pagamento:</u></h5>
                      <strong><?php echo $forma_pagto; ?></strong><?php echo ($pedido[0]->forma_pagto!="boleto")?" <sup><small>* $porcentagem_juros% de juros</small></sup>":null; ?><br>
                      <h5 class="bold mt-4"><u>Sobre o Frete:</u></h5>
                      Modalidade: <strong><?php echo ($pedido[0]->modalidade_frete=="LOCAL")?"Retirar na Loja":$pedido[0]->modalidade_frete; ?></strong><br/>
                      Prazo de Entrega: <strong><?php echo ($pedido[0]->prazo_frete=="0")?"Já disponível para retirada":$pedido[0]->prazo_frete."dia(s)<sup>**</sup></strong>"; ?> <br/>
                      
                    </div>
                  </div>
                  

                </div>
              </div>
              </form>
        </div>

    <!-- /Main Content -->

    </div>
    </div>
    </div>
</div>

