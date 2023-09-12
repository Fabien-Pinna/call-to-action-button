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
    register_setting('donation_button_settings', 'button_link_target', 'sanitize_url_field');
    register_setting('donation_button_settings', 'label_color', 'sanitize_text_field');
    register_setting('donation_button_settings', 'button_color', 'sanitize_text_field');
    register_setting('donation_button_settings', 'button_querySelector', 'sanitize_text_field');

    add_settings_section('button_settings_section', __('Button Settings', 'donation-button'), 'button_settings_section_callback', 'donation_button');

    add_settings_field('button_label', __('Button Label', 'donation-button'), 'button_label_callback', 'donation_button', 'button_settings_section');
    add_settings_field('button_link_target', __('Button Link Target', 'donation-button'), 'button_link_target_callback', 'donation_button', 'button_settings_section');
    add_settings_field('label_color', __('Label Color', 'donation-button'), 'label_color_callback', 'donation_button', 'button_settings_section');
    add_settings_field('button_color', __('Button Color', 'donation-button'), 'button_color_callback', 'donation_button', 'button_settings_section');
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

function button_link_target_callback()
{
    $button_link_target = get_option('button_link_target', 'https://example.com');
    echo "<input type='url' name='button_link_target' value='" . esc_attr($button_link_target) . "' />";
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

function button_querySelector_callback()
{
    $button_querySelector = get_option('button_querySelector', 'Add your querySelector');
    echo "
        <input type='text' name='button_querySelector' value='" . esc_attr($button_querySelector) . "' />
        <p class='description'>Enter the class or id for the HTML element where you want the button to appear.</p>
        <p><strong>Example:</strong> #wp-container</p>
    ";
}

// Enqueue Scripts and Styles
function donation_button_scripts()
{
    wp_enqueue_script('donation-button', plugin_dir_url(__FILE__) . 'admin.js', [], '1.0.1', true);
    wp_enqueue_style('donation-button', plugin_dir_url(__FILE__) . 'style.css');

    $button_data = [
        'buttonLabel' => get_option('button_label', 'Click Me'),
        'buttonLinkTarget' => get_option('button_link_target', 'https://example.com'),
        'labelColor'  => get_option('label_color', '#000000'),
        'buttonColor' => get_option('button_color', '#000000'),
        'buttonQuerySelector' => get_option('button_querySelector', ''),
    ];
    wp_localize_script('donation-button', 'localizedObject', $button_data);
}
add_action('wp_enqueue_scripts', 'donation_button_scripts');
