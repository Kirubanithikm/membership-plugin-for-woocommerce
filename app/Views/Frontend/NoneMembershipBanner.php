<?php defined('ABSPATH') or exit ?>

<?php if (!isset($product_permalink) && !isset($banner_message) && !isset($membership_product_link_message)) exit; ?>

<div class="mpw-membership-banner">
    <p><?php esc_html_e($banner_message, 'membership-plugin-woocommerce'); ?></p>
    <a href="<?php echo esc_url($product_permalink); ?>"><?php esc_html_e($membership_product_link_message, 'membership-plugin-woocommerce'); ?></a>
</div>
