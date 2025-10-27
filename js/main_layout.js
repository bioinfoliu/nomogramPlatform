//layout
$(document).ready(function(e) {
    $('#bt_gnb').click(function(e) {
        $(this).toggleClass('on');
        $('#gnb').toggleClass('on');
        $('header').toggleClass('on');
    });
});

$(function () {
    $('#header').each(function () {

        var $window = $(window), 
            $header = $(this), 
            headerOffsetTop = $header.offset().top;

        $window.on('scroll', function () {
            if ($window.scrollTop() > 10) {
                $header.addClass('sticky');
            } else {
                $header.removeClass('sticky');
            }
        });
        $window.trigger('scroll');

    });
});
