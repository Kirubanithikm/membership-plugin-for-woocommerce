<?php defined('ABSPATH') or exit ?>

<?php if (!isset($product_permalink)) exit; ?>

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
    <p><?php esc_html_e("Oops! If you don't have a membership, we suggest you buy one. Then you can get exciting offers.", 'membership-plugin-woocommerce'); ?></p>
    <a href="<?php echo esc_url($product_permalink); ?>"><?php esc_html_e('Click here to buy Membership', 'membership-plugin-woocommerce'); ?></a>
</div>
