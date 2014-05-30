/*
 * jQuery resize event - v1.1 - 3/14/2010
 * http://benalman.com/projects/jquery-resize-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function($,h,c){var a=$([]),e=$.resize=$.extend($.resize,{}),i,k="setTimeout",j="resize",d=j+"-special-event",b="delay",f="throttleWindow";e[b]=250;e[f]=true;$.event.special[j]={setup:function(){if(!e[f]&&this[k]){return false}var l=$(this);a=a.add(l);$.data(this,d,{w:l.width(),h:l.height()});if(a.length===1){g()}},teardown:function(){if(!e[f]&&this[k]){return false}var l=$(this);a=a.not(l);l.removeData(d);if(!a.length){clearTimeout(i)}},add:function(l){if(!e[f]&&this[k]){return false}var n;function m(s,o,p){var q=$(this),r=$.data(this,d);r.w=o!==c?o:q.width();r.h=p!==c?p:q.height();n.apply(this,arguments)}if($.isFunction(l)){n=l;return m}else{n=l.handler;l.handler=m}}};function g(){i=h[k](function(){a.each(function(){var n=$(this),m=n.width(),l=n.height(),o=$.data(this,d);if(m!==o.w||l!==o.h){n.trigger(j,[o.w=m,o.h=l])}});g()},e[b])}})(jQuery,this);

$(document).ready(function(){
	$(".submitfield").bind("click", function(){
		$(this).parents("form").trigger("submit");
		return false;
	});
	$(".topli").bind("focusin mouseover", function(){$(this).addClass("hover")});
	$(".topli").bind("focusout blur mouseout", function(){$(this).removeClass("hover")});
	

	$(".primarynav .dropdown").each(function(i,dropdownel){
		var dd = $(dropdownel);
		var anchor = dd.prevAll(".topa");
		var arrow = dd.prevAll(".dropdownarrow");
		var anchorwidth = anchor.width();
		var anchorleft = $(anchor).position()["left"];
		var offset = anchor.css("padding-left").replace("px","")*1;
		if(anchorwidth < dd.width()){
		 var outdent = (dd.width()-anchorwidth)/2;
		} else {
			var outdent = (anchorwidth-dd.width())/2;
		}
		dd.css('margin-left', anchorleft-outdent+'px');
		arrow.css("margin-left", anchorleft+anchorwidth/2+offset-4+'px');

	});
	$(".sliderdetail").hide();
	
	$(".slideranchor").bind("click", function(){
		$(this).toggleClass("open");
		$(this).parent(".sliderheader:first").next().slideToggle('fast');
		$(this).blur();
		return false;
	});
	
	// Check for direct links
	if($(".slideranchor").length > 0){
		if(window.location.hash){
			var targetslider = $(window.location.hash);
			if(targetslider.length > 0){
				if(targetslider.hasClass("sliderdetail")){
					targetslider.slideToggle('fast');
					$('html,body').animate({scrollTop: targetslider.offset()["top"]-30+"px"});
				}
			}
		}
	}
	

	if($(".ideabankcontent").length > 0){
		$(window).bind("resize", function(){
			$(".ideabankcontent").css({"height": $(window).height()-85+"px", "width": $(window).width()+"px"});
		}).trigger("resize");
		// we don't want slimbox, sharing tools or avatar!
		return false;
	}
	
	$("#homerotator_h200").homepageRotator();
	$("#homerotator").homepageRotator();
	$("#homerotator_2thirds").homepageRotator();
	if($("body.homepage").length > 0){
		$("#homepagenews").homepageNews();
		$("#homepagenotice").css("opacity", "0");
		$("#homepagenotice").animate({"bottom": "0", "opacity": "1"}, 1000);
	}
	
	
	if(typeof $.colorbox != "undefined"){
		$("a[rel='screenshots'], a[rel='lightbox']").colorbox({opacity: 0.25, loop: false, current: "{current} of {total}", onOpen: function(){
			$("#cboxContent").addClass("photo");
		}});
		$(".homelink.how, .videolink").colorbox({opacity: 0.25, iframe: true,  innerWidth:850, innerHeight:478});
	}
	
	// Sharing tools
	setupSharing();
	
	setupAvatar();
});



var avatarclasses = new Array("var1left", "var2left", "var3left", "var1right", "var2right", "var3right");
var avatarleft = false;
if($("body.homepage").length > 0){
	var avatartop = 117;
	var avatarwidth = 382;
	var contentwidth = 440;	
} else {
	var avatartop = 127;
	var avatarwidth = 315;
	var contentwidth = 971;
}
setupAvatar = function(){
	var avatarclass = avatarclasses[Math.floor(Math.random()*avatarclasses.length)];
	$("#avatarwrapper").addClass(avatarclass);
	avatarleft = (avatarclass.indexOf("left") != -1) ? true : false;
	if($("body").hasClass("downloadcomplete")){
		positionDownloadAvatar(true);
		$(window).bind("resize", positionDownloadAvatar);
	} else {
		positionAvatar(true);
		$(window).bind("resize", positionAvatar);
	}
}
positionAvatar = function(firstime){
	var viewport = $(window).width();
	if (viewport < 1025) {
		$("#avatarwrapper").css({"background-position": "50% -9999px"});
		return false;
	}
	var halfviewport = viewport/2
	if(avatarleft){
		var leftpos = halfviewport-contentwidth/2-avatarwidth;
	} else {
		var leftpos = halfviewport+contentwidth/2;
	}
	if(firstime === true){
		$("#avatarwrapper").css({"background-position": leftpos+"px "+avatartop+"px"});
	} else {
		$("#avatarwrapper").clearQueue().animate({"background-position": leftpos+"px "+avatartop+"px"}, 500);
	}
}
positionDownloadAvatar = function(firstime){
	leftpos = $("#main").offset()["left"]-119;
	if(firstime === true){
		$("#mainwrapper").css({"background-position": leftpos+"px 282px"});
	} else {
		$("#mainwrapper").clearQueue().animate({"background-position": leftpos+"px  385px"}, 500);
	}	
}
setupSharing = function(){
// 	$("#sharing .facebook").attr("href","http://www.facebook.com/share.php?u="+ encodeURIComponent(location.href)).attr("target","_blank");
// 	$("#sharing .twitter").attr("href", "http://twitter.com/share?url="+escape(location.href)+"&text="+encodeURIComponent(document.title)).attr("target","_blank");
 	$("#fblike").html("<iframe src='http://www.facebook.com/plugins/like.php?href="+encodeURIComponent(location.href)+"&amp;layout=standard&amp;show_faces=false&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=35' scrolling='no' frameborder='0' style='border:none; overflow:hidden; width:450px; height:35px;' allowTransparency='true'></iframe>");
}
var homepageNewsPause = false;
jQuery.fn.homepageNews = function(){
	return this.each(function(){
		var me = $(this);
		me.find("li:first").show();
		setInterval(function(){
			if (!homepageNewsPause) {
				visible = me.find("li:visible")
				next = visible.next("li")
				if(next.length == 0){
					next = me.find("li:first");
				}
				visible.fadeOut(function(){next.fadeIn()});
			}
		}, 5000);
	});
}
var homepageRotator = 1
jQuery.fn.homepageRotator = function(){
	return this.each(function(){
		var me = $(this)
		homepageRotator= setInterval(function(){
			doRotate();
		}, 10000);
		
		$("#homerotatorcontrols a").bind("click", function(){
			clearInterval(homepageRotator);
			var activeli = me.find("li:first");
			var nextli = $($(this).attr("href"));
			if(activeli.attr("id") != nextli.attr("id")){
				activeli.after(nextli);
				doRotate();
			}
			return false;
		});
		
		 doRotate = function(){
			nextli = $("#homerotatorcontrols .active").next();
			if(nextli.length < 1){
				nextli = $("#homerotatorcontrols li:first");
			}
			$("#homerotatorcontrols .active").removeClass("active");
			nextli.addClass("active");
			var activeli = me.find("li:first");
			activeli.animate({"margin-top": "-319px", "opacity": 0.25}, 500, function(){
				me.append(activeli);
				activeli.css({"margin-top": "0px", "opacity": 1});
			})
		}
	});
}
