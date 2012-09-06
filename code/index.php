<!DOCTYPE html>
<html>
<head>
<title>local music</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="./style/localIndex.css" rel="stylesheet">
<style type="text/css">
#overlay{
	display:none;
	width:100%;
	height:100%;
	background:#EEEEEE;
	position:fixed;
	top:0;
	right:0;
	bottom:0;
	left:0;
	opacity:0.80;
	filter:Alpha(opacity=80);
	z-index:997;
	}
#overlay_close span{
	display:block;
	width:10px;
	height:10px;
	background:url("./skin/close.png") 0px 1px no-repeat;
	float:right;
	margin:25px 10px 0 0;
	font-size:13px;
	color:#133783;
	padding:3px 3px 4px 3px;
	cursor:pointer;
	}
#overlay_close span:hover{
    background:url("./skin/close.png") 0px -47px no-repeat;
	}
#playContainer{
   display:none;
   width:780px;
   height:430px;
   border:5px solid #f2f2f2;
   padding:5px;
   position:absolute;
   top:80px;
   left:250px;
   overflow:auto;
   background:#f9f9f9;
   z-index:998;
   border:1px solid #ccc;
}

.control_ul li{
  color:#505050;
  font-size:12px;
  padding:5px 5px 5px 10px;
  background:url("./skin/bullet_black.gif") 5px 10px no-repeat;
  border-bottom:1px dotted #ccc;
  overflow: hidden;
  text-overflow: ellipsis;
  -o-text-overflow: ellipsis;
  white-space: nowrap;
}
.control_ul li:hover{ 
  background:url("./skin/bullet_red.gif") 5px 10px no-repeat;
  background-color:#EEEEEE;
}
.jp-container{
  width:365px;
  height:350px;
  outline:none;
}
.jspContainer
{
	overflow: hidden;
	position: relative;
}
.jspPane
{
	position: absolute;
}

.jspVerticalBar
{
	position: absolute;
	top: 0;
	right: 0;
	width: 9px;
	height: 100%;
	background:transparent;
}

.jspHorizontalBar
{
	position: absolute;
	bottom: 0;
	left: 0;
	width: 100%;
	height: 14px;
	background: transparent;
}

.jspVerticalBar *,
.jspHorizontalBar *
{
	margin: 0;
	padding: 0;
}

.jspCap
{
	display: none;
}

.jspHorizontalBar .jspCap
{
	float: left;
}

.jspTrack
{
	background: transparent;
	position: relative;
}

.jspDrag
{
	background: #666;
	position: relative;
	top: 0;
	left: 0;
	cursor: pointer;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
}

.jspHorizontalBar .jspTrack,
.jspHorizontalBar .jspDrag
{
	float: left;
	height: 100%;
}

.jspArrow
{
	background: #50506d;
	text-indent: -20000px;
	display: block;
	cursor: pointer;
}

.jspArrow.jspDisabled
{
	cursor: default;
	background: #80808d;
}

.jspVerticalBar .jspArrow
{
	height: 16px;
}

.jspHorizontalBar .jspArrow
{
	width: 16px;
	float: left;
	height: 100%;
}

.jspVerticalBar .jspArrow:focus
{
	outline: none;
}

.jspCorner
{
	background: #eeeef4;
	float: left;
	height: 100%;
}

* html .jspCorner
{
	margin: 0 -3px 0 0;
}
</style>
</head>
<body>
<div class="topbar">
	<div class="topbar_inside">
		<div class="global_nav">
			<div class="global_actions">
				<span><a class="active" href='javascript:void(0)' >Home</a></span>
			</div>
			<div id="active_info">
				<div class="info_box">
					<a id="addMusic" href="javascript:void(0)">Add Music</a>
				</div>
		    </div>
		</div>
	</div>
