/*
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

define([
    'underscore',
    'uiRegistry',
    'Magento_Ui/js/form/element/select'
], function (_, uiRegistry, select) {

    'use strict';

    return select.extend({

        /**
         * Array of field names that depend on the value of
         * this UI component.
         */
        dependentFieldNames: [
            'points',
            'spend',
            'earn'
        ],

        /**
         * Reference storage for dependent fields. We're caching this
         * because we don't want to query the UI registry so often.
         */
        dependentFields : [],

        /**
         * Initialize field component, and store a reference to the dependent fields.
         */
        initialize: function() {
            this._super();
            this.processDependentFieldVisibility(parseInt(this.initialValue));

            // We're creating a promise that resolves when we're sure that all our dependent
            // UI components have been loaded. We're also binding our callback because
            // we're making use of `this`
            uiRegistry.promise(this.dependentFieldNames).done(_.bind(function() {

                // Let's store the arguments (the UI Components we queried for) in our object
                this.dependentFields = arguments;

                // Set the initial visibility of our fields.
                this.processDependentFieldVisibility(parseInt(this.initialValue));
            }, this));
        },

        /**
         * On value change handler.
         *
         * @param {String} value
         */
        onUpdate: function (value) {

            // We're calling parseInt, because in JS "0" evaluates to True
            this.processDependentFieldVisibility(parseInt(value));
            return this._super();
        },

        /**
         * Shows or hides dependent fields.
         *
         * @param visibility
         */
        processDependentFieldVisibility: function (visibility) {
            var field1 = uiRegistry.get('index = spend');
            var field2 = uiRegistry.get('index = earn');
            var field3 = uiRegistry.get('index = points');

            if (visibility==1) {
                field1.hide();
                field2.hide();
                field3.show();
            }else{
                field1.show();
                field2.show();
                field3.hide();
            }
        }
    });
});