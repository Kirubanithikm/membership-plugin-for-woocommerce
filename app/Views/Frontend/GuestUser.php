<?php defined('ABSPATH') or exit ?>

<?php if (!isset($login_permalink)) exit; ?>

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
    <p><?php esc_html_e('We suggest logging in to check your membership. Then you can get exciting offers.', 'membership-plugin-woocommerce'); ?></p>
    <a href="<?php echo esc_url($login_permalink); ?>"><?php esc_html_e('Click here to Login', 'membership-plugin-woocommerce'); ?></a>
</div>