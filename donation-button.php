<?php

/**
 * Plugin Name:       Donation Button
 * Description:       A call-to-action button in the donation.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Webinf@b
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       donation-button
 */

// Add settings page
add_action('admin_menu', 'donation_button_menu');

function donation_button_menu()
{
    add_menu_page(
        __('Donation Button Settings', 'donation-button'),
        __('Donation Button', 'donation-button'),
        'manage_options',
        'donation_button',
        'donation_button_page'
    );
}

function donation_button_page()
{
?>
    <div class="wrap">
        <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('donation_button_settings');
            do_settings_sections('donation_button');
            submit_button();
            ?>
        </form>
    </div>
<?php
}

// Register settings
add_action('admin_init', 'donation_button_settings');

function donation_button_settings()
{
    register_setting('donation_button_settings', 'button_label', 'sanitize_text_field');
    register_setting('donation_button_settings', 'label_color', 'sanitize_text_field');
    register_setting('donation_button_settings', 'button_color', 'sanitize_text_field');
    register_setting('donation_button_settings', 'label_font_size', 'sanitize_text_field');
    register_setting('donation_button_settings', 'icon_size', 'sanitize_text_field');
    register_setting('donation_button_settings', 'button_link_target', 'sanitize_text_field');
    register_setting('donation_button_settings', 'button_icon', 'sanitize_text_field');
    register_setting('donation_button_settings', 'button_querySelector', 'sanitize_text_field');

    add_settings_section('button_settings_section', __('Button Settings', 'donation-button'), 'button_settings_section_callback', 'donation_button');

    add_settings_field('button_label', __('Button Label', 'donation-button'), 'button_label_callback', 'donation_button', 'button_settings_section');
    add_settings_field('label_color', __('Label Color', 'donation-button'), 'label_color_callback', 'donation_button', 'button_settings_section');
    add_settings_field('button_color', __('Button Color', 'donation-button'), 'button_color_callback', 'donation_button', 'button_settings_section');
    add_settings_field('label_font_size', __('Label Font Size', 'donation-button'), 'label_font_size_callback', 'donation_button', 'button_settings_section');
    add_settings_field('icon_size', __('Icon Size', 'donation-button'), 'icon_size_callback', 'donation_button', 'button_settings_section');
    add_settings_field('button_link_target', __('Button Link Target', 'donation-button'), 'button_link_target_callback', 'donation_button', 'button_settings_section');
    add_settings_field('button_icon', __('Button Icon', 'donation-button'), 'button_icon_callback', 'donation_button', 'button_settings_section');
    add_settings_field('button_querySelector', __('Button querySelector', 'donation-button'), 'button_querySelector_callback', 'donation_button', 'button_settings_section');
}

function button_settings_section_callback()
{
    echo esc_html__('Customize the donation button settings.', 'donation-button');
}

function button_label_callback()
{
    $button_label = get_option('button_label', 'Click Me');
    echo "<input type='text' name='button_label' value='" . esc_attr($button_label) . "' />";
}

function label_color_callback()
{
    $label_color = get_option('label_color', '#000000');
    echo "<input type='color' name='label_color' value='" . esc_attr($label_color) . "' />";
}

function button_color_callback()
{
    $button_color = get_option('button_color', '#000000');
    echo "<input type='color' name='button_color' value='" . esc_attr($button_color) . "' />";
}

function label_font_size_callback()
{
    $label_font_size = get_option('label_font_size', '1em');
    echo "<input type='text' name='label_font_size' value='" . esc_attr($label_font_size) . "' />";
}

function icon_size_callback()
{
    $icon_size = get_option('icon_size', '1em');
    echo "<input type='text' name='icon_size' value='" . esc_attr($icon_size) . "' />";
}


function button_link_target_callback()
{
    $button_link_target = get_option('button_link_target', 'https://example.com');
    echo "<input type='url' name='button_link_target' value='" . esc_attr($button_link_target) . "' />";
}



function button_icon_callback()
{
    $button_icon = get_option('button_icon', 'fas fa-gift');
    echo "
    <div id='icon-picker'></div>
    <input type='hidden' id='button_icon' name='button_icon' value='" . esc_attr($button_icon) . "' />
    ";
}

function button_querySelector_callback()
{
    $button_querySelector = get_option('button_querySelector', 'Add your querySelector');
    echo "
        <input type='text' name='button_querySelector' value='" . esc_attr($button_querySelector) . "' />
        <p class='description'>Enter the class or id for the HTML element where you want the button to appear.</p>
        <p><strong>Example:</strong> #wp-container</p>
    ";
}

