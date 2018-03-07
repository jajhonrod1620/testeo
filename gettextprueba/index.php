<?php
// I18N support information here
$language = 'en';
putenv("LANG=$language"); 
setlocale(LC_ALL, $language);

// Set the text domain as 'messages'
$domain = 'messages';
bindtextdomain($domain, "/www/htdocs/site.com/locale"); 
textdomain($domain);

echo gettext("A string to be translated would go here");
?>
