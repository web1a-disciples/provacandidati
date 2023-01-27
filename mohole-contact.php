<?php
/*
Plugin Name: Mohole Contact
Plugin URI:http://www.mohole.it
Description: Contact Form Plugin Mohole Contact
Version: 1.0
Author: Captain America
Author URI: http://www.mohole.it
*/

/*path*/
//define( ‘MOHOLE_CONTACT_PATH’, plugin_dir_path( __FILE__ ) );
/*URL*/
/*
function themeslug_enqueue_style() {
	wp_enqueue_style( 'core', 'style.css', false ); 
}
*/

function enqueue_my_scripts() {
    wp_enqueue_script('pluginjs', plugin_dir_url(__FILE__) . 'js/plugin.js', array('jquery'));
  //  wp_enqueue_script('script1', plugin_dir_url(__FILE__) . 'another-script.js');
}
add_action('wp_enqueue_scripts', 'enqueue_my_scripts');





function cf_load_plugin_css() {
    $plugin_url = plugin_dir_url( __FILE__ );

    wp_enqueue_style( 'plugin', $plugin_url . 'css/plugin.css' );
   // wp_enqueue_style( 'style2', $plugin_url . 'css/style2.css' );
}
add_action( 'wp_enqueue_scripts', 'cf_load_plugin_css' );


function cf_html_form_code() {
    echo '<form name="contact" class="plugin" action="' .esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
    echo '<p>';
    echo 'Il tuo Nome (obbligatorio) <br>';
    echo '<input type="text" name="cf-name" pattern="[a-zA-Z0-9]+" value="' . ( isset($_POST["cf-name"]) ? esc_attr( $_POST["cf-name"]) : '' ) . '" size=40>';
    echo '</p>';
     echo '<p>';
    echo 'La tua email(obbligatorio) <br>';
    echo '<input type="email" name="cf-email" value="' . ( isset($_POST["cf-email"]) ? esc_attr( $_POST["cf-email"]) : '' ) . '" size=40>';
    echo '</p>';
    echo '<p>';
    echo '<textarea rows="10" cols="35" name="cf-message">' . ( isset( $_POST["cf-message"]) ? esc_attr( $_POST["cf-message"]) : '') . '</textarea>';
    echo '</p>';
    echo '<p><input type="submit" name="cf-submitted" value="Invia"></p>';
    echo '</form>';
}

function deliver_mail(){
    //se il bottone di submit è cliccato invia la mail
    // vedere su codex il sanitize per ogni tipo di input
    // text= sanitize_text_field ecc.
    if ( isset ( $_POST['cf-submitted'] ) ) {
        // sanitize dei valori della form
        $name = sanitize_text_field( $_POST["cf-name"]);
        $email = sanitize_email( $_POST["cf-email"]);
        $message = esc_textarea( $_POST["cf-message"]);
        
        //ottieni l'indirizzo email dell'admin
        $to = get_option( 'admin_email' );
        //$to = 'fra@gmail.com';
         $headers = "Da: $name <$email>" . "\r\n";
        
        //messaggio di successo o fail
        if ( wp_mail( $to, $message, $headers ))
            
        {
         echo '<div>';
         echo '<p>Grazie per avere scritto. A presto ti risponderemo.</p>';
         echo '</div>';
            
        } else {
            echo '<p>Invio non riuscito! </p>';
        }
        
    }
    
}
 
function cf_shortcode(){
    ob_start();
    deliver_mail();
    cf_html_form_code();
    
}

add_shortcode( 'mohole_contact_form', 'cf_shortcode');
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

?>