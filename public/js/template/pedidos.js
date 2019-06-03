$(document).ready(function() {
	
	var select = $('.datalist-filter__email').selectize({
		create: false,
		sortField: 'text'
	});

	//$('.date').datepicker();
	
	$('.input-daterange').datepicker();

	$('.slider').ionRangeSlider({
		type: "double",
		grid: false,
		min: 0,
		max: 0,
		from: 0,
		to: 0,
		prefix: "$: ",
		decorate_both: false,
		onChange: function (data) {
			tables.draw();
		}
	});

	var slider = $(".slider").data("ionRangeSlider");

	var tb_abertos = $('#tb_abertos').DataTable( {
		ordering: true,
		order: [[ 0, "desc" ]],
		lengthChange: false,
		pagingType: 'numbers',
		ajax: "data/pedidos/abertos.php",
		stateSave: false,
		columns: [
            { title: "Id" },
            { title: "Código Pedido" },
            { title: "Entrega" },
            { title: "Valor Total" },
            { title: "Status" },
			{ title: "" }
		]
	} );

	var tb_entregar = $('#tb_entregar').DataTable( {
		ordering: true,
		order: [[ 0, "desc" ]],
		lengthChange: false,
		pagingType: 'numbers',
		ajax: "data/pedidos/entregar.php",
		stateSave: false,
		columns: [
            { title: "Id" },
            { title: "Código Pedido" },
            { title: "Entrega" },
            { title: "Valor Total" },
            { title: "Status" },
			{ title: "" }
		]
	} );
	
	var tb_entregando = $('#tb_entregando').DataTable( {
		ordering: true,
		order: [[ 0, "desc" ]],
		lengthChange: false,
		pagingType: 'numbers',
		ajax: "data/pedidos/entregando.php",
		stateSave: false,
		columns: [
            { title: "Id" },
            { title: "Código Pedido" },
            { title: "Entrega" },
            { title: "Valor Total" },
            { title: "Status" },
			{ title: "" }
		]
	} );

	var tb_entregues = $('#tb_entregues').DataTable( {
		ordering: true,
		order: [[ 0, "desc" ]],
		lengthChange: false,
		pagingType: 'numbers',
		ajax: "data/pedidos/entregues.php",
		stateSave: false,
		columns: [
            { title: "Id" },
            { title: "Código Pedido" },
            { title: "Entrega" },
            { title: "Valor Total" },
            { title: "Status" },
			{ title: "" }
		]
	} );

	var tb_finalizados = $('#tb_finalizados').DataTable( {
		ordering: true,
		order: [[ 0, "desc" ]],
		lengthChange: false,
		pagingType: 'numbers',
		ajax: "data/pedidos/finalizados.php",
		stateSave: false,
		columns: [
            { title: "Id" },
            { title: "Código Pedido" },
            { title: "Entrega" },
            { title: "Valor Total" },
            { title: "Status" },
			{ title: "" }
		]
	} );

	var tb_cancelados = $('#tb_cancelados').DataTable( {
		ordering: true,
		order: [[ 0, "desc" ]],
		lengthChange: false,
		pagingType: 'numbers',
		ajax: "data/pedidos/cancelados.php",
		stateSave: false,
		columns: [
            { title: "Id" },
            { title: "Código Pedido" },
            { title: "Entrega" },
            { title: "Valor Total" },
            { title: "Status" },
			{ title: "" }
		]
	} );
	
	
	
});
