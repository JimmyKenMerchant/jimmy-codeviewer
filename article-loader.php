<?php
/**
 * article-loader.php in Jimmy Codeviewer, a WordPress plugins
 * @author Kenta Ishii, Tokyo. Copyright 2017 Kenta Ishii. All Rights Reserved.
 * @package Jimmy Codeviewer
 */

/**
 *  Make shortcode [articleloader_byid]
 *  e.g. [articleloader_byid]articleid[/articleloader_byid]
 *  Load article by article id
 */
function shortcode_articleloader_byid( $atts, $content = null ) {
	// To safety, return Error
	if ( !$content ) return "!articleloader_byid Error: No article-ID!";

	// Get Content
	$article = get_post( (int)$content ); // articleid
	if ( $article->ID && $article->post_status === "publish" && $article->post_type === "article" && ! $article->post_password ) {
		$content_text = $article->post_content;
	} else {
		return "!articleloader_byid Error: No article!";
	}

	// To safety, return Error
	if ( !$content_text ) return "!articleloader_byid Error: No content!";

	return $content_text;
}
add_shortcode( 'articleloader_byid', 'shortcode_articleloader_byid' );

/**
 *  Make shortcode [articleloader_byname]
 *  e.g. [articleloader_byname]articlename[/articleloader_byname]
 *  Load article by name (article slug)
 */
function shortcode_articleloader_byname( $atts, $content = null ) {
	// To safety, return Error
	if ( !$content ) return "!articleloader_byname Error: No article-Name!";

	// Get Content
	$article = get_page_by_path( $content, OBJECT, 'article' ); // articlename
	if ( $article->ID && $article->post_status === "publish" && $article->post_type === "article" && ! $article->post_password ) {
		$content_text = $article->post_content;
	} else {
		return "!articleloader_byname Error: No article!";
	}

	// To safety, return Error
	if ( !$content_text ) return "!articleloader_byname Error: No content!";

	return $content_text;
}
add_shortcode( 'articleloader_byname', 'shortcode_articleloader_byname' );
