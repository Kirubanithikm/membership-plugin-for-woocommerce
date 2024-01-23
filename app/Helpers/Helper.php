<?php
namespace MPW\App\Helpers;

defined('ABSPATH') or exit;

class Helper
{

    /**
     * Check user membership conditions
     * @param $user_id
     * @param $membership_product_id
     * @param $expiry_years
     * @param $max_product_limit
     * @return bool
     */
    public function checkUserMembership($user_id, $membership_product_id, $expiry_years, $max_product_limit)
    {
        $user_orders = wc_get_orders(array(
            'customer' => $user_id,
            'status'   => 'completed',
        ));

        foreach ($user_orders as $order) {
            foreach ($order->get_items() as $item) {
                $product_id = $item->get_product_id();
                if ($product_id === $membership_product_id) {
                    $get_expiry_years = strtotime('-'. $expiry_years.' year');
                    if(strtotime($order->get_date_created()->date('Y-m-d H:i:s')) > $get_expiry_years) {
                        if($this->checkPurchaseCount($user_id, $max_product_limit, $membership_product_id)){
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    /**
     * Check user purchase count
     * @param $user_id
     * @param $max_product_limit
     * @param $membership_product_id
     * @return bool
     */
    function checkPurchaseCount($user_id, $max_product_limit, $membership_product_id)
    {
        if (is_user_logged_in()) {
            $products_purchased_after = 0;
            $customer_orders = wc_get_orders(array(
                'limit'         => -1,
                'customer_id'   => $user_id,
                'status'        => array('completed'),
            ));

            foreach ($customer_orders as $order) {
                foreach ($order->get_items() as $item) {
                    $product_id = $item->get_product_id();
                    if ($product_id != $membership_product_id) {
                        $products_purchased_after++;
                    }
                }
            }
            if ($products_purchased_after >= $max_product_limit) {
                return false;
            }
        }
        return true;
    }

    /**
     * Render the view file
     * @param $path
     * @param array $data
     * @return void
     */
    function view($path, array $data = []){
        $file = MPW_PLUGIN_PATH . '/app/Views/' . $path . '.php';
        $output = false;
        if (file_exists($file)) {
            ob_start();
            extract($data);
            include $file;
            $output = ob_get_clean();
        }
        echo $output;
    }
}
