<?php
/**
 * Plugin Name: Price-switcher
 * Version 0.0.3
 * Author:            Patryk Organiściak
 * Author URI:        https://keyweb.pl/
 */


// Return price depends on user coockie and role
function return_custom_price($price, $product)
{

    global $post, $blog_id;
    $post_id = $post->ID;
    //$product = wc_get_product( $post_id );

    if (isset($_COOKIE['client_type'])) {
        $ppc = $_COOKIE['client_type'];
        if ($ppc == 1) {

            $user = wp_get_current_user();

            if (in_array('localvendor', (array)$user->roles)) {

                if ($product && $product->meta_exists('wholesale_customer_wholesale_price')) {
                    $hurt_price = $product->get_meta('wholesale_customer_wholesale_price');
                    if (is_numeric($hurt_price)) {
                        $new_price = $hurt_price;
                        return $new_price;
                    }
                }
            }
        }
    }
    return $price;
}

add_filter('woocommerce_get_price', 'return_custom_price', 10, 2);

function last_button_state_by_coockie()
{
    if (isset($_COOKIE['price_type_checked'])) {
        $ptc = $_COOKIE['price_type_checked'];
        if ($ptc == 1) {
            return "checked";
        }
    }
    return "";
}


// The shortcode function
function switch_shortcode()
{
// Swtich code
    $string = '<label class="switch">
<input type="checkbox" onclick="changePrices()" id="changePricesBtn" ' . last_button_state_by_coockie() . '>
<span class="slider"></span>
</label>';
// Ad code returned
    $user = wp_get_current_user();

    if (in_array('localvendor', (array)$user->roles)) {
        return $string;
    } else {
        return '';
    }
}

// Register shortcode
add_shortcode('price_switch', 'switch_shortcode');


// Include JS
function switch_js()
{
    wp_enqueue_script(
        'switch_js',
        plugins_url('js/switch.js', __FILE__));
}

add_action('wp_enqueue_scripts', 'switch_js', PHP_INT_MAX);


// Include CSS
function add_switch_stylesheet()
{
    wp_register_style(
        'switch_css',
        plugins_url('css/switch.css', __FILE__));
    wp_enqueue_style('switch_css');
}

add_action('wp_enqueue_scripts', 'add_switch_stylesheet');



