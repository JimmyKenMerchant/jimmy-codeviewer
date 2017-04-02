<?php
/*
Plugin Name: Jimmy Codeviewer
Plugin URI: http://electronics.jimmykenmerchant.com/jimmy-codeviewer/
Description: Multipurpose text viewer
Author: Kenta Ishii
Author URI: http://electronics.jimmykenmerchant.com
Version: 0.9.6 Beta
Text Domain: jimmy-codeviewer
Domain Path: /languages
License: GPL2 or Later
*/

require "constants.php";

/**
 * Add Custom Post type, article
 */
function jimmy_codeviewer_create_post_type() {
	register_post_type(
		'jarticle',
		array(
		'labels' => array(
			'name' => __( 'jArticles' ),
			'singular_name' => __( 'jArticle' ),
		),
		'supports' => array(
			'title',
			'editor',
			'author',
			'revisions',
		),
		'public' => false,
		'has_archive' => false,
		'show_ui' => true,
		'capability_type' => array( 'jarticle', 'jarticles' ),
		'map_meta_cap' => true,
		'menu_position' => 20,
		)
	);
}
add_action( 'init', 'jimmy_codeviewer_create_post_type' );

/* Role Making "jfellow" to only edit or delete article on activation */
function jimmy_codeviewer_roles_customize() {
	$capabilities = array(
			'edit_posts' => 'edit_jarticles',
			'edit_others_posts' => 'edit_others_jarticles',
			'edit_private_posts' => 'edit_private_jarticles',
			'edit_published_posts' => 'edit_published_jarticles',
			'delete_posts' => 'delete_jarticles',
			'delete_others_posts' => 'delete_others_jarticles',
			'delete_private_posts' => 'delete_private_jarticles',
			'delete_published_posts' => 'delete_published_jarticles',
			'publish_posts' => 'publish_jarticles',
			'read_private_posts' => 'read_private_jarticles',
			);

	$role = get_role( 'administrator' );
	foreach( $capabilities as $cap ) {
		$role->add_cap( $cap );
	}

	$role = get_role( 'editor' );
	foreach( $capabilities as $cap ) {
		$role->add_cap( $cap );
	}

	add_role( 'jfellow', 'jFellow',
		 array( 'read' => true,
			'edit_jarticles' => true,
			'delete_jarticles' => true,
		) );
}
register_activation_hook( __FILE__, 'jimmy_codeviewer_roles_customize' );

/* Role Delete on Deactivation */
function jimmy_codeviewer_roles_retrieve() {
	$capabilities = array(
			'edit_posts' => 'edit_jarticles',
			'edit_others_posts' => 'edit_others_jarticles',
			'edit_private_posts' => 'edit_private_jarticles',
			'edit_published_posts' => 'edit_published_jarticles',
			'delete_posts' => 'delete_jarticles',
			'delete_others_posts' => 'delete_others_jarticles',
			'delete_private_posts' => 'delete_private_jarticles',
			'delete_published_posts' => 'delete_published_jarticles',
			'publish_posts' => 'publish_jarticles',
			'read_private_posts' => 'read_private_jarticles',
			);

	$role = get_role( 'administrator' );
	foreach( $capabilities as $cap ) {
		$role->remove_cap( $cap );
	}

	$role = get_role( 'editor' );
	foreach( $capabilities as $cap ) {
		$role->remove_cap( $cap );
	}

	remove_role( 'jfellow' );
}
register_deactivation_hook( __FILE__, 'jimmy_codeviewer_roles_retrieve' );

/**
 * Cancels auto html tagging <p> and/or <br />
 * On Default, post is only capable with Code Viewer. 
 */
function jimmy_codeviewer_cancel_tagging() {
	if ( get_post_type() === "post" ) {
		remove_filter('the_content', 'wpautop');
		remove_filter('the_excerpt', 'wpautop');
		add_filter('the_content', 'jimmy_codeviewer_erase_indents');
		add_filter('the_excerpt', 'jimmy_codeviewer_erase_indents');
	}
	return true;
}
add_action( 'the_post', 'jimmy_codeviewer_cancel_tagging' );

/**
 * Erase indents in posts for proportional html.
 */
function jimmy_codeviewer_erase_indents( $content ) {
	// add multi-lines pattern modifier "m" to use beginning of line outside of the delimiter.
	$content = preg_replace( "/^[\t\s]+(<\/?div>?)/m", "$1", $content );
	$content = preg_replace( "/^\t+\[|^\s+\[/m", "[", $content );
	return $content;
}

/**
 * Add style around codeview
 */
