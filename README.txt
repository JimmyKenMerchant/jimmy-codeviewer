=== Jimmy Codeviewer ===
Contributors: Kenta Ishii
Requires at least: WordPress 4.8-trunk
Tested up to: WordPress 4.7.3
Version: 0.9.6 Beta
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Jimmy Codeviewer is a multipurpose text viewer. First, I purposed to make a viewer for programming code for my site that introduces my articles. It was OK. But in making Jimmy Codeviewer, I think that this could be a multipurpose text viewer. On this time, many news sites have very simple layout for their contents. By the way, you could watch magazines or papers at a news-stand every day and these are so colorful and design-riches. I just want these on Internet. Colorful design-riches actually make us some attention and affection. Browsers is growing their rendering ability right now. This challenge — mocking magazines or news papers on Internet — not a dream, but a real on Internet. In addition to this, I tried to change WordPress to SVG-Free. SVG is one of vector graphics containers. It's just like HTML and JavaScrpt. This is exactly the reason why WordPress Community prohibits to upload SVG Files by Media Uploader. If SVGs are programming codes, these should be stored as scripts in pages. But "Posts" and "Pages" are having these unique purpose as public pages, so I decided to make "jArticles" inner pages and store texts and SVGs to "jArticles". For loading "jArticles" on "Posts" I made several WordPress shortcodes.

Jimmy Codeviewer consists three departments which have several WordPress shortcodes and functions.


1. Code Viewer

a. Shortcodes: [codeview_byid] and [codeview_byname] to show text in "Posts".

b. Edit Instructions: "(edit(exam-ple))" to make HTML markup or other escaped literal codes in "jArticles" pages.

c. Style Sheet: CSS Style Sheet to make web layout easier with Code Viewer.


2. Article Loader

a. Shortcodes: [articleloader_byid] and [articleloader_byname] to show SVGs or other scripts in "Posts".


3. Color and Style Changer

a. Shortcodes: [init_spansearch], [spansearch] and [spansearch_all] to change the text color and other styles. [divsearch] to change the row styles.

b. JavaSctipt: spanSearch() and its family, the engine to provide the above shortcodes to function.


== Tutorial ==

I. General
First, you publish your text or SVGs in "jArticles". Second, you call these in "Posts" by using shortcodes. If you want to change color or style on some particular string and row, use shortcodes as the instruction below.


II. Publish your text or SVGs in "jArticles"
After activated this plugin, you can see "jArticles" menu on the Admin Side Bar. Click this, then edit your text and publish. Make sure to note the post ID (on URL of the editor page itself) or the slug you made. This "jArticle" can not been shown in your site publicly.


III. Calling "jArticles" in "Posts"
Now you can use shortcodes on "Posts".

a. '[codeview_byid theme="default" id="desc" start="1" count="5"]111(the post ID of jArticle)[/codeview_byid]':
Shows line No.1 and sequenced 5 lines from No.1 in the text of the jArticle, the post ID is "111" and assign each row ID as "desc-(its linenumber)" and table class as "desc" with default template.

b. '[codeview_byname theme="magazine" id="text" start="4"]some-thing(the post slug [name] of jArticle)[/codeview_byname]':
Shows line No.4 in the text of the jArticle, the post slug is "some-thing" and assign each row ID as "text-(its linenumber)" and table class as "text" with magazine template.

'theme="magazine"' in these shortcodes means making html tags with magazine template. For example, if you use magazine template, background-color of your text becomes transparent. Besides, if you use default template, the background-color becomes blue.

Styles on templates can change individually on each shortcode. You can use the parameters below.

1. 'id' // ID to add
2. 'start' // The number as Initial Line Number
3. 'count' // Row numbers you want to show
4. 'width'
5. 'number-width'
6. 'text-align'
7. 'line-height'
8. 'color'
9. 'number-color'
10. 'background-color'
11. 'odd-background-color'
12. 'even-background-color'
13. 'font-family'
14. 'font-size'
15. 'font-style'
16. 'font-weight'
17. 'opacity'
18. 'padding-top'
19. 'padding-right'
20. 'padding-bottom'
21. 'padding-left'
22. 'white-space'
23. 'title' // Title Name under the code
24. 'line10-color' // font's color
25. 'line20-color' // font's color
26. 'line10-1' // line number (absolute) you want LINE10COL color
27. 'line10-2' // line number (absolute) you want LINE10COL color
28. 'line10-3' // line number (absolute) you want LINE10COL color
29. 'line20-1' // line number (absolute) you want LINE20COL color
30. 'line20-2' // line number (absolute) you want LINE20COL color
31. 'line20-3' // line number (absolute) you want LINE20COL color

