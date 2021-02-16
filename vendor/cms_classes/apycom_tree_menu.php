<?php

if(!defined('APYCOM_TREEMENU_PHP')):
	define('APYCOM_TREEMENU_PHP', true);

class Apycom_TreeMenu
{
	const EXPAND_POLICY_ON_ICON_CLICK = 0;
	const EXPAND_POLICY_ON_ITEM_CLICK = 1;
	const POSITION_RELATIVE = 0;
	const POSITION_ABSOLUTE = 1;

###################################################################################################

	/* system */
	private $blank_image = null;
	private $level_indent = 20;
	private $expand_policy = null;
	private $expand_items = true;
	private $target = '_self';
	private $cursor = 'default';
	private $enable_toggle_mode = false;
	private $close_expanded_item = true;
	private $xp_close_expanded_item = false;
	private $save_state = false;
	private $global_link_prefix = null;
	private $global_img_prefix = null;

	/* size */
	private $width = 250;
	private $height = 0;

	/* positioning */
	private $position = null;
	private $pos_x = 0;
	private $pos_y = 0;

	/* floating */
	private $is_floatable = false;
	private $float_itertions = 6;
	private $float_pos_x = 1;
	private $float_pos_y = 1;

	/* movement */
	private $is_movable = false;
	private $move_image = null;
	private $move_height = 12;
	private $move_color = '#aaaaaa';

	/* menu look */
	private $pressed_font_color = '#aa0000';
	private $font_style = 'normal 11px Arial';
	private $font_color_normal = '#444444';
	private $font_color_hover = '#ffffff';
	private $font_color_disabled = '#444444';
	private $font_decoration_normal = 'none';
	private $font_decoration_hover = 'none';

	private $background_color = '#ffffff';
	private $background_image = null;
	private $border_color = '#cccccc';
	private $border_style = 'solid';
	private $border_width = 0;

	/* item look */
	private $item_align = 'left';
	private $item_background_color_normal = '#ffffff';
	private $item_background_color_hover = '#4792e6';
	private $item_background_image_normal = null;
	private $item_background_image_hover = null;
	private $item_height = 22;

	/* icons */
	private $icon_width = 16;
	private $icon_height = 16;
	private $icon_align = 'left';
	private $icon_expanded_normal = null;
	private $icon_expanded_hover = null;
	private $icon_expanded_expanded = null;
	private $icon_expanded_width = 9;
	private $icon_expanded_height = 9;
	private $icon_expanded_align = 'left';

	/* lines */
	private $show_menu_lines = false;
	private $line_image_horizontal = null;
	private $line_image_vertical = null;
	private $line_image_corner = null;

	/* xp-style */
	private $xp_enable = true;
	private $xp_iterations = 5;
	private $xp_title_background_color = '#265bcc';
	private $xp_title_background_image = null;
	private $xp_title_left_image = null;
	private $xp_title_left_image_width = 4;
	private $xp_icon_expand_normal = null;
	private $xp_icon_expand_hover = null;
	private $xp_icon_collapsed_normal = null;
	private $xp_icon_collapsed_hover = null;
	private $xp_icon_width = 25;
	private $xp_icon_height = 25;
	private $xp_submenu_icon_width = 30;
	private $xp_submenu_icon_height = 32;
	private $xp_filter_enable = true;

###################################################################################################

	private $item_style_list = array();
	private $xp_style_list = array();
	private $item_list = array();

###################################################################################################
# public
###################################################################################################

	public function __construct()
	{
		$this->expand_policy = self::EXPAND_POLICY_ON_ITEM_CLICK;
		$this->position = self::POSITION_ABSOLUTE;
	}

###################################################################################################

	public function __call($name, $args)
	{
		if(strpos($name, 'set') !== false)
		{
			$var_name = CN_Utils::getRealName(substr($name, 3));
			$var_value = is_string($args[0]) ? trim($args[0]) : $args[0];

			########################################################################################

			$props = get_object_vars($this);

			if(array_key_exists($var_name, $props))
				$this->$var_name = $var_value;
			else
				throw new CN_Exception(sprintf(_("Property `%1\$s` is not defined in class `%2\$s`."), $var_name, __CLASS__));

		}
		elseif(strpos($name, 'get') !== false)
		{
			$var_name = CN_Utils::getRealName(substr($name, 3));
			$var_value = is_string($args[0]) ? trim($args[0]) : $args[0];

			########################################################################################

			if(array_key_exists($var_name, $props))
				return $this->$var_name;
			else
				throw new CN_Exception(sprintf(_("Property `%1\$s` is not defined in class `%2\$s`."), $var_name, __CLASS__));
		}
		else
			throw new CN_Exception(_("Unknown method call, use `set` or `get` for prefix."));
	}

###################################################################################################

