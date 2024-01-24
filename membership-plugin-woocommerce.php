<?php

/**
 * Plugin Name:          Membership Plugin for WooCommerce
 * Plugin URI:           https://github.com/Kirubanithikm/membership-plugin-for-woocommerce
 * Description:          It helps to create a membership for WooCommerce.
 * Version:              1.0.0
 * Author:               Kirubanithi G
 * Text Domain:          membership-plugin-woocommerce
 * Slug:                 membership-plugin-woocommerce
 * Domain Path:          /i18n/languages
 * Requires at least:    5.3
 * WC requires at least: 5.0
 * License:              GPL v3 or later
 * License URI:          https://www.gnu.org/licenses/gpl-3.0.html
 */

defined('ABSPATH') or exit;

/**
 * The plugin file
 */
if (!defined('MPW_PLUGIN_FILE')) {
    define('MPW_PLUGIN_FILE', __FILE__);
}

/**
 * The plugin path
 */
if (!defined('MPW_PLUGIN_PATH')) {
    define('MPW_PLUGIN_PATH', plugin_dir_path(MPW_PLUGIN_FILE));
}

/**
 * The plugin base name
 */
if (!defined('MPW_PLUGIN_BASENAME')) {
    define('MPW_PLUGIN_BASENAME', plugin_basename(MPW_PLUGIN_FILE));
}

/**
 * Required PHP Version
 */
if (!defined('MPW_PHP_REQUIRED_VERSION')) {
    define('MPW_PHP_REQUIRED_VERSION', 5.6);
}

/**
 * Required WooCommerce Version
 */
if (!defined('MPW_WC_REQUIRED_VERSION')) {
    define('MPW_WC_REQUIRED_VERSION', '5.0');
}

/**
 * Required WordPress Version
 */
if (!defined('MPW_WP_REQUIRED_VERSION')) {
    define('MPW_WP_REQUIRED_VERSION', '5.3');
}

/**
 * Remote repository url
 */
if (!defined('MPW_REMOTE_REPO')) {
    define('MPW_REMOTE_REPO', 'https://github.com/Kirubanithikm/membership-plugin-for-woocommerce');
}

/**
 * Remote branch name
 */
if (!defined('MPW_REMOTE_BRANCH')) {
    define('MPW_REMOTE_BRANCH', 'stable');
}

/**
 * Package - autoload
 */
if (!file_exists(MPW_PLUGIN_PATH . '/vendor/autoload.php')) {
    wp_die('Membership Plugin for WooCommerce is unable to find the autoload file.');
} else {
    require MPW_PLUGIN_PATH . '/vendor/autoload.php';
}

/**
 * Check compatibilities
 */
register_activation_hook(MPW_PLUGIN_FILE, function() {
    if (class_exists('MPW\App\Controllers\Admin\Compatibility')) {
        $Compatibility = new \MPW\App\Controllers\Admin\Compatibility();
        $Compatibility->CheckCompatibilities();
    } else {
        wp_die(__('Membership Plugin for WooCommerce is unable to find the Compatibility class.'));
    }
});

/**
 * Call the Route class
 */
add_action('plugins_loaded', function () {
    if (class_exists('WooCommerce') && class_exists('MPW\App\Route')) {
        do_action('before_membership_plugin_loaded');
        $route =  new MPW\App\Route();
        $route->hooks();
        if (function_exists('load_plugin_textdomain')) {
            load_plugin_textdomain('membership-plugin-woocommerce', false, basename(dirname(MPW_PLUGIN_FILE)) . '/i18n/languages/');
        }
        do_action('after_membership_plugin_loaded');
    }
}, 1);

/**
 * Git configurations for plugin update
 */
if(file_exists(MPW_PLUGIN_PATH . '/vendor/yahnis-elsts/plugin-update-checker/plugin-update-checker.php')) {
    require MPW_PLUGIN_PATH . '/vendor/yahnis-elsts/plugin-update-checker/plugin-update-checker.php';
    if(class_exists('YahnisElsts\PluginUpdateChecker\v5\PucFactory')) {
        $myUpdateChecker = YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
            MPW_REMOTE_REPO,
            MPW_PLUGIN_FILE,
            'membership-plugin-woocommerce'
        );
        $myUpdateChecker->setBranch(MPW_REMOTE_BRANCH);
    }
}
