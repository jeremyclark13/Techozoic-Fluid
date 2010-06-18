<html>
<head><title> Techozoic Change Log</title></head>
<body>
<p>
<h2>Donor Thank You</h2>
<p>Thank you to all of those that have donated towards my further development of Techozoic</p>
<ul><li><a href="http://nicolaus.com" rel="nofollow" target="_blank">Martin Nicolaus</a></li>
<li>Dayona Dodd</li>
<li><a href="http://saconsultants.org/blog1/" rel="nofollow" target="_blank">Don Wilmer</a></li>
<li>Debra Rosenberg – <a href="http://divaentertains.com/blog/" rel="nofollow" target="_blank">DivaEntertains</a></li>
<li><a href="http://www.GetaWebSiteShell.com" rel="nofollow" target="_blank">Heather</a></li>
</ul>
<br />
<h2>Change Log</h2>
<h3>Version 1.8.8</h3><br />
- Added option to choose social network icons on home page and single post page<br />
- Added options to display links to social network profiles in about widget<br />
- Added Norwegian Translation - Thanks <a href="http://stig.ulfsby.no/">stig.ulfsby.no</a><br />
- Added German Translation - Thanks <a href="http://InterNet-Dienste.biz">Thomas Morvay</a><br />
- Fixed error with image alignment outside of post container<br />
- Fixed error with Tag archive containters being too small<br />
- Fixed error with some plugins causing post meta info to be read in header causing problems with disabling sidebar and nav menus<br />
- Added 3 new layouts - Sidebar - Sidebar - Content, Content - Sidebar, Sidebar - Content<br />
- Added function for outputing sidebars depending on layout options<br />
- Added support for WordPress 3.0 menus<br />
- Added Options for adjust size and family of Nav Menu Fonts<br />
- Added option to rearrange footer text with shortcodes<br />
- Added option to disable search box in header area.<br />
<h3>Version 1.8.7</h3><br />
- Added French Translations - Thanks <a href="http://www.wolforg.eu" title= "Wolforg : CMS, Logiciels Libres & Réseaux Sociaux en Lozère" _target="blank">Wolforg</a><br />
- Added Cufon javascript font replacement options, and three free to use on web fonts<br />
- Added option to change content area background color<br />
- Added option to have content area background image<br />
- Added option to upload favicon<br />
- Bugfix: Search results page blank cause by missing ) in translation functions<br />
- Added Search term highlighting<br />
- Moved default upload location to wp-content/techozoic folder to stop theme updates deleting uploaded headers<br />
- Added option to center navigation menu<br />
- Fixed dropdown menu bug where specifying a fixed width wouldn't work<br />
- Moved widget code and comment callback code into separate files included with functions.php <br />
- Added comment preview section at bottom of post <br />
- Added export/import page for saving options to a downloadable file and restoring later or to another blog<br />
<h3>Version 1.8.6.1</h3><br />
- Fixed theme activation error<br />
<h3>Version 1.8.6</h3><br />
- Removed Tim thumb script causing to many errors, using browser scaled images for preview links <br />
- Moved options to separate menu page with sub menu pages for General, Header Images, and Style Settings<br />
- Major CSS cleanup for style.css<br />
- Added option to restore original style.css if static css is used and changes have been made <br />
- Backup of current style.css file made before overwriting file<br />
- Added option to change repeat pattern of custom page background image<br />
- Added Widgetized footer section -Limited to 3 widgets<br />
- Added Meta Box to Post/Page Screen to selectively disable sidebars on an individual basis if Display Sidebars on Single Pages is set<br />

<h3>Version 1.8.5</h3><br />
- Added Italian Translation -Thanks <a href="http://www.bomentre.com" _target="blank">Giuseppe Bomentre</a><br />
- Reworked Header image upload to no longer rely on javascript<br />
- Header image selection screen uses timthumb script to display previews<br />
- Header image selection screen uses thickbox for image previews<br />
- Added Page background selection to choose custom background instead of plain color<br />
- Changed Nav Exclusion list to be multiple selection box, instead of manually typing ids <br />
- Moved options to separate file to be included on controlpanel and theme-init files<br />

