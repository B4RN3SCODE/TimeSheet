<?php if( !defined( 'ABSPATH') ) exit(); ?>

<!-- //Youtube dialog: -->
<div id="dialog_video" class="dialog-video" title="<?php _e('Add Video Layout', 'revslider'); ?>" style="display:none">
	
	<form name="video_dialog_form" onkeypress="return event.keyCode != 13;">
		<div id="video_content" style="display:none"></div>

		<div id="video-dialog-wrap">
			<div id="video_dialog_tabs" class="box-closed tp-accordion disabled" style="border-bottom:5px solid #ddd; background:#fff">
				<ul class="rs-layer-settings-tabs">
					<li data-content="#rs-video-source" id="reset_video_dialog_tab" class="selected"><i style="height:45px" class="rs-mini-layer-icon eg-icon-export rs-toolbar-icon"></i><?php _e('Source', 'revslider'); ?></li>
					<li data-content="#rs-video-size"><i style="height:45px; font-size:16px" class="rs-mini-layer-icon eg-icon-resize-full-alt rs-toolbar-icon"></i><?php _e('Sizing', 'revslider'); ?></li>
					<li data-content="#rs-video-settings"><i style="height:45px; font-size:16px" class="rs-mini-layer-icon eg-icon-cog rs-toolbar-icon"></i><?php _e('Settings', 'revslider'); ?></li>
					<li data-content="#rs-video-thumbnails"><i style="height:45px; font-size:16px" class="rs-mini-layer-icon eg-icon-eye rs-toolbar-icon"></i><?php _e('Visibility', 'revslider'); ?></li>
					<li data-content="#rs-video-arguments"><i style="height:45px; font-size:16px" class="rs-mini-layer-icon eg-icon-th rs-toolbar-icon"></i><?php _e('Arguments', 'revslider'); ?></li>
				</ul>
				<div style="clear:both"></div>
			</div>
			
		</div>
		
		<div id="rs-video-source">
			<!-- Type chooser -->
			<div id="video_type_chooser" class="video-type-chooser" style="margin-bottom:25px">
				<label><?php _e('Choose video type', 'revslider'); ?></label>
				<input type="radio" checked id="video_radio_youtube" name="video_select">
				<span for="video_radio_youtube"><?php _e('YouTube', 'revslider'); ?></span>
				<input type="radio" id="video_radio_vimeo" name="video_select" style="margin-left:20px">
				<span for="video_radio_vimeo"><?php _e('Vimeo', 'revslider'); ?></span>
				<input type="radio" id="video_radio_html5" name="video_select" style="margin-left:20px">
				<span for="video_radio_html5"><?php _e('HTML5', 'revslider'); ?></span>
				
				<span class="rs-show-when-youtube-stream" style="display: none;">
					<input type="radio" id="video_radio_streamyoutube" name="video_select" style="margin-left:20px">
					<span for="video_radio_streamyoutube"><?php _e('From Stream', 'revslider'); ?></span>
				</span>
				<span class="rs-show-when-vimeo-stream" style="display: none;">
					<input type="radio" id="video_radio_streamvimeo" name="video_select" style="margin-left:20px">
					<span for="video_radio_streamvimeo"><?php _e('From Stream', 'revslider'); ?></span>
				</span>
				<span class="rs-show-when-instagram-stream" style="display: none;">
					<input type="radio" id="video_radio_streaminstagram" name="video_select" style="margin-left:20px">
					<span for="video_radio_streaminstagram"><?php _e('From Stream', 'revslider'); ?></span>
				</span>
			</div>
			

			<!-- Vimeo block -->		
			<div id="video_block_vimeo" class="video-select-block" style="display:none;" >
				<label><?php _e('Vimeo ID or URL', 'revslider'); ?></label>
				<input type="text" id="vimeo_id" value="">
				<input type="button" style="vertical-align:middle" id="button_vimeo_search" class="button-regular video_search_button" value="search">
				<span class="video_example"><?php _e('example: 30300114', 'revslider'); ?></span>		
				<img id="vimeo_loader" src="<?php echo RS_PLUGIN_URL; ?>/admin/assets/images/loader.gif" style="display:none">
			</div>
			
			<!-- Youtube block -->		
			<div id="video_block_youtube" class="video-select-block">
				<label><?php _e('YouTube ID or URL', 'revslider'); ?></label>
				<input type="text" id="youtube_id" value="">
				<input type="button" style="vertical-align:middle" id="button_youtube_search" class="button-regular video_search_button" value="search">
				<span class="video_example"><?php _e('example', 'revslider'); ?>: <?php echo RevSliderGlobals::YOUTUBE_EXAMPLE_ID; ?></span>
				<img id="youtube_loader" src="<?php echo RS_PLUGIN_URL; ?>/admin/assets/images/loader.gif" style="display:none">
			</div>
			
			<!-- Html 5 block -->		
			<div id="video_block_html5" class="video-select-block" style="display:none;">
				<label><?php _e('Poster Image Url', 'revslider'); ?></label>
				<input style="width:330px" type="text" id="html5_url_poster" name="html5_url_poster" value="">
				<span class="imgsrcchanger-div" style="margin-left:20px;">
					<a href="javascript:void(0)" class="button-image-select-html5-video button-primary revblue" ><?php _e('Set Image', 'revslider'); ?></a>
				</span>
				<span class="video_example"><?php _e('example', 'revslider'); ?>: http://video-js.zencoder.com/oceans-clip.png</span>
				
		
				<label><?php _e('Video MP4 Url', 'revslider'); ?></label>
				<input style="width:330px" type="text" id="html5_url_mp4" name="html5_url_mp4" value="">
				<span class="vidsrcchanger-div" style="margin-left:20px;">
					<a href="javascript:void(0)" data-inptarget="html5_url_mp4" class="button_change_video button-primary revblue" ><?php _e('Set Video', 'revslider'); ?></a>
				</span>
				<span class="video_example"><?php _e("example",'revslider'); ?>: http://video-js.zencoder.com/oceans-clip.mp4</span>
		
				<label><?php _e('Video WEBM Url', 'revslider'); ?></label>
				<input style="width:330px" type="text" id="html5_url_webm" name="html5_url_webm" value="">
				<span class="vidsrcchanger-div" style="margin-left:20px;">
					<a href="javascript:void(0)" data-inptarget="html5_url_webm" class="button_change_video button-primary revblue" ><?php _e('Set Video', 'revslider'); ?></a>
				</span>
				<span class="video_example"><?php _e('example','revslider'); ?>: http://video-js.zencoder.com/oceans-clip.webm</span>
		
				<label><?php _e('Video OGV Url', 'revslider'); ?></label>
				<input style="width:330px" type="text" id="html5_url_ogv" name="html5_url_ogv" value="">
				<span class="vidsrcchanger-div" style="margin-left:20px;">
					<a href="javascript:void(0)" data-inptarget="html5_url_ogv" class="button_change_video button-primary revblue" ><?php _e('Set Video', 'revslider'); ?></a>
				</span>
				<span class="video_example"><?php _e('example', 'revslider'); ?>: http://video-js.zencoder.com/oceans-clip.ogv</span>
				
			</div>
		</div>


		<div id="rs-video-size"  style="display:none">
			<!-- Video Sizing -->
			<div id="video_size_wrapper" class="youtube-inputs-wrapper">
				
				<label for="input_video_fullwidth"><?php _e('Full Screen:', 'revslider'); ?></label>	
				<input type="checkbox" class="tp-moderncheckbox rs-staticcustomstylechange tipsy_enabled_top" id="input_video_fullwidth">
				<div class="clearfix mb10"></div>
			</div>
			
			<label for="input_video_cover" class="video-label"><?php _e('Force Cover:', 'revslider'); ?></label>
			<input type="checkbox" class="checkbox_video_dialog tp-moderncheckbox mb10" id="input_video_cover">
			
			<div id="fullscreenvideofun1" class="video-settings-line">
				<label for="input_video_dotted_overlay" class="video-label" id="input_video_dotted_overlay_lbl">
					<?php _e('Dotted Overlay:', 'revslider'); ?>
				</label>				
				<select id="input_video_dotted_overlay" style="width:100px">
					<option value="none"><?php _e('none','revslider'); ?></option>
					<option value="twoxtwo"><?php _e('2 x 2 Black','revslider'); ?></option>
					<option value="twoxtwowhite"><?php _e('2 x 2 White','revslider'); ?></option>
					<option value="threexthree"><?php _e('3 x 3 Black','revslider'); ?></option>
					<option value="threexthreewhite"><?php _e('3 x 3 White','revslider'); ?></option>
				</select>
				<div class="clearfix mb10"></div>
				<label for="input_video_ratio" class="video-label" id="input_video_ratio_lbl">
					<?php _e('Aspect Ratio:', 'revslider'); ?>
				</label>				
				<select id="input_video_ratio" style="width:100px">
					<option value="16:9"><?php _e('16:9','revslider'); ?></option>
					<option value="4:3"><?php _e('4:3','revslider'); ?></option>
				</select>
			</div>

		</div>
		
		<div id="rs-video-settings" style="display:none">
			<div class="mb10">
				<label for="input_video_loop"><?php _e("Loop Video:",'revslider'); ?></label>
				<?php /* <input type="checkbox" class="checkbox_video_dialog  mtop_13" id="input_video_loop" > */ ?>
				<select id="input_video_loop" style="width: 200px;">
					<option value="none"><?php _e('Disable', 'revslider'); ?></option>
					<option value="loop"><?php _e('Loop, Slide is paused', 'revslider'); ?></option>
					<option value="loopandnoslidestop"><?php _e('Loop, Slide does not stop', 'revslider'); ?></option>
				</select>
			</div>

			<div class="mb10">
				<label for="input_video_autoplay"><?php _e('Autoplay:', 'revslider'); ?></label>
				<select id="select_video_autoplay">
					<option value="false"><?php _e('Off', 'revslider'); ?></option>
					<option value="true"><?php _e('On', 'revslider'); ?></option>
					<option value="1sttime"><?php _e('On 1st Time', 'revslider'); ?></option>
					<option value="no1sttime"><?php _e('Not on 1st Time', 'revslider'); ?></option>
				</select>
			</div>

			<div class="mb10">
				<label for="input_video_stopallvideo"><?php _e('Stop Other Videos:', 'revslider'); ?></label>
				<input type="checkbox" class="checkbox_video_dialog tp-moderncheckbox" id="input_video_stopallvideo" >
			</div>

			<div class="mb10 hide-for-vimeo">
				<label for="input_video_allowfullscreen"><?php _e('Allow FullScreen:', 'revslider'); ?></label>
				<input type="checkbox" class="checkbox_video_dialog tp-moderncheckbox" id="input_video_allowfullscreen" >
			</div>

			<div class="mb10">	
				<label for="input_video_nextslide"><?php _e('Next Slide On End:', 'revslider'); ?></label>
				<input type="checkbox" class="checkbox_video_dialog tp-moderncheckbox" id="input_video_nextslide" >
			</div>

			<div class="mb10">
				<label for="input_video_force_rewind"><?php _e('Rewind at Slide Start:', 'revslider'); ?></label>
				<input type="checkbox" class="checkbox_video_dialog tp-moderncheckbox" id="input_video_force_rewind" >
			</div>

			<div class="mb10 hide-for-vimeo">
				<label for="input_video_control"><?php _e('Hide Controls:', 'revslider'); ?></label>
				<input type="checkbox" class="checkbox_video_dialog tp-moderncheckbox" id="input_video_control" >
			</div>

			<div class="mb10">
				<label for="input_video_mute"><?php _e('Mute:', 'revslider'); ?></label>
				<input type="checkbox" class="checkbox_video_dialog tp-moderncheckbox" id="input_video_mute" >
			</div>

			<div class="mb10 video-volume">
				<label for="input_video_volume"><?php _e('Volume (0 - 100):', 'revslider'); ?></label>
				<input type="text" class="input_video_dialog" style="width: 50px;" id="input_video_volume" >
			</div>
			
			<div class="mb10">
				<label for="input_video_start_at"><?php _e('Start at:', 'revslider'); ?></label>
				<input type="text" id="input_video_start_at" style="width: 50px;"> <?php _e('i.e.: 0:17', 'revslider'); ?>
			</div>
			
			<div class="mb10">
				<label for="input_video_end_at"><?php _e('End at:', 'revslider'); ?></label>
				<input type="text" id="input_video_end_at" style="width: 50px;"> <?php _e('i.e.: 2:41', 'revslider'); ?>
			</div>
			
			<div class="mb10">
				<label for="input_video_show_cover_pause"><?php _e('Show Cover at Pause:', 'revslider'); ?></label>
				<input type="checkbox" class="checkbox_video_dialog tp-moderncheckbox" id="input_video_show_cover_pause" >
			</div>
			
			<div id="rev-youtube-options" class="video-settings-line mb10">
				<label for="input_video_speed"><?php _e('Video Speed:', 'revslider'); ?></label>
				<select id="input_video_speed" style="width:75px">
					<option value="0.25"><?php _e('0.25', 'revslider'); ?></option>
					<option value="0.50"><?php _e('0.50', 'revslider'); ?></option>
					<option value="1"><?php _e('1', 'revslider'); ?></option>
					<option value="1.5"><?php _e('1.5', 'revslider'); ?></option>
					<option value="2"><?php _e('2', 'revslider'); ?></option>
				</select>
			</div>

			<div id="rev-html5-options" style="display: none; mb10">
				<label for="input_video_preload" class="video-label">
					<?php _e("Video Preload:",'revslider')?>
				</label>
				<select id="input_video_preload" style="width:200px">
					<option value="auto"><?php _e('Auto', 'revslider'); ?></option>
					<option value="none"><?php _e('Disable', 'revslider'); ?></option>
					<option value="metadata"><?php _e('Metadata', 'revslider'); ?></option>
				</select>
			</div>		
		</div>

		<div id="rs-video-thumbnails" style="display:none">
			<div id="preview-image-video-wrap" class="mb10">
				<label><?php _e('Preview Image', 'revslider'); ?></label>
				<input type="text" class="checkbox_video_dialog " id="input_video_preview">
				<input type="button" id="" class="button-image-select-video button-primary revblue" value="<?php _e('Image Library', 'revslider'); ?>">
				<input type="button" id="" class="button-image-select-video-default button-primary revblue" value="<?php _e('Video Thumbnail', 'revslider'); ?>">
				<input type="button" id="" class="button-image-remove-video button-primary revblue" value="<?php _e('Remove', 'revslider'); ?>">
				<div class="clear"></div>			
			</div>

			<div class="mb10">
				<label for="input_disable_on_mobile"><?php _e('Disable Mobile:', 'revslider'); ?></label>
				<input type="checkbox" class="checkbox_video_dialog tp-moderncheckbox" id="input_disable_on_mobile" >
			</div>

			<div class="mb10">
				<label for="input_use_poster_on_mobile"><?php _e('Only Preview on Mobile:', 'revslider'); ?></label>
				<input type="checkbox" class="checkbox_video_dialog tp-moderncheckbox" id="input_use_poster_on_mobile" >
				<div style="width:100%;height:10px"></div>
			</div>
		</div>

		<div id="rs-video-arguments" style="display:none">
			<div>
				<label><?php _e('Arguments:', 'revslider'); ?></label>
				<input type="text" id="input_video_arguments" style="width:350px;" value="" data-youtube="<?php echo RevSliderGlobals::DEFAULT_YOUTUBE_ARGUMENTS; ?>" data-vimeo="<?php echo RevSliderGlobals::DEFAULT_VIMEO_ARGUMENTS; ?>" >
			</div>
		</div>
		
		<div class="add-button-wrapper" style="margin-left:25px;">
			<a href="javascript:void(0)" class="button-primary revblue" id="button-video-add" data-textadd="<?php _e('Add This Video', 'revslider'); ?>" data-textupdate="<?php _e('Update Video', 'revslider'); ?>" ><?php _e('Add This Video', 'revslider'); ?></a>
		</div>
	</form>
</div>