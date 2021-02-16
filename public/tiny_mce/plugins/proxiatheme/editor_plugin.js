/**

 */
	
proxiaThemeSelectedIndex = 0;
	
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
				return '<select id="{$editor_id}_proxiathemeSelect" name="{$editor_id}_proxiathemeSelect" onfocus="tinyMCE.addSelectAccessibility(event, this, window);" onchange="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'proxiaTheme\',false,this);" class="mceSelectList">' + 
						tinyMCE.getParam("proxia_combo_theme_value")+ 
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
				proxia_project_name = tinyMCE.getParam("proxia_project_name");
				proxia_element_name = tinyMCE.getParam("proxia_element_name");
				proxia_path = tinyMCE.getParam("proxia_path");
				proxia_textarea_id = tinyMCE.getParam("elements");
				proxia_themes_value = value.options[value.selectedIndex].value;
				proxiaThemeSelectedIndex = document.getElementById(editor_id+"_proxiathemeSelect").selectedIndex;		

			 //tinyMCE.removeMCEControl(editor_id);
       // tinyMCE.addMCEControl(document.getElementById(proxia_textarea_id), editor_id);
				tinyMCE.execCommand('mceRemoveControl', false, proxia_textarea_id);
				tinyMCE.settings["content_css"]= proxia_path+""+proxia_project_name+"/themes/"+proxia_themes_value+"/css/editor_styles_4_"+proxia_element_name+".css";				
				tinyMCE.execCommand('mceAddControl', false, proxia_textarea_id);

				return true;
		}

		// Pass to next handler in chain
		return false;
	},

	/**
	 * Gets called ones the cursor/selection in a TinyMCE instance changes. This is useful to enable/disable
	 * button controls depending on where the user are and what they have selected. This method gets executed
	 * alot and should be as performance tuned as possible.
	 *
	 * @param {string} editor_id TinyMCE editor instance id that was changed.
	 * @param {HTMLNode} node Current node location, where the cursor is in the DOM tree.
	 * @param {int} undo_index The current undo index, if this is -1 custom undo/redo is disabled.
	 * @param {int} undo_levels The current undo levels, if this is -1 custom undo/redo is disabled.
	 * @param {boolean} visual_aid Is visual aids enabled/disabled ex: dotted lines on tables.
	 * @param {boolean} any_selection Is there any selection at all or is there only a cursor.
	 */
	handleNodeChange : function(editor_id, node, undo_index, undo_levels, visual_aid, any_selection) {

		document.getElementById(editor_id+"_proxiathemeSelect").selectedIndex = proxiaThemeSelectedIndex
	}

};

tinyMCE.addPlugin("proxiatheme", TinyMCE_ProxiaThemePlugin);
