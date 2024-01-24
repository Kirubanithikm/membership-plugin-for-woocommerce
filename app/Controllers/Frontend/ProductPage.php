<?php

namespace MPW\App\Controllers\Frontend;

use MPW\App\Helpers\Helper;

defined('ABSPATH') or exit;

class ProductPage
{
    private static $helper;

    public function __construct()
    {
        self::$helper = empty( self::$helper) ? new Helper() : self::$helper;
    }

    /**
     * Show membership banner
     * @return void
     */
    public static function membershipBanner()
    {
        global $product;

        $membership_settings = get_option('mpw_settings');
        $membership_settings_data = [
            'product_id' => isset($membership_settings['product_id']) ? apply_filters('mpw_membership_product_id', absint($membership_settings['product_id']), $membership_settings) : 0,
            'discount_price' => isset($membership_settings['discount_price']) ? apply_filters('mpw_membership_discount_price', absint($membership_settings['discount_price']), $membership_settings) : 0,
            'expiry_years' => isset($membership_settings['expiry_years']) ? apply_filters('mpw_membership_expiry_year', absint($membership_settings['expiry_years']), $membership_settings) : 0,
            'max_product_limit' => isset($membership_settings['max_product_limit']) ? apply_filters('mpw_membership_max_product_limit', absint($membership_settings['max_product_limit']), $membership_settings) : 0,
        ];

        if(is_object($product) && method_exists($product, 'get_id') && $product->get_id() != $membership_settings_data['product_id']) {
            if (function_exists('is_user_logged_in') && function_exists('get_current_user_id') && is_user_logged_in()) {
                $user_id = get_current_user_id();
                $check_user_membership = self::$helper->checkUserMembership($user_id, $membership_settings_data['product_id'], $membership_settings_data['expiry_years'], $membership_settings_data['max_product_limit']);

                if ($check_user_membership && method_exists($product, 'get_price')) {
                    $original_price = apply_filters('mpw_product_original_price_for_product_page', $product->get_price(), $membership_settings);
                    $discounted_price = $original_price - $membership_settings_data['discount_price'];
                    $discounted_price = apply_filters('mpw_product_discounted_price_for_product_page', max($discounted_price, 0), $membership_settings);

                    $data = [
                        'product_id' => $product->get_id(),
                        'original_price' => $original_price,
                        'discount_price' => $membership_settings_data['discount_price'],
                        'discounted_price' => $discounted_price,
                        'banner_message' => apply_filters('mpw_membership_banner_message','Congratulations! Your membership price is'),
                        'banner_saved_message' => apply_filters('mpw_membership_banner_saved_message','You saved'),
                    ];
                    self::$helper->view('Frontend/MembershipBanner', $data);
                } else {
                    if (function_exists('get_permalink')) {
                        $data = [
                            'product_permalink' => apply_filters('mpw_membership_product_permalink', get_permalink($membership_settings_data['product_id']), $membership_settings),
                            'banner_message' => apply_filters('mpw_none_membership_banner_message','Oops! If you don\'t have a membership, we suggest you buy one. Then you can get exciting offers.'),
                            'membership_product_link_message' => apply_filters('mpw_none_membership_product_link_message','Click here to buy Membership'),
                        ];
                        self::$helper->view('Frontend/NoneMembershipBanner', $data);
                    }
                }
            } else {
                $data = [
                    'login_permalink' => apply_filters('mpw_membership_login_permalink', esc_url(wp_login_url(get_permalink())), $membership_settings),
                    'banner_message' => apply_filters('mpw_guest_user_message','We suggest logging in to check your membership. Then you can get exciting offers.'),
                    'guest_user_login_message' => apply_filters('mpw_guest_user_login_message','Click here to Login'),
                ];
                self::$helper->view('Frontend/GuestUser', $data);
            }
        }
    }

    /**
     * Change the product price in cart page
     * @param $cart
     * @return void
     */
    function changePriceInCartForMembershipUser($cart)
    {
        if (is_user_logged_in() && function_exists('get_current_user_id')) {
            $user_id = get_current_user_id();

            $membership_settings = get_option('mpw_settings');
            $membership_settings_data = [
                'product_id' => isset($membership_settings['product_id']) ? apply_filters('mpw_membership_product_id', absint($membership_settings['product_id']), $membership_settings) : 0,
                'discount_price' => isset($membership_settings['discount_price']) ? apply_filters('mpw_membership_discount_price', absint($membership_settings['discount_price']), $membership_settings) : 0,
                'expiry_years' => isset($membership_settings['expiry_years']) ? apply_filters('mpw_membership_expiry_year', absint($membership_settings['expiry_years']), $membership_settings) : 0,
                'max_product_limit' => isset($membership_settings['max_product_limit']) ? apply_filters('mpw_membership_max_product_limit', absint($membership_settings['max_product_limit']), $membership_settings) : 0,
            ];

            $check_user_membership = self::$helper->checkUserMembership($user_id, $membership_settings_data['product_id'], $membership_settings_data['expiry_years'], $membership_settings_data['max_product_limit']);
            if ($check_user_membership) {
                foreach ($cart->get_cart() as $cart_item) {
                    $product = $cart_item['data'];
                    if ($product->get_id() === $membership_settings_data['product_id']) {
                        continue;
                    }
                    $original_price = apply_filters('mpw_product_original_price_for_cart_page', $product->get_price(), $membership_settings);
                    $discounted_price = $original_price - $membership_settings_data['discount_price'];
                    $discounted_price = apply_filters('mpw_product_discounted_price_for_cart_page', max($discounted_price, 0), $membership_settings);
                    $cart_item['data']->set_price($discounted_price);
                }
            }
        }
    }
}