</div>
<div id="container" class="containter">
	<div class="inner">
		<div class="jp-playlist">
			<table border="0" cellpadding="0" cellspacing="1">
				<tbody id="td_header">
					<tr><td class="td_song">Music Title</td><td class="td_rate">Count</td><td class="td_like">like</td></tr>
				</tbody>
			</table>
			<ul class="listItem">
			</ul>
		</div>
		<div class="rightArea">
			<div class="lyricArea">
			    <span class="musicName" id="musicName"></span>
				<div id="thumb" class="playingThumb"><img src="./skin/default.jpg" alt="" /></div>
				<div id="jp-container" class="jp-container">
				  <div class="lyric" id="lyric"></div>	
				</div>
			</div>
		</div>
		<div class="jp-interface">
			<div class="jp-controls">
				<div class="control_left">
					<a href="javascript:void(0);" class="jp-previous" tabindex="1"></a>
					<a href="javascript:void(0);" class="jp-play" tabindex="1"></a>
					<a href="javascript:void(0);" class="jp-pause" tabindex="1"></a>
					<a href="javascript:void(0);" class="jp-next" tabindex="1"></a>
					<div class="jp-time-holder">
						 <div class="jp-current-time"></div>/<div class="jp-duration"></div>
					</div>
				</div>
				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
				</div>
				<div class="control_right">
					<div class="jp-toggles">
						<a href="javascript:;" class="jp-shuffle" style="display:block;" tabindex="1" title="随机播放"></a>
						<a href="javascript:;" class="jp-shuffle-off" style="display:block;"  tabindex="1" title="关闭随机播放"></a>
						<a href="javascript:;" class="jp-repeat" style="display:block;"  tabindex="1" title="整体循环"></a>
						<a href="javascript:;" class="jp-repeat-off" style="display:block;"  tabindex="1" title="关闭整体循环"></a>
					</div>
					<div class="vol_control">
						<a href="javascript:void(0);" class="jp-mute" tabindex="1" title="静音"></a>
						<a href="javascript:void(0);" class="jp-unmute" tabindex="1" title="取消静音"></a>
						<div class="jp-volume-bar">
							<div class="jp-volume-bar-value"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="jp-no-solution">
			<span>flash更新提示</span>
			由于您的flash版本过低，音乐不能正常播放，请更新flash插件<a href="http://get.adobe.com/flashplayer/" target="_blank">Flash插件地址</a>.
		</div>
		<div id="jquery_jplayer_1" class="jp-jplayer"></div>
	</div>
</div>
<div id="mask"></div>
<div class="prompt" id="prompt">
	<div class='mesBoxTop'>
		<h3>welcome</h3><span id="promptClose">&times;</span>
	</div>
	<div class='mesBoxContent'><p>Please add your music folder!</p></div>
	<div class='mesBoxBottom'>
		<div class='choose_btn'>
			 <input type="file" class="file" webkitdirectory="" directory="" multiple="" mozdirectory="" onchange="getMusic(this.files)" />
			 <a href="javascript:void(0)" class="btn_hover" />choose</a>
		</div>
	</div>
