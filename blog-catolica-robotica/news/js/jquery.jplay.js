jQuery.fn.videopopup = function (options) {
    var settings = {
	videoid: "",
	videoplayer: "youtube",
	width: "600px",
	height: "400px",
	autoplay: "false"
    };
    return this.each(function () {
	if (options) {
	    $.extend(settings, options)
	}
	function centerS(cur) {
	    var cur = cur;
	    cur.css("position", "absolute");
	    cur.css("top", ($(window).height() - cur.height()) / 2 + $(window).scrollTop() + "px");
	    cur.css("left", ($(window).width() - cur.width()) / 2 + $(window).scrollLeft() + "px");
	    return this
	}
	$(this).click(function (e) {
	    var a = $(document).height();
	    var b = $(window).width();
	    e.preventDefault();
	    var popuphtml = '<div id="dvGlobalMask"></div><div id="videopopup"><div class="modalnav"></div><div id="videocontent"></div></div>';
	    $("body").append(popuphtml);
	    $("#dvGlobalMask").css({
		width: b,
		height: a
	    });
	    $("#dvGlobalMask").fadeTo("fast", 0.4);
	    $("#videopopup").css("width", settings.width);
	    $("#videopopup").css("height", settings.height);
	    centerS($("#videopopup"));
	    var autoplay = 0;
	    if (settings.autoplay == "true") {
		autoplay = 1
	    } else {
		autoplay = 0
	    }
	    youtubestr = '<iframe width="' + settings.width + '" height="' + settings.height + '" src="http://www.youtube.com/embed/' + settings.videoid + "?autoplay=" + autoplay + '&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>';
	    vimeostr = '<iframe src="http://player.vimeo.com/video/' + settings.videoid + "?color=00adef&amp;show_title=0&amp;show_portrait=0&amp;autoplay=" + autoplay + '" width="' + settings.width + '" height="' + settings.height + '" frameborder="0"></iframe>';
	    switch (settings.videoplayer) {
		case "youtube":
		    $("#videocontent").html($(youtubestr));
		    break;
		case "vimeo":
		    $("#videocontent").html($(vimeostr));
		    break
	    }
	    $("#videopopup").show();
	    $(".modalnav").show()
	});
	$(".modalnav").live("click", function () {
	    $("#dvGlobalMask").hide();
	    $("#videopopup").hide();
	    $(".modalnav").hide();
	    $('#videocontent').html('');
	    $(settings.videoid).hide();
	})
    });
    return this
};
     
$(document).ready(function(){
    $('.youtube').each(function(){
	//var videourl = $(this).attr('url');
        //var videoid = $(this).attr('id');
        /*
	$.ajax({
	    url: "http://gdata.youtube.com/feeds/api/videos/"+videourl+"?v=2&alt=json",
	    dataType: "jsonp",
	    success: function (data) {
		$('#'+videoid).append('<br/><ul>'+data.entry.title.$t+'</ul>');
	    }
	})
	$('#'+videoid).videopopup({
	    'videoid' : videourl,
	    'videoplayer' : 'youtube', 
	    'autoplay' : 'true'
	})
        */
    })
})
	