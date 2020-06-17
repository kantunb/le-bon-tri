$(document).ready(function () {
	var options = {
		url: function (name) {

			//return "api/objetJson.php?phrase=" + phrase + "&format=json";
			return "ajaxsearch?name=" + name;
		},

		getValue: "name"
	};

	$("#provider-remote").easyAutocomplete(options);

})