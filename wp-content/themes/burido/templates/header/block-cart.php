<?php

defined('ABSPATH') || exit;

if (!class_exists('Burido_Header_Cart')) {
    class Burido_Header_Cart extends Burido_Get_Header
    {
        public function __construct()
        {
            if (!class_exists('\WooCommerce')) {
                return;
            }

            $this->header_vars();

            global $wgl_woo_cart;
            if (!empty($wgl_woo_cart)) { ?>
                <div class="wgl-cart-header">
                    <div class="wgl-mini-cart_wrapper">
                    <div class="mini-cart woocommerce">
                        <?php echo self::woo_cart(); ?>
                    </div>
                    </div>
                </div><?php
            }
        }
    }

    new Burido_Header_Cart();
}
