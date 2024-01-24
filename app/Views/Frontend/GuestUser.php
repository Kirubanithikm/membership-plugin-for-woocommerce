<?php defined('ABSPATH') or exit ?>

<?php if (!isset($login_permalink) || !isset($banner_message) || !isset($guest_user_login_message)) exit; ?>

<style>
    .product-banner {
        background-color: gold;
        padding: 20px 20px;
        text-align: center;
        font-size: 18px;
        color: #333;
    }
</style>

<div class="product-banner">
    <p><?php esc_html_e($banner_message, 'membership-plugin-woocommerce'); ?></p>
    <a href="<?php echo esc_url($login_permalink); ?>"><?php esc_html_e($guest_user_login_message, 'membership-plugin-woocommerce'); ?></a>
</div>