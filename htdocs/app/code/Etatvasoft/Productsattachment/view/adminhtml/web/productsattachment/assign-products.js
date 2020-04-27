/* global $, $H */

define(
    [
    'mage/adminhtml/grid'
    ], function () {
        'use strict';

        return function (config) {
            var selectedProducts = config.selectedProducts,
            categoryProducts = $H(selectedProducts),
            gridJsObject = window[config.gridJsObjectName],
            tabIndex = 1000;

            $('in_attachment_products').value = Object.toJSON(categoryProducts);

            /**
             * Register Category Product
             *
             * @param {Object} grid
             * @param {Object} element
             * @param {Boolean} checked
             */
            function registerCategoryProduct(grid, element, checked)
            {
           
                if (checked) {
                    //element.positionElement.disabled = false;
                    categoryProducts.set(element.value,0);
                } else {                
                    //element.positionElement.disabled = true;
                    categoryProducts.unset(element.value);
                }

                $('in_attachment_products').value = Object.toJSON(categoryProducts);
                grid.reloadParams = {
                    'selected_products[]': categoryProducts.keys()
                };
            }

            /**
             * Click on product row
             *
             * @param {Object} grid
             * @param {String} event
             */
            function categoryProductRowClick(grid, event)
            {
            
                var trElement = Event.findElement(event, 'tr'),
                isInput = Event.element(event).tagName === 'INPUT',
                checked = false,
                checkbox = null;

                if (trElement) {
                    checkbox = Element.getElementsBySelector(trElement, 'input');

                    if (checkbox[0]) {
                        checked = isInput ? checkbox[0].checked : !checkbox[0].checked;
                        gridJsObject.setCheckboxChecked(checkbox[0], checked);
                    }
                }
            }

            /**
             * Change product position
             *
             * @param {String} event
             */
            function positionChange(event)
            {
                    
                var element = Event.element(event);

                if (element && element.checkboxElement && element.checkboxElement.checked) {
                    categoryProducts.set(element.checkboxElement.value, element.value);
                    $('in_attachment_products').value = Object.toJSON(categoryProducts);
                }
            }

            /**
             * Initialize category product row
             *
             * @param {Object} grid
             * @param {String} row
             */
            function categoryProductRowInit(grid, row)
            {            
                var checkbox = $(row).getElementsByClassName('checkbox')[0];          

                if (checkbox) {
                
                    Event.observe(checkbox, 'click', positionChange);
                }
            }

            gridJsObject.rowClickCallback = categoryProductRowClick;
            gridJsObject.initRowCallback = categoryProductRowInit;
            gridJsObject.checkboxCheckCallback = registerCategoryProduct;

            if (gridJsObject.rows) {
                gridJsObject.rows.each(
                    function (row) {
                        categoryProductRowInit(gridJsObject, row);
                    }
                );
            }
        };
    }
);
