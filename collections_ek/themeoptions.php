<?php

// force UTF-8 Ø

/* Plug-in for theme option handling
 * The Admin Options page tests for the presence of this file in a theme folder
 * If it is present it is linked to with a require_once call.
 * If it is not present, no theme options are displayed.
 *
 */

class ThemeOptions {

	function __construct() {
		$me = basename(dirname(__FILE__));
		
		// set core theme option defaults
		setThemeOptionDefault('Allow_search', true);
		setThemeOptionDefault('Use_thickbox', true);
		setThemeOptionDefault('albums_per_page', 12);
		setThemeOptionDefault('images_per_page', 20);
		setThemeOption('image_size', 2200, NULL, $me);
		setThemeOption('image_use_side', 'longest', NULL, $me);
		setThemeOption('thumb_size', 450, NULL, $me);
		setThemeOptionDefault('thumb_crop_width', 450);
		setThemeOptionDefault('thumb_crop_height', 450);
		setThemeOptionDefault('thumb_crop', 1);
		setThemeOptionDefault('thumb_transition', 1);

		// set custom theme option defaults
		setThemeOptionDefault('collections_download', true);
		setThemeOptionDefault('collections_metas', true);
		setThemeOptionDefault('comment_form_toggle', false);
		setThemeOptionDefault('col_albdesc', false);		
		setThemeOptionDefault('col_custommenu_top', false);
		setThemeOptionDefault('col_custommenu_side', false);
		setThemeOptionDefault('col_custommenu_foot', false);
		setThemeOptionDefault('col_show_zplink', true);
		setThemeOptionDefault('collections_homepage', '');
		setThemeOptionDefault('collections_sidebar', false);

		if (extensionEnabled('zenpage')) {
			setThemeOption('custom_index_page', 'gallery', NULL, $me, false);
		} else {
			setThemeOption('custom_index_page', '', NULL, $me, false);
		}

		if (class_exists('cacheManager')) {
			cacheManager::deleteCacheSizes($me);
			cacheManager::addDefaultThumbSize();
			cacheManager::addDefaultSizedImageSize();
			cacheManager::addCacheSize($me,null, 2200, null, null, null, null, null, true, false);
			cacheManager::addCacheSize($me,null, 1280, null, null, null, null, null, true, false);
			cacheManager::addCacheSize($me,null, 640, null, null, null, null, null, true, false);
			cacheManager::addCacheSize($me,null, 500, null, null, null, null, null, true, false);
		}

		if (function_exists('createMenuIfNotExists')) {
			$menuitems_topbar = array(
				array('type' => 'menulabel', 'title' => gettext('Topbar Item'), 'link' => '', 'show' => 1, 'nesting' => 0)
			);
			$menuitems_sidebar = array( 				array('type' => 'menulabel', 'title' => gettext('Sidebar Item'), 'link' => '', 'show' => 1, 'nesting' => 0) 			);$menuitems_footer = array(
				array('type' => 'menulabel', 'title' => gettext('Footer Item'), 'link' => '', 'show' => 1, 'nesting' => 0)
			);
			
			createMenuIfNotExists($menuitems_topbar, 'col-topbar');
			createMenuIfNotExists($menuitems_sidebar, 'col-sidebar');
			createMenuIfNotExists($menuitems_footer, 'col-footer');
		}
	}

	function getOptionsSupported() {
		global $_zp_db;
		$unpublishedpages =$_zp_db->queryFullArray("SELECT title,titlelink FROM " . $_zp_db->prefix('pages') . " WHERE `show` != 1 ORDER by `sort_order`");
		$list = array();
		foreach ($unpublishedpages as $page) {$list[get_language_string($page['title'])] =$page['titlelink'];
		}
		return array(
				gettext('Show sidebar') => array(
						'key' => 'collections_sidebar',
						'type' => OPTION_TYPE_CHECKBOX,
						'desc' => gettext("Check to enable the sidebar ( & hide the topbar)")),
				gettext('Allow search') => array(
						'key' => 'Allow_search',
						'type' => OPTION_TYPE_CHECKBOX,
						'desc' => gettext("Check to enable search form.")),
				gettext('Download Button') => array(
						'key' => 'collections_download',
						'type' => OPTION_TYPE_CHECKBOX,
						'desc' => gettext("Check to enable users the ability to download original image from image details page. If you want a save dialog, you will need to set the appropriate option in options->image as well (protected, download).")),
				gettext('Metadata') => array(
						'key' => 'collections_metas',
						'type' => OPTION_TYPE_CHECKBOX,
						'desc' => gettext("Check to enable metadata view.")),
				gettext('Title & Desc. in album view') => array(
						'key' => 'col_albdesc',
						'type' => OPTION_TYPE_CHECKBOX,
						'desc' => gettext("If active, add title & description under the picture in album mode.")),
				gettext('Homepage') => array(
						'key' => 'collections_homepage',
						'type' => OPTION_TYPE_SELECTOR,
						'selections' => $list,
						'null_selection' => gettext('none'),
						'desc' => gettext("Choose here any <em>un-published Zenpage page</em> (listed by <em>titlelink</em>) to act as your site’s homepage instead the normal gallery index.") . "<p class='notebox'>" . gettext("<strong>Note:</strong> This of course overrides the <em>News on index page</em> option and your theme must be setup for this feature! Visit the theming tutorial for details.") . "</p>"),
				gettext('Custom Topbar menu') => array(
						'key' => 'col_custommenu_top',
						'type' => OPTION_TYPE_CHECKBOX,
						'desc' => gettext("Check to build custom menu via Menu Manager if the <em>menu_manager</em> plugin is enabled. The default menu set <code>col-topbar</code> will be  used to replace default utility links.")),
				gettext('Custom Sidebar menu') => array(
						'key' => 'col_custommenu_side',
						'type' => OPTION_TYPE_CHECKBOX,
						'desc' => gettext("Check to build custom menu via Menu Manager if the <em>menu_manager</em> plugin is enabled. The default menu set <code>col-sidebar</code> will be  used to replace default utility links.")),
				gettext('Custom Footer menu') => array(
						'key' => 'col_custommenu_foot',
						'type' => OPTION_TYPE_CHECKBOX,
						'desc' => gettext("Check to build custom menu via Menu Manager if the <em>menu_manager</em> plugin is enabled. The default menu set <code>col-footer</code> will be  used to replace default utility links.")),
				gettext('Show Zenphoto link') => array(
						'key' => 'col_show_zplink',
						'type' => OPTION_TYPE_CHECKBOX,
						'desc' => gettext('Check to display the "Powered by Zenphoto" link in the footer.'))
		);
	}

	function getOptionsDisabled() {
		return array('custom_index_page', 'image_size', 'thumb_size');
	}

	function handleOption($option,$currentValue) {
		
	}

}

?>