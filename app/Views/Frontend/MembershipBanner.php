<?php defined('ABSPATH') or exit ?>

<?php if (!isset($discounted_price) || !isset($product_id) || !isset($discount_price) || !isset($original_price)) exit; ?>

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
    <p><?php esc_html_e('Congratulations! Your membership price is', 'membership-plugin-woocommerce'); ?> <?php echo '<del>' . wc_price($original_price) . '</del>' . '&nbsp' . '<ins>' . wc_price($discounted_price) . '</ins>'; ?></p>
    <p><?php esc_html_e('You saved', 'membership-plugin-woocommerce'); ?> <?php echo wc_price($discount_price); ?></p>
</div>
