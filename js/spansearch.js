/**
 * spansearch.js in Jimmy Codeviewer, a WordPress plugins
 * @author Kenta Ishii, Tokyo. Copyright 2017 Kenta Ishii. All Rights Reserved.
 * @package Jimmy Codeviewer
 * License: GPLv2 or later
 */
/**
 * In var str (for string searching), if you want search &nbsp, use "\xA0" or "\u00A0" or "\u{00A0}" (Unicode No-Break space), not "&nbsp".
 * Besides, In var str, if you want plain space, just use " " itself.
 * In var str, if you want search &amp, use "&" itself or "\x26" or "\u0026" or "\u{0026}", not "&amp".
 * Likewise if you want search &copy, use copryright-symbol itself (if you can type) or "\xA9" or "\u00A9" or "\u{00A9}", not "&copy".
 * Element.textContent returns actual inner text and translate alphabetical html entities codes to numerical unicodes.
 * Beside, other vars use ordinary space and chars just keyboard displays.
 */

//spanSearch("alpha", "24", "25", "Array", "#0ff", "", "", "", "", "", "");

/**
 * Search some word or spring then treat its font styles, color, etc.
 * id: table's id
 * start: line number to start
 * end: line number to end
 * str: target string to change status
 * col: font's color of target string
 * back_col: background-color of target string
 * font_family: font-family of target string
 * font_size: font-size of target string
 * font_style: font-style of target string
 * font_weight: font-weight of target string
 * v_align: vertical-align property
 * 
 * end, col, back_col, font_family, font_size, font_style, font_weight, v_align can be undefined.
 */
function spanSearch (id, start, end, str, col, back_col, font_family, font_size, font_style, font_weight, v_align) {
	if (id === "" || typeof id === "undefined") {
		console.error("spanSearch: 'id' empty or undefined!");
		return false;
	}
	if (start === "" || typeof start === "undefined") {
		console.error("spanSearch: 'start' empty or undefined!");
		return false;
	}
	if (str === "" || typeof str === "undefined") {
		console.error("spanSearch: 'str' empty or undefined!");
		return false;
	}
	if (end === "" || typeof end === "undefined") {
		end = parseInt(start);
	} else {
		end = parseInt(end);
	}

	var i = parseInt(start);
	while (i <= end) {
		var idnum = id + i;
		//console.log(idnum);
		var roottag = document.getElementById(idnum);
		if (roottag) {
			var error = __spanSearch(idnum, str, col, back_col, font_family, font_size, font_style, font_weight, v_align);
			if (!error) {
				console.error("spanSearch: Failed to __spanSearch");
				return false;
			}
		} else {
			/* if not serial numbers, this function stops */
			console.error("spanSearch: Failed to getElementById");
			return false;
		}
		i++;
	}
	return true;
}

/**
 * Search some word or spring then treat its font styles, color, etc. in all line of the table
 * id: table's id
 * str: target string to change status
 * col: font's color of target string
 * back_col: background-color of target string
 * font_family: font-family of target string
 * font_size: font-size of target string
 * font_style: font-style of target string
 * font_weight: font-weight of target string
 * v_align: vertical-align property
 * 
 * col, back_col, font_family, font_size, font_style, font_weight, v_align can be undefined.
 */
function spanSearch_All (id, str, col, back_col, font_family, font_size, font_style, font_weight, v_align) {
	if (id === "" || typeof id === "undefined") {
		console.error("spanSearch_All: 'id' empty or undefined!");
		return false;
	}
	if (str === "" || typeof str === "undefined") {
		console.error("spanSearch_All: 'str' empty or undefined!");
		return false;
	}

	var eles = document.getElementsByClassName(id);
	if (eles) {
		var c_eles = [];
		var div_length = 0;
		var blk_length = 0;
		var idnum = "";
		/* forloop needs unique variable names e.g. i j k, etc. in a sequence */
		for (var j = 0; j < eles.length; j++) {
			c_eles = eles[j].getElementsByTagName("DIV");
			div_length = c_eles.length;
			blk_length = div_length / 3;
			var incre = 2;
			for (var k = 0; k < blk_length; k++) {
				idnum = c_eles[incre].id;
				var error = __spanSearch(idnum, str, col, back_col, font_family, font_size, font_style, font_weight, v_align);
				if (!error) {
					console.error("spanSearch_All: Failed to __spanSearch");
					return false;
				}
				incre += 3;
			}
		}
	} else {
		console.error("spanSearch_All: Failed to getElementsByClassName");
		return false;
	}
	return true;
}

