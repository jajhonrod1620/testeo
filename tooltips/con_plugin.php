<html>
<head>
	<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="jquery.qtip-1.0.0.min.js"></script> 
<script type="text/javascript">
// Create the tooltips only on document load
$(document).ready(function() 
{
    /*
     * You'll need your own API key, don't abuse mine please!
     * Get yours here: http://www.websnapr.com/free_services/
     */
    var apiKey = '0KUn7MSO3322';

    // Notice the use of the each method to gain access to each element individually
    $('#content a').each(function()
    {
        // Grab the URL from our link
        var url = encodeURIComponent( $(this).attr('href') ),

        // Create image thumbnail using Websnapr thumbnail service
        thumbnail = $('<img />').attr({
            src: 'http://images.websnapr.com/?url=' + url + '&key=' + apiKey + '&hash=' + encodeURIComponent(websnapr_hash),
            alt: 'Loading thumbnail...',
            width: 202,
            height: 152
        });

        // Setup the tooltip with the content
        $(this).qtip(
        {
            content: thumbnail,
            position: {
                corner: {
                    tooltip: 'bottomMiddle',
                    target: 'topMiddle'
                }
            },
            style: {
                tip: true, // Give it a speech bubble tip with automatic corner detection
                name: 'cream'
            }
        });
    });
});
</script>


<div id="content" class="thumbnail">
<div class="center">
   <h2>Hover over a link below to see a thumbnail of it!</h2>
   <p class="cloud">
      <a class="cloud5" href="http://google.com">Google</a>
      <a class="cloud4" href="http://yahoo.com">Yahoo</a>
      <a class="cloud3" href="http://amazon.com">Amazon</a>
      <a class="cloud5" href="http://ebay.com">Ebay</a>
      <a class="cloud7" href="http://facebook.com">Facebook</a>
      <a class="cloud1" href="http://digg.com">Digg</a>
      <a class="cloud8" href="http://youtube.com">Youtube</a>
      <a class="cloud3" href="http://live.com">Live</a>
      <a class="cloud6" href="http://wikipedia.org">Wikipedia</a>
      <a class="cloud1" href="http://blogger.com">Blogger</a>
      <a class="cloud5" href="http://myspace.com">MySpace</a>
      <a class="cloud6" href="http://microsoft.com">Microsoft</a>
      <a class="cloud1" href="http://wordpress.com">Wordpress</a>
      <a class="cloud4" href="http://imdb.com">IMDB</a>
      <a class="cloud2" href="http://adobe.com">Adobe</a>
   </p>
</div>
</div>