	public function registerItemStyle(Apycom_TreeItemStyle $tree_item_style)
	{
		$this->item_style_list[$tree_item_style->getName()] = $tree_item_style;
	}

	public function registerXPStyle(Apycom_XPStyle $xp_style)
	{
		$this->xp_style_list[$xp_style->getName()] = $xp_style;
	}

###################################################################################################

	public function addTreeItem(Apycom_TreeItem $tree_item) { $this->item_list[] = $tree_item; }

###################################################################################################

	public function render($script_tags=true)
	{
		$variable_token = $this->getVariableToken();
		$item_style_token = $this->getItemStyleToken();
		$xp_style_token = $this->getXPStyleToken();
		$tree_item_token = $this->getTreeItemToken();

		###########################################################################################

		$apycom_tree_menu =<<<APYCOM_TREE_MENU
		$variable_token\n
		$item_style_token\n
		$xp_style_token\n
		$tree_item_token\n

		apy_tmenuInit();\n
APYCOM_TREE_MENU;

		###########################################################################################

		if($script_tags)
			$apycom_tree_menu = '<script type="text/javascript">'.$apycom_tree_menu.'</script>';

		###########################################################################################

		return $apycom_tree_menu;
	}

###################################################################################################
# private
###################################################################################################

	private function getVariableToken()
	{
		$expand_items = (int)$this->expand_items;
		$enable_toggle_mode = (int)$this->enable_toggle_mode;
		$close_expanded_item = (int)$this->close_expanded_item;
		$xp_close_expanded_item = (int)$this->xp_close_expanded_item;
		$save_state = (int)$this->save_state;

		$system_token =<<<SYSTEM_TOKEN
		var tblankImage = "{$this->blank_image}";
		var tlevelDX = {$this->level_indent};
		var texpandItemClick = {$this->expand_policy};
		var texpanded = $expand_items;
		var titemTarget =  "{$this->target}";
		var titemCursor = "{$this->cursor}";
		var ttoggleMode = $enable_toggle_mode;
		var tcloseExpanded = $close_expanded_item;
		var tcloseExpandedXP = $xp_close_expanded_item;
		var tsaveState = $save_state;
		var tpathPrefix_link = "{$this->global_link_prefix}";
		var tpathPrefix_img = "{$this->global_img_prefix}";
SYSTEM_TOKEN;

		###########################################################################################

		$size_token =<<<SIZE_TOKEN
		var tmenuWidth = {$this->width};
		var tmenuHeight = {$this->height};
SIZE_TOKEN;

		###########################################################################################

		$positioning_token =<<<POSITIONING_TOKEN
		var tabsolute = {$this->position};
		var tleft = {$this->pos_x};
		var ttop = {$this->pos_y};
POSITIONING_TOKEN;

		###########################################################################################

		$is_floatable = (int)$this->is_floatable;

		$floating_token =<<<FLOATING_TOKEN
		var tfloatable = $is_floatable;
		var tfloatIterations = {$this->float_itertions};
		var tfloatableX = {$this->float_pos_x};
		var tfloatableY = {$this->float_pos_y};
FLOATING_TOKEN;

		###########################################################################################

		$is_movable = (int)$this->is_movable;

		$movement_token =<<<MOVEMENT_TOKEN
		var tmoveable = $is_movable;
		var tmoveImage = "{$this->move_image}";
		var tmoveHeight = {$this->move_height};
		var tmoveColor = "{$this->move_color}";
MOVEMENT_TOKEN;

		###########################################################################################

		$font_color = '["'.$this->font_color_normal.'", "'.$this->font_color_hover.'"]';
		$font_decoration = '["'.$this->font_decoration_normal.'", "'.$this->font_decoration_hover.'"]';

		$menu_look_token =<<<MENU_LOOK_TOKEN
		var tpressedFontColor = "{$this->pressed_font_color}";
		var tfontStyle = "{$this->font_style}";
		var tfontColor = $font_color;
		var tfontColorDisabled = "{$this->font_color_disabled}";
		var tfontDecoration = $font_decoration;
		var tmenuBackColor = "{$this->background_color}";
		var tmenuBackImage = "{$this->background_image}";
		var tmenuBorderColor = "{$this->border_color}";
		var tmenuBorderStyle = "{$this->border_style}";
		var tmenuBorderWidth = {$this->border_width};
MENU_LOOK_TOKEN;

		###########################################################################################

		$item_background_color = '["'.$this->item_background_color_normal.'", "'.$this->item_background_color_hover.'"]';
		$item_background_image = '["'.$this->item_background_image_normal.'", "'.$this->item_background_image_hover.'"]';

		$item_look_token =<<<ITEM_LOOK_TOKEN
		var titemAlign = "{$this->item_align}";
		var titemBackColor = $item_background_color;
		var titemBackImage = $item_background_image;
		var titemHeight = {$this->item_height};
ITEM_LOOK_TOKEN;

		###########################################################################################

		$expand_icon = '["'.$this->icon_expanded_normal.'", "'.$this->icon_expanded_hover.'", "'.$this->icon_expanded_expanded.'"]';

		$icons_token =<<<ICONS_TOKEN
		var ticonWidth = {$this->icon_width};
		var ticonHeight = {$this->icon_height};
		var ticonAlign = "{$this->icon_align}";
		var texpandBtn = $expand_icon;
		var texpandBtnW = {$this->icon_expanded_width};
		var texpandBtnH = {$this->icon_expanded_height};
		var texpandBtnAlign = "{$this->icon_expanded_align}";
ICONS_TOKEN;

		###########################################################################################

		$show_menu_lines = (int)$this->show_menu_lines;

		$lines_token =<<<LINES_TOKEN
		var tpoints = $show_menu_lines;
		var tpointsImage = "{$this->line_image_horizontal}";
		var tpointsVImage = "{$this->line_image_vertical}";
		var tpointsCImage = "{$this->line_image_corner}";

LINES_TOKEN;

		###########################################################################################

		$xp_enable = (int)$this->xp_enable;
		$xp_icon = '["'.$this->xp_icon_expand_normal.'", "'.$this->xp_icon_expand_hover.'", "'.$this->xp_icon_collapsed_normal.'", "'.$this->xp_icon_collapsed_hover.'"]';
		$xp_filter_enable = (int)$this->xp_filter_enable;

		$xp_style_token =<<<XP_STYLE_TOKEN
		var tXPStyle = $xp_enable;
		var tXPIterations = {$this->xp_iterations};
		var tXPTitleBackColor = "{$this->xp_title_background_color}";
		var tXPTitleBackImg = "{$this->xp_title_background_image}";
		var tXPTitleLeft = "{$this->xp_title_left_image}";
		var tXPTitleLeftWidth = "{$this->xp_title_left_image_width}";
		var tXPExpandBtn = $xp_icon;
		var tXPBtnWidth = {$this->xp_icon_width};
		var tXPBtnHeight = {$this->xp_icon_height};
		var tXPIconWidth = {$this->xp_submenu_icon_width};
		var tXPIconHeight = {$this->xp_submenu_icon_height};
		var tXPFilter = $xp_filter_enable;
XP_STYLE_TOKEN;

		###########################################################################################

		$system_token = "\t".trim($system_token);
		$size_token = "\t".trim($size_token);
		$positioning_token = "\t".trim($positioning_token);
		$floating_token = "\t".trim($floating_token);
		$movement_token = "\t".trim($movement_token);
		$menu_look_token = "\t".trim($menu_look_token);
		$item_look_token = "\t".trim($item_look_token);
		$icons_token = "\t".trim($icons_token);
		$lines_token = "\t".trim($lines_token);
		$xp_style_token = "\t".trim($xp_style_token);

		###########################################################################################

		$variable_token =<<<VARIABLE_TOKEN
		$system_token\n
		$size_token\n
		$positioning_token\n
		$floating_token\n
		$movement_token\n
		$menu_look_token\n
		$item_look_token\n
		$icons_token\n
		$lines_token\n
		$xp_style_token\n
VARIABLE_TOKEN;

		return $variable_token;
	}

