<?php
/*
* Plugin Name: Woo Alipay Subscriptions
* Plugin URI: https://woocn.com/
* Description: Woo Alipay 的订阅扩展。与 WooCommerce Subscriptions 集成，当前支持手动续费增强并预留自动代扣（签约/代扣）能力。
* Version: 0.1.0
* Author: WooCN.com
* Author URI: https://woocn.com/
* Text Domain: woo-alipay-subscriptions
* Domain Path: /languages
* Requires Plugins: woocommerce, woo-alipay
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Constants
if ( ! defined( 'WOO_ALIPAY_SUBSCRIPTIONS_FILE' ) ) {
    define( 'WOO_ALIPAY_SUBSCRIPTIONS_FILE', __FILE__ );
}
if ( ! defined( 'WOO_ALIPAY_SUBSCRIPTIONS_PATH' ) ) {
    define( 'WOO_ALIPAY_SUBSCRIPTIONS_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'WOO_ALIPAY_SUBSCRIPTIONS_URL' ) ) {
    define( 'WOO_ALIPAY_SUBSCRIPTIONS_URL', plugin_dir_url( __FILE__ ) );
}

// Load textdomain
add_action( 'init', function() {
    load_plugin_textdomain( 'woo-alipay-subscriptions', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
} );

// Dependency check and bootstrap after Core has loaded its gateway on init
add_action( 'init', function() {
    // WooCommerce
    if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
        return;
    }

    // WooCommerce Subscriptions
    if ( ! function_exists( 'wcs_is_subscription' ) && ! class_exists( 'WC_Subscriptions' ) && ! class_exists( 'WC_Subscription' ) ) {
        add_action( 'admin_notices', function() {
            echo '<div class="notice notice-warning"><p>' . esc_html__( 'Woo Alipay Subscriptions 需要 WooCommerce Subscriptions 插件支持。', 'woo-alipay-subscriptions' ) . '</p></div>';
        } );
        return;
    }

    // Core plugin (Woo Alipay) — check after Core's init bootstrap
    if ( ! class_exists( 'WC_Alipay' ) ) {
        add_action( 'admin_notices', function() {
            echo '<div class="notice notice-warning"><p>' . esc_html__( '请先安装并启用 Woo Alipay 核心插件。', 'woo-alipay-subscriptions' ) . '</p></div>';
        } );
        return;
    }

    // Register token class
    require_once WOO_ALIPAY_SUBSCRIPTIONS_PATH . 'inc/class-wc-payment-token-alipay-agreement.php';
    add_filter( 'woocommerce_payment_token_class', function( $class, $type ) {
        if ( 'alipay_agreement' === $type ) {
            return 'WC_Payment_Token_Alipay_Agreement';
        }
        return $class;
    }, 10, 2 );

    // Admin settings
    require_once WOO_ALIPAY_SUBSCRIPTIONS_PATH . 'inc/class-wc-alipay-subscriptions-admin.php';

    // Emails enhancer
    require_once WOO_ALIPAY_SUBSCRIPTIONS_PATH . 'inc/class-wc-alipay-subscriptions-emails.php';

    // Agreement signing routes (skeleton)
    require_once WOO_ALIPAY_SUBSCRIPTIONS_PATH . 'inc/class-wc-alipay-subscriptions-signing.php';
    // Charge helper
    require_once WOO_ALIPAY_SUBSCRIPTIONS_PATH . 'inc/class-wc-alipay-subscriptions-charge.php';
    // Checkout interceptor (sign_and_pay)
    require_once WOO_ALIPAY_SUBSCRIPTIONS_PATH . 'inc/class-wc-alipay-subscriptions-checkout.php';

    // Boot subscriptions integration
    require_once WOO_ALIPAY_SUBSCRIPTIONS_PATH . 'inc/class-wc-alipay-subscriptions.php';
}, 20 );
