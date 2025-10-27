//layout
$(function () {
    $('#header_m').each(function () {

        var $window = $(window), 
            $header = $(this), 
            headerOffsetTop = $header.offset().top;

        $window.on('scroll', function () {
            if ($window.scrollTop() > headerOffsetTop) {
                $header.addClass('sticky');
            } else {
                $header.removeClass('sticky');
            }
        });
        $window.trigger('scroll');

    });
});
$(document).ready(function(e) {
	$('#bt_gnb').click(function(){
		$(this).toggleClass('on');
		$('#gnb_m').toggleClass('on');
		$('#gnb_m ul').toggleClass('on');
		$('html').toggleClass('on');
	});
});
$(document).ready(function(e) {
	$('#bt_menu.on').click(function(){
		$('#menu').addClass('on');
		$('#gnb').removeClass('off').addClass('on')
		$('#footer').removeClass('off').addClass('on')
		$('#bt_menu.off').show();
		$(this).hide();
		$('html').addClass('on');
	});
	$('#bt_menu.off').click(function(){
		$('#menu').removeClass('on');
		$('#gnb').removeClass('on').addClass('off')
		$('#footer').removeClass('on').addClass('off')
		$(this).hide();
		$('#bt_menu.on').show();
		$('html').removeClass('on');
	});
});

//contents
$(document).ready(function() {
    $(".tab_con li").click(function() {
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
        $(this).parent().parent().find(".tab_con_content").hide();
        var activeTab = $(this).find("a").attr("href");
        $(activeTab).show();
        return false;
    });
	$('.tab_con li a').click(function(e) {
        $('.tab_con').toggleClass('on');
    });
});

//select
$(document).ready(function(e) {
	$('.select .selected').click(function(e) {
        $(this).parent().toggleClass('on');
    });
	$('.select ul li a').click(function(e) {
        $(this).parent().addClass('on');
        $(this).parent().siblings().removeClass('on');
        $(this).parent().parent().removeClass('on');
        var s_val = $(this).html();
		$('.select .selected').html(s_val)
    });
});