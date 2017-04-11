<?php
/**
 * article-loader.php in Jimmy Codeviewer, a WordPress plugin
 * @package Jimmy Codeviewer
 * @author Kenta Ishii
 */

/**
 *  Make shortcode [articleloader_byid]
 *  e.g. [articleloader_byid]articleid[/articleloader_byid]
 *  Load article by article id
 */
function jimmy_codeviewer_shortcode_articleloader_byid( $atts, $content = null ) {
	// To safety, return Error
	if ( !$content ) return "!articleloader_byid Error: No article-ID!";

	// Get Content
	$article = get_post( (int)$content );
	if ( $article->ID && $article->post_status === "publish" && $article->post_type === "jarticle" && ! $article->post_password ) {
		$content_text = $article->post_content;
	} else {
		return "!articleloader_byid Error: No article!";
	}

	// To safety, return Error
	if ( !$content_text ) return "!articleloader_byid Error: No content!";

	// Erase null character for security
	$content_text = preg_replace( '/\x00/', "", $content_text );

	return $content_text;
}
add_shortcode( 'articleloader_byid', 'jimmy_codeviewer_shortcode_articleloader_byid' );


/**
 *  Make shortcode [articleloader_byname]
 *  e.g. [articleloader_byname]articlename[/articleloader_byname]
 *  Load article by name (article slug)
 */
function jimmy_codeviewer_shortcode_articleloader_byname( $atts, $content = null ) {
	// To safety, return Error
	if ( !$content ) return "!articleloader_byname Error: No article-Name!";

	// Get Content
	$article = get_page_by_path( $content, OBJECT, 'jarticle' );
	if ( $article->ID && $article->post_status === "publish" && $article->post_type === "jarticle" && ! $article->post_password ) {
		$content_text = $article->post_content;
	} else {
		return "!articleloader_byname Error: No article!";
	}

	// To safety, return Error
	if ( !$content_text ) return "!articleloader_byname Error: No content!";

	// Erase null character for security
	$content_text = preg_replace( '/\x00/', "", $content_text );

	return $content_text;
}
add_shortcode( 'articleloader_byname', 'jimmy_codeviewer_shortcode_articleloader_byname' );
