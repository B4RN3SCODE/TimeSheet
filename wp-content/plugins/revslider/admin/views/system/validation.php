<?php
if( !defined( 'ABSPATH') ) exit();

$validated = get_option('revslider-valid', 'false');
$code = get_option('revslider-code', '');
$latest_version = get_option('revslider-latest-version', RevSliderGlobals::SLIDER_REVISION);

?>

<!-- 
  CONTENT BEFORE ACTIVATION, BASED OF VALIDATION 
-->
<?php
if($validated === 'true') {
	$displ = "block";
	?> 
	<div class="revgreen valid_big_border" style="left:0px;top:0px;position:absolute;height:100%;padding:30px 10px;"><i style="font-size:25px" class="iconttowhite eg-icon-check"></i></div>
	<?php 	
} else {
	$displ = "none";
	?> 
	<div class="revcarrot valid_big_border" style="left:0px;top:0px;position:absolute;height:100%;padding:22px 10px;"><i style="font-size:25px" class="iconttowhite revicon-cancel"></i></div>
	<?php 
}
?>

<div id="rs-validation-wrapper" style="display:<?php echo $displ; ?>">
	
	<div class="validation-label"><?php _e('Purchase code:','revslider'); ?></div> 
	<div class="validation-input">
		<input type="text" name="rs-validation-token" value="<?php echo $code; ?>" <?php echo ($validated === 'true') ? ' readonly="readonly"' : ''; ?> style="width: 350px;" />
		<p class="validation-description"><?php _e('Please enter your ','revslider'); ?><strong style="color:#000"><?php _e('CodeCanyon Slider Revolution purchase code / license key','revslider'); ?></strong><?php _e('. You can find your key by following the instructions on','revslider'); ?><a target="_blank" href="http://www.themepunch.com/home/plugins/wordpress-plugins/revolution-slider-wordpress/where-to-find-the-purchase-code/"><?php _e(' this page.','revslider'); ?></a></p>
	</div>
	<div style="height:15px" class="clear"></div>
	
	<span style="display:none" id="rs_purchase_validation" class="loader_round"><?php _e('Please Wait...', 'revslider'); ?></span>

	<a href="javascript:void(0);" <?php echo ($validated !== 'true') ? '' : 'style="display: none;"'; ?> id="rs-validation-activate" class="button-primary revgreen"><?php _e('Register','revslider'); ?></a>
	
	<a href="javascript:void(0);" <?php echo ($validated === 'true') ? '' : 'style="display: none;"'; ?> id="rs-validation-deactivate" class="button-primary revred"><?php _e('Deregister','revslider'); ?></a>
	
	<?php
	if($validated === 'true'){
		?>
		<a href="update-core.php?checkforupdates=true" id="rs-check-updates" class="button-primary revpurple"><?php _e('Search for Updates','revslider'); ?></a>
		<?php
	}
	?>
	
	<?php
	if($validated === 'true'){
		echo '<span style="margin-left:10px;color: #999; font-weight: 400; font-style:italic;">'.__('To register the plugin on a different website, click the “Deregister” button here first.', 'revslider').'</span>';
	}
	?>
	
</div>

<!-- 
  CONTENT AFTER ACTIVATION, BASED OF VALIDATION 
-->
<?php if($validated === 'true') {
	?> 
	<h3> <?php _e("How to get Support ?",'revslider')?></h3>				
	<p>
		<?php _e("Please feel free to contact us via our ",'revslider')?><a href='http://themepunch.ticksy.com'><?php _e("Support Forum ",'revslider')?></a><?php _e("and/or via the ",'revslider')?><a href='http://codecanyon.net/item/slider-revolution-responsive-wordpress-plugin/2751380/comments'><?php _e("Item Disscussion Forum",'revslider')?></a><br />
	</p> 	
	<?php 	
} else {
	?> 
	<p style="margin-top:10px; margin-bottom:10px;" id="tp-before-validation">
		<?php _e("Click Here to get ",'revslider'); ?><strong><?php _e("Premium Support and Auto Updates",'revslider'); ?></strong><br />
	</p> 
	<?php 
}
?>