	private function getItemStyleToken()
	{
		$item_style = '[], ';

		###########################################################################################

		foreach($this->item_style_list as $item)
		{
			$item_style .= '[';

			$option_list = $item->getOptionList();

			foreach($option_list as $option_name => $option_value)
				$item_style	.= sprintf('"%s=%s", ', $option_name, $option_value);

			$item_style .= '],';
		}

		###########################################################################################

		return 'var tstyles = ['.rtrim($item_style, ',').'];';
	}

	private function getXPStyleToken()
	{
		$xp_style = '[], ';

		###########################################################################################

		foreach($this->xp_style_list as $item)
		{
			$xp_style .= '[';

			$option_list = $item->getOptionList();

			foreach($option_list as $option_name => $option_value)
				$xp_style .= sprintf('"%s=%s", ', $option_name, $option_value);

			$xp_style .= '],';
		}

		###########################################################################################

		return 'var tXPStyles = ['.rtrim($xp_style, ',').'];';
	}

	private function getTreeItemToken()
	{
		$menu_items = null;

		###########################################################################################

		foreach($this->item_list as $item)
		{
			$label = ($item->getIsExpanded() === true ? '+' : '').$item->getLabel();
			$link = $item->getLink();
			$normal_icon = $item->getNormalIcon();
			$hover_icon = $item->getHoverIcon();
			$expanded_icon = $item->getExpandedIcon();
			$tooltip = $item->getTooltip();
			$target = $item->getIsDisabled() === true ? '_' : $item->getTarget();
			$item_style = $this->findStyleIndex($item->getItemStyle(), 'item');
			$xp_style = $this->findStyleIndex($item->getXPStyle(), 'xp');

			$menu_items .= sprintf('["%s", "%s", "%s", "%s", "%s", "%s", "%s", %s, %s],', $label, $link, $normal_icon, $hover_icon, $expanded_icon, $tooltip, $target, $item_style, $xp_style);

			if(count($item->getChildItemList()))
				$menu_items .= $this->buildSubMenu($item, 1);
		}

		if(!is_null($menu_items))
			$menu_items = 'var tmenuItems = ['.rtrim($menu_items, ',').'];';
		else
			$menu_items = 'var tmenuItems = [];';

		###########################################################################################

		return $menu_items;
	}

