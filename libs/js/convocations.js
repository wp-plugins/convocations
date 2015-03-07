jQuery(document).ready(function($){
	
	$("#datepicker").datepicker({
		dateFormat: "yy-mm-dd",
		dayNames: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
		dayNamesMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
		dayNamesShort : ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
		monthNames: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"],
		monthNamesMin: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"],
		monthNamesShort: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"],
		changeYear: true,
		yearRange: "c-10:c+10",
		firstDay: 1
	});
	
	$("#heurerdv").timepicker({
		'timeFormat' : 'H:i'
	});
	$("#heuremacth").timepicker({
		'timeFormat' : 'H:i'
	});
	
	$("#select-convocation select").live("change", function() {
		var value = $(this).val();
		
		if( value != 0 ) {
			var data = {
				action: "displayNext",
				value: value
			}
			
			$.post(ajaxurl, data, function(response) {
				$('#liste-joueurs').html(response).show(200);
			});
		}
		else {
			var response = "Aucune équipe sélectionnée";
			$('#liste-joueurs').html(response).show(200);
		}
		
	});
});