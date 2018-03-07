<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>jQuery UI Tooltip - Custom content</title>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
	<link rel="stylesheet" href="/resources/demos/style.css" />
	<style>
	.photo {
		width: 300px;
		text-align: center;
	}
	.photo .ui-widget-header {
		margin: 1em 0;
	}
	.map {
		width: 350px;
		height: 350px;
	}
	.ui-tooltip {
		max-width: 350px;
	}
	#tippy { color: red; }
	</style>
	<script>

$(function(){
	$('#tippy').tooltip({
    open: function(evt, ui) {
		var elem = $(this);
		$.ajax({
			url: "fragment.html",
			type: "GET",
			dataType: "script",
			async:false,
			success: function(datos){
			 return datos;
			}
		 });
		}
});
});
	</script>
</head>
<body>
 
<p>This is some <span id="tippy" title="">awesomeness</span>.</p>
</body>
</html>
