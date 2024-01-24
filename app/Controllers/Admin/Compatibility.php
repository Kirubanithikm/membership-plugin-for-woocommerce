<?php
namespace MPW\App\Controllers\Admin;
defined('ABSPATH') or exit;

class Compatibility
{

    /**
     * Check PHP environment compatible
     * @return bool|int
     */
    function isMPWEnvironmentCompatible()
    {
        return version_compare(PHP_VERSION, MPW_PHP_REQUIRED_VERSION, '>=');
    }

    /**
     * Check WooCommerce active or not
     * @return bool
     */
    function isMPWWooActive() {
        $active_plugins = apply_filters('active_plugins', get_option('active_plugins', array()));
        if (is_multisite()) {
            $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
        }
        return in_array('woocommerce/woocommerce.php', $active_plugins, false) || array_key_exists('woocommerce/woocommerce.php', $active_plugins);
    }

    /**
     * Check Discount Rules for WooCommerce active or not
     * @return null
     */
    function getMPWWooVersion() {
        if (defined('WC_VERSION')) {
            return WC_VERSION;
        }
        if (!function_exists('get_plugins')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }
        $plugin_folder = get_plugins('/woocommerce');
        $plugin_file = 'woocommerce.php';
        $wc_installed_version = NULL;
        if (isset($plugin_folder[$plugin_file]['Version'])) {
            $wc_installed_version = $plugin_folder[$plugin_file]['Version'];
        }
        return $wc_installed_version;
    }

    /**
     * Check WooCommerce version compatible
     * @return bool|int
     */
    function isMPWWooCompatible() {
        $current_wc_version = $this->getMPWWooVersion();
        return version_compare($current_wc_version, MPW_WC_REQUIRED_VERSION, '>=');
    }

    /**
     * Check WordPress version compatible
     * @return bool|int
     */
    function isMPWWpCompatible() {
        return version_compare(get_bloginfo('version'), MPW_WP_REQUIRED_VERSION, '>=');
    }

    /**
     * Check the Version amd Environment compatibilities
     * @return void
     */
    function CheckCompatibilities()
    {
        if (!$this->isMPWEnvironmentCompatible()) {
            wp_die(__('Membership Plugin for WooCommerce can not be activated because it requires minimum PHP version of', 'membership-plugin-woocommerce') . ' ' . esc_html(MPW_PHP_REQUIRED_VERSION));
        }
        if (!$this->isMPWWooActive()) {
            wp_die(__('Woocommerce must installed and activated in-order to use Membership Plugin for WooCommerce!', 'membership-plugin-woocommerce'));
        }
        if (!$this->isMPWWooCompatible()) {
            wp_die(__('Membership Plugin for WooCommerce requires at least Woocommerce', 'membership-plugin-woocommerce') . ' ' . esc_html(MPW_WC_REQUIRED_VERSION));
        }
        if (!$this->isMPWWpCompatible()) {
            wp_die(__('Membership Plugin for WooCommerce at least WordPress', 'membership-plugin-woocommerce') . ' ' . esc_html(MPW_WP_REQUIRED_VERSION));
        }
    }
}