	###############################################################################################

	private function buildSubMenu(Apycom_TreeItem $parent_item, $level)
	{
		$child_items = null;
		$child_item_list = $parent_item->getChildItemList();

		foreach($child_item_list as $item)
		{
			$label = str_repeat('|', $level).($item->getIsExpanded() === true ? '+' : '').$item->getLabel();
			$link = $item->getLink();
			$normal_icon = $item->getNormalIcon();
			$hover_icon = $item->getHoverIcon();
			$expanded_icon = $item->getExpandedIcon();
			$tooltip = $item->getTooltip();
			$target = $item->getIsDisabled() === true ? '_' : $item->getTarget();
			$item_style = $this->findStyleIndex($item->getItemStyle(), 'item');
			$xp_style = $this->findStyleIndex($item->getXPStyle(), 'xp');

			$child_items .= sprintf('["%s", "%s", "%s", "%s", "%s", "%s", "%s", %s, %s],', $label, $link, $normal_icon, $hover_icon, $expanded_icon, $tooltip, $target, $item_style, $xp_style);

			#######################################################################################

			if(count($item->getChildItemList()) > 0)
				$child_items .= $this->buildSubMenu($item, $level + 1);
		}

		return $child_items;
	}

	###############################################################################################

	private function findStyleIndex($name, $type)
	{
		$search_target = $type == 'item' ? $this->item_style_list : $this->xp_style_list;

		if(!isset($search_target[$name]))
			return null;

		$index = 0;

		foreach($search_target as $style_name => $value)
		{
			if($style_name == $name)
				return $index + 1;

			++$index;
		}
	}

###################################################################################################
# public static
###################################################################################################

	public static function loadFromFile($source_file, $script_tags=true)
	{

	}
}

###################################################################################################
###################################################################################################
###################################################################################################

class Apycom_TreeItemStyle
{
	private $name = null;

