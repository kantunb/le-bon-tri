


console.log('hello');
var options = {
	url: function(name) {
	
		//return "api/objetJson.php?phrase=" + phrase + "&format=json";
		console.log("ajaxsearch?name=" + name);
		return "ajaxsearch?name=" + name;
	},

	getValue: "name"
};

$("#provider-remote").easyAutocomplete(options);