</div>
	<!--javascript BEGIN-->
    <script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.jplayer.min.js"></script>
	<script type="text/javascript" src="js/jplayer.playlist.js"></script>
	<script type="text/javascript" src="js/id3v2.js"></script>
	<script type="text/javascript" src="js/scroll/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="js/scroll/jquery.jscrollpane.min.js"></script>
	<script type="text/javascript" src="js/scroll/scroll-startstop.events.jquery.js"></script>
	<script type="text/javascript">
	var myPlaylist = new jPlayerPlaylist({
		jPlayer: "#jquery_jplayer_1",
		cssSelectorAncestor: "#container"
	},[
	  ],{
		swfPath: "js",
		supplied: "mp3",
		wmode: "window"
	});
	
	//parse mp3 file
	function parseFile(file, callback){
        ID3v2.parseFile(file,function(tags){
            callback(tags);
        })
    }
	
	//check music type (mp3,ogg......)
    function canPlay(type){
        var audio = document.createElement('audio');
        return !!(audio.canPlayType && audio.canPlayType(type).replace(/no/, ''));
    }
	var first_flag=true;
	
	//Import the mp3 files
    function getMusic(files){
	    $("#prompt").animate({top:"-200px"},function(){
		    $("#prompt").fadeOut("20");
			$("#mask").fadeOut("20");
		});
        var queue = [];
        var mp3 = canPlay('audio/mpeg;'), ogg = canPlay('audio/ogg; codecs="vorbis"');
        for(var i = 0; i < files.length; i++){
            var file = files[i];
			var path = file.webkitRelativePath || file.mozFullPath || file.fileName;
		    if (path.indexOf('.AppleDouble') != -1) {
				// Meta-data folder on Apple file systems, skip
				continue;
			} 
			var size = file.size || file.fileSize || 4096;
			  if(size < 4095) { 
				// Most probably not a real MP3
				console.log(path);
				continue;
			 }
			if(file.fileName.indexOf('mp3') != -1){//Import the mp3 type files
				if(mp3){
				   queue.push(file);
				}
			}
			if(file.fileName.indexOf('ogg') != -1  || file.fileName.indexOf('oga') != -1){//Import the ogg type files
				if(ogg){ 
				  queue.push(file);
				}
			}
        }
		
        function process(){
            if(queue.length){
				var f = queue.shift();
				    var tag_title = f.fileName.replace(".mp3",'');
                    if(!localStorage[tag_title]){					
						localStorage[tag_title] = JSON.stringify({
							   playCount:0
						});
					}
					if(window.createObjectURL){
						url = window.createObjectURL(f);
					}else if(window.createBlobURL){
						url = window.createBlobURL(f)
					}else if(window.URL && window.URL.createObjectURL){
						url = window.URL.createObjectURL(f)
					}else if(window.webkitURL && window.webkitURL.createObjectURL){
						url = window.webkitURL.createObjectURL(f)
					}
					if(first_flag){
						myPlaylist.add({
						   title:tag_title,
						   mp3:url
						},true);
						first_flag=false;
					}else{
					     myPlaylist.add({
						   title:tag_title,
						   mp3:url
						});
					}
					$("<span class='show'></span>").appendTo("li:last-child").click(function(){
					    parseFile(f,function(tags){
						    var tag_thumb = tags.pictures.length?tags.pictures[0].dataURL:'./skin/default.jpg';
							$("#thumb").html("<img src='"+tag_thumb+"' />");
					    })
					});
				process();
				var lq = queue.length;
				setTimeout(function(){
				     if(queue.length == lq){
					     process();
				     }
				},300);
			}
        }
        process();
		$(".jp-playlist-current").find("span.show").click();
    }
	
	
	//clicked like this music show a red heart 
	function heart(e,title){
	    var currentMp3=unescape(title);
		if(localStorage[currentMp3]){
			var info=jQuery.parseJSON(localStorage[currentMp3]);
			if($(e).hasClass("heart-on")){
				localStorage[currentMp3] = JSON.stringify({
				   playCount:info.playCount,
				   heart:0
				});
				$(e).removeClass("heart-on");
			}else{
			    localStorage[currentMp3] = JSON.stringify({
				   playCount:info.playCount,
				   heart:1
				});
	            $(e).addClass("heart-on");
	        }
		}
	}
	
	$(".music-play").click(function(){
		$(this).removeClass("music-play").addClass("played");
		var info=$(this).find("input").val();
		var f_name=info.split("{}")[0];
		if(!localStorage[f_name]){					
			localStorage[f_name] = JSON.stringify({
				   playCount:0
			});
		}
		myPlaylist.add({
			title:f_name,
			mp3:info.split("{}")[1]
		},true);
    });
	
	
	$("#promptClose").click(function(){
		$("#prompt").animate({top:"-200px"},function(){
		         $("#prompt").fadeOut("20");
			     $("#mask").fadeOut("20");
		    });
	});
	
	//add music button clicked
	$("#addMusic").click(function(){
	    $("#mask").fadeIn("10");
		$("#prompt").fadeIn("10",function(){
		  $("#prompt").animate({top:"200px"});
		});
	});
