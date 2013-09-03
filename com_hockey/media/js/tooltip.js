this.tootipshow = function(){
     jQuery("a.tool_tip").hover(function(e){
            this.t = this.title;
            this.title = "";
            var c = (this.t != "") ? "<span>" + this.t + "</span>" : "";
             jQuery("body").append("<div id='ptooltip'><img src='"+ this.rel +"' alt='photo' />"+ c +"</div>");
             jQuery("#ptooltip")
                    .css("top",(e.pageY - 300) + "px")
                    .css("left",(e.pageX - 60) + "px")
                    .animate({opacity: "show", top:(e.pageY - 200)}, "slow");


     },
    function(){
            this.title = this.t;
             jQuery("#ptooltip").remove();
     });
     jQuery("a.tool_tip").mousemove(function(e){
             jQuery("#ptooltip")
                    .css("top",(e.pageY - 200) + "px")
                    .css("left",(e.pageX - 60) + "px");
    });
};
jQuery(document).ready(function(){ tootipshow();});