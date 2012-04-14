<?php
/*
By Matt Mullenweg > http://ma.tt
Inspired by Dan Benjamin > http://hiveware.com/imagerotator.php
Latest version always at:
http://ma.tt/scripts/randomimage
*/
	$folder = './images/headers/';
	// Space seperated list of extensions, you probably won't have to change this.
	$exts = 'jpg jpeg png gif';
	$files = array(); $i = -1; // Initialize some variables
	if ('' == $folder) $folder = './';
	$handle = opendir($folder);
	$exts = explode(' ', $exts);
	while (false !== ($file = readdir($handle))) {
		foreach($exts as $ext) { // for each extension check the extension
			if (preg_match('/\.'.$ext.'$/i', $file, $test)) { // faster than ereg, case insensitive
				$files[] = $file; // it's good
				++$i;
			}
		}
	}
	closedir($handle); // We're not using it anymore
	mt_srand((double)microtime()*1000000); // seed for PHP < 4.2
	$rand = mt_rand(0, $i); // $i was incremented as we went along
	header('Location: '.$folder.$files[$rand]); // Voila!
?>