add_action('init', function () {
    error_log("HOOK INSTANCIATED!!!");
});

add_action('rest_api_init', function () {
    error_log("Hook rest_api_init OKKKK");
    register_rest_route('myplugin/v1', '/icons/', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_icons',
    ));
});

function get_icons()
{
    $icons = [];
    $directory_path = WP_CONTENT_DIR . '/uploads/simple-iconfonts/';

    foreach (glob($directory_path . '*', GLOB_ONLYDIR) as $folder) {
        $json_path = $folder . '/metadata.json';

        if (file_exists($json_path)) {
            $content = json_decode(file_get_contents($json_path), true);
            if (isset($content['icons'])) {
                $icons = array_merge($icons, $content['icons']);
            }
        }
    }

    return new WP_REST_Response($icons, 200);
}

function check_file_update()
{
    $directory_path = WP_CONTENT_DIR . '/uploads/simple-iconfonts/';
    $icons = []; // Initialize an array to hold the new icons

    // Loop through each icon font directory
    foreach (glob($directory_path . '*', GLOB_ONLYDIR) as $folder) {
        $json_path = $folder . '/metadata.json';
        $css_path = $folder . '/style.css';

        // Check metadata.json file
        if (file_exists($json_path)) {
            $current_hash_json = md5_file($json_path);
            $option_name_json = 'metadata_json_hash_' . basename($folder);
            $saved_hash_json = get_option($option_name_json, '');

            if ($current_hash_json !== $saved_hash_json) {
                update_option($option_name_json, $current_hash_json);

                $content = json_decode(file_get_contents($json_path), true);
                if (isset($content['icons'])) {
                    $icons = array_merge($icons, $content['icons']);
                }
            }
        }

        // Check style.css file
        if (file_exists($css_path)) {
            $current_hash_css = md5_file($css_path);
            $option_name_css = 'style_css_hash_' . basename($folder);
            $saved_hash_css = get_option($option_name_css, '');

            if ($current_hash_css !== $saved_hash_css) {
                update_option($option_name_css, $current_hash_css);
                // Assuming that the style.css would have similar meta info for icons
            }
        }
    }

    // Update the icons list in the database
    update_option('donation_button_icons', $icons);
}
add_action('admin_init', 'check_file_update');


// Enqueue Scripts and Styles
function donation_button_scripts()
{
    wp_enqueue_script('donation-button', plugin_dir_url(__FILE__) . 'dist/donation-button.bundle.js', [], '1.0.1', true);
    wp_enqueue_style('donation-button', plugin_dir_url(__FILE__) . 'dist/donation-button.css');

    $button_data = [
        'buttonLabel' => get_option('button_label', 'Click Me'),
        'labelColor'  => get_option('label_color', '#000000'),
        'buttonColor' => get_option('button_color', '#000000'),
        'labelFontSize' => get_option('label_font_size', '1em'),
        'iconSize' => get_option('icon_size', '1em'),
        'buttonLinkTarget' => get_option('button_link_target', 'https://example.com'),
        'buttonIcon' => get_option('button_icon', 'fas fa-gift'),
        'buttonQuerySelector' => get_option('button_querySelector', '')
    ];
    wp_localize_script('donation-button', 'localizedObject', $button_data);
}
add_action('wp_enqueue_scripts', 'donation_button_scripts');

// Enqueue scripts and styles for admin
function enqueue_donation_button_admin_scripts()
{
    $current_screen = get_current_screen();
    if ('toplevel_page_donation_button' === $current_screen->id) {
        wp_enqueue_script('donation-button-admin', plugin_dir_url(__FILE__) . 'dist/admin-picker.bundle.js', [], '1.0.1', true);
        wp_enqueue_style('donation-button-admin-style', plugin_dir_url(__FILE__) . 'dist/admin-picker.css');

        // Get styles from check_file_update
        $directory_path = WP_CONTENT_DIR . '/uploads/simple-iconfonts/';

        foreach (glob($directory_path . '*', GLOB_ONLYDIR) as $folder) {
            $css_path = $folder . '/style.css';

            if (file_exists($css_path)) {
                // Generate a unique style id
                $style_id = 'style-' . basename($folder);

                wp_enqueue_style($style_id, content_url('/uploads/simple-iconfonts/' . basename($folder) . '/style.css'));
            }
        }
    }
}
add_action('admin_enqueue_scripts', 'enqueue_donation_button_admin_scripts');
