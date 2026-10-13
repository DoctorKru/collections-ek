<?php include("_inc/inc-header.php"); ?>
	<body>
		<?php zp_apply_filter('theme_body_open'); ?>
		<a href="#main-content" tabindex="0" class="skip-to-content">Skip to main content</a>
	
		<div class="grid-container <?=$navbar;?>bar-layout">
		
			<?php include '_inc/inc-'.$navbar.'bar.php'; ?>
			
			<main class="main <?=$active_template ?>" id="main-content">
			
				<div class="picture_container">
					<?php 
					# Overlay for nav, ONLY if photo
					if ($_zp_current_image->isPhoto()) {
						echo '<div class="overlay_nav_container">';
						if (hasPrevImage()) { ?><a tabindex="-1" href="<?php echo html_encode(getPrevImageURL()); ?>" class="cursor_prev"></a><?php }
						if (hasNextImage()) { ?><a tabindex="-1" href="<?php echo html_encode(getNextImageURL()); ?>" class="cursor_next"></a><?php }
						if (!hasNextImage()) { ?><a tabindex="-1" href="<?php echo html_encode(getAlbumURL()); ?>" class="cursor_close"></a><?php }
						echo '</div>';
					} 
					# Responsive picture for photo
						if ($_zp_current_image->isPhoto()) { ?>
						<div class="img_responsive">
		<?php 
	// Get raw dimensions safely
	$full_w = (int) getFullWidth();
	$full_h = (int) getFullHeight();
	
	// Calculate aspect ratio safely
	$aspect_ratio = ($full_h > 0) ? ($full_w / $full_h) : 1.0;
	
	// Calculate the correct responsive width attributes for the srcset tags
	$w_2200 = ($full_w > $full_h) ? 2200 : (int) round(2200 * $aspect_ratio);
	$w_1280 = ($full_w > $full_h) ? 1280 : (int) round(1280 * $aspect_ratio);
	$w_640  = ($full_w > $full_h) ? 640  : (int) round(640 * $aspect_ratio);

	// Default layout string
	$sizes_attr = "100vw"; 
	
	// If it's a vertical (portrait) image, compute the horizontal viewport constraints
	if ($full_h > $full_w) {
		// 85 matches your CSS max-height: 85vh;
		$calculated_vh_width = (int) round(85 * $aspect_ratio); 
		$sizes_attr = "(orientation: landscape) " . $calculated_vh_width . "vh, 100vw";
	}
	?>
	<img srcset="<?php echo html_encode(getFullImageURL()); ?> <?php echo $full_w; ?>w,
				 <?php echo html_encode(getCustomImageURL(2200,NULL,NULL,NULL,NULL,NULL,NULL,false,NULL)); ?> <?php echo $w_2200; ?>w,
				 <?php echo html_encode(getCustomImageURL(NULL,1280,NULL,NULL,NULL,NULL,NULL,false,NULL)); ?> <?php echo $w_1280; ?>w,
				 <?php echo html_encode(getCustomImageURL(NULL,640,NULL,NULL,NULL,NULL,NULL,false,NULL)); ?> <?php echo $w_640; ?>w"  
					  sizes="<?php echo $sizes_attr; ?>" 
					  src="<?php echo html_encode(getCustomImageURL(NULL,1280,NULL,NULL,NULL,NULL,NULL,false,NULL)); ?>" 
					  alt="<?php echo getBareImageTitle(); ?>" 
					  width="<?php echo $full_w; ?>"
					  height="<?php echo $full_h; ?>" >
					</div>
					<?php # Everything else (video, text…)
							} else {
								printDefaultSizedImage(getImageTitle());
							} 
							# Button next/prev
							if (hasPrevImage()) { ?>
					<a href="<?php echo html_encode(getPrevImageURL()); ?>">
						<div role="button" aria-hidden="true" aria-label="<?php echo gettext("Previous Image"); ?>" class="prev_img" title="<?php echo gettext("Previous Image"); ?>">
							<svg width="24" height="24" viewBox="0 0 24 24" class="LKARhb">
								<path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
								
								<path fill="none" d="M0 0h24v24H0V0z"></path>
							</svg>
						</div>
					</a>
					<?php } ?>
									<?php if (hasNextImage()) { ?>
					<a href="<?php echo html_encode(getNextImageURL()); ?>">
						<div role="button" aria-hidden="true" aria-label="<?php echo gettext("Next Image"); ?>" class="next_img" title="<?php echo gettext("Next Image"); ?>">
							<svg width="24" height="24" viewBox="0 0 24 24" class="LKARhb">
								<path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
								
								<path fill="none" d="M0 0h24v24H0V0z"></path>
							</svg>
						</div>
					</a>
				<?php } ?>
	
					</div>
				
				<div class="picture_detail">
					<div class="picture_descr">
						<h1><?php printImageTitle(); ?></h1>
							<?php printImageDesc(); ?>
							<?php	printTags('links', '', 'taglist', ''); ?>
							<!-- CUSTOM DATA FIELD START -->
							<?php 
							$custom_data = getImageCustomData(); 
							if (!empty($custom_data)) { 
							?>
								<div class="picture_custom_data">
									<?php printImageCustomData(); ?>
								</div>
							<?php } ?>
							<!-- CUSTOM DATA FIELD END -->
					</div>
					<div class="picture_icons">
						<?php if (getOption('collections_download')) { ?><a download href="<?php echo html_encode(getFullImageURL()); ?>" title="<?php echo gettext('Download'); ?>"   class="svg_button download" >
							<svg width="16px" height="25px" viewBox="0 0 16 25">
								<path fill="#6a6a6a" d="M8,16L0,8l1.4-1.4L7,12.2V0h2v12.2l5.6-5.6L16,8L8,16z M0.5,20.6h15l0-2h-15L0.5,20.6z" />
							</svg>
						</a><?php } ?>
					<?php #start function favorite
					if(function_exists('printAddToFavorites')) {?>
					<?php
						#check if favorites_multi is "on"
						if(getOption('favorites_multi')==1) {
						#Show favorites_multi form ?>
						<div class="bloc-multi-favs">
						<?php printAddToFavorites($_zp_current_image); ?>
						</div>
					<?php } #else, show simple favorite
						else { ?>
						<div class="bloc-favs">
						<?php	#printAddToFavorites($_zp_current_image,"add","remove"); 
						printAddToFavorites($_zp_current_image); ?>
						</div>
					<?php } #end else 
						} #end function Favorites ?>				
					</div>
				</div> <!--END picture_detail-->
					
				<?php if(function_exists('printRating') || function_exists('printGoogleMap') || function_exists('printOpenStreetMap') || (getOption('collections_metas')) || function_exists('printCommentForm')) {   ?>
				<aside class="media_supp xl_hmar">
					<div class="media_supp_content">
						<div class="media_supp_content_col">
						<?php 
						if(function_exists('printRating')) {
							echo '<section class="bloc-rating">';
							echo '<h2>Rating</h2>';
							echo '<div class="bloc-rating-content">';
							@call_user_func('printRating'); 
							echo '</div>';
							echo '</section>';
						 } 
						if(function_exists('printGoogleMap')) {
							echo '<section class="bloc-gmaps">';
							@call_user_func('printGoogleMap');
							echo '</section>';
						} 
						if(function_exists('printOpenStreetMap') && (getImageData('EXIFGPSLatitude')!='')) {
							echo '<section class="bloc-osm">';
							echo '<h2>Maps</h2>';
							@call_user_func('printOpenStreetMap');
							echo '</section>';
						}
						if (getImageMetaData() && (getOption('collections_metas'))) {
							echo '<section class="bloc-metadata">';
								echo '<h2>'.gettext('Info').'</h2>';
							printImageMetadata('',false,'imagemetadata');
							echo '</section>';
					 } 
						if (class_exists('ScriptlessSocialSharing')) {
						ScriptlessSocialSharing::printButtons();
						}
					?>
					</div>
					<div class="media_supp_content_col">
					<?php 
						if (function_exists('printCommentForm')) {
							if ($_zp_current_image->getCommentsAllowed() || $_zp_current_image->getCommentCount()) {
								echo '<section class="bloc-comments">';
								echo '<h2>'.gettext('Comments').'</h2>';
								printCommentForm();
								echo '</section>';
							}
						} 
						?>
						</div>
						</div> <!--END media_supp_content-->
				</aside> <!--END media_supp-->
				<?php } ?>
				
				<?php if (function_exists('printRelatedItems') && !empty(getRelatedItems('all'))) { ?>
					<section class="bloc_relat_item ">
					<div class="bloc_relat_item_content">
							<?php printRelatedItems(5,'all',null,null,true); ?>
					</div>
				</section>
				<?php } ?>
	
			</main>
			
			<footer class="footer">
				<?php include("_inc/inc-footer.php"); ?>
			</footer>
		</div>	
	</body>
</html>