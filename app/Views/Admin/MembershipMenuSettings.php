<?php defined('ABSPATH') or exit ?>

<br>
<form class="mpw-settings-form" action="#" method="post">
    <label class="mpw-settings-label" for="product_id"><?php esc_html_e('Product ID:', 'membership-plugin-woocommerce'); ?></label>
    <input class="mpw-settings-inputs" type="number" id="product_id" name="product_id" required>

    <label class="mpw-settings-label" for="discount_price"><?php esc_html_e('Discount price:', 'membership-plugin-woocommerce'); ?></label>
    <input class="mpw-settings-inputs" type="number" id="discount_price" name="discount_price" required>

    <label class="mpw-settings-label" for="expiry_years"><?php esc_html_e('Expiry in Years:', 'membership-plugin-woocommerce'); ?></label>
    <input class="mpw-settings-inputs" type="number" id="expiry_years" name="expiry_years" required>

    <label class="mpw-settings-label" for="max_product_limit"><?php esc_html_e('Maximum Product Limit:', 'membership-plugin-woocommerce'); ?></label>
    <input class="mpw-settings-inputs" type="number" id="max_product_limit" name="max_product_limit" required>

    <input type="submit" name="submit-membership-settings" class="mpw-submit-button" value="<?php esc_attr_e('Submit', 'membership-plugin-woocommerce'); ?>">
</form>

<?php if (!isset($no_data) && isset($product_id) && isset($expiry_years) && isset($max_product_limit) && isset($discount_price)){ ?>
    <p class="mpw-settings-values"><strong><?php esc_html_e('Product ID:', 'membership-plugin-woocommerce'); ?></strong> <?php echo esc_html($product_id); ?></p>
    <p class="mpw-settings-values"><strong><?php esc_html_e('Discount price:', 'membership-plugin-woocommerce'); ?></strong> <?php echo esc_html($discount_price); ?></p>
    <p class="mpw-settings-values"><strong><?php esc_html_e('Expiry in Years:', 'membership-plugin-woocommerce'); ?></strong> <?php echo esc_html($expiry_years); ?></p>
    <p class="mpw-settings-values"><strong><?php esc_html_e('Maximum Product Limit:', 'membership-plugin-woocommerce'); ?></strong> <?php echo esc_html($max_product_limit); ?></p>
<?php } else { ?>
    <p class="mpw-settings-values"><?php esc_html_e('No Data!', 'membership-plugin-woocommerce'); ?></p>
<?php } ?>