/**
 * Pseudo Recursive Function to search target string in all span tags on one line
 * Change font styles, color, etc. of target string
 */
function __spanSearch (idnum, str, col, back_col, font_family, font_size, font_style, font_weight, v_align) {
	// without value, "" or undefined, depending on Browsers
	var clist = document.getElementById(idnum).getElementsByTagName("SPAN");
	var curlength = clist.length;
	var error = 0;
	var pre_spanid = idnum + "-sp";
	var pre_number = 0;
	var asign_number = clist.length + 1;
	//console.log(clist.length);
	for (var i = 0; i < curlength; i++) {
		pre_number = i + 1;
		//console.log(pre_spanid + pre_number);
		var target = document.getElementById(pre_spanid + pre_number);
		// Check whether this span tag is last level child or not
		if (target.getElementsByTagName("SPAN").length === 0) {
			// Get Text on the last lavel child to search target string
			var seartxt = target.textContent;
			// Check whether target string exists or not in text
			if (seartxt.indexOf(str) !== -1) {
				// Remove all text node in this span tag
				while (target.hasChildNodes()) {
					target.removeChild(target.lastChild);
				}
				// Check whether second time or not on next loop
				var stflag = false;
				// Loop to change status of all target string in this tag
				while (seartxt.indexOf(str) !== -1) {
					// If second time on this loop, remove last children span tag in this tag not to duplicate strings
					if (stflag) {
						target.removeChild(target.lastChild);
						asign_number--;
					}
					var hit = seartxt.indexOf(str);
					var txtlth = seartxt.length;
					var strlth = str.length;
					var lastcheck = txtlth - hit - strlth;
					// Check wheter target string is on end of text or not
					if (lastcheck === 0) {
						// Check whether target string is on start of text or not
						if (hit === 0) {
							var fst = seartxt.slice(0, strlth);
							seartxt = seartxt.slice(strlth, txtlth);

							var fstspan = document.createElement("SPAN");
							fstspan.id = pre_spanid + asign_number;
							asign_number++;
							var fsttxt = document.createTextNode(fst);
							fstspan = spanStyle(fstspan, col, back_col, font_family, font_size, font_style, font_weight, v_align);
							if (!fstspan) {
								return false;
							}
							error = fstspan.appendChild(fsttxt);
							if (!error) {
								console.error("__spanSearch: Failed to appendChild");
								return false;
							}
							error = target.appendChild(fstspan);
							if (!error) {
								console.error("__spanSearch: Failed to appendChild");
								return false;
							}
							// One Span inserted 
						} else {
							var fst = seartxt.slice(0, hit);
							strlth += hit;
							var snd = seartxt.slice(hit, strlth);
							seartxt = seartxt.slice(strlth, txtlth);
							
							var fstspan = document.createElement("SPAN");
							fstspan.id = pre_spanid + asign_number;
							asign_number++;
							var fsttxt = document.createTextNode(fst);
							error = fstspan.appendChild(fsttxt);
							if (!error) {
								console.error("__spanSearch: Failed to appendChild");
								return false;
							}
							error = target.appendChild(fstspan);
							if (!error) {
								console.error("__spanSearch: Failed to appendChild");
								return false;
							}

							var sndspan = document.createElement("SPAN");
							sndspan.id = pre_spanid + asign_number;
							asign_number++;
							var sndtxt = document.createTextNode(snd);
							sndspan = spanStyle(sndspan, col, back_col, font_family, font_size, font_style, font_weight, v_align);
							if (!sndspan) {
								return false;
							}
							error = sndspan.appendChild(sndtxt);
							if (!error) {
								console.error("__spanSearch: Failed to appendChild");
								return false;
							}
							error = target.appendChild(sndspan);
							if (!error) {
								console.error("__spanSearch: Failed to appendChild");
								return false;
							}
							// Two Spans inserted 
						}
					} else {
						// Check whether target string is on start of text or not
						if (hit === 0) {
							var fst = seartxt.slice(0, strlth);
							seartxt = seartxt.slice(strlth, txtlth);

							var fstspan = document.createElement("SPAN");
							fstspan.id = pre_spanid + asign_number;
							asign_number++;
							var fsttxt = document.createTextNode(fst);
							fstspan = spanStyle(fstspan, col, back_col, font_family, font_size, font_style, font_weight, v_align);
							if (!fstspan) {
								return false;
							}
							error = fstspan.appendChild(fsttxt);
							if (!error) {
								console.error("__spanSearch: Failed to appendChild");
								return false;
							}
							error = target.appendChild(fstspan);
							if (!error) {
								console.error("__spanSearch: Failed to appendChild");
								return false;
							}

							var sndspan = document.createElement("SPAN");
							sndspan.id = pre_spanid + asign_number;
							asign_number++;
							var sndtxt = document.createTextNode(seartxt);
							error = sndspan.appendChild(sndtxt);
							if (!error) {
								console.error("__spanSearch: Failed to appendChild");
								return false;
							}
							error = target.appendChild(sndspan);
							if (!error) {
								console.error("__spanSearch: Failed to appendChild");
								return false;
							}
							// Two Spans inserted 
						} else {
							var fst = seartxt.slice(0, hit);
							strlth += hit;
							var snd = seartxt.slice(hit, strlth);
							seartxt = seartxt.slice(strlth, txtlth);

							var fstspan = document.createElement("SPAN");
							fstspan.id = pre_spanid + asign_number;
							asign_number++;
							var fsttxt = document.createTextNode(fst);
							error = fstspan.appendChild(fsttxt);
							if (!error) {
								console.error("__spanSearch: Failed to appendChild");
								return false;
							}
							error = target.appendChild(fstspan);
							if (!error) {
								console.error("__spanSearch: Failed to appendChild");
								return false;
							}

							var sndspan = document.createElement("SPAN");
							sndspan.id = pre_spanid + asign_number;
							asign_number++;
							var sndtxt = document.createTextNode(snd);
							sndspan = spanStyle(sndspan, col, back_col, font_family, font_size, font_style, font_weight, v_align);
							if (!sndspan) {
								return false;
							}
							error = sndspan.appendChild(sndtxt);
							if (!error) {
								console.error("__spanSearch: Failed to appendChild");
								return false;
							}
							error = target.appendChild(sndspan);
							if (!error) {
								console.error("__spanSearch: Failed to appendChild");
								return false;
							}

							var thdspan = document.createElement("SPAN");
							thdspan.id = pre_spanid + asign_number;
							asign_number++;
							var thdtxt = document.createTextNode(seartxt);
							error = thdspan.appendChild(thdtxt);
							if (!error) {
								console.error("__spanSearch: Failed to appendChild");
								return false;
							}
							error = target.appendChild(thdspan);
							if (!error) {
								console.error("__spanSearch: Failed to appendChild");
								return false;
							}
							// Three Spans inserted 
						}
					}
					// Second time on this loop
					stflag = true;
				}
			}
		}
		//console.log(clist.length);
	}
	return true;
}

