<?php

	if (defined('JSON_PRETTY_PRINT') && defined('JSON_UNESCAPED_UNICODE') && defined('JSON_UNESCAPED_SLASHES')) {
		$json = json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_HEX_TAG);
	} else {
		$json = preg_replace_callback(
			'/\\\\u([0-9a-zA-Z]{4})/',
			function ($matches) {
				return mb_convert_encoding(pack('H*',$matches[1]),'UTF-8','UTF-16');
			},
			json_encode($data, JSON_HEX_TAG)
	    );
	    $json = str_replace('\\/', '/', json_encode($data));
	}

	$json = preg_replace('#&amp;#', "&", $json);
	$json = preg_replace('#&lt;#', "<", $json);
	$json = preg_replace('#&gt;#', ">", $json);
	echo $json;
?>

