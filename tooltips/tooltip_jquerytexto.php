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
	</style>
	<script>
	/*
	$(document).tooltip({
    items:'.tooptip',
    tooltipClass:'preview-tip',
    position: { my: "left+15 top", at: "right center" },
    content:function(callback) {
        $.get('preview.php', {
            id:id
        }, function(data) {
            callback(data); //**call the callback function to return the value**
        });
    },
});*/
	
	$(function() {
		$( document ).tooltip({
			items: "txt, img, [data-geo], [title]",
			content: function() {
				var element = $( this );
				if ( element.is( "[txt]" ) ) {
					/*function(callback) {
						$.get('fragment.html', {
            id:id
					}, function(data) {
            callback(data); //**call the callback function to return the value**
					});
					}*/
				}
				if ( element.is( "[title]" ) ) {
					return element.attr( "title" );
				}
				if ( element.is( "img" ) ) {
          return element.attr( "alt" );
        }
        if ( element.is( "[data-geo]" ) ) {
          var text = element.text();
          return "<img class='map' alt='" + text +
            "' src='http://maps.google.com/maps/api/staticmap?" +
            "zoom=11&size=350x350&maptype=terrain&sensor=false&center=" +
            text + "'>";
        }
			}
		});
	});
	</script>
</head>
<body>
 
<div class="ui-widget photo">
	<div class="ui-widget-header ui-corner-all">
		<h2>St. Stephen's Cathedral</h2>
		<h3><a href="http://maps.google.com/maps?q=vienna,+austria&amp;z=11" data-geo="data-geo">Vienna, Austria</a></h3>
	</div>
	<a href="http://en.wikipedia.org/wiki/File:Wien_Stefansdom_DSC02656.JPG">
		<img src="images/st-stephens.jpg" alt="St. Stephen's Cathedral" class="ui-corner-all" />
	</a>
</div>
 
<div class="ui-widget photo">
	<div class="ui-widget-header ui-corner-all">
		<h2>Tower Bridge</h2>
		<h3><a href="http://maps.google.com/maps?q=london,+england&amp;z=11" data-geo="data-geo">London, England</a></h3>
	</div>
	<a href="http://en.wikipedia.org/wiki/File:Tower_bridge_London_Twilight_-_November_2006.jpg">
		<img src="images/tower-bridge.jpg" alt="Tower Bridge" class="ui-corner-all" />
	</a>
</div> 

		<h2>Archivo Plano</h2>
		<h3><a href="http://maps.google.com/maps?q=london,+england&amp;z=11" txt="txt">titularizadora201303.txt</a></h3>

	

<p>All images are part of <a href="http://commons.wikimedia.org/wiki/Main_Page">Wikimedia Commons</a>
and are licensed under <a href="http://creativecommons.org/licenses/by-sa/3.0/deed.en" title="Creative Commons Attribution-ShareAlike 3.0">CC BY-SA 3.0</a> by the copyright holder.</p> 
</body>
</html>