</script>
<script type="text/javascript">
$(function() {
	var $el	= $('#jp-container').jScrollPane({
		verticalGutter 	: -16
	}),

		extensionPlugin 	= {	
			extPluginOpts	: {
				mouseLeaveFadeSpeed	: 500,
				hovertimeout_t		: 1000,
				useTimeout			: false,
				deviceWidth			: 980
			},
			hovertimeout	: null,
			isScrollbarHover: false,
			elementtimeout	: null,	
			isScrolling		: false,
			addHoverFunc	: function() {
				if( $(window).width() <= this.extPluginOpts.deviceWidth ) return false;	
				var instance		= this;
				$.fn.jspmouseenter 	= $.fn.show;
				$.fn.jspmouseleave 	= $.fn.fadeOut;
				var $vBar			= this.getContentPane().siblings('.jspVerticalBar').hide();
	
				/*
				 * mouseenter / mouseleave events on the main element
				 */
				$el.bind('mouseenter.jsp',function() {
					$vBar.stop( true, true ).jspmouseenter();	
					if( !instance.extPluginOpts.useTimeout ) return false;						
					// hide the scrollbar after hovertimeout_t ms
					clearTimeout( instance.hovertimeout );
					instance.hovertimeout 	= setTimeout(function() {
						// if scrolling at the moment don't hide it
						if( !instance.isScrolling )
							$vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
					}, instance.extPluginOpts.hovertimeout_t );	
				}).bind('mouseleave.jsp',function() {
					
					// hide the scrollbar
					if( !instance.extPluginOpts.useTimeout )
						$vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
					else {
					  clearTimeout( instance.elementtimeout );
					  if( !instance.isScrolling )
							$vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
					}
				});
				
				if( this.extPluginOpts.useTimeout ) {
					$el.bind('scrollstart.jsp', function() {
						clearTimeout( instance.hovertimeout );
						instance.isScrolling	= true;
						$vBar.stop( true, true ).jspmouseenter();
						
					}).bind('scrollstop.jsp', function() {
						
						// when stop scrolling hide the scrollbar (if not hovering it at the moment)
						clearTimeout( instance.hovertimeout );
						instance.isScrolling	= false;
						instance.hovertimeout 	= setTimeout(function() {
							if( !instance.isScrollbarHover )
								$vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
						}, instance.extPluginOpts.hovertimeout_t );
						
					});
					
					// wrap the scrollbar
					// we need this to be able to add the mouseenter / mouseleave events to the scrollbar
					var $vBarWrapper	= $('<div/>').css({
						position	: 'absolute',
						left		: $vBar.css('left'),
						top			: $vBar.css('top'),
						right		: $vBar.css('right'),
						bottom		: $vBar.css('bottom'),
						width		: $vBar.width(),
						height		: $vBar.height()
					}).bind('mouseenter.jsp',function() {
						
						clearTimeout( instance.hovertimeout );
						clearTimeout( instance.elementtimeout );
						
						instance.isScrollbarHover	= true;							
						instance.elementtimeout	= setTimeout(function() {
							$vBar.stop( true, true ).jspmouseenter();
						}, 100 );	
						
					}).bind('mouseleave.jsp',function() {
						
						// hide the scrollbar after hovertimeout_t
						clearTimeout( instance.hovertimeout );
						instance.isScrollbarHover	= false;
						instance.hovertimeout = setTimeout(function() {
							// if scrolling at the moment don't hide it
							if( !instance.isScrolling )
								$vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
						}, instance.extPluginOpts.hovertimeout_t );
						
					});
					
					$vBar.wrap( $vBarWrapper );
				
				}
			}			
		},
		jspapi 	= $el.data('jsp');
	$.extend( true, jspapi, extensionPlugin );
	jspapi.addHoverFunc();  
});
</script>
</body>
</html>