function jimmy_codeviewer_style() {
	wp_enqueue_style( 'jimmy-codeviewer-style',  plugins_url( 'style-codeviewer.css', __FILE__ ), array(), null );
	return true;
}
add_action( 'wp_enqueue_scripts', 'jimmy_codeviewer_style' );

/**
 *  Make shortcode [codeview_byid]
 *  e.g. [codeview_byid title="something"]articleid[/codeview_byid]
 *  Make Codeview from article by article id
 */
function shortcode_codeviewer_article_byid( $atts, $content = null ) {
	// To safety, return Error
	if ( !$content ) return "!codeview_byid Error: No article-ID!";

	// Get Content
	$article = get_post( (int)$content ); // articleid
	if ( $article->ID && $article->post_status === "publish" && $article->post_type === "jarticle" && ! $article->post_password ) {
		$content_text = $article->post_content;
	} else {
		return "!codeview_byid Error: No article!";
	}

	// To safety, return Error
	if ( !$content_text ) return "!codeview_byid Error: No content!";

	return __shortcode_codeviewer_article( $atts, $content_text );
}
add_shortcode( 'codeview_byid', 'shortcode_codeviewer_article_byid' );

/**
 *  Make shortcode [codeview_byname]
 *  e.g. [codeview_byname title="something"]articlename[/codeview_byname]
 *  Make Codeview from article by name (article slug)
 */
function shortcode_codeviewer_article_byname( $atts, $content = null ) {
	// To safety, return Error
	if ( !$content ) return "!codeview_byname Error: No article-Name!";

	// Get Content
	$article = get_page_by_path( $content, OBJECT, 'jarticle' ); // articlename
	if ( $article->ID && $article->post_status === "publish" && $article->post_type === "jarticle" && ! $article->post_password ) {
		$content_text = $article->post_content;
	} else {
		return "!codeview_byname Error: No article!";
	}

	// To safety, return Error
	if ( !$content_text ) return "!codeview_byname Error: No content!";

	return __shortcode_codeviewer_article( $atts, $content_text );
}
add_shortcode( 'codeview_byname', 'shortcode_codeviewer_article_byname' );

/**
 * Common function to make html on codeviewer
 */
