<?php
/**
 * Newsletter Coupon - Email Limit & Login Enforcement
 * 
 * Forces user login and limits coupon usage to once per email address.
 * Checks order history (completed, processing, on-hold statuses).
 * 
 * @author      Torwald45
 * @link        https://github.com/Torwald45/wp-snippet-coupon-email-limit-woocommerce
 * @license     GPL-2.0-or-later
 * @version     1.0.0
 */

// Force login + check if email already used the coupon
add_filter('woocommerce_coupon_is_valid', 'torwald45_coupem_validate_coupon', 5, 3);
function torwald45_coupem_validate_coupon($valid, $coupon, $discount) {
    $coupon_code = 'BLABLA10'; // Newsletter coupon code
    
    // Check if this is our coupon
    if (strtoupper($coupon->get_code()) !== strtoupper($coupon_code)) {
        return $valid; // Not our coupon, pass through
    }
    
    // Check if user is logged in
    if (!is_user_logged_in()) {
        throw new Exception('You must be logged in to use this coupon.');
    }
    
    // Get logged-in user's email
    $current_user = wp_get_current_user();
    $user_email = $current_user->user_email;
    
    // Check if this email already used this coupon
    if (torwald45_coupem_check_email_usage($user_email, $coupon_code)) {
        throw new Exception('This coupon has already been used by your account.');
    }
    
    return $valid;
}

// Function to check if email already used the coupon
function torwald45_coupem_check_email_usage($email, $coupon_code) {
    // Search orders with this email and this coupon
    $orders = wc_get_orders(array(
        'billing_email' => $email,
        'limit' => -1,
        'status' => array('wc-completed', 'wc-processing', 'wc-on-hold')
    ));
    
    foreach ($orders as $order) {
        $used_coupons = $order->get_coupon_codes();
        
        if (in_array(strtolower($coupon_code), array_map('strtolower', $used_coupons))) {
            return true; // Email already used this coupon
        }
    }
    
    return false; // Email hasn't used the coupon yet
}
