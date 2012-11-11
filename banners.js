
// initialisation call from block - once for each available shared dropbox
function animatebanners (Y, code, config){
    Y.use('yui2-carousel','yui2-animation', function(){  
         Y.on("domready",   function(){
                        var carousel = new YAHOO.widget.Carousel('container_'+code, {
                                isCircular:true,
                                carouselEl: "UL",
                                numVisible: 1,
                                autoPlayInterval: config.speed*1000,
                                animation: {speed:1,effect:YAHOO.util.Easing.easeOut}            
                        });
                        carousel.render();
                        carousel.startAutoPlay();  
                        Y.one('#container_'+code+' .yui-carousel-nav').remove();
                        Y.one('#container_'+code).setStyle("visibility", "");
                        Y.one('#container_'+code).setStyle("height", config.height+2);
                        
                        carousel.on('pageChange', function (o){//test for if last page
                            var x = this._selectedItem;
                            var y = this._getNumPages();
                            if (x==y-1){ 
                                var animation = this.get('animation');
                                var animationObj = { speed: 0, effect: YAHOO.util.Easing.easeNone };
                                this.set('animation', animationObj);
                                this.set('selectedItem', 0);
                                this.scrollTo();
                                this.set('animation', animation);
                            } 
                        });
                        Y.one('#pause_banner_'+code).on('click', function (e) {
                                this.setStyle('display','none');
                                carousel.stopAutoPlay();
                        });
                        Y.one('#left_banner_'+code).on('click', function (e) {
                                Y.one('#pause_banner_'+code).setStyle('display','none');
                                carousel.stopAutoPlay();
                                x=carousel.get("selectedItem");
                                y=carousel.get("numItems");
                                if (x==0){
                                    var animation = carousel.get('animation');
                                    var animationObj = { speed: 0, effect: YAHOO.util.Easing.easeNone };
                                    carousel.set('animation', animationObj);
                                    carousel.set('selectedItem', y-1);
                                    carousel.scrollTo();
                                    carousel.set('animation', animation);
                                    carousel.set('selectedItem', y-2);
                                }else{
                                    carousel.set('selectedItem', carousel.get("selectedItem")-1);
                                }
                                e.preventDefault();
                        });
                        Y.one('#right_banner_'+code).on('click', function (e) {
                                Y.one('#pause_banner_'+code).setStyle('display','none');
                                carousel.stopAutoPlay();
                                x=carousel.get("selectedItem");
                                y=carousel.get("numItems");
                                if (x==y-1){
                                    var animation = carousel.get('animation');
                                    var animationObj = { speed: 0, effect: YAHOO.util.Easing.easeNone };
                                    carousel.set('animation', animationObj);
                                    carousel.set('selectedItem', 0);
                                    carousel.scrollTo();
                                    carousel.set('animation', animation);
                                    carousel.set('selectedItem', 1);
                                }else{
                                    carousel.set('selectedItem', carousel.get("selectedItem")+1);
                                }
                                e.preventDefault();
                        });
            });
})}