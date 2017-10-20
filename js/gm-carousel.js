(function($) {

    function get_li_array() {

        var array = [];
        var carousel = $('.gm_carousel');
        var li_elms = carousel.find('li');

        li_elms.each( function () {
            array.push( $(this).html() );
        });

        return array;
    }

    function rotate_carousel(li_array) {
        var li_count = li_array.length - 1;
        var carousel_card = $('.gm_carousel_card');
        var content = carousel_card.find('.gm_card_content');

        animate_card(content, 'left', function() {

            var active_index = get_active_button();
            var next_index = active_index >= li_count ? 0 : active_index+1;
            var next_li = li_array[next_index];

            content.remove();

            var new_content_card = '<div class="gm_card_content">' + next_li + '</div>';

            carousel_card.append(new_content_card);

            set_active_button(next_index);

        });

        tid = setTimeout(function () { rotate_carousel(li_array); }, 5000);
    }

    function button_click(li_array) {
        var button_nav = $('.gm_carousel_nav');

        var span = button_nav.find('span');

        span.on('click', function(){
            abortTimer();

            var carousel_card = $('.gm_carousel_card');

            var clicked_button = $(this);
            var clicked_id = clicked_button.attr('id');
            var clicked_index = get_number_from_id(clicked_id);

            var active_button = button_nav.find('.gm_active');
            var active_id = active_button.attr('id');
            var active_index = get_number_from_id(active_id);

            if (clicked_index === active_index) {
                return false;
            }

            var direction = clicked_index < active_index ? 'right' : 'left';

            var content = carousel_card.find('.gm_card_content');

            animate_card(content, direction, function () {

                content.remove();

                var new_content = li_array[clicked_index];
                var new_content_card = '<div class="gm_card_content">' + new_content + '</div>';

                carousel_card.append(new_content_card);

                set_active_button(clicked_index);
            });
        });
    }

    function check_mobile() {
        return parseInt(gm_js.is_mobile) === 1;
    }

    function carousel_swipe(li_array)
    {
        var is_mobile = check_mobile();

        if ( is_mobile === false )
        {
            return false;
        }

        var carousel = $('.gm_carousel_wrapper');

        /* *************************************************
         * - swipeleft triggers navigate to the next image.
         * - swiperight find the previous image.
         * *************************************************/
        carousel.on('swipeleft', function () {
            abortTimer();
            swipe_click('right', li_array);
        });

        carousel.on('swiperight', function () {
            abortTimer();
            swipe_click('left', li_array);
        });
    }

    function swipe_click(direction, li_array) {

        var max_index = li_array.length -1;
        var active = get_active_button();
        var new_index = null;

        var carousel_card = $('.gm_carousel_card');

        switch (direction)
        {
            case 'right':
                new_index = active +1;
                direction = 'right';
                break;
            case 'left':
                new_index = active -1;
                direction = 'left';
                break;
        }

        new_index = new_index > max_index ? 0 : new_index;
        new_index = new_index < 0 ? max_index : new_index;

        var content = carousel_card.find('.gm_card_content');

        animate_card(content, direction, function () {

            var new_content = li_array[new_index];

            content.remove();

            var new_content_card = '<div class="gm_card_content">' + new_content + '</div>';

            carousel_card.append(new_content_card);

            set_active_button(new_index);
        });
    }

    function animate_card(content, direction, callback) {

        var animate_rules;

        switch (direction) {
            case 'left':
                animate_rules = {left: '100%'};
                break;
            case 'right':
                animate_rules = {right: '100%'};
                break;
            default:
                break;
        }

        content.animate(animate_rules, 600, callback);
    }

    function get_active_button()
    {
        var button_nav = $('.gm_carousel_nav');
        var active = button_nav.find('.gm_active');
        var id = active.attr('id');
        var id_num = id[id.length -1];

        return parseInt(id_num);
    }

    function set_active_button(set_active)
    {
        var button_nav = $('.gm_carousel_nav');
        var active = button_nav.find('.gm_active');

        active.removeClass('gm_active');

        if (! active.hasClass('gm_inactive')) {
            active.addClass('gm_inactive');
        }

        var new_active = button_nav.find('#gm_dot_'+set_active);

        new_active.addClass('gm_active');
    }

    function abortTimer() { // to be called when you want to stop the timer
        clearTimeout(tid);
    }

    function set_delay() {
        var delay = gm_js.delay;
        return parseInt(delay) * 1000;
    }

    function get_number_from_id(id) {
        var id_num = id.replace(/[^0-9]/gi, '');
        return parseInt(id_num, 10);
    }

    // Start the infinite loop
    var li_array = get_li_array();
    var delay = set_delay();

    var tid = setTimeout(function() { rotate_carousel(li_array); }, delay);

    // Navigate
    button_click(li_array);
    carousel_swipe(li_array);

})(jQuery);