function init() {
    var max_value = 0;
    var values_count = 0;
    var chart_height = 700;
    var bar_width = 125;
    
    jQuery('#chart .value').each(function (index, value) {
        var new_value = parseInt(jQuery(this).attr('value'));
        if (new_value > max_value) {
            max_value = new_value;
        }
        values_count ++;
    });
    
    var i = 0;
    
    jQuery('#chart .value').each(function (index, value) {
        var new_value = parseInt(jQuery(this).attr('value'));
        var timestamp = jQuery(this).attr('timestamp');
        
        jQuery(this).css({height: ((new_value / max_value) * chart_height) + 'px', width: bar_width + 'px',}).css('left', i * (bar_width + 10) + 5 + 'px').get(0).innerHTML = new_value;
        i++;
    });
}
