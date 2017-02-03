/**
 * This file is part of the Sulaeman Checkout Unique Grand Total package.
 *
 * @author Sulaeman <me@sulaeman.com>
 * @package Sulaeman_CheckoutUniqueGrandTotal
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/*global define*/
define(
    [
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/totals'
    ],
    function (Component, quote, totals) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Sulaeman_CheckoutUniqueGrandTotal/summary/unique_number'
            },
            totals: quote.getTotals(),
            isDisplayed: function() {
                return this.isFullMode() && this.getPureValue() != 0;
            },
            getPureValue: function() {
                var price = 0;
                if (this.totals()) {
                    if (totals.getSegment('unique_number')) {
                        price = totals.getSegment('unique_number').value;
                    }
                }
                return parseFloat(price);
            },
            getValue: function() {
                return this.getFormattedPrice(this.getPureValue());
            }
        });
    }
);
