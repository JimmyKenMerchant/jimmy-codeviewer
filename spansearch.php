<?php
/**
 * spansearch.php in Jimmy Codeviewer, a WordPress plugins
 * @author Kenta Ishii, Tokyo. Copyright 2017 Kenta Ishii. All Rights Reserved.
 * @package Jimmy Codeviewer
 */

/**
 *  Make shortcode [init_spansearch]
 *  e.g. make sure to put [init_spansearch] before [spansearch], [spansearch_all] and [divsearch]
 */
function shortcode_spansearch_init() {
	/*
	 * Make sure to NOT use of async or defer on library javascript file
	 */
	$return_str = "<script src=\"" . plugins_url( "js/spansearch.js", __FILE__ ) . "\" " . "type=\"text/javascript\"></script>\r\n";

	return $return_str;
}

add_shortcode( 'init_spansearch', 'shortcode_spansearch_init' );

/**
 *  Make shortcode [spansearch]
 *  e.g. [spansearch id="" start="" end=""]Something Else[/spansearch]
 *  Search Targeted Strings and Treat These
 *  Memo: In content, just use typed chars. no need of escaped code for space, etc. if both 1bytes and 2 bytes chars.
 *		Besides, if you want search html entities such as "&nbsp;" use unicode escape,
 *		just as "\xA0" or "\u00A0" or "\u{00A0}". In shortcode $atts process, escape chars tranlsate actual chars.
 *		Attribute values must not contain ] [ ' " and < > are in limited use. Spaces makes attributes broken.
 */
function shortcode_spansearch( $atts, $content = null ) {
	$arr = shortcode_atts(
		array( 'id' => '', // table's id
			'start' => '', // line number to start
			'end' => '', // line number to end
			'color' => '', // fontcolor of target string
			'background-color' => '', // background-color of target string
			'font-family' => '', // font-size of target string
			'font-size' => '', // font-size of target string
			'font-style' => '', // font-style of target string
			'font-weight' => '', // font-weight of target string
			'vertical-align' => '', // vertical-align of target string
			'regex-enable' => '', //use Regular Expression ('TRUE' or 'true') or not
		),
		$atts);

	$return_str = "<script defer type=\"text/javascript\">\r\n";

	$return_str .= "\tspanSearch(\"" . $arr[ 'id' ] .
						"\", \"" . $arr[ 'start' ] .
						"\", \"" . $arr[ 'end' ] .
						"\", \"" . $content . // target string to change status
						"\", \"" . $arr[ 'color' ] .
						"\", \"" . $arr[ 'background-color' ] .
						"\", \"" . $arr[ 'font-family' ] .
						"\", \"" . $arr[ 'font-size' ] .
						"\", \"" . $arr[ 'font-style' ] .
						"\", \"" . $arr[ 'font-weight' ] .
						"\", \"" . $arr[ 'vertical-align' ] .
						"\", \"" . $arr[ 'regex-enable' ] .
						"\");\r\n";

	$return_str .= "</script>\r\n";

	return $return_str;
}

add_shortcode( 'spansearch', 'shortcode_spansearch' );

/**
 *  Make shortcode [spansearch_all]
 *  e.g. [spansearch_all id=""]Something Else[/spansearch_all]
 *  Search Targeted Strings and Treat These in all lines
 */
function shortcode_spansearch_all( $atts, $content = null ) {
	$arr = shortcode_atts(
		array( 'id' => '', // table's id
			'color' => '', // fontcolor of target string
			'background-color' => '', // background-color of target string
			'font-family' => '', // font-size of target string
			'font-size' => '', // font-size of target string
			'font-style' => '', // font-style of target string
			'font-weight' => '', // font-weight of target string
			'vertical-align' => '', // vertical-align of target string
			'regex-enable' => '', //use Regular Expression ('TRUE' or 'true') or not
		),
		$atts);

	$return_str = "<script defer type=\"text/javascript\">\r\n";

	$return_str .= "\tspanSearch_All(\"" . $arr[ 'id' ] .
						"\", \"" . $content . // target string to change status
						"\", \"" . $arr[ 'color' ] .
						"\", \"" . $arr[ 'background-color' ] .
						"\", \"" . $arr[ 'font-family' ] .
						"\", \"" . $arr[ 'font-size' ] .
						"\", \"" . $arr[ 'font-style' ] .
						"\", \"" . $arr[ 'font-weight' ] .
						"\", \"" . $arr[ 'vertical-align' ] .
						"\", \"" . $arr[ 'regex-enable' ] .
						"\");\r\n";

	$return_str .= "</script>\r\n";

	return $return_str;
}

add_shortcode( 'spansearch_all', 'shortcode_spansearch_all' );

/**
 *  Make shortcode [divsearch]
 *  e.g. [divsearch id="" start="" end="" text-align="" line-height=""]
 *  Set text-align, line-height, background-color of line(s)
 */
function shortcode_divsearch( $atts ) {
	$arr = shortcode_atts(
		array( 'id' => '', // table's id
			'start' => '', // line number to start
			'end' => '', // line number to end
			'text-align' => '', // align property
			'line-height' => '', // line-height of target line(s)
			'color' => '', // color of target line(s)
			'background-color' => '', // background-color of target line(s)
			'font-family' => '', // font-size of target target line(s)
			'font-size' => '', // background-color of target line(s)
			'font-style' => '', // background-color of target line(s)
			'font-weight' => '', // background-color of target line(s)
		),
		$atts);

	$return_str = "<script defer type=\"text/javascript\">\r\n";

	$return_str .= "\tdivSearch(\"" . $arr[ 'id' ] .
						"\", \"" . $arr[ 'start' ] .
						"\", \"" . $arr[ 'end' ] .
						"\", \"" . $arr[ 'text-align' ] .
						"\", \"" . $arr[ 'line-height' ] .
						"\", \"" . $arr[ 'color' ] .
						"\", \"" . $arr[ 'background-color' ] .
						"\", \"" . $arr[ 'font-family' ] .
						"\", \"" . $arr[ 'font-size' ] .
						"\", \"" . $arr[ 'font-style' ] .
						"\", \"" . $arr[ 'font-weight' ] .
						"\");\r\n";

	$return_str .= "</script>\r\n";

	return $return_str;
}

add_shortcode( 'divsearch', 'shortcode_divsearch' );