/**
 * Style Changer in function _spanSearch
 */
function spanStyle (ele, col, back_col, font_family, font_size, font_style, font_weight, v_align) {
	if (col !== "" && typeof col !== "undefined") {
		ele.style.color = col;
		if (!ele.style.color) {
			console.error("spanStyle: Failed to color");
			return false;
		}
	}
	if (back_col !== "" && typeof back_col !== "undefined") {
		ele.style.backgroundColor = back_col;
		if (!ele.style.backgroundColor) {
			console.error("spanStyle: Failed to backgroundColor");
			return false;
		}
	}
	if (font_family !== "" && typeof font_family !== "undefined") {
		ele.style.fontFamily = font_family;
		if (!ele.style.fontFamily) {
			console.error("spanStyle: Failed to fontFamily");
			return false;
		}
	}
	if (font_size !== "" && typeof font_size !== "undefined") {
		ele.style.fontSize = font_size;
		if (!ele.style.fontSize) {
			console.error("spanStyle: Failed to fontSize");
			return false;
		}
	}
	if (font_style !== "" && typeof font_style !== "undefined") {
		ele.style.fontStyle = font_style;
		if (!ele.style.fontStyle) {
			console.error("spanStyle: Failed to fontStyle");
			return false;
		}
	}
	if (font_weight !== "" && typeof font_weight !== "undefined") {
		ele.style.fontWeight = font_weight;
		if (!ele.style.fontWeight) {
			console.error("spanStyle: Failed to fontWeight");
			return false;
		}
	}
	if (v_align !== "" && typeof v_align !== "undefined") {
		ele.style.verticalAlign = v_align;
		if (!ele.style.verticalAlign) {
			console.error("spanStyle: Failed to verticalAlign");
			return false;
		}
	}

	return ele;
}

