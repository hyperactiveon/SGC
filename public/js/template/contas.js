$(document).ready(function() {
	
	var select = $('.datalist-filter__email').selectize({ create: false, sortField: 'text' });
	var slider = $(".slider").data("ionRangeSlider");

	var tb_contas = $('#tb_contas').DataTable( {
		ordering: true,
		lengthChange: false,
		pagingType: 'numbers',
		ajax: "data/financeiro/contas.php",
		stateSave: false,
		columns: [
            { title: "Id" },
            { title: "Titulo" },
            { title: "Titular" },
            { title: "Banco" },
            { title: "Tipo" },
            { title: "Saldo" },
            { title: "Status" },
            { title: "" }
		]
	} );

});