<h3>Version 1.8.4</h3><br />
- Localized public part of theme (Translators needed see <a href="http://clark-technet.com/theme-support/techozoic/translators-needed/">here</a>)
- Bugfix: IE7 wasn't properly centering blog title in header<br />
- Bugfix: If either the sidebars or main column widths weren't declared then the default values were used sometimes causing layout problems<br />
- Changed how options are referenced, controlpanel.php is only included on the dashboard<br />
- Added new tech-init.php file to change option names in database and pull values for the options<br />
- Added option to exclude pages from nav menu<br />
- Added new javascript dropdown menu type<br />
- Added option to use static css instead of dynamic<br />
- Added page to allow copying of dynamic css to static style.css file<br />
- Style.css now contains all default css and is used until custom options have been defined<br />
- Added option for header image alignment<br />
- Added option for header image size<br />
- Added New header image selection interface - Shows small previews with a link to full versions of header images to save space<br />
- Added New Navigation tab with new options for :<br />
-- Adding option for specifying up to 5 custom external links and their positioning in nav menu<br />
-- Toggling Home link visibility 
-- Changing text for Home link<br />
-- Showing Dashboard and login/logout links<br />
<h3>Version 1.8.3</h3><br />
- Bugfix: Didn't remove all debugging code, was causing problems with headers <br />
- Bugfix: If options haven't been setup default style.css is loaded to fix error with theme preview<br />
- Updated JS for Typography options to have Font Previews update with size and family<br />
<h3>Version 1.8.2</h3><br />
- Updated way style.php is called, no longer using unsafe $_GET variables<br />
-- Thanks to Atahualpa theme by BytesForAll for the inspiration and code<br />
- Added more options for font sizes for different sections<br />
<h3>Version 1.8.1</h3><br />
- Bugfix: Long Post titles were pushing post meta info down into content<br />
- Bugfix: Options panel form is now validated before being submitted<br />
- Bugfix: Style.php now sanitizes values from options panel before being displayed<br />
- Moved default css from style.php to default-css.php to make editing easier<br />
<h3>Version 1.8</h3><br />
- Major Code Cleanup: prettified code, removed extraneous php open and close tags, removed old features<br />
- Major Rework of how theme options are stored only two options added to wp_options table instead of 40+<br />
-- Old options are moved into new entry and old entries deleted from wp_options table<br />
- Bugfix: Custom comment function was causing problem with PHP 5.0.5 bug, code reworked to eliminate bug and maintain function<br />
- Bugfix: Pages weren't getting the right width if sidebars were disabled<br />
- Added New Color Option for navigation button background<br />
- Split Color option for Body/Accent color into two separate options<br />
- Added Dashboard Widget with links to options page and support forum<br />
- Added Sidebar Navigation Widget and option to disable Horizontal menu<br />
- Added About Author Widget with option to display Gravatar image<br />
- Updated widgets to new 2.8 style with title options<br />
- Updated Style.php code used to get variables from option panel, added custom function, reworked code to save space<br />
<h3>Version 1.7.2 - 1.7.9</h3><br />
- Skipped for major version change.  See version 1.8 for details.<br />
<h3>Version 1.7.1</h3><br />
- Bugfix: If javascript disabled, custom header upload form will still work<br />
- Bugfix: Ad settings fields are now sanitized by stripslashes to work with certain php and MySQL versions<br />
- Added second navigation menu type Two Tier - Horizontal menu with sub menu of any subpages<br />
- Added Header Text alignment option<br />
- Added Option to disable SEO optimization of post title being the main title on single pages<br />
- Added Webkit browser (Safari/Chrome) rounded corners<br />
- Added Webkit and Firefox drop shadows for images<br />
<h3>Version 1.7</h3><br />
- Added support for WordPress 2.9 post thumbnails feature, backwards compatibility maintained<br />
- Added header management page with custom image upload form and selection and deletion buttons for each header - BETA<br />
- Added base font size option for increasing font sizes with examples of page element's sizes<br />
- Added option to turn on/off Blog title and tag line overlay in header<br />
- Added option to save two custom color schemes<br />
- Added color choices for text and post background color<br />
- Added color picker for all colors choices<br />
- Modified option page to have tabbed interface to save scrolling, and cleaned up option descriptions<br />
<h3>Version 1.6.8 - 1.6.9</h3><br />
- Skipped for major version change, theme options page reworked and many new features added.  See version 1.7 for new features<br />
<h3>Version 1.6.7</h3><br />
- Added width adjustments for page, content, and sidebars<br />
- Added javascript to validate choices for widths<br />
- Added new header Landscape which is a shot of Hawaii taken from a mountain top<br />
- Added default styles to be applied if no options have been chosen<br />
<h3>Version 1.1 - 1.6.6</h3><br />
- Neglected to keep track of all features<br />
<h3>Version 1.0</h3><br />
- Initial Public Release<br />
</p>
</body>
</html>