	private $option_list = array();

###################################################################################################
# public
###################################################################################################

	public function __construct($name)
	{
		$this->name = $name;
	}

###################################################################################################

	public function getName() { return $this->name; }
	public function getOptionList() { return $this->option_list; }

###################################################################################################

	public function setOption($name, $value) { $this->option_list[$name] = $value; }

	public function getOption($name)
	{
		if(isset($this->option_list[$name]))
			return $this->option_list[$name];
		else
			return null;
	}
}

###################################################################################################
###################################################################################################
###################################################################################################

class Apycom_XPStyle
{
	private $name = null;

	private $option_list = array();

###################################################################################################
# public
###################################################################################################

	public function __construct($name)
	{
		$this->name = $name;
	}

###################################################################################################

	public function getName() { return $this->name; }
	public function getOptionList() { return $this->option_list; }

###################################################################################################

	public function setOption($name, $value) { $this->option_list[$name] = $value; }

	public function getOption($name)
	{
		if(isset($this->option_list[$name]))
			return $this->option_list[$name];
		else
			return null;
	}
}

###################################################################################################
###################################################################################################
###################################################################################################

class Apycom_TreeItem
{
	private $label = null;
	private $link = null;
	private $normal_icon = null;
	private $hover_icon = null;
	private $expanded_icon = null;
	private $tooltip = null;
	private $target = null;
	private $item_style = null;
	private $xp_style = null;

	private $is_disabled = false;
	private $is_expanded = false;

	private $child_item_list = array();

###################################################################################################
# public
###################################################################################################

	public function __construct($label=null, $link=null, $normal_icon=null, $hover_icon=null, $expanded_icon=null, $tooltip=null, $target=null, $item_style=null, $xp_style=null)
	{
		$this->label = trim($label);
		$this->link = trim($link);
		$this->normal_icon = trim($normal_icon);
		$this->hover_icon = trim($hover_icon);
		$this->expanded_icon = trim($expanded_icon);
		$this->tooltip = trim($tooltip);
		$this->target = trim($target);
		$this->item_style = trim($item_style);
		$this->xp_style = trim($xp_style);
	}

###################################################################################################

	public function setLabel($label) { $this->label = trim($label); }
	public function setLink($link) { $this->link = trim($link); }
	public function setNormalIcon($normal_icon) { $this->normal_icon = trim($normal_icon); }
	public function setHoverIcon($hover_icon) { $this->hover_icon = trim($hover_icon); }
	public function setExpandedIcon($expanded_icon) { $this->expanded_icon = trim($expanded_icon); }
	public function setTooltip($tooltip) { $this->tooltip = trim($tooltip); }
	public function setTarget($target) { $this->target = trim($target); }
	public function setItemStyle($item_style) { $this->item_style = trim($item_style); }
	public function setXPstyle($xp_style) { $this->xp_style = trim($xp_style); }

	public function setIsDisabled($is_disabled) { $this->is_disabled = (bool)$is_disabled; }
	public function setIsExpanded($is_expanded) { $this->is_expanded = (bool)$is_expanded; }

###################################################################################################

	public function getLabel() { return $this->label; }
	public function getLink() { return $this->link; }
	public function getNormalIcon() { return $this->normal_icon; }
	public function getHoverIcon() { return $this->hover_icon; }
	public function getExpandedIcon() { return $this->expanded_icon; }
	public function getTooltip() { return $this->tooltip; }
	public function getTarget() { return $this->target; }
	public function getItemStyle() { return $this->item_style; }
	public function getXPStyle() { return $this->xp_style; }

	public function getIsDisabled() { return $this->is_disabled; }
	public function getIsExpanded() { return $this->is_expanded; }

###################################################################################################

	public function getChildItemList() { return $this->child_item_list; }

###################################################################################################

	public function addChildItem(Apycom_TreeItem $tree_item) { $this->child_item_list[] = $tree_item; }

###################################################################################################

	public function clear()
	{
		$this->label = null;
		$this->link = null;
		$this->normal_icon = null;
		$this->hover_icon = null;
		$this->expanded_icon_icon = null;
		$this->tooltip = null;
		$this->target = null;
		$this->item_style = null;
		$this->xp_item_style = null;
	}

	public function clearItems() { $this->child_item_list = array(); }
}

endif;

?>
