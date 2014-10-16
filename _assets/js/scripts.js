/**
 * Created by musaatalay on 30.9.2014.
 */
$(function(){
    /*App(".slide").slide({
        timeout: 3000
    });*/
    $('.ui.dropdown')
        .dropdown({
            on: 'hover'
        })
    ;
    $('.slider').fractionSlider({
        'fullWidth': 			true,
        'controls': 			false,
        'pager': 				true,
        'responsive': 			true,
        'dimensions': 			"1359,400",
        'increase': 			false,
        'pauseOnHover': 		true
    });
    $(".direction .button").click(function(){
        var
            $shape    = $('.ui.slayt.shape'),
            direction = $(this).data('direction') || false,
            animation = $(this).data('animation') || false
            ;
        if(direction && animation) {
            $shape.shape(animation + '.' + direction);
        }
    });
    setInterval(function(){
        App('.content-stuff-wrapper > .shape-stuff > .column > .ui.shape').fourshape();
    }, 5000);

    App(window).scrollFixed({
        target: ".row.ust-kutu-wrapper",
        afterScrolled: 5,
        zindex: [1,9999]
    });

    App(".mobile-menu-button").mobilemenu({
        target: "div.ui.sidebar.menu.mobile-menu",
        overlay: true,
        floating: true,
        size: "thin"
    });

});