/**
 * Search line(s) and set text-align, line-height and background-color
 * id: table's id
 * start: line number to start
 * end: line number to end
 * t_align: text-align parameter
 * line_height: line-height parameter (block element only)
 * col: font's color of target line(s)
 * back_col: background-color of target line(s)
 * font_family: font-family of target line(s)
 * font_size: font-size of target line(s)
 * font_style: font-style of target line(s)
 * font_weight: font-weight of target line(s)
 *
 * end, t_align, line_height, col, back_col, font_family, font_size, font_style, font_weight can be undefined.
 *
 */
function divSearch (id, start, end, t_align, line_height, col, back_col, font_family, font_size, font_style, font_weight) {
	if (id === "" || typeof id === "undefined") {
		console.error("divSearch: 'id' empty or undefined!");
		return false;
	}
	if (start === "" || typeof start === "undefined") {
		console.error("divSearch: 'start' empty or undefined!");
		return false;
	}
	if (end === "" || typeof end === "undefined") {
		end = parseInt(start);
	} else {
		end = parseInt(end);
	}

	var i = parseInt(start);
	while (i <= end) {
		var idnum = id + i;
		//console.log(idnum);
		var roottag = document.getElementById(idnum);
		if (roottag) {
			if (t_align !== "" && typeof t_align !== "undefined") {
				roottag.style.textAlign = t_align;
				if (!roottag.style.textAlign) {
					console.error("divSearch: Failed to textAlign");
					return false;
				}
			}

			if (line_height !== "" && typeof line_height !== "undefined") {
				roottag.style.lineHeight = line_height;
				if (!roottag.style.lineHeight) {
					console.error("divSearch: Failed to lineHeight");
					return false;
				}
			}

			if (col !== "" && typeof col !== "undefined") {
				roottag.style.color = col;
				if (!roottag.style.color) {
					console.error("divSearch: Failed to color");
					return false;
				}
			}

			if (back_col !== "" && typeof back_col !== "undefined") {
				roottag.style.backgroundColor = back_col;
				if (!roottag.style.backgroundColor) {
					console.error("divSearch: Failed to backgroundColor");
					return false;
				}
			}

			if (font_family !== "" && typeof font_family !== "undefined") {
				roottag.style.fontFamily = font_family;
				if (!roottag.style.fontFamily) {
					console.error("divSearch: Failed to fontFamily");
					return false;
				}
			}

			if (font_size !== "" && typeof font_size !== "undefined") {
				roottag.style.fontSize = font_size;
				if (!roottag.style.fontSize) {
					console.error("divSearch: Failed to fontSize");
					return false;
				}
			}

			if (font_style !== "" && typeof font_style !== "undefined") {
				roottag.style.fontStyle = font_style;
				if (!roottag.style.fontStyle) {
					console.error("divSearch: Failed to fontStyle");
					return false;
				}
			}

			if (font_weight !== "" && typeof font_weight !== "undefined") {
				roottag.style.fontWeight = font_weight;
				if (!roottag.style.fontWeight) {
					console.error("divSearch: Failed to fontWeight");
					return false;
				}
			}

		} else {
			console.error("divSearch: Failed to getElementById");
			return false;
		}
		i++;
	}
	return true;
}