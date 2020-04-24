/*
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

define(
    [
    "jquery",
    'Magento_Checkout/js/model/quote',
    "jquery/ui"
    ],
    function ($, quote) {
        'use strict';

        $.widget(
            'mage.rewardPoints',
            {

                options: {
                    "rewardPointSelector":null,
                    "applyButton": null,
                    "points": 0,
                    "maxPoints": 0,
                    "selectedPoints":0
                },

                totals: null,


                _create: function () {
                    this.rewardPoints = $(this.options.rewardPointSelector);

                    $(this.options.applyButton).on(
                        'click',
                        $.proxy(
                            function () {
                                this.rewardPoints.attr('data-validate', '{required:true}');
                                //this.removeCoupon.attr('value', '0');
                                $(this.element).validation().submit();
                            },
                            this
                        )
                    );

                    this._createSlider();
                },

                _apply: function () {

                },

                _createSlider: function () {
                    var self = this;
                    if (this.options.points >= this.options.maxPoints) {
                        var maxPoints = this.options.maxPoints;
                    } else {
                        var maxPoints = this.options.points;
                    }
                    $("#reward-slider").slider(
                        {
                            classes: {
                                "ui-slider": "highlight"
                            },
                            range: "max",
                            min: 0,
                            max: maxPoints,
                            value: self.options.selectedPoints,
                            slide: function (event, ui) {
                                $("#reward_point_manually").val(ui.value);
                            }
                        }
                    );

                    $("#reward_point_manually").val(this.options.selectedPoints);
                }
            }
        );

        return $.mage.rewardPoints;


    }
);
