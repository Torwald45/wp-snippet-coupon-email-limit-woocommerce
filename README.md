# WP Snippet: Newsletter Coupon - Email Limit & Login Enforcement

Forces user login and limits WooCommerce coupon usage to once per email address.

## Features

- Forces user login before coupon can be applied
- Limits coupon usage to once per email address
- Checks order history (completed, processing, on-hold statuses)
- Easy coupon code customization in code
- Custom error messages for better UX

## Requirements

- WordPress 5.0 or higher
- WooCommerce 3.0 or higher
- PHP 7.4 or higher

## Installation

### Method 1: functions.php

1. Open your theme's `functions.php` file
2. Copy the entire content from `coupon-email-limit-woocommerce.php`
3. Paste at the end of your `functions.php`
4. Save the file

### Method 2: Code Snippets Plugin

1. Install and activate the [Code Snippets](https://wordpress.org/plugins/code-snippets/) plugin
2. Go to Snippets → Add New
3. Copy content from `coupon-email-limit-woocommerce.php` **WITHOUT the opening `<?php` tag**
4. Paste into the Code field
5. Activate the snippet

## Usage

### Customizing the Coupon Code

Edit line 20 in the PHP file to change the coupon code:
```php
$coupon_code = 'BLABLA10'; // Change to your coupon code
```

### Creating the Coupon in WooCommerce

1. Go to WooCommerce → Coupons
2. Create a new coupon with the same code (e.g., BLABLA10)
3. Set your desired discount amount and other settings
4. Publish the coupon

The snippet will automatically enforce login and email-based usage limits for this coupon.

### Error Messages

Users will see these messages if validation fails:
- **Not logged in:** "You must be logged in to use this coupon."
- **Already used:** "This coupon has already been used by your account."

## Technical Details

### Hooks Used
- `woocommerce_coupon_is_valid` (priority 5) - Validates coupon before application

### Functions
- `torwald45_coupem_validate_coupon()` - Main validation logic
- `torwald45_coupem_check_email_usage()` - Checks order history for email

### Order Statuses Checked
- `wc-completed`
- `wc-processing`
- `wc-on-hold`

### Prefix
All function names use the prefix `torwald45_coupem_` to prevent conflicts with other plugins.

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for version history.

## License

GPL v2 or later

## Author

[Torwald45](https://github.com/Torwald45)
