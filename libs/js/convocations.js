jQuery(document).ready(function(){
	jQuery("#datepicker").datepicker({
	dateFormat: "yy-mm-dd",
	dayNames: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
	dayNamesMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
	dayNamesShort : ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
	monthNames: ["Janvier", "F�vrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "D�cembre"],
	monthNamesMin: ["Janvier", "F�vrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "D�cembre"],
	monthNamesShort: ["Janvier", "F�vrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "D�cembre"],
	changeYear: true,
	yearRange: "c-10:c+10"
	});						
});