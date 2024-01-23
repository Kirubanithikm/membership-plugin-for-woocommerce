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
            'product_id' => isset($membership_settings['product_id']) ? absint($membership_settings['product_id']) : 0,
            'discount_price' => isset($membership_settings['discount_price']) ? absint($membership_settings['discount_price']) : 0,
            'expiry_years' => isset($membership_settings['expiry_years']) ? absint($membership_settings['expiry_years']) : 0,
            'max_product_limit' => isset($membership_settings['max_product_limit']) ? absint($membership_settings['max_product_limit']) : 0,
        ];

        if(is_object($product) && method_exists($product, 'get_id') && $product->get_id() != $membership_settings_data['product_id']) {
            if (function_exists('is_user_logged_in') && function_exists('get_current_user_id') && is_user_logged_in()) {
                $user_id = get_current_user_id();
                $check_user_membership = self::$helper->checkUserMembership($user_id, $membership_settings_data['product_id'], $membership_settings_data['expiry_years'], $membership_settings_data['max_product_limit']);

                if ($check_user_membership && method_exists($product, 'get_price')) {
                    $product_price = $product->get_price();
                    $discounted_price = $product_price - $membership_settings_data['discount_price'];
                    $discounted_price = max($discounted_price, 0);

                    $data = [
                        'product_id' => $product->get_id(),
                        'original_price' => $product_price,
                        'discount_price' => $membership_settings_data['discount_price'],
                        'discounted_price' => $discounted_price,
                    ];
                    self::$helper->view('Frontend/MembershipBanner', $data);
                } else {
                    if (function_exists('get_permalink')) {
                        $product_permalink = get_permalink($membership_settings_data['product_id']);
                        $data = [
                            'product_permalink' => $product_permalink,
                        ];
                        self::$helper->view('Frontend/NoneMembershipBanner', $data);
                    }
                }
            } else {
                $login_permalink = esc_url(wp_login_url(get_permalink()));
                $data = [
                    'login_permalink' => $login_permalink,
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
                'product_id' => isset($membership_settings['product_id']) ? absint($membership_settings['product_id']) : 0,
                'discount_price' => isset($membership_settings['discount_price']) ? absint($membership_settings['discount_price']) : 0,
                'expiry_years' => isset($membership_settings['expiry_years']) ? absint($membership_settings['expiry_years']) : 0,
                'max_product_limit' => isset($membership_settings['max_product_limit']) ? absint($membership_settings['max_product_limit']) : 0,
            ];

            $check_user_membership = self::$helper->checkUserMembership($user_id, $membership_settings_data['product_id'], $membership_settings_data['expiry_years'], $membership_settings_data['max_product_limit']);
            if ($check_user_membership) {
                foreach ($cart->get_cart() as $cart_item) {
                    $product = $cart_item['data'];
                    if ($product->get_id() === $membership_settings_data['product_id']) {
                        continue;
                    }
                    $original_price = $product->get_price();
                    $discounted_price = $original_price - $membership_settings_data['discount_price'];
                    $discounted_price = max($discounted_price, 0);
                    $cart_item['data']->set_price($discounted_price);
                }
            }
        }
    }
}