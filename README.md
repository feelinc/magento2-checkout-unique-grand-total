# Magento 2 - Unique Grand Total
Implement a unique amount that will be applied to order grand total.


## DONATE
Donate to me by clicking the PayPal LOVE image
[![Donasi](https://www.sulaeman.com/wp-content/uploads/2017/01/paypal-logo-donation.png)](https://www.paypal.me/sulaeman)

## IMPLEMENTATION
-  A new unique_number table column will be created inside : quote, sales_order, and sales_invoice.
-  The "Unique Number" row applied to shopping cart summary, checkout order summary, customer order view, and admin order view.
-  The unique number generated from the last 3 digit numbers of quote ID. Additional 3 digits is acceptable here in Indonesia. I hope this 3 digit numbers will be unique if your website does not having more than 1000 orders daily. If you having another better approach, please try it and let me know the result.
-  When generating new invoice, the grand total does not include unique number currently. So the unique number will be appear in order total due. You can add some modifications, if you really want the invoice grand total to include unique number.

## INSTALLATION
- Create "Sulaeman/CheckoutUniqueGrandTotal" folders inside your "app/code/" folder.
- Clone or download this repository into "Sulaeman/CheckoutUniqueGrandTotal" folder. 
- Run "php bin/magento setup:upgrade".
- Run "php bin/magento setup:di:compile"
- Run 'php bin/magento setup:static-content:deploy --area="frontend"'.

## UPDATES
-|- 02-02-2017 (Sulaeman)
   - Magento 2.1.2 support

## SCREENSHOTS
Description | Screenshot
------------ | -------------
Shopping cart summary | ![Shopping Cart](../../blob/master/screenshots/shopping-cart.jpg?raw=true)
Shopping cart summary | ![Shopping Cart](../../blob/master/screenshots/shopping-cart.jpg?raw=true)
Checkout order summary | ![Checkout order summary](../../blob/master/screenshots/checkout.jpg?raw=true)
Customer order view | ![Customer order view](../../blob/master/screenshots/customer-order-view.jpg?raw=true)
Admin new order | ![Admin new order](../../blob/master/screenshots/admin-order-new.jpg?raw=true)
Admin order view | ![Admin order view](../../blob/master/screenshots/admin-order-view.jpg?raw=true)
Admin new invoice | ![Admin new invoice](../../blob/master/screenshots/admin-invoice-new.jpg?raw=true)
Admin order total due | ![Admin order total due](../../blob/master/screenshots/admin-order-view-2.jpg?raw=true)

## FOUND BUGS
Please open a issue (please check if similar issue exist reported here, just comment). We will consider to fix or close without fixing it.


## IMPROVING
Thank you for your help improving it.

## LICENSE
[MIT license](http://opensource.org/licenses/MIT).
