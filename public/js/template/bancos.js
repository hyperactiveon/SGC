$(document).ready(function() {
	
	var select = $('.datalist-filter__email').selectize({ create: false, sortField: 'text' });
	var slider = $(".slider").data("ionRangeSlider");

	var tb_bancos = $('#tb_bancos').DataTable( {
		ordering: true,
		lengthChange: false,
		pagingType: 'numbers',
		ajax: "data/financeiro/bancos.php",
		stateSave: false,
		columns: [
            { title: "Id" },
            { title: "Código" },
            { title: "Nome" },
            { title: "" }
		]
	} );

});
