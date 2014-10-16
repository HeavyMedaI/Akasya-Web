/**
 * Created by musaatalay on 30.9.2014.
 */
var Application = function(e){

    this.element = e||null;

    this.slide = function(o){

        var SlideElements = $(this.element);
        var First =  0;
        var Index = 0;
        setInterval(function(){
            On = $(SlideElements).find(".on");
            Index = $(On).index();
            $(On).transition({
                animation : 'scale',
                duration  : '1s',
                complete  : function() {
                    $(this).addClass("off").removeClass("on");
                    //$(SlideElements).find(".slide-element").eq(Index+1).transition('scale').removeClass("off").addClass("on");
                }
            });
            //$(SlideElements).find(".slide-element").eq(Index+1).transition('scale').removeClass("off").addClass("on");

        }, o.timeout);

    },

    this.fourshape = function(o){

        o = o||null;

        $(this.element)
            .eq(0).shape('flip up').end()
            .eq(1).shape('flip over').end()
            .eq(2).shape('flip up').end()
            .eq(3).shape('flip back').end();

    },

    this.scrollFixed = function(o){

        o = o || {};

        $(this.element).scroll(function(){
            if($(this).scrollTop() > o.afterScrolled){
                $(o.target).css("position","fixed").css("z-index", o.zindex[1]);
            }else{
                $(o.target).css("position","relative").css("z-index", o.zindex[0]);
            }
        });

    },

    this.mobilemenu = function(o){

        o = o||{};

        if(o.size!=null&& o.size!=false){
            $(o.target).addClass(o.size);
        }

        if(o.floating!=null&& o.floating==true){
            $(o.target).addClass("floating");
        }

        $(o.target).sidebar({overlay: o.overlay});

        $(this.element).click(function(){
            $(o.target).sidebar("toggle");
        });

    }

}
function App(p) {
    return new Application(p);
}