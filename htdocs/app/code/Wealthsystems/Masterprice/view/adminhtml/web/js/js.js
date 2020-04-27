function addOption(option) {
    jQuery(option).parent().parent().find('.select-rules').first().clone().addClass('new').appendTo(jQuery(option).parent().parent().find('.list-rules'));

    setKey();
}

function removeOption(option) {
    if (jQuery(option).parent().parent().find('.select-rules').length > 1) {
        jQuery(option).parent().remove();
    }
}

function setKey() {
    i = 0;
    jQuery('.item').each(function (index) {
        y = 0;
        jQuery(this).find('.select-rules').each(function (index) {
            jQuery(this).find('select').attr('name', 'variable[' + i + '][' + y + ']');
            y++;
        });
        i++;
    });
}

function addRule() {
    jQuery('.item').first().clone().appendTo('.list-item');
    jQuery('.item').last().find('.query-text').val('');

    setKey();

    jQuery('.item').last().find('.new').each(function (index) {
        jQuery(this).remove();
    });

    i = 0
    jQuery('.item').last().find('.select-rules').each(function (index) {
        if (i > 0) {
            jQuery(this).remove();
        }
        i++;
    });
}

function removeRule(option) {
    if (jQuery('.item').length > 1) {
        jQuery(option).parent().parent().remove();

        setKey()
    }
}

function resetRule(rule) {
    jQuery(rule).parent().parent().find('.query-text').val('');

    i = 0;
    jQuery(rule).parent().parent().find('.select-rules').each(function (index) {
        if (i > 0) {
            jQuery(this).remove();
        }
        i++;
    });

    setKey()
}