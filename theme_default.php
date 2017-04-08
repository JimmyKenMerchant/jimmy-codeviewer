<?php
/**
 * theme_default.php in Jimmy Codeviewer, a WordPress plugins
 * @author Kenta Ishii, Tokyo. Copyright 2017 Kenta Ishii. All Rights Reserved.
 * @package Jimmy Codeviewer
 */

/**
 * In shortcode attributes,
 * ]["' never be used and HTML Chars <> are limited.
 * Use html entities for restricted chars, such as &#34 (Double Quotation).
 * See the newest text of https://codex.wordpress.org/Shortcode_API
 */

$LINE_COUNT = 100; // lines you want to make
$BLOCK_WIDTH = "900px"; // width of this block
$NUMBER_WIDTH = "8%"; // number width
$TEXT_ALIGN = "left"; // left because of alphabetical code viewer
$LINE_HEIGHT = "normal";
$FONT_COLOR = "#fff"; // white
$NUMBER_COLOR = "#ff0"; // yellow
$BACK_COLOR = "#00f"; //  // background-color blue
$ODD_BACKCOLOR = "#00c"; // darkblue
$EVEN_BACKCOLOR = "#007"; // darkblue
$FONT_FAMILY = "inherit";
$FONT_SIZE = "inherit";
$FONT_STYLE = "inherit";
$FONT_WEIGHT = "inherit";
$OPACITY = "1.0";
$PADDING_TOP = "0px";
$PADDING_RIGHT = "4px";
$PADDING_DOWN = "0px";
$PADDING_LEFT = "4px";
// wrap or line for words. preformatted "pre-wrap", "pre", "normal", "nowrap"
$WHITE_SPACE = "pre-wrap";
$LINE10_COLOR = "#ff0"; // font-color yellow
$LINE20_COLOR = "#f0f"; // font-color magenta
