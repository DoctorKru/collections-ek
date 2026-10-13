<?php
if (function_exists('printCustomMenu') && getOption('col_custommenu_foot')) {
    // EK: Custom Footer Menu enabled via Menu Manager
    printCustomMenu(
        'col-footer',        // $menuset
        'list',              // $option
        'footer-links',      // $cssid: root ul ID
        'foot-links',        // $cssclass
        'menu-active',       // $activeclass
        'footer-submenu',    // $sub_cssclass
        'menu-active-sub',   // $sub_activeclass
        1,                   // $showsubs
        false                // $default_active
    );
} else {
    // EK: Default Hardcoded Utility Items
    // Uses the same root ID (#footer-links) as Menu Manager for 1:1 CSS parity
    echo '<ul id="footer-links">';
    
    echo '<li>', printCustomPageURL(gettext("Archive View"), "archive"), '</li>';

    if (extensionEnabled('contact_form') && method_exists('contactForm', 'printContactForm')) {
        echo '<li>', printCustomPageURL(gettext('Contact us'), 'contact', '', ''), '</li>';
    }

    if ((function_exists("printUserLogin_out")) || (!zp_loggedin() && function_exists('printRegistrationForm'))) {
        if (!zp_loggedin() && function_exists('printRegisterURL')) {
            echo '<li>', printRegisterURL(gettext('Register for this site')), '</li>';
        }
        if (function_exists('printFavoritesURL')) {
            printFavoritesURL(NULL, '<li>', '</li><li>', '</li>');
        }
        if (function_exists("printUserLogin_out")) {
            echo "<li>", printUserLogin_out('', '', ''), "</li>";
        }
    }

    printPrivacyPageLink('<li>', '</li>');

    if (getOption('Display_copyright') && function_exists('printCopyrightNotice')) {
        $copyright = trim(printCopyrightNotice('', '', false));
        if (!empty($copyright)) {
            echo '<li>' . $copyright . '</li>';
        }
    }

    if (function_exists('printLanguageSelector')) {
        echo "<li>", callUserFunction('printLanguageSelector'), "</li>";
    }

    if (getOption('col_show_zplink')) {
        echo '<li>', printZenphotoLink(), '</li>';
    }
    
    echo '</ul>';
}
?>

<!-- EK: changed order for html_meta_tags plugin to work and v= -->
<script src="<?php echo $_zp_themeroot; ?>/js/collection.js?v=2.2"></script>

<?php zp_apply_filter('theme_body_close'); ?>