function __shortcode_codeviewer_article( $atts, $content_text ) {
	// include a theme, if a theme is not, require the default theme
	$pre = (array)$atts; // already array by shortcode_parse_atts in shorcodes.php
	if ( array_key_exists( "theme", $pre ) ) {
		$theme = "theme_" . $pre[ 'theme' ] . ".php";
		if ( (include $theme) == FALSE ) {
			require "theme_default.php";

		}
	} else {
		require "theme_default.php";
	}

	// '',"",'0',"0", NULL all means and false, except '\0' in C lang. '', "" means empty
	$arr = shortcode_atts(
		array( 'id' => '', // ID to add
			'start' => 1, // The number as Initial Line Number
			'count' => $LINE_COUNT, // Row numbers you want to show
			'width' => $BLOCK_WIDTH,
			'number-width' => $NUMBER_WIDTH,
			'text-align' => $TEXT_ALIGN,
			'line-height' => $LINE_HEIGHT,
			'color' => $FONT_COLOR,
			'number-color' => $NUMBER_COLOR,
			'background-color' => $BACK_COLOR,
			'odd-background-color' => $ODD_BACKCOLOR,
			'even-background-color' => $EVEN_BACKCOLOR,
			'font-family' => $FONT_FAMILY,
			'font-size' => $FONT_SIZE,
			'font-style' => $FONT_STYLE,
			'font-weight' => $FONT_WEIGHT,
			'opacity' => $OPACITY,
			'padding-top' => $PADDING_TOP,
			'padding-right' => $PADDING_RIGHT,
			'padding-bottom' => $PADDING_DOWN,
			'padding-left' => $PADDING_LEFT,
			'white-space' => $WHITE_SPACE,
			'title' => '', // Title Name under the code
			'line10-color' => $LINE10_COLOR, // font's color
			'line20-color' => $LINE20_COLOR, // font's color
			'line10-1' => 0, // line number (absolute) you want LINE10COL color
			'line10-2' => 0, // line number (absolute) you want LINE10COL color
			'line10-3' => 0, // line number (absolute) you want LINE10COL color
			'line20-1' => 0, // line number (absolute) you want LINE20COL color
			'line20-2' => 0, // line number (absolute) you want LINE20COL color
			'line20-3' => 0, // line number (absolute) you want LINE20COL color
		),
		$atts);

	// Set Numbers from attributes
	// Attributes all seem like to be string type even though number...
	$incre = $arr[ 'start' ];
	// To make sequence numbers for span tags
	$sequence = 1;
	$countlimit = $arr[ 'count' ] + $arr[ 'start' ] - 1;

	// Make Return String
	// display: inline-block; ... overflow style is basically second order, because of not indicating height
	// Use double quotations and escape to use \r\n
	if ( $arr[ 'id' ] ) {
		$return_str = "<div class=\"" . $arr[ 'id' ] . "\"";
	} else {
		$return_str = "<div";
	}

	$return_str .= " style=\"display: block;margin: 0;padding: 0;width: " . $arr[ 'width' ] . ";font-size: " . $arr[ 'font-size' ] . ";color: " . $arr[ 'color' ] . ";background-color: " . $arr[ 'background-color' ] . ";font-family: " . $arr[ 'font-family' ] . ";font-style: " . $arr[ 'font-style' ] . ";font-weight: " . $arr[ 'font-weight' ] . ";line-height: " . $arr[ 'line-height' ] . ";opacity: " . $arr[ 'opacity' ] . ";\">\r\n";

	// Counter Set
	$i = 0;
	// explode seems if empty, return empty but array exist
	// For Compatibility POSIX and WINDOWS
	$content_text = preg_replace( '/\r/', "", $content_text );
	$bufferarr = explode( "\n", $content_text );
	// Add count limit to be safe code
	while ( array_key_exists( $i, $bufferarr ) && $i < $countlimit && $i < LOOP_LIMITTER ) {
		$buffer = $bufferarr[ $i ];
		if(!$buffer) $buffer=" ";
		$i++;
		if ( $i < $arr[ 'start' ] ) continue;

		/* 
		 * Strictly wants that Encoding of the text is UTF-8 otherwise, you meet empty return
		 * mb_detect_encoding and mb_convert_encoding are useful
		 * Plus, use utf-8 as PHP default. e.g. set "default_charset = UTF-8" in php.ini
		 * You may need settings of Multibyte String Extension (php-mbstring) and so on
		 * Make sure to set utf-8 in html. e.g. set "<meta charset="UTF-8">" in head tag
		 * In addition, MySQL's Table charset needs utf8mb4, collate needs utf8mb4_unicode_ci
		 *
		 * MEMO: UTF-8 is ultimatelly in-bytes format for unicode. if you want to search raw unicode, you may need utf-16 style unicode sucn as "/\x{2010}/u"
		 */

		// First, change html special chars to html entities NOT to be actual codes
		$buffer = htmlentities( $buffer, ENT_QUOTES, 'UTF-8' );

		// "(edit([a-z]+\-[a-z]+[a-zA-Z0-9#\-]*))", Edit Instructions
		// Use Double quotations for immediate string to use escape
		// Escape of "(edit([a-z\-]+))" itself by backslash at first
		$buffer = preg_replace( '/\x5C\(edit\(([a-z]+\-[a-z]+[a-zA-Z0-9#\-]*)\)\)/', "&#40;edit&#40;$1&#41;&#41;", $buffer );
		$matches = array();

		if ( preg_match_all( '/\(edit\(([a-z]+\-[a-z]+)[a-zA-Z0-9#\-]*\)\)/', $buffer, $matches, PREG_PATTERN_ORDER ) > 0) {
			// $matches[0] stores all matched text,
			// and $matches[1] and after stores word in parenthesis
			// In this case, first and second words. Third is omitted.
			foreach ($matches[1] as $value) {
				switch ($value) {
					case "hard-hyphen":
						$buffer = preg_replace( '/\(edit\(hard-hyphen\)\)/', "\x2D\r\n", $buffer, 1 );
						break;
					case "soft-hyphen":
						$buffer = preg_replace( '/\(edit\(soft-hyphen\)\)/', "&shy;", $buffer, 1 );
						break;
					case "new-line":
						$buffer = preg_replace( '/\(edit\(new-line\)\)/', "\r\n", $buffer, 1 );
						break;
					case "br-tag":
						$buffer = preg_replace( '/\(edit\(br-tag\)\)/', "</span><br /><span id=\"" . $arr [ 'id' ] . $incre . "-sp" . ++$sequence . "\" style=\"white-space: " . $arr[ 'white-space' ] . ";\">", $buffer, 1 );
						break;
					case "ruby-tag":
						$buffer = preg_replace( '/\(edit\(ruby-tag\)\)/', "</span><ruby>" , $buffer, 1 );
						break;
					case "end-ruby":
						$buffer = preg_replace( '/\(edit\(end-ruby\)\)/', "</ruby><span id=\"" . $arr [ 'id' ] . $incre . "-sp" . ++$sequence . "\" style=\"white-space: " . $arr[ 'white-space' ] . ";\">", $buffer, 1 );
						break;
					case "rb-tag":
						$buffer = preg_replace( '/\(edit\(rb-tag\)\)/', "<rb>" , $buffer, 1 );
						break;
					case "end-rb":
						$buffer = preg_replace( '/\(edit\(end-rb\)\)/', "</rb>" , $buffer, 1 );
						break;
					case "rt-tag":
						$buffer = preg_replace( '/\(edit\(rt-tag\)\)/', "<rt>" , $buffer, 1 );
						break;
					case "end-rt":
						$buffer = preg_replace( '/\(edit\(end-rt\)\)/', "</rt>" , $buffer, 1 );
						break;
					case "color-tag":
						$buffer = preg_replace( '/\(edit\(color-tag-([a-zA-Z0-9#]+)\)\)/', "</span><span id=\"" . $arr [ 'id' ] . $incre . "-sp" . ++$sequence . "\" style=\"color: $1;white-space: " . $arr[ 'white-space' ] . ";\">", $buffer, 1 );
						break;
					case "end-color":
						$buffer = preg_replace( '/\(edit\(end-color\)\)/', "</span><span id=\"" . $arr [ 'id' ] . $incre . "-sp" . ++$sequence . "\" style=\"white-space: " . $arr[ 'white-space' ] . ";\">", $buffer, 1 );
						break;
					default:
						$buffer = preg_replace( '/\(edit\(([a-z]+\-[a-z]+)[a-zA-Z0-9#\-]*\)\)/', "", $buffer, 1 );
						break;
				}
			}
		}

		// Then Make html
		$return_str .= "\t<div style=\"display: block;margin: 0;padding: 0;width: 100%;text-align: left;\">\r\n";

		$return_str .= "\t\t<div style=\"display: inline-block;margin: 0;vertical-align: top;text-align: right;width: " . $arr[ 'number-width' ] . ";color: " . $arr[ 'number-color' ];

		if ( $arr [ 'number-width' ] > 0 ) {
			$return_str .= ";padding: 0 1% 0 0;\">\r\n";
		} else {
			$return_str .= ";padding: 0;visibility:hidden;\">\r\n";
		}

		$return_str .= "\t\t\t<span>" . $incre . "</span>\r\n";

		// No need to \r\n because of inline-block
		$return_str .= "\t\t</div>";

		// Change Color by line number, odd or even
		// No need to \t\t because of inline-block
		if ( $arr[ 'id' ] ) {
			$return_str .= "<div id=\"" . $arr [ 'id' ] . $incre . "\" style=\"";
		} else {
			$return_str .= "<div style=\"";
		}

		if ( $incre == $arr[ 'line10-1' ] || $incre == $arr[ 'line10-2' ] || $incre == $arr[ 'line10-3' ] ) {
			$return_str .= "color: " . $arr[ 'line10-color' ] . ";";
		} elseif ( $incre == $arr[ 'line20-1' ] || $incre == $arr[ 'line20-2' ] || $incre == $arr[ 'line20-3' ] ) {
			$return_str .= "color: " . $arr[ 'line20-color' ] . ";";
		}

		// use cast to remove "%" this cast uses 'atoi', a c function
		$textwidth = 100 - (int)$arr[ 'number-width' ];
		$return_str .= "display: inline-block;margin: 0;padding: " . $arr[ 'padding-top' ] . " " . $arr[ 'padding-right' ] . " " . $arr[ 'padding-bottom' ] . " " . $arr[ 'padding-left' ] . ";vertical-align: top;text-align: " . $arr[ 'text-align' ] . ";width: " . $textwidth . "%;";

		if ( $incre % 2 === 1 ) {
			$return_str .= "background-color: " . $arr[ 'odd-background-color' ] . ";\">\r\n";
		} else {
			$return_str .= "background-color: " . $arr[ 'even-background-color' ] . ";\">\r\n";
		}

		$return_str .= "\t\t\t<span id=\"" . $arr [ 'id' ] . $incre . "-sp1\" style=\"white-space: " . $arr[ 'white-space' ] . ";\">" . $buffer . "</span>\r\n";

		$return_str .= "\t\t</div>\r\n";
		$return_str .= "\t</div>\r\n";

		// Increment line number
		$incre++;
	}

	if ( $arr[ 'title' ] ) {
		$return_str .= "</div>\r\n<div style=\"display: block;text-align: center;margin: 0;padding: 0.2em;width: " . $arr[ 'width' ] . "\">\r\n";
		$return_str .= "\t<p><em><strong>" . $arr[ 'title' ] . "</strong></em></p>\r\n";
		$return_str .= "</div>";
	} else {
		$return_str .= "</div>";
	}

	return $return_str;
}

include "spansearch.php";

include "article-loader.php";