No.6 to No.22 are similar to html style parameters. But if you use spaces in the value, parameters will be broken. No.1 to No.5 are the basic of making the table. Make sure to add "%" in the value of "number-width" . No.23 to No.31 are to use in programming code viewing to change font color on some particular line.

Jimmy Codeviewer never consider of putting same lines on a page several times. Therefore, if you name the same ID to a doubled line, you will meet ID conflict and functional problems on 'spansearch' series and 'divsearch'.

c. '[articleloader_byid"]111(the post ID of jArticle)[/articleloader_byid]':
d. '[articleloader_byname"]some-thing(the post slug [name] of jArticle)[/articleloader_byname]':
Likewise 'codeviewer' series, these show jArticles on your posts. But these are not for text but for scripts. SVGs and other scripts can be loaded to particular posts. Unlike 'codeviewer' series, parameters don't exist.


IV. Change Color or style on some particular string and row
a. '[init_spansearch]':
Make sure to add this to use the shortcodes below. If you use <!--nextpage--> on your post, add this on all divisions to make each pages.

b. '[spansearch id="desc" start="11" end="14" color="red"]Some Word[/spansearch]':
Searches the string "Some Word" on lines No.11 to No.14 of id "desc" which named in 'codeview' series then changes "Some Word" font color to red. If some line does not exist between No.11 to No.14, This function will be stopped. If you use this shortcode, make sure to confirm sequenced line numbers between "start" and "end".

c. '[spansearch_all id="text" background-color="blue"]Some String[/spansearch_all]':
Searches the string "Some String" on all lines of id "text" which named in 'codeview' series then changes "Some String" background-color to blue.

To search for some special chars, you may need escape chars. WordPress shortcodes specially hate raw ">" and "<", even in the enclosed content, otherwise shortcodes will be broken. Shortcode values should not contain [, ], ", ', <, >. Plus, in the enclosed content, ', ", & will be html entities because of safety. e.g. use "\x3E" for ">", less-than and "\x3C""<", greater-than.

To put spaces in attribute values, use quotes. spaces in unquoted values will be broken.

'spansearch' series have these parameters below.

1. 'id' // table's id
2. 'color' // fontcolor of target string
3. 'background-color' // background-color of target string
4. 'font-family' // font-size of target string
5. 'font-size' // font-size of target string
6. 'font-style' // font-style of target string
7. 'font-weight' // font-weight of target string
8. 'vertical-align' // vertical-align of target string
9. 'regex-enable' // enable Regular Expression ('TRUE' or 'true') or not
10. 'regex-modifier' // assign "i" and/or "m" modifier on RegExp. "g" will be ignored

'[spansearch]' have these parameters below.

11. 'start' // line number to start
12. 'end' // line number to end

If 9. 'regex-enable' is "TRUE" or "true", 'spansearch' series are searching the word by JavaScript's Regular Expression. Type your search word by JavaScript's rule for Regular Expression without delimiters and assign "m" (multi-lines modifier for use "^", "$" on each lines), and/or "i" (ignore cases) in 10. 'regex-modifier'. "g" is never be used because this modifier for all replacing words on one time [String.prototype.replace()], or get all matching words on one time [String.prototype.match()].


d. '[divsearch id="title" start="3" end="7" text-align="center" line-height="1.6em"]':
Searches lines No.3 to No.7 of id "title" which named in 'codeview' series then changes these text-align to center, and line-height to 1.6em. If some line does not exist between No.11 to No.14, This function will be stopped. If you use this shortcode, make sure to confirm sequenced line numbers between "start" and "end".

'[divsearch]' have these parameters below.

1. 'id' // table's id
2. 'start' // line number to start
3. 'end' // line number to end
4. 'text-align' // align property
5. 'line-height' // line-height of target line(s)
6. 'color' // color of target line(s)
7. 'background-color' // background-color of target line(s)
8. 'font-family' // font-size of target target line(s)
9. 'font-size' // background-color of target line(s)
10. 'font-style' // background-color of target line(s)
11. 'font-weight' // background-color of target line(s)


V. Capabilities of editing "jArticles"
On Activation of this plugin, "Adiministor" and "Editor" are added full capabilities to edit and publish "jArticles". "jFellow" role, which has limited capabilities to edit "jArticle", added to admin system. On Deactivation of this plugin, capabilities for "jArticles" and "jFellow" role will be erased.


