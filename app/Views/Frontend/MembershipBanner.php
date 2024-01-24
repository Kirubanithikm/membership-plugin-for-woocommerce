<?php defined('ABSPATH') or exit ?>

<?php if (!isset($discounted_price) || !isset($product_id) || !isset($discount_price) || !isset($original_price) || !isset($banner_message) || !isset($banner_saved_message)) exit; ?>

<div class="mpw-membership-banner">
    <p><?php esc_html_e($banner_message, 'membership-plugin-woocommerce'); ?> <?php echo '<del>' . wc_price($original_price) . '</del>' . '&nbsp' . '<ins>' . wc_price($discounted_price) . '</ins>'; ?></p>
    <p><?php esc_html_e($banner_saved_message, 'membership-plugin-woocommerce'); ?> <?php echo wc_price($discount_price); ?></p>
</div>
