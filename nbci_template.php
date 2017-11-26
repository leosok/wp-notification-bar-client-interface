<!-- template.php -->
</br></br></br>
<?php 

/* Styling: */

debug_to_console('Style - Load from'.PLUGIN_PATH.'nbci_styles.css');

debug_to_console( 'CurrTemplate: '. THE_SLUG); //. get_post_field( 'post_name', get_post())) ;

echo "Hi There, I like you, because you're smart :-)";

$nb_options = get_option('seed_wnb_settings_1', array());

$is_note = isset($nb_options["enabled"][0]);
$is_note_checked = $is_note ? 'checked' : '';

echo "</br></br>";
var_dump($nb_options);
echo "</br></br>";
echo "Ohne Enabled:";
unset($nb_options['enabled']);
var_dump($nb_options);
echo "</br></br>";
echo "is_set?" . $is_note_checked;
echo "</br></br>";
echo "removing....";
update_option('seed_wnb_settings_1',$nb_options );

echo "Note an ist: ".(isset($nb_options["enabled"][0]) ? 'true' : 'false')."\n";


?>

<html>

<head>
    <link rel="stylesheet" type="text/css" href="<?= plugins_url( 'nbci_styles.css', __FILE__ ) ?>">
</head>

<body>
     <div class="toggle text">
        <label> An-/Aus-Schalter
            <input type="checkbox" <?= $is_note_checked?>>
            <span class="slider"></span>
        </label>
    </div>
</body>

</html>