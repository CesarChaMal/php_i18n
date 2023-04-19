<?php
// Set the user's language preference
$language = 'en_US'; // Change this to 'es_ES' for Spanish

// Set the locale for the gettext extension
putenv("LC_ALL=$language");
setlocale(LC_ALL, $language);

// Specify the location of the translation files
bindtextdomain("messages", "./locale");
textdomain("messages");

// Display the translated greeting
echo gettext("GREETING");
?>

