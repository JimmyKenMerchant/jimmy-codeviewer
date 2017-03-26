=== Jimmy Codeviewer ===
Contributors: Kenta Ishii, Tokyo
Requires at least: WordPress 4.8-trunk
Tested up to: WordPress 4.7.3
Version: 0.9.1 Beta
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Jimmy Codeviewer is a multipurpose text viewer. First, I purposed to make a viewer for programming code for my site that introduces my articles. It was OK. But in making Jimmy Codeviewer, I think that this could be a multipurpose text viewer. On this time, many news sites have very simple layout for their contents. By the way, you could watch magazines or papers at a news-stand every day and these are so colorful and design-riches. I just want these on Internet. Colorful design-riches actually make us some attention and affection. Browsers is growing their rendering ability right now. This challenge — mocking magazines or news papers on Internet — not a dream, but a real on Internet. In addition to this, I tried to change WordPress to SVG-Free. SVG is one of vector graphics containers. It's just like HTML and JavaScrpt. This is exactly the reason why WordPress Community prohibits to upload SVG Files by Media Uploader. If SVGs are programming codes, these should be stored as scripts in pages. But "Posts" and "Pages" are having these unique purpose as public pages, so I decided to make "Articles" inner pages and store texts and SVGs to "Articles". For loading "Articles" on "Posts" I made several WordPress shortcodes.

Jimmy Codeviewer consists three departments which have several WordPress shortcodes and functions.

1. Code Viewer

	a. Shortcodes: [codeview_byid], [codeview_byname] and [codeview_bytitle] to show text in "Posts".

	b. EditInstruction: "(edit(exam-ple))" to make HTML markup or other escaped literal codes in "Articles" pages.

	c. Style Sheet: CSS Style Sheet to make web layout easier with Code Viewer.

2. Article Loader

	a. Shortcodes: [articleloader_byid], [articleloader_byname] and [articleloader_bytitle] to show SVGs or other scripts in "Posts".

3. Color and Style Changer

	a. Shortcodes: [init_spansearch], [spansearch] and [spansearch_all] to change the text color and other styles. [divsearch] to change the column styles.

	b. JavaSctipt: spanSearch() and its family, the engine to provide the above shortcodes to function.

== Tutorial ==

ON BREIEF

1. General
First, you publish your text or SVGs in "Articles". Second, you call these in "Posts" by using shortcodes. If you want to change color or style on some particular string and column, use shortcodes as the instruction below.

2. Publish your text or SVGs in "Articles"
After activated this plugin, you can see "Articles" menu on the Admin Side Bar. Click this, then edit your text and publish. Make sure to note the post ID or the slug you made. This "Article" can not been shown in your site.

3. Calling "Articles" in "Posts"
Now you can use shortcodes on "Posts". e.g. '[codeview_byid theme="default" id="desc" start="1" count="5"]ID of Article[/codeview_byid]' shows line No.1 and sequenced 5 lines from No.1 in the text of the Article and assign table ID as "desc" and its line number.

4. Change Color or style on some particular string and column.
Also you can change color or style of some particular string and column by shortcodes. If you need to use these Color/Style changer, shortcode '[init_spansearch]' is needed before actual functional shortcodes. .e.g. '[spansearch id="desc" start="1" color="cyan"]What[/spansearch]' changes "What" word on line No.1 of ID "desc" table.

== Installation ==

Jimmy Codeviewer is a plugin under the terms of the GNU GPL. Now on its Beta Version. I can't guarantee correct functions on this plugin. But if you have some curious to this plugin, you can download and test it. Make sure to activate this plugin in "Installed Plugins" page.

== Copyright ==

The Jimmy Codeviewer, A WordPress Plugin, Copyright 2017 Kenta Ishii
Jimmy Codeviewer is distributed under the terms of the GNU GPL

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

== Changelog ==

= 0.9.1 Beta =
* Released: March 26, 2017
