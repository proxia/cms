/* Import plugin specific language pack */
tinyMCE.importPluginLanguagePack('proxiaflash');

var TinyMCE_PROXIAFlashPlugin = {
	getInfo : function() {
		return {
			longname : 'Flash',
			author : '',
			authorurl : '',
			infourl : '',
			version : tinyMCE.majorVersion + "." + tinyMCE.minorVersion
		};
	},

	initInstance : function(inst) {
		if (!tinyMCE.settings['flash_skip_plugin_css'])
			tinyMCE.importCSS(inst.getDoc(), tinyMCE.baseURL + "/plugins/proxiaflash/css/content.css");

	},

	getControlHTML : function(cn) {
		switch (cn) {
			case "proxiaflash":
				return tinyMCE.getButtonHTML(cn, 'lang_flash_desc', '{$pluginurl}/images/flash.gif', 'mceProxiaFlash');
		}

		return "";
	},

	execCommand : function(editor_id, element, command, user_interface, value) {
		// Handle commands
		switch (command) {
			case "mceProxiaFlash":
				var name = "", swffile = "", swfwidth = "", swfheight = "", swfflashvars = "", action = "insert";
				var template = new Array();
				var inst = tinyMCE.getInstanceById(editor_id);
				var focusElm = inst.getFocusElement();

				template['file']   = '../../plugins/proxiaflash/flash.htm'; // Relative to theme
				template['width']  = 425;
				template['height'] = 350;

				template['width'] += tinyMCE.getLang('lang_flash_delta_width', 0);
				template['height'] += tinyMCE.getLang('lang_flash_delta_height', 0);

				// Is selection a image
				if (focusElm != null && focusElm.nodeName.toLowerCase() == "img") {
					name = tinyMCE.getAttrib(focusElm, 'class');

					if (name.indexOf('mceItemPROXIAFlash') == -1) // Not a Flash
						return true;

					// Get rest of Flash items
					swffile = tinyMCE.getAttrib(focusElm, 'alt');

					if (tinyMCE.getParam('convert_urls'))
						swffile = eval(tinyMCE.settings['urlconverter_callback'] + "(swffile, null, true);");

					swfwidth = tinyMCE.getAttrib(focusElm, 'width');
					swfheight = tinyMCE.getAttrib(focusElm, 'height');
					swfflashvars = tinyMCE.getAttrib(focusElm, 'xflashvars');
					action = "update";
				}

				tinyMCE.openWindow(template, {editor_id : editor_id, inline : "yes", swffile : swffile, swfwidth : swfwidth, swfheight : swfheight, swfflashvars : swfflashvars, action : action});
			return true;
	   }

	   // Pass to next handler in chain
	   return false;
	},

	cleanup : function(type, content) {

		switch (type) {
			case "insert_to_editor_dom":
				// Force relative/absolute
				if (tinyMCE.getParam('convert_urls')) {
					var imgs = content.getElementsByTagName("img");
					for (var i=0; i<imgs.length; i++) {
						if (tinyMCE.getAttrib(imgs[i], "class") == "mceItemPROXIAFlash") {
							var src = tinyMCE.getAttrib(imgs[i], "alt");

							if (tinyMCE.getParam('convert_urls'))
								src = eval(tinyMCE.settings['urlconverter_callback'] + "(src, null, true);");

							imgs[i].setAttribute('alt', src);
							imgs[i].setAttribute('title', src);
						}
					}
				}
				break;

			case "get_from_editor_dom":
				var imgs = content.getElementsByTagName("img");
				for (var i=0; i<imgs.length; i++) {
					if (tinyMCE.getAttrib(imgs[i], "class") == "mceItemPROXIAFlash") {
						var src = tinyMCE.getAttrib(imgs[i], "alt");

						if (tinyMCE.getParam('convert_urls'))
							src = eval(tinyMCE.settings['urlconverter_callback'] + "(src, null, true);");

						imgs[i].setAttribute('alt', src);
						imgs[i].setAttribute('title', src);
					}
				}
				break;

			case "insert_to_editor":
				var startPos = 0;
				var embedList = new Array();

				// Fix the embed and object elements
				content = content.replace(new RegExp('<[ ]*embed','gi'),'<embed');
				content = content.replace(new RegExp('<[ ]*/embed[ ]*>','gi'),'</embed>');
				content = content.replace(new RegExp('<[ ]*object','gi'),'<object');
				content = content.replace(new RegExp('<[ ]*/object[ ]*>','gi'),'</object>');

				// Parse all embed tags
				while ((startPos = content.indexOf('<embed', startPos+1)) != -1) {
					var endPos = content.indexOf('>', startPos);
					var attribs = TinyMCE_PROXIAFlashPlugin._parseAttributes(content.substring(startPos + 6, endPos));
					embedList[embedList.length] = attribs;
				}

				// Parse all object tags and replace them with images from the embed data
				var index = 0;
				while ((startPos = content.indexOf('<object', startPos)) != -1) {
					if (index >= embedList.length)
						break;

					var attribs = embedList[index];

					// Find end of object
					endPos = content.indexOf('</object>', startPos);
					endPos += 9;

					// Insert image
					var contentAfter = content.substring(endPos);
					content = content.substring(0, startPos);
					content += '<img width="' + attribs["width"] + '" height="' + attribs["height"] + '"';
					content += ' src="' + (tinyMCE.getParam("theme_href") + '/images/spacer.gif') + '" title="' + attribs["src"] + '"';
					content += ' alt="' + attribs["src"] + '" xflashvars="' + attribs["xflashvars"] + '" class="mceItemPROXIAFlash" />' + content.substring(endPos);
					content += contentAfter;
					index++;

					startPos++;
				}

				// Parse all embed tags and replace them with images from the embed data
				var index = 0;
				while ((startPos = content.indexOf('<embed', startPos)) != -1) {
					if (index >= embedList.length)
						break;

					var attribs = embedList[index];

					// Find end of embed
					endPos = content.indexOf('>', startPos);
					endPos += 9;

					// Insert image
					var contentAfter = content.substring(endPos);
					content = content.substring(0, startPos);
					content += '<img width="' + attribs["width"] + '" height="' + attribs["height"] + '"';
					content += ' src="' + (tinyMCE.getParam("theme_href") + '/images/spacer.gif') + '" title="' + attribs["src"] + '"';
					content += ' alt="' + attribs["src"] + '" xflashvars="' + attribs["xflashvars"] + ' class="mceItemPROXIAFlash" />' + content.substring(endPos);
					content += contentAfter;
					index++;

					startPos++;
				}

				break;

			case "get_from_editor":
				// Parse all img tags and replace them with object+embed
				var startPos = -1;

				while ((startPos = content.indexOf('<img', startPos+1)) != -1) {
					var endPos = content.indexOf('/>', startPos);

					var attribs = TinyMCE_PROXIAFlashPlugin._parseAttributes(content.substring(startPos + 4, endPos));

					// Is not flash, skip it
					if (attribs['class'] != "mceItemPROXIAFlash")
						continue;

					endPos += 2;

					var embedHTML = '';
					//var wmode = tinyMCE.getParam("flash_wmode", "");
					//var quality = tinyMCE.getParam("flash_quality", "high");
					//var menu = tinyMCE.getParam("flash_menu", "false");

					// Insert object + embed
					embedHTML += '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"';
					embedHTML += ' codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0"';
					embedHTML += ' width="' + attribs["width"] + '" height="' + attribs["height"] + '">';
					embedHTML += '<param name="movie" value="' + attribs["title"] + '"></param>';
					embedHTML += '<param name="allowFullScreen" value="true"></param>';
					embedHTML += '<param name="xflashvars" value="' + attribs["xflashvars"] + '"></param>';
					embedHTML += '<param name="allowscriptaccess" value="always"></param>';
					embedHTML += '<param name="flashVars" value="mediaFile=__project_path__' + attribs["title"] + '"></param>';
					embedHTML += '<embed src="' + attribs["title"] + '" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="' + attribs["width"] + '" height="' + attribs["height"] + '" xflashvars="' + attribs["xflashvars"] + '" flashVars="mediaFile=__project_path__' + attribs["title"] + '"></embed></object>';

					// Insert embed/object chunk
					chunkBefore = content.substring(0, startPos);
					chunkAfter = content.substring(endPos);
					content = chunkBefore + embedHTML + chunkAfter;
				}
				break;
		}

		// Pass through to next handler in chain
		return content;
	},

	handleNodeChange : function(editor_id, node, undo_index, undo_levels, visual_aid, any_selection) {
		if (node == null)
			return;

		do {
			if (node.nodeName == "IMG" && tinyMCE.getAttrib(node, 'class').indexOf('mceItemPROXIAFlash') == 0) {
				tinyMCE.switchClass(editor_id + '_flash', 'mceButtonSelected');
				return true;
			}
		} while ((node = node.parentNode));

		tinyMCE.switchClass(editor_id + '_flash', 'mceButtonNormal');

		return true;
	},

	// Private plugin internal functions

	_parseAttributes : function(attribute_string) {
		var attributeName = "";
		var attributeValue = "";
		var withInName;
		var withInValue;
		var attributes = new Array();
		var whiteSpaceRegExp = new RegExp('^[ \n\r\t]+', 'g');

		if (attribute_string == null || attribute_string.length < 2)
			return null;

		withInName = withInValue = false;

		for (var i=0; i<attribute_string.length; i++) {
			var chr = attribute_string.charAt(i);

			if ((chr == '"' || chr == "'") && !withInValue)
				withInValue = true;
			else if ((chr == '"' || chr == "'") && withInValue) {
				withInValue = false;

				var pos = attributeName.lastIndexOf(' ');
				if (pos != -1)
					attributeName = attributeName.substring(pos+1);

				attributes[attributeName.toLowerCase()] = attributeValue.substring(1);

				attributeName = "";
				attributeValue = "";
			} else if (!whiteSpaceRegExp.test(chr) && !withInName && !withInValue)
				withInName = true;

			if (chr == '=' && withInName)
				withInName = false;

			if (withInName)
				attributeName += chr;

			if (withInValue)
				attributeValue += chr;
		}

		return attributes;
	}
};

tinyMCE.addPlugin("proxiaflash", TinyMCE_PROXIAFlashPlugin);
