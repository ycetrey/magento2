/**
 * MageMe
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageMe.com license that is
 * available through the world-wide-web at this URL:
 * https://mageme.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    MagemeCom
 * @package     MagemeCom_HidePrice
 * @author      MageMe Team <support@mageme.com>
 * @copyright   Copyright (c) MageMe (https://mageme.com)
 * @license     https://mageme.com/license
 */
define(['MagemeCom_HidePrice/js/sweetalert'], function (Swal) {
    function hidePriceAlert(options, node) {
        var o = {
            title: '',
            text: '',
            html: '',
            type: '',
            confirmButtonText: ''
        };
        for (var k in options) {
            if (options.hasOwnProperty(k)) o[k] = options[k];
        }
        node.onclick = function () {
            Swal.fire({
                title: o.title,
                text: o.text,
                html: o.html,
                type: o.icon,
                confirmButtonText: o.confirmButtonText,
                customClass: {
                    container: 'swal-container-class',
                    popup: 'swal-popup-class',
                    header: 'swal-header-class',
                    title: 'swal-title-class',
                    closeButton: 'swal-close-button-class',
                    image: 'swal-image-class',
                    content: 'swal-content-class',
                    input: 'swal-input-class',
                    actions: 'swal-actions-class',
                    confirmButton: 'swal-confirm-button-class',
                    cancelButton: 'swal-cancel-button-class',
                    footer: 'swal-footer-class'
                }
            });
        }
    }

    return hidePriceAlert;
});
