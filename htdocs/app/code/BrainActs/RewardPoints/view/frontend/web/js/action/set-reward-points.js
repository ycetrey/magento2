/*
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */


define(
    [
        'ko',
        'jquery',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/resource-url-manager',
        'BrainActs_RewardPoints/js/model/resource-url-manager',
        'Magento_Checkout/js/model/error-processor',
        'BrainActs_RewardPoints/js/model/payment/reward-points-messages',
        'mage/storage',
        'mage/translate',
        'Magento_Checkout/js/action/get-payment-information',
        'Magento_Checkout/js/model/totals',
        'Magento_Checkout/js/model/full-screen-loader'
    ],
    function (
        ko,
        $,
        quote,
        urlManager,
        urlManagerRewardPoints,
        errorProcessor,
        messageContainer,
        storage,
        $t,
        getPaymentInformationAction,
        totals,
        fullScreenLoader
    ) {
        'use strict';

        return function (rewardPoints, isApplied) {
            var quoteId = quote.getQuoteId(),
                url = urlManagerRewardPoints.getApplyPointsUrl(rewardPoints, quoteId),
                message = $t('Reward points was successfully applied.');

            fullScreenLoader.startLoader();

            return storage.put(
                url,
                {},
                false
            ).done(
                function (response) {
                    if (response) {
                        var deferred = $.Deferred();

                        isApplied(true);
                        totals.isLoading(true);
                        getPaymentInformationAction(deferred);
                        $.when(deferred).done(
                            function () {
                                fullScreenLoader.stopLoader();
                                totals.isLoading(false);
                            }
                        );
                        messageContainer.addSuccessMessage(
                            {
                                'message': message
                            }
                        );
                    }
                }
            ).fail(
                function (response) {
                    fullScreenLoader.stopLoader();
                    totals.isLoading(false);
                    errorProcessor.process(response, messageContainer);
                }
            );
        };
    }
);
