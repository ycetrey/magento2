/*
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */
define(
    [
    'Magento_Ui/js/view/messages',
    '../../../model/payment/reward-points-messages'
    ],
    function (Component, messageContainer) {
        'use strict';

        return Component.extend(
            {


                initialize: function (config) {
                    return this._super(config, messageContainer);
                }
            }
        );
    }
);
