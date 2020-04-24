define([
    ‘Magento_Ui / js / lib / validation / validator’,
    ‘jquery’,
    ‘jquery / ui’,
    ‘jquery / validate’,
    ‘mage / translate’
], function (validator, $) {
    ‘use strict’;

    return function () {
        $.validator.addMethod(
            ‘mcpostcode’, function (value, element) {
                return value.length > 5 && value.length < 7 && value.match(/[0-9]/);
            }, $.mage.__('Input 6 digit postcode')); validator.addRule('mcpostcode', function (value, element) { return value.length > 5 && value.length < 7 && value.match(/[0-9]/); }, $.mage.__('Input 6 digit postcode'));
    }
});