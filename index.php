<?php
require_once 'vendor/autoload.php';

use Gettext\Translation;
use Gettext\Translations;
use Gettext\Loader\PoLoader;

// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if a language has been selected via the dropdown
if (isset($_POST['language'])) {
    $language = $_POST['language'];
} else {
    $language = 'en_US'; // Default language
}

// Create a new Translations instance
$t = Gettext\Translations::create(null, $language);

// Load the translations
$loader = new PoLoader();
//echo __DIR__; 
//$translations = $loader->loadFile("locale/$language/LC_MESSAGES/messages.po");
$translations = $loader->loadFile(__DIR__ . "/locale/$language/LC_MESSAGES/messages.po");


// Add the loaded translations to the Translations instance
echo "<pre>Loaded translations:\n";
foreach ($translations as $translation) {
    echo $translation->getId() . " => " . $translation->getTranslation() . "\n";
    $t->add($translation);
}
echo "</pre>";

// Add the loaded translations to the Translations instance
foreach ($translations as $translation) {
    $t->add($translation);
}

// Set the locale for the gettext extension
putenv("LC_ALL=$language");
setlocale(LC_ALL, $language);

// Function to generate the language dropdown
function language_dropdown($selected_language)
{
    $languages = [
        'en_US' => 'English',
        'es_ES' => 'Español',
        'es_MX' => 'Español Mexico',
        'pl_PL' => 'Polish',
    ];

    $dropdown = '<select name="language" onchange="this.form.submit();">';
    foreach ($languages as $code => $label) {
        $selected = $selected_language === $code ? 'selected' : '';
        $dropdown .= "<option value=\"$code\" $selected>$label</option>";
    }
    $dropdown .= '</select>';

    return $dropdown;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Language Dropdown Example</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <?php echo language_dropdown($language); ?>
    </form>
    <p><?php echo $t->find(null, "GREETING")->getTranslation(); ?></p>
    <!-- Debugging information -->
    <pre>
        <?php
        echo "Selected language: ";
        var_dump($language);
        echo "Translated greeting: ";
        var_dump($t->find(null, "GREETING")->getTranslation());
        ?>
    </pre>
</body>
</html>
