=== Techozoic Fluid ===
Contributors: jeremyclark13
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=10998817
Tags: blue, light, one-column, two-columns, three-columns, flexible-width, custom-colors, custom-header, theme-options ,left-sidebar, right-sidebar, threaded-comments, translation-ready, sticky-post
Requires at least: 2.8
Tested up to: 3.1
Stable tag: trunk

Simple, fluid width, widget-ready sidebars and footer, 2 or 3 column theme.    

== Description ==
Over 70 theme options to adjust column settings, color scheme, font, ad placement, and custom headers.  SEO optimized titles and meta information.

== Installation ==

Installation can be done automatically through the Install Themes feature or manually by following instructions below.

1. Upload `techozoic-fluid.zip` to the `/wp-content/themes/` directory
1. Choose the theme from the 'Appearence menu in WordPress
1. Visit the Techozoic Settings pages to configure all the theme options.

== Frequently Asked Questions ==

= Where can I get support? =

[Support Forums](http://clark-technet.com/theme-support/techozoic/)

= Is there any documentation? =

[Techozoic Fluid](http://techozoic.clark-technet.com/ "Techozoic Fluid theme site")

== Changelog ==

= Version 1.9.2 =
* Fixed IE 7 layout error when blog title box was aligned left.
* Fixed localization for date formats * format now pulled from blog options instead of hardcoded.
* Added new social media networks (LinkedIn and email post).
* Fixed error with 2 column setting defaulting to Content * Sidebar even after saving.
* Updated attachment.php page for better gallery intergration. 

= Version 1.9.1 =
* Dynamic Styles now stored in database instead of calculated on every page load.
* Changed how style.php is called from functions.php
* Added option for specifing different widths for left and right sidebars
* Added font resize widget
* Fixed error on search results and 404 page if sidebars where used on single pages 
* Adjusted Techozoic Navigation widget if a menu is assigned to the Sideber Navigation location it always displayed
* Added Footer Navigation Section for footer links 
* Added Option to disable drop shadow for post and header 
* Added Left and Right header widget areas
* Completely localized admin screens look in languages folder for .pot file to translate
* Reworked header for better flow under side borders

= Version 1.9 =

* Major code cleanup and validation.
* No longer using any deprecated funtions but still maintain backwards compatibilty with older version of WordPress 
* Added option to choose social network icons on home page and single post page
* Added options to display links to social network profiles in about widget
* Added Norwegian Translation - Thanks [stig.ulfsby.no](http://stig.ulfsby.no/)
* Added German Translation - Thanks [Thomas Morvay](http://InterNet-Dienste.biz)
* Fixed error with image alignment outside of post container
* Fixed error with Tag archive containters being too small
* Fixed error with some plugins causing post meta info to be read in header causing problems with disabling sidebar and nav menus
* Added 3 new layouts - Sidebar - Sidebar - Content, Content - Sidebar, Sidebar - Content
* Added function for outputing sidebars depending on layout options
* Added support for WordPress 3.0 menus
* Added Options for adjust size and family of Nav Menu Fonts
* Added option to rearrange footer text with shortcodes
* Added option to disable search box in header area.

= Version 1.8.7 =
* Added French Translations * Thanks [Wolforg](http://www.wolforg.eu "Wolforg : CMS, Logiciels Libres & Réseaux Sociaux en Lozère")
* Added Cufon javascript font replacement options, and three free to use on web fonts
* Added option to change content area background color
* Added option to have content area background image
* Added option to upload favicon
* Bugfix: Search results page blank cause by missing ) in translation functions
* Added Search term highlighting
* Moved default upload location to wp*content/techozoic folder to stop theme updates deleting uploaded headers
* Added option to center navigation menu
* Fixed dropdown menu bug where specifying a fixed width wouldn't work
* Moved widget code and comment callback code into separate files included with functions.php 
* Added comment preview section at bottom of post 
* Added export/import page for saving options to a downloadable file and restoring later or to another blog\

= Version 1.8.6.1 =
* Fixed theme activation error

= Version 1.8.6 =
* Removed Tim thumb script causing to many errors, using browser scaled images for preview links 
* Moved options to separate menu page with sub menu pages for General, Header Images, and Style Settings
* Major CSS cleanup for style.css
* Added option to restore original style.css if static css is used and changes have been made 
* Backup of current style.css file made before overwriting file
* Added option to change repeat pattern of custom page background image
* Added Widgetized footer section *Limited to 3 widgets
* Added Meta Box to Post/Page Screen to selectively disable sidebars on an individual basis if Display Sidebars on Single Pages is set

= Version 1.8.5 =
* Added Italian Translation - Thanks [Giuseppe Bomentre](http://www.bomentre.com)
* Reworked Header image upload to no longer rely on javascript
* Header image selection screen uses timthumb script to display previews
* Header image selection screen uses thickbox for image previews
* Added Page background selection to choose custom background instead of plain color
* Changed Nav Exclusion list to be multiple selection box, instead of manually typing ids 
* Moved options to separate file to be included on controlpanel and theme*init files

= Version 1.8.4 =
* Localized public part of theme ( Translators needed see [here](http://clark-technet.com/theme-support/techozoic/translators-needed/) )
* Bugfix: IE7 wasn't properly centering blog title in header
* Bugfix: If either the sidebars or main column widths weren't declared then the default values were used sometimes causing layout problems
* Changed how options are referenced, controlpanel.php is only included on the dashboard
* Added new tech*init.php file to change option names in database and pull values for the options
* Added option to exclude pages from nav menu
* Added new javascript dropdown menu type
* Added option to use static css instead of dynamic
* Added page to allow copying of dynamic css to static style.css file
* Style.css now contains all default css and is used until custom options have been defined
* Added option for header image alignment
* Added option for header image size
* Added New header image selection interface - Shows small previews with a link to full versions of header images to save space
* Added New Navigation tab with new options for :
* Adding option for specifying up to 5 custom external links and their positioning in nav menu, toggling Home link visibility, changing text for Home link, showing Dashboard and login/logout links

= Version 1.8.3 =
* Bugfix: Didn't remove all debugging code, was causing problems with headers 
* Bugfix: If options haven't been setup default style.css is loaded to fix error with theme preview
* Updated JS for Typography options to have Font Previews update with size and family

= Version 1.8.2 =
* Updated way style.php is called, no longer using unsafe $_GET variables
* Thanks to Atahualpa theme by BytesForAll for the inspiration and code
* Added more options for font sizes for different sections

= Version 1.8.1 =
* Bugfix: Long Post titles were pushing post meta info down into content
* Bugfix: Options panel form is now validated before being submitted
* Bugfix: Style.php now sanitizes values from options panel before being displayed
* Moved default css from style.php to default*css.php to make editing easier

= Version 1.8 =
* Major Code Cleanup: prettified code, removed extraneous php open and close tags, removed old features
* Major Rework of how theme options are stored only two options added to wp_options table instead of 40+
* Old options are moved into new entry and old entries deleted from wp_options table
* Bugfix: Custom comment function was causing problem with PHP 5.0.5 bug, code reworked to eliminate bug and maintain function
* Bugfix: Pages weren't getting the right width if sidebars were disabled
* Added New Color Option for navigation button background
* Split Color option for Body/Accent color into two separate options
* Added Dashboard Widget with links to options page and support forum
* Added Sidebar Navigation Widget and option to disable Horizontal menu
* Added About Author Widget with option to display Gravatar image
* Updated widgets to new 2.8 style with title options
* Updated Style.php code used to get variables from option panel, added custom function, reworked code to save space

= Version 1.7.2 - 1.7.9 =
* Skipped for major version change.  See version 1.8 for details.

= Version 1.7.1 =
* Bugfix: If javascript disabled, custom header upload form will still work
* Bugfix: Ad settings fields are now sanitized by stripslashes to work with certain php and MySQL versions
* Added second navigation menu type Two Tier * Horizontal menu with sub menu of any subpages
* Added Header Text alignment option
* Added Option to disable SEO optimization of post title being the main title on single pages
* Added Webkit browser (Safari/Chrome) rounded corners
* Added Webkit and Firefox drop shadows for images

= Version 1.7 =
* Added support for WordPress 2.9 post thumbnails feature, backwards compatibility maintained
* Added header management page with custom image upload form and selection and deletion buttons for each header * BETA
* Added base font size option for increasing font sizes with examples of page element's sizes
* Added option to turn on/off Blog title and tag line overlay in header
* Added option to save two custom color schemes
* Added color choices for text and post background color
* Added color picker for all colors choices
* Modified option page to have tabbed interface to save scrolling, and cleaned up option descriptions

= Version 1.6.8 - 1.6.9 =
* Skipped for major version change, theme options page reworked and many new features added.  See version 1.7 for new features

= Version 1.6.7 =
* Added width adjustments for page, content, and sidebars
* Added javascript to validate choices for widths
* Added new header Landscape which is a shot of Hawaii taken from a mountain top
* Added default styles to be applied if no options have been chosen

= Version 1.1 - 1.6.6 =
* Neglected to keep track of all features

= Version 1.0 =
* Initial Public Release