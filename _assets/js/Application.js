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

    },

    this.page = function(page){

        eval("this."+page);

    },

    this.alanadi = function () {

        $(".check-domain").click(function(){

            $(".siparis-alanadi").css("display","none");

            $(".input-alanadi > i.icon").removeAttr("class").addClass("icon");

            $(".input-alanadi").addClass("loading");

            var Domain = $("input[name='alan_adi']").val()
                .replace("ww.","")
                .replace("www.","");

            if(Domain.length<=0){

                $(".input-alanadi").removeClass("loading");

                $(".input-alanadi > i.icon").addClass("close");

                $("p.description-alanadi").text("Lütfen bir Alan Adı giriniz!");

                return false;

            }

            if(Domain.indexOf(".")<=-1){

                $(".input-alanadi").removeClass("loading");

                $(".input-alanadi > i.icon").addClass("close");

                $("p.description-alanadi").text("Geçersiz bir Alan Adı girdiniz!");

                return false;

            }

            $.post("System/whois.php", {domain_name: Domain}, function(e){

                var parseJSON = e;

                $(".input-alanadi").removeClass("loading");

                if(parseJSON.available){

                    $(".input-alanadi > i.icon").addClass("checkmark");

                    $("p.description-alanadi").text("Bu Alan Adı müsait.");

                    $(".siparis-alanadi").css("display","inline-block").click(function(){

                        $(".siparis-alanadi-form").modal("show");

                        $(".siparis-alanadi-form .form-alanadi > .input > input[name='domain']").val("www."+Domain);
                        
                        $(".siparis-alanadi-form .siparis-done").click(function () {

                            var Name = $(".siparis-alanadi-form input[name='firstname']").val() + " " + $(".siparis-alanadi-form input[name='surname']").val();

                            var Phone = $(".siparis-alanadi-form input[name='phone']").val();

                            var Mail = $(".siparis-alanadi-form input[name='email']").val();

                            $.post("System/AlanadiSiparis.php", {name: Name, phone: Phone, mail: Mail, domain: Domain}, function(json){

                                  if(json.response){



                                  }

                            });

                        });

                    });

                }else{

                    $(".input-alanadi > i.icon").addClass("close");

                    $("p.description-alanadi").text("Bu Alan Adı başkası tarafından kayıt edilmiş.");

                }

            });

        });

    }

}
function App(p) {
    return new Application(p);
}