<?php
/*
Plugin Name: WP Dribbble
Plugin URI: http://daverupert.com/2010/05/dribbble-wordpress-plugin/
Description: Pull in your Dribbble Feed.
Author: Dave Rupert
Version: 1.0.1
Author URI: http://daverupert.com/
*/
/*
Copyright 2010  Dave Rupert  (email : dave@paravelinc.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function wpDribbble() { 
	include_once(ABSPATH . WPINC . '/feed.php');
 
  $options = get_option("widget_wpDribbble");
	$playerName = $options['playerName'];

	if(function_exists('fetch_feed')):
		$rss = fetch_feed("http://dribbble.com/players/$playerName/shots.rss");
		add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 1800;' ) );
		if (!is_wp_error( $rss ) ) : 
			$items = $rss->get_items(0, $rss->get_item_quantity($options['maxItems'])); 
		endif;
	endif;

	if (!empty($items)): ?>
<ol class="dribbbles">
<?php	
foreach ( $items as $item ):
	$title = $item->get_title();
	$link = $item->get_permalink();
	$date = $item->get_date('F d, Y');
	$description = $item->get_description();

	preg_match("/src=\"(http.*(jpg|jpeg|gif|png))/", $description, $image_url);
	$image = $image_url[1];
	if(!$options['bigImage']) {
		$image = preg_replace('/.(jpg|jpeg|gif|png)/', '_teaser.$1',$image); #comment this out if you want to use the big 400x300 image
	}
?>
	<li class="group"> 
	<div class="dribbble"> 
		<div class="dribbble-shot"> 
			<div class="dribbble-img"> 
				<a href="<?php echo $link; ?>" class="dribbble-link"><img src="<?php echo $image; ?>" alt="<?php echo $title;?>"/></a> 
				<a href="<?php echo $link; ?>" class="dribbble-over"><strong><?php echo $title; ?></strong> 
					<span class="dim"><?php echo $options['playerName'] ?></span>
					<em><?php echo $date; ?></em> 
				</a>
			</div>
		</div>
	</div> 
 	</li>
<?php endforeach;?>
</ol>
<?php endif;
}

function wpDribbble_head() {
  $options = get_option("widget_wpDribbble");
	$dir = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
?>
<!-- wp-dribbble plugin -->
<style type="text/css">
.dribbbles{list-style-type:none;margin:0px 0px 1.5em;}
.dribbbles li{font-size:15px;position:relative;width:220px;padding:0;margin:0 0 1.5em 0;}
.dribbbles .dribbble{font-family:"Helvetica Nueue", Helvetica, Arial, sans-serif;position:relative;clear:left;overflow:hidden;<?php if($options['dropShadow']):?>padding:0 0 10px 0;background:url(<?php echo $dir; ?>images/dribbblesprite.png) no-repeat -10px -480px;<?php else:?>border-bottom:1px solid #e5e5e5;<?php endif;?>}
.dribbbles .dribbble-shot{padding:10px;background:url(<?php echo $dir; ?>images/dribbblesprite.png) no-repeat -10px -330px;}
.dribbbles .dribbble-over{position:absolute;top:10px;left:10px;z-index:1;width:180px;height:130px;margin:0!important;padding:10px;font-size:0.8em;line-height:2em;text-decoration:none;color:#888;background:url(<?php echo $dir; ?>images/dribbblesprite.png) no-repeat -110px -160px;}
.dribbbles .dribbble-link{position:relative;z-index:2;}
.dribbbles img{margin:0;width:200px;height:auto;opacity:1;-webkit-transition:opacity 0.2s linear;-o-transition:opacity 0.2s linear;-moz-transition:opacity 0.2s linear;}
.dribbbles a:hover img{opacity:0.1;-webkit-transition:opacity 0.2s linear;-o-transition:opacity 0.2s linear;-moz-transition:opacity 0.2s linear;}
.dribbbles strong{display:block;font-weight:bold;font-size:1.4em;line-height:1.2em;color:#ea4c88;}
.dribbbles .dim{font-weight:bold;color:#666;}
.dribbbles em{position: absolute;bottom:11px;left:10px;font-size:1em;line-height:1em;font-weight:normal;font-style:normal;}
.dribbbles .dribbble-img{width:200px;height:150px;overflow:hidden;}
</style>
<?php
}

function wpDribbble_control() {
  $options = get_option("widget_wpDribbble");
  if (!is_array( $options )) {
	$options = array(
		'playerName'=> 'Your Player Name',
  	'maxItems' => '5',
  	'includeCSS' => true,
  	'dropShadow' => true,
  	'bigImage' => false
    );
  }
  if ($_POST['wpDribbble-Submit']) {
    $options['playerName'] = htmlspecialchars($_POST['wpDribbble-WidgetPlayerName']);
    $options['maxItems'] = htmlspecialchars($_POST['wpDribbble-WidgetMaxItems']);
    $options['includeCSS'] = htmlspecialchars($_POST['wpDribbble-WidgetIncludeCSS']);
    $options['dropShadow'] = htmlspecialchars($_POST['wpDribbble-WidgetDropShadow']);
    $options['bigImage'] = htmlspecialchars($_POST['wpDribbble-WidgetBigImage']);
    update_option("widget_wpDribbble", $options);
  }
?>
<style type="text/css">
	.labbbel { width: 90px; display:inline-block; }
	.quiet { color:#CCC;}
</style>
<p>
    <label class="labbbel" for="wpDribbble-WidgetPlayerName">Player Name: </label>
    <input type="text" id="wpDribbble-WidgetPlayerName" name="wpDribbble-WidgetPlayerName" value="<?php echo $options['playerName'];?>" />
</p>
<p>
		<label class="labbbel" for="wpDribbble-WidgetMaxItems">No. of Shots: </label>
    <select id="wpDribbble-WidgetMaxItems" name="wpDribbble-WidgetMaxItems">
    	<option value="1" <?php if($options['maxItems'] == 1) echo "selected";?>>1</option>
    	<option value="2" <?php if($options['maxItems'] == 2) echo "selected";?>>2</option>
    	<option value="3" <?php if($options['maxItems'] == 3) echo "selected";?>>3</option>
    	<option value="4" <?php if($options['maxItems'] == 4) echo "selected";?>>4</option>
    	<option value="5" <?php if($options['maxItems'] == 5) echo "selected";?>>5</option>
    	<option value="6" <?php if($options['maxItems'] == 6) echo "selected";?>>6</option>
    	<option value="7" <?php if($options['maxItems'] == 7) echo "selected";?>>7</option>
    	<option value="8" <?php if($options['maxItems'] == 8) echo "selected";?>>8</option>
    	<option value="9" <?php if($options['maxItems'] == 9) echo "selected";?>>9</option>
    	<option value="10" <?php if($options['maxItems'] == 10) echo "selected";?>>10</option>
    </select>
</p>
<p>
		<label class="labbbel" for="wpDribbble-WidgetIncludeCSS">Include CSS?  </label>
    <input type="checkbox" id="wpDribbble-WidgetIncludeCSS" name="wpDribbble-WidgetIncludeCSS" <?php if($options['includeCSS']) echo "checked";?>>
    <em class="quiet">Default: On</em>
</p>
<p>
		<label class="labbbel" for="wpDribbble-WidgetDropShadow">Drop shadow?  </label>
    <input type="checkbox" id="wpDribbble-WidgetDropShadow" name="wpDribbble-WidgetDropShadow" <?php if($options['dropShadow']) echo "checked";?>>
    <em class="quiet">Default: On</em>
</p>
<p>
		<label class="labbbel" for="wpDribbble-WidgetBigImage">Big Image?  </label>
    <input type="checkbox" id="wpDribbble-WidgetBigImage" name="wpDribbble-WidgetBigImage" <?php if($options['bigImage']) echo "checked";?>>
    <em class="quiet">Default: Off</em>
</p>
    <input type="hidden" id="wpDribbble-Submit" name="wpDribbble-Submit" value="1" />

<?php
}
 
function widget_wpDribbble($args) {
  extract($args);
  echo $before_widget;
  echo $before_title;?>Dribbble<?php echo $after_title;
  wpDribbble();
  echo $after_widget;
}
  
function wpDribbble_init()
{
  $options = get_option("widget_wpDribbble");
  wp_register_sidebar_widget(__('Dribbble'),__('Dribbble'), 'widget_wpDribbble' ,array('description' => 'Pull in your latest Dribbble shots'));
  register_widget_control(   'Dribbble', 'wpDribbble_control');
	add_action( 'wp_dribbble', 'wpDribbble' );
	if($options['includeCSS']) {
		add_action('wp_head', 'wpDribbble_head');
	}
}
add_action("plugins_loaded", "wpDribbble_init");
?>