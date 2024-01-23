<?php

namespace MPW\App;

use MPW\App\Controllers\Admin\Admin;
use MPW\App\Controllers\Frontend\ProductPage;

defined('ABSPATH') or exit;

class Route
{
    private static $admin, $product_page;

    /**
     * Init the hooks
     * @return void
     */
    public function hooks()
    {
        self::$admin = empty(self::$admin) ? new Admin() : self::$admin;
        self::$product_page = empty(self::$product_page) ? new ProductPage() : self::$product_page;

        //Admin
        add_action('admin_menu', array(self::$admin, 'membershipMenu'));
        add_filter('plugin_action_links_' . MPW_PLUGIN_BASENAME, array(self::$admin, 'mpwSettingsLink'));

        //Frontend
        add_action('woocommerce_before_add_to_cart_form', array(self::$product_page, 'membershipBanner'), 10);
        add_action('woocommerce_before_calculate_totals', array(self::$product_page, 'changePriceInCartForMembershipUser'), 10, 1);
    }
}
