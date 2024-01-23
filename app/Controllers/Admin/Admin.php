<?php

namespace MPW\App\Controllers\Admin;

use MPW\App\Helpers\Helper;

defined('ABSPATH') or exit;

class Admin
{
    private static $helper;

    public function __construct()
    {
        self::$helper = empty( self::$helper) ? new Helper() : self::$helper;
    }

    /**
     * Create membership menu
     * @return void
     */
    function membershipMenu()
    {
        add_menu_page('Membership menu',
            'Membership menu',
            'manage_options',
            'Membership menu',
            array($this, 'membershipSettings')
        );
    }

    /**
     * Membership settings tab
     * @return void
     */
    function MembershipSettings()
    {
        if (isset($_POST['submit-membership-settings'])) {
            $option_data = [
                'product_id' => isset($_POST['product_id']) ? absint($_POST['product_id']) : 0,
                'discount_price' => isset($_POST['discount_price']) ? absint($_POST['discount_price']) : 0,
                'expiry_years' => isset($_POST['expiry_years']) ? absint($_POST['expiry_years']) : 0,
                'max_product_limit' => isset($_POST['max_product_limit']) ? absint($_POST['max_product_limit']) : 0,
            ];
            update_option('mpw_settings', $option_data);
        }

        $membership_settings = get_option('mpw_settings');
        if(is_array($membership_settings) && !empty($membership_settings)) {
            $data = [
                'product_id' => isset($membership_settings['product_id']) ? absint($membership_settings['product_id']) : 0,
                'discount_price' => isset($membership_settings['discount_price']) ? absint($membership_settings['discount_price']) : 0,
                'expiry_years' => isset($membership_settings['expiry_years']) ? absint($membership_settings['expiry_years']) : 0,
                'max_product_limit' => isset($membership_settings['max_product_limit']) ? absint($membership_settings['max_product_limit']) : 0,
            ];
        } else {
            $data = [
                'no_data' => true,
            ];
        }
        self::$helper->view('Admin/MembershipMenuSettings', $data);
    }

    /**
     * Add settings link in plugins page
     * @param $links
     * @return string[]
     */
    function mpwSettingsLink($links)
    {
        $action_links = array(
            'settings' => '<a href="' . esc_url(admin_url('admin.php?page=Membership+menu')) . '">' . __('Settings', 'membership-plugin-woocommerce') . '</a>',
        );
        return array_merge($action_links, $links);
    }
}