VI. Edit Instructions
In text of "jArticles" to use 'codeviewer' series, you can use Edit Instructions to put html tags for ruby ,newline, etc. In 'codeviewer', html specialchars and some entities changes to html escapes such as "&lt; ('<')". Therefore, you need to use Edit Instructions to put html tags. Plus, to function 'spansearch' series, each children tag needs to be named. To take easy of these work, Edit Instructions exist. Plus, if you want newlines in one line on "jArticles", you can use '(edit(new-line))'.

Actual Edit Instructions are below.

1. '(edit(hard-hyphen))':
To put Actual Hyphen and have newline.

2. '(edit(soft-hyphen))':
To put a html entity "&shy;" to use "hyphens: manual;" in CSS.

3. '(edit(new-line))':
To have newline.

4. '(edit(br-tag))':
To put <br /> (XHTML Style) tag.

5. '(edit(ruby-tag))':
To put <ruby> tag for ruby.

6. '(edit(end-ruby))':
To put </ruby> tag for ruby.

7. '(edit(rb-tag))':
To put <rb> tag for ruby.

8. '(edit(end-rb))':
To put </rb> tag for ruby.

9. '(edit(rt-tag))':
To put <rt> tag for ruby.

10. '(edit(end-rt))':
To put </rt> tag for ruby.

11. '(edit(color-tag-somecolor))':
To Color the string between this Instruction and '(end-color)'.
This Instruction is a little special. If you want to color the string to red, use '(edit(color-tag-red))'. Besides, '(edit(color-tag-#09abcd))' means the string colored to hexadecimal #09abcd. Capital letters are recognized as well as small letters.

12. '(edit(end-color))':
To end color-tag.


Visit my site to check layout samples, and actually how to write html and shortcodes in your posts.
http://electronics.jimmykenmerchant.com/jimmy-codeviewer/


== Compatibility ==

1. Theme Compatibility
On WordPress Team's "Twenty Seventeen", This Plugin works but you need to customize "Twenty Seventeen" or this plugin to fit on display. Some themes such as "Twenty Seventeen" are having style flexibility between mobile devices and personal computers. Nowadays, rendering power of displays on both mobiles and personals are close to each other. Small displays can work as well as big displays. So I now recommend to trash flexibility between both. This gives us concentration of manpower to one layout in one site and grows quality of the site design. 

2. Browser Compatibility
Firefox, Chrome (webkit), Opera, IE and Edges work on this plugin. This plugin never guarantee to work SVG, JavaScript or other scripts in browsers. Even though you can load scripts using 'articleloader' series, these may not work properly.

== Security Notice ==

Both 'codeviewer' series and 'articleloader' series do not support loading by post titles. Because post titles can not be guaranteed for unique naming, rewriting content attack by hackers may occur on junior graded users (such as "jFellow"). post ID and post slug have its unique naming. In extending or modifying this plugin, make sure NOT to use post titles for loading "jArticles". This plugin prohibit to load "jArticles" which do not be published by senior graded users (such as "Editor"). Senior graded users should pay attention to invest SVGs, JavaScript and other scripts in "jArticles" for stopping any malicous activities before publishing "jArticles".

== Installation ==

Jimmy Codeviewer is a plugin under the terms of the GNU GPL. Now on its Beta Version. I can't guarantee correct functions on this plugin. But if you have some curious to this plugin, you can download and test it. Make sure to activate this plugin in "Installed Plugins" page.

This Plugin uses several text domains. Names of shortcodes may conflict with shortcodes in other plugins. Post Type Name, "jArticle" is considering its unique naming, but even "jArticle", this name may conflict with other Post Type Name. LATEX, a renowned digital document preparation system, uses "jarticle" as a document class. But I think, in WordPress, "jArticle" as Post Type Name is unique naming. Before activating this plugin, make sure to check naming conflict between this plugin and others.

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

= 0.9.6 Beta =
* Reviewed the security of 'spansearch' series, typically handling special characters
: April 2, 2017

= 0.9.5 Beta =
* Added Variable Modifiers of Regular Expression Search | Reviewed Text Domain
: April 1, 2017

= 0.9.4 Beta =
* Changed the Post Type Name "article" to "jarticle" for unique naming
: March 31, 2017

= 0.9.3 Beta =
* Added Regular Expression Search to 'spansearch' series
: March 30, 2017

= 0.9.2 Beta =
* Shorcodes using post titles are deprecated because of a security reason. Please see Securiy Notice above
: March 29, 2017

= 0.9.1 Beta =
* Released: March 26, 2017
