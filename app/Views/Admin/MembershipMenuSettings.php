<?php defined('ABSPATH') or exit ?>

<style>
    form {
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        background-color: #f4f4f4;
        border-radius: 5px;
        box-shadow: 0 0 10px #888888;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    input[type="number"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 16px;
        box-sizing: border-box;
    }

    .mpw-submit-button {
        background-color: #4caf50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .mpw-settings-values {
        font-weight: bold;
        text-align: center;
        color: #4caf50;
        font-size: 1.2em;
    }
</style>

<br>
<form action="#" method="post">
    <label for="product_id"><?php esc_html_e('Product ID:', 'membership-plugin-woocommerce'); ?></label>
    <input type="number" id="product_id" name="product_id" required>

    <label for="discount_price"><?php esc_html_e('Discount price:', 'membership-plugin-woocommerce'); ?></label>
    <input type="number" id="discount_price" name="discount_price" required>

    <label for="expiry_years"><?php esc_html_e('Expiry in Years:', 'membership-plugin-woocommerce'); ?></label>
    <input type="number" id="expiry_years" name="expiry_years" required>

    <label for="max_product_limit"><?php esc_html_e('Maximum Product Limit:', 'membership-plugin-woocommerce'); ?></label>
    <input type="number" id="max_product_limit" name="max_product_limit" required>

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
