$(function () {

        if(valor_total_pedido>0){$("a#btnSubmit").removeClass("disabled") }
        $("input#valor_total_pedido").val(valor_total_pedido);
        $("#h3TotalPedido").html("R$ "+valor_total_pedido.replace(".",","));

        $("button.menos").click(function(){
            var btnId = $(this).attr("id");
            var id = btnId.split("-")[1];
            var qtde = parseInt($("input#qtde-"+id).val());
            if(qtde==0) { $("input#qtde-"+id).val(1) } 
            else if(qtde>=1) {
                var preco = parseFloat($("input#preco_unit_item-"+id).val());
                var valor_total_pedido = parseFloat($("input#valor_total_pedido").val());
                var novaQtde = (qtde>1)?qtde--:qtde=1;
                var novoPreco = parseFloat(novaQtde * preco).toFixed(2);
                valor_total_pedido -= parseFloat(preco);
                
                $("input#valor_total_pedido").val(valor_total_pedido);
                $("input#preco_total_item-"+id).val(novoPreco);
                $("span#spanPrecoItem-"+id).html("R$ "+novoPreco.replace(".",","));
                $("#h3TotalPedido").html("R$  "+parseFloat(valor_total_pedido).toFixed(2).replace(".",","));
            }
        });

        $("button.mais").click(function() {
            var btnId = $(this).attr("id");
            var id = btnId.split("-")[1];
            var qtde = parseInt($("input#qtde-"+id).val());
            var qtde_estoque = parseInt($("input#qtde_estoque-"+id).val());
            if( qtde==(qtde_estoque+1) ){ $("input#qtde-"+id).val(qtde_estoque) }
            else if( qtde<=qtde_estoque ){
                var preco = parseFloat($("input#preco_unit_item-"+id).val());
                var valor_total_pedido = parseFloat($("input#valor_total_pedido").val());
                var novaQtde = (qtde<=qtde_estoque)?qtde++:qtde_estoque;
                var novoPreco = parseFloat(novaQtde * preco).toFixed(2);
                valor_total_pedido += parseFloat(preco);

                $("input#valor_total_pedido").val(valor_total_pedido);
                $("input#preco_total_item-"+id).val(novoPreco);
                $("span#spanPrecoItem-"+id).html("R$ "+novoPreco.replace(".",","));
                $("#h3TotalPedido").html("R$  "+parseFloat(valor_total_pedido).toFixed(2).replace(".",","));
            }
        });

        $("a#btnSubmit").click(function(){
            $("form#cart_list").submit();
        });
        
});

function removeItem(produto_id, carrinho_id){$.ajax({type:"POST",url:'./cart',data:{passo:5,produto_id:produto_id,carrinho_id:carrinho_id},success:function(rs,textoStatus,xhr){var preco_total_item=parseFloat($("input#preco_total_item-"+produto_id).val());var valor_total_pedido=parseFloat($("input#valor_total_pedido").val());var novo_valor_total_pedido=parseFloat(valor_total_pedido-preco_total_item).toFixed(2);ClientCart.Del(produto_id);$("input#valor_total_pedido").val(novo_valor_total_pedido);$("#h3TotalPedido").html("R$  "+parseFloat(novo_valor_total_pedido).toFixed(2).replace(".",","));$("#tr-"+produto_id).css({'display':'none'}); if(novo_valor_total_pedido<0.01){ $("a#btnSubmit").addClass("disabled") } },error:function(rs,status,err){console.log('Erro --> ',rs,url,err)}});}