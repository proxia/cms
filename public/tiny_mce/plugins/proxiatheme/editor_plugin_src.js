/**
 * $Id: editor_plugin_src.js 201 2007-02-12 15:56:56Z spocke $
 *
 * @author Moxiecode
 * @copyright Copyright � 2004-2007, Moxiecode Systems AB, All rights reserved.
 */

var TinyMCE_ProxiaThemePlugin = {
	getInfo : function() {
		return {
			longname : 'ProxiaTheme',
			author : '',
			authorurl : '',
			infourl : '',
			version : tinyMCE.majorVersion + "." + tinyMCE.minorVersion
		};
	},

	/**
	 * Returns the HTML contents of the zoom control.
	 */
	getControlHTML : function(control_name) {

		switch (control_name) {
			case "proxiatheme":
				return '<select id="{$editor_id}_proxiathemeSelect" name="{$editor_id}_proxiathemeSelect" onfocus="tinyMCE.addSelectAccessibility(event, this, window);" onchange="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'proxiaTheme\',false,this.options[this.selectedIndex].value);" class="mceSelectList">' + 
						'<option value="100%">default</option>' + 
						'<option value="150%">roman</option>' + 
						'<option value="200%">wamalker</option>' +  
						'</select>';
		}

		return "";
	},

	/**
	 * Executes the mceZoom command.
	 */
	execCommand : function(editor_id, element, command, user_interface, value) {
		// Handle commands
		switch (command) {
			case "proxiaTheme":
				//tinyMCE.getInstanceById(editor_id).contentDocument.body.style.zoom = value;
				//tinyMCE.getInstanceById(editor_id).contentDocument.body.style.mozZoom = value;
				return true;
		}

		// Pass to next handler in chain
		return false;
	}
};

tinyMCE.addPlugin("proxiatheme", TinyMCE_ProxiaThemePlugin);
