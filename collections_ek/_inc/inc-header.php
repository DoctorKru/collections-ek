<?php if (!defined('WEBPATH')) die(); ?>
<?php 
	switch ($_zp_gallery_page) {
		case 'gallery.php':
			$active_template = 'home-layout';
			break;
		case 'index.php':
			$active_template = 'home-layout';
			break;
		case '404.php':
			$active_template = 'error-layout';
			break;
		case 'archive.php':
			$active_template = 'archive-layout';
			break;
		case 'album.php':
			$active_template = 'album-layout';
			break;
		case 'contact.php':
			$active_template = 'contact-layout';
			break;
		case 'favorites.php':
			$active_template = 'favorites-layout';
			break;
		case 'image.php':
			$active_template = 'image-layout';
			break;
		case 'news.php':
			$active_template = 'news-layout';
			break;
		case 'pages.php':
			$active_template = 'pages-layout';
			break;
		case 'password.php':
			$active_template = 'password-layout';
			break;
		case 'register.php':
			$active_template = 'register-layout';
			break;
		case 'search.php':
			$active_template = 'search-layout';
			break;
	}

?>
<?php 
	if (getOption('collections_sidebar')) {
		$navbar = "side";
		}
	else { 
		$navbar = "top";
		}
?>
<!doctype html>
<html<?php printLangAttribute(); ?>>
	<head>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="<?php echo LOCAL_CHARSET; ?>">
	<?php zp_apply_filter('theme_head'); ?>
	<?php printHeadTitle(); ?>
	<?php if (class_exists('RSS')) printRSSHeaderLink('Gallery', gettext('Gallery RSS')); ?>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/styles.css?v=240606" type="text/css" />
        <link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/css/jquery.fancybox.min.css" type="text/css" media="screen"/>
	<script type="text/javascript" src="<?php echo $_zp_themeroot; ?>/js/jquery.fancybox.min.js"></script>
	<script type="text/javascript" src="<?php echo $_zp_themeroot; ?>/js/zpB_fancybox_config.js"></script>
	<script type="text/javascript">
	//<![CDATA[
		$(document).ready( function() {
			$.fancybox.defaults.lang = '<?php $loc = substr(getOption('locale'), 0, 2); if (empty($loc)) {$loc = 'en';}; echo $loc; ?>';
			$.fancybox.defaults.i18n = {
				'<?php echo $loc; ?>' : {
					CLOSE		: '<?php echo gettext('close'); ?>',
					NEXT		: '<?php echo gettext('next'); ?>',
					PREV		: '<?php echo gettext('prev'); ?>',
					PLAY_START	: '<?php echo gettext('start slideshow'); ?>',
					PLAY_STOP	: '<?php echo gettext('stop slideshow'); ?>',
					THUMBS		: '<?php echo gettext_th('thumbnails'); ?>'
				}
			};

			// cohabitation between keyboard Navigation and Fancybox
			$.fancybox.defaults.onInit = function() { FancyboxActive = true; };
			$.fancybox.defaults.afterClose = function() { FancyboxActive = false; };
		});
	//]]>
	</script>
	<script type="text/javascript">
	//<![CDATA[
		<?php
		$NextURL = $PrevURL = false;
		if ($_zp_gallery_page == 'image.php') {
			if (hasNextImage()) { ?>var nextURL = "<?php echo html_encode(getNextImageURL()); $NextURL = true; ?>";<?php }
			if (hasPrevImage()) { ?>var prevURL = "<?php echo html_encode(getPrevImageURL()); $PrevURL = true; ?>";<?php }
		} else {
			if ($_zenpage_news_enabled && is_NewsArticle()) {
				if (getNextNewsURL()) { $article_url = getNextNewsURL(); ?>var nextURL = "<?php echo html_decode($article_url['link']); $NextURL = true; ?>";<?php }
				if (getPrevNewsURL()) { $article_url = getPrevNewsURL(); ?>var prevURL = "<?php echo html_decode($article_url['link']); $PrevURL = true; ?>";<?php }
			}
		} ?>

		// cohabitation between keyboard Navigation and Fancybox
		var FancyboxActive = false;

		function keyboardNavigation(e) {
			// keyboard Navigation disabled if Fancybox active
			if (FancyboxActive) return true;

			if (!e) e = window.event;
			if (e.altKey) return true;
			var target = e.target || e.srcElement;
			if (target && target.type) return true;		//an input editable element
			var keyCode = e.keyCode || e.which;
			var docElem = document.documentElement;
			switch(keyCode) {
				case 63235: case 39:
					if (e.ctrlKey || (docElem.scrollLeft == docElem.scrollWidth-docElem.clientWidth)) {
						<?php if ($NextURL) { ?>window.location.href = nextURL; <?php } ?>return false; }
					break;
				case 63234: case 37:
					if (e.ctrlKey || (docElem.scrollLeft == 0)) {
						<?php if ($PrevURL) { ?>window.location.href = prevURL; <?php } ?>return false; }
					break;
			}
			return true;
		}

		document.onkeydown = keyboardNavigation;

	//]]>
	</script>
	</head>
