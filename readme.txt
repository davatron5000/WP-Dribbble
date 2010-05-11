=== WP Dribbble ===
Contributors: davatron5000
Donate link: http://github.com/davatron5000
Tags: dribbble, designer, social media, widget
Requires at least: 2.9.2

A sidebar widget for Dribbble, the show and tell social network for web designers, developers and other creatives.

== Description ==

By request, I've created a sidebar widget for Dribbble, the show and tell social network for web designers, developers and other creatives.

Until the fine folks at Dribbble release their fully functioning API, this plugin will take the latest shots from your RSS feed.

The page was created to mimic the Popular page (design by Dan Cederholm, aka @simplebits) with the small 200x150 thumbs.

Features

* Specify the number of shots (up to 10).
* You can enable/disable drop shadow.
* You can choose to ignore the CSS from the plugin and create your own.


== Installation ==

There are a few ways to get the plugin working.  Here's the normal way:

1. Upload the plugin to your plugins directory.
1. Activate the plugin.
1. Drag the widget into your sidebar and configure the widget. Click save and visit your site and you should see it in the sidebar.

If you don't use sidebars and are a SUPER-DIY "roll your own" kind of guy/gal, then here's what you do:

1. Upload the plugin to your plugins directory.
1. Activate the plugin.
1. Drag the widget into your sidebar and configure the widget. Click save.
1. "Remove" the widget immediately or drag it to "Inactive Widgets".
1. In your theme add the following php snippet `<?php do_action('wp_dribbble'); ?>`

= Roll Your Own CSS =

By default the application will include the following CSS in an inline CSS block, which may or may not validate.  If you hate inline CSS or think you can it CSS better, just uncheck the option.

Below is the sample CSS block that will load by default.

`
<style type="text/css"> 
.dribbbles{list-style-type:none;margin:0px 0px 1.5em;}
.dribbbles li{font-size:15px;position:relative;width:220px;padding:0;margin:0 0 1.5em 0;}
.dribbbles .dribbble{font-family:"Helvetica Nueue", Helvetica, Arial, sans-serif;position:relative;clear:left;overflow:hidden;}
.dribbbles .dribbble-shot{padding:10px;background:url(http://yoursite.com/path/to/plugins/wp-dribbble/images/dribbblesprite.png) no-repeat -10px -330px;}
.dribbbles .dribbble-over{position:absolute;top:10px;left:10px;z-index:1;width:180px;height:130px;margin:0!important;padding:10px;font-size:0.8em;line-height:2em;text-decoration:none;color:#888;background:url(http://yoursite.com/path/to/plugins/wp-dribbble/images/dribbblesprite.png) no-repeat -110px -160px;}
.dribbbles .dribbble-link{position:relative;z-index:2;}
.dribbbles img{margin:0;width:200px;height:auto;opacity:1;-webkit-transition:opacity 0.2s linear;-o-transition:opacity 0.2s linear;-moz-transition:opacity 0.2s linear;}
.dribbbles a:hover img{opacity:0.1;-webkit-transition:opacity 0.2s linear;-o-transition:opacity 0.2s linear;-moz-transition:opacity 0.2s linear;}
.dribbbles strong{display:block;font-weight:bold;font-size:1.4em;line-height:1.2em;color:#ea4c88;}
.dribbbles .dim{font-weight:bold;color:#666;}
.dribbbles em{position: absolute;bottom:11px;left:10px;font-size:1em;line-height:1em;font-weight:normal;font-style:normal;}
.dribbbles .dribbble-img{width:200px;height:150px;overflow:hidden;}
</style>
`

And here's the generated code (pretty much the same as Dribbble's).

`
<ol class="dribbbles"> 
	<li class="group"> 
	<div class="dribbble"> 
		<div class="dribbble-shot"> 
			<div class="dribbble-img"> 
				<a href="http://dribbble.com/shots/..." class="dribbble-link"><img src="http://dribbble.com/..._teaser.jpg" alt="Title"/></a> 
				<a href="http://dribbble.com/shots/..." class="dribbble-over"><strong>Title</strong> 
					<span class="dim">Your Player Name</span> 
					<em>January 01, 2010</em> 
				</a> 
			</div> 
		</div> 
	</div> 
 	</li> 
</ol>
`


== Frequently Asked Questions ==

= Can I do my own CSS? =

Yes.  Just uncheck the "Include CSS?" option and then get to CSSing.



== Changelog ==

= 1.0.1 =
* Now with less deprecated functions!
* Fixed issue with needless expand($args) call.
* Added border-bottom to shots CSS with no-shadow.
* Fixed issue where RSS feed rendered invalid because of extra whitespace.

= 1.0 =
* First version suckkkkaaz.