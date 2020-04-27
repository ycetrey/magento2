/*
 * Copyright (c) 2018 BrainActs Commerce OÜ, All rights reserved.
 * See LICENSE.txt for license details.
 */

define(
    [
        'jquery',
        'mage/template',
        'text!./templates/customers.html',
        'Magento_Ui/js/modal/alert',
        'validation',
        'Magento_Ui/js/modal/modal',
        'mage/translate',
        'mage/mage'
    ],
    function ($, mageTemplate, customersTmpl, alert) {
        'use strict';

        $.widget(
            'mage.rewardPoints',
            {

                options: {
                    createButton: $('#add-remove-points'),
                    customer_url: null,
                    save_url: null,
                    template: customersTmpl
                },

                timer: null,

                _create: function () {
                    this.options.createButton.removeAttr('onclick');
                    this._viewAddRemove();
                    this._keyUpCustomer();
                    this._selectCustomer();
                },


                _viewAddRemove: function () {
                    var _self = this;
                    this.options.createButton.removeAttr('onclick');

                    this.options.createButton.click(
                        function (e) {
                            e.preventDefault();

                            var popup = $('#add-remove-dialog');
                            var buttons = [
                                    {
                                        text: 'Apply',
                                        class: 'primary',
                                        click: function () {

                                            _self._validate();
                                        }
                                    },
                                    {
                                        text: 'Close',
                                        class: 'close',
                                        click: function () {
                                            this.closeModal();
                                            $('[name="points"]').val('');
                                            $('[name="customer_name"]').val('');
                                            $('[name="customer_id]').val('');
                                            $('[name="reason"]').val('');
                                            $('.customer-list-wrapper').remove();
                                        }
                                    }
                                ],
                                dialogProperties = {
                                    title: $.mage.__('Add/Remove Reward Points'),
                                    type: 'slide',
                                    dialogClass: ''
                                };

                            if (buttons.length > 0) {
                                dialogProperties['buttons'] = buttons
                            }

                            popup.modal(dialogProperties);
                            popup.modal('openModal');
                        }
                    );
                },

                _keyUpCustomer: function () {
                    var self = this;
                    $(document).on(
                        'keyup',
                        '[name="customer_name"]',
                        function () {
                            if (self.timer != null) {
                                clearTimeout(self.timer);
                            }
                            $('[name="customer_id"]').val('');

                            var data = {'form_key': window.FORM_KEY, 'search': $(this).val()};

                            self.timer = setTimeout(
                                function () {
                                    $.ajax(
                                        {
                                            url: self.options.customer_url,
                                            data: data,
                                            success: function (resp) {
                                                self._drawResultTable(resp)
                                            },
                                            /**
                                             * Complete callback.
                                             */
                                            complete: function () {

                                            }
                                        }
                                    )
                                },
                                400
                            );
                        }
                    );

                },

                /**
                 * Bind click by customer name and fill field after click
                 *
                 * @private
                 */
                _selectCustomer: function () {
                    $(document).on(
                        'click',
                        '#customer-list-wrapper li',
                        function () {
                            var id = $(this).data('id'),
                                value = $(this).text();

                            $('[name="customer_name"]').val($.trim(value));
                            $('[name="customer_id"]').val($.trim(id));
                            $('.customer-list-wrapper').remove();
                        }
                    );
                },

                /**
                 * Draw customer items and show in form
                 *
                 * @param   data
                 * @private
                 */
                _drawResultTable: function (data) {
                    var tmpl = mageTemplate(this.options.template);
                    var dataObject = {data: data.customers};
                    tmpl = tmpl(dataObject);
                    $('.customer-list-wrapper').remove();
                    var container = $('<div />').attr('id', 'customer-list-wrapper').addClass('customer-list-wrapper');
                    container.insertAfter('[name="customer_name"]');
                    $('.customer-list-wrapper').html($(tmpl));
                },


                /**
                 * Validate and Save
                 *
                 * @returns {boolean}
                 * @private
                 */
                _validate: function () {

                    if (!$('#points_form').valid()) {
                        return false;
                    }
                    if ($('[name="customer_id"]').val() == '') {
                        alert({
                            title: $.mage.__('Attention'),
                            content: $.mage.__('The customer needs to be chosen from the drop-down. If you cannot find the customer, check if name or email is correct.'),
                            actions: {
                                always: function(){}
                            }
                        });
                        return;
                    }


                    $('body').trigger('processStart');
                    var form = $('#points_form');
                    var data = $('#points_form').serializeArray();
                    //data.push({'name':'form_key', 'value':window.FORM_KEY})
                    $.ajax(
                        {
                            url: form.attr('action'),
                            data: data,
                            success: function (resp) {
                                window.location.href = resp.redirect;
                            },
                            /**
                             * Complete callback.
                             */
                            complete: function () {

                            }
                        }
                    )
                }

            }
        );

        return $.mage.rewardPoints;


    }
);
