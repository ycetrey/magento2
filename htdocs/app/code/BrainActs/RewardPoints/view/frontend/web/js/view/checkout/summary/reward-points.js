/*
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

define(
    [
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Catalog/js/price-utils',
        'Magento_Checkout/js/model/totals'
    ],
    function (Component, quote, priceUtils, totals) {
        "use strict";
        return Component.extend(
            {
                defaults: {
                    template: 'BrainActs_RewardPoints/checkout/summary/reward-points'
                },

                totals: quote.getTotals(),

                isDisplayedRewardPoints: function () {
                    var price = 0;

                    if (this.totals()) {
                        price = totals.getSegment('reward_points').value;
                    }
                    return price;
                },

                getRewardPoints: function () {

                    var price = 0;
                    if (this.totals()) {
                        price = totals.getSegment('reward_points').value;
                    }
                    return this.getFormattedPrice(price);
                },

                getBaseValue: function () {
                    var price = 0;
                    if (this.totals()) {
                        price = this.totals().reward_points;
                    }
                    return priceUtils.formatPrice(price, quote.getBasePriceFormat());
                }
            }
        );
    }
);