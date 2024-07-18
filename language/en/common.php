<?php

/**
 * @package BBCode Icons
 * @copyright (c) 2024 Daniel James
 * @license https://opensource.org/license/gpl-2-0 GPL v2
 */

if ( ! defined( 'IN_PHPBB' ) ) {

	exit;

}

if ( empty( $lang ) || ! is_array( $lang ) ) {

	$lang = [];

}

$lang = array_merge( $lang, [
	'ACP_BBCODE_FONT_ICON_LEGEND'	=> 'Appearance',
	'ACP_BBCODE_FONT_ICON_LABEL'	=> 'BBCode Font Icon',
	'ACP_BBCODE_FONT_ICON_EXPLAIN'	=> 'Enter the name of a Font Awesome icon (without the fa prefix) to display instead of the BBCode name appearing on the button. <a href="https://fontawesome.com/v4/icons/" target="_blank">Click here</a> to view the list of available icons.',
] );
