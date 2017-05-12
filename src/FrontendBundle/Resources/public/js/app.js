$(window).on('load',function() {
    var window_height = $(window).height();
    $(".wrapper").css('min-height', window_height - $('.content-footer').outerHeight() - 50);
});