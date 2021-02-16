 <?php

if(!defined('APYCOM_TABS_PHP')):
	define('APYCOM_TABS_PHP', true);

class Apycom_Tabs
{
	const POSITION_RELATIVE = 0;
	const POSITION_ABSOLUTE = 1;

###################################################################################################

	/* system */
	private $menu_orientation = 0; // reserved, always set to 0
	private $blank_image = null;
	private $selected_item = 0;
	private $selected_sub_item = 0;

	/* positioning */
	private $position = null;
	private $pos_x = 0;
	private $pos_y = 0;

	/* size */
	private $overal_width = null;
	private $overal_height = null;

	/* floating */
	private $is_floatable = false;
	private $float_iterations = 6;

	/* tabs look */
	private $background_color = null;
	private $background_image = null;
	private $border_width = 0;
	private $border_color = '#000000';
	private $border_style = 'solid';
	private $row_space = 0;

	/* tab item look */
	private $item_text_align = 'center';
	private $item_cursor = 'default';
	private $item_target = '_self';
	private $item_spacing = 0;
	private $item_padding = 0;

	private $item_before_space = 12;
	private $item_after_space = 20;

	private $item_before_image_normal = null;
	private $item_before_image_hover = null;
	private $item_before_image_selected = null;
	private $item_before_image_width = 5;
	private $item_before_image_height = 18;

	private $item_after_image_normal = null;
	private $item_after_image_hover = null;
	private $item_after_image_selected = null;
	private $item_after_image_width = 5;
	private $item_after_image_height = 18;

	private $item_font_style_normal = 'bold 8px Tahoma';
	private $item_font_style_hover = null;
	private $item_font_style_selected = null;
	private $item_font_color_normal = '#ffffff';
	private $item_font_color_hover = '#ffffff';
	private $item_font_color_selected = '#000000';
	private $item_font_decoration_normal = 'none';
	private $item_font_decoration_hover = 'none';
	private $item_font_decoration_selected = 'none';

	private $item_border_width = 0;
	private $item_border_color_normal = '#ffffff';
	private $item_border_color_hover = '#000000';
	private $item_border_color_selected = '#ffffff';
	private $item_border_style_normal = 'solid';
	private $item_border_style_hover = 'dotted';
	private $item_border_style_selected = 'solid';

	private $item_background_color_normal = '#ffffff';
	private $item_background_color_hover = '#ffffff';
	private $item_background_color_selected = '#ffffff';
	private $item_background_image_normal = null;
	private $item_background_image_hover = null;
	private $item_background_image_selected = null;

	/* icons */
	private $icon_align = 'left';
	private $icon_width = 16;
	private $icon_height = 16;

	/* separator */
	private $separator_width = 7;

	/* efects */
	private $transition = 0;
	private $transition_duration = 0;
	private $transition_options = null;

	/* subtabs look */
	private $enable_subtabs_border = true;

	private $subtabs_height = 0;
	private $subtabs_background_color = null;
	private $subtabs_border_width = 0;
	private $subtabs_border_color = '#AA0000';
	private $subtabs_border_style = 'solid';
	private $subtabs_item_text_align = 'center';
	private $subtabs_item_spacing = 0;
	private $subtabs_item_padding = 0;


###################################################################################################

	private $tab_style_list = array();
	private $tab_list = array();

###################################################################################################
# public
###################################################################################################

	public function __construct()
	{
		$this->position = self::POSITION_RELATIVE;
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
            $props = get_object_vars($this);

			if(array_key_exists($var_name, $props))
				return $this->$var_name;
			else
				throw new CN_Exception(sprintf(_("Property `%1\$s` is not defined in class `%2\$s`."), $var_name, __CLASS__));
		}
		else
			throw new CN_Exception(_("Unknown method call, use `set` or `get` for prefix."));
	}

###################################################################################################

	public function registerTabStyle(Apycom_TabStyle $tab_style) { $this->tab_style_list[$tab_style->getName()] = $tab_style; }

###################################################################################################

	public function addTabItem(Apycom_TabItem $tab, $row=1)
	{
		if($row > 1)
		{
			$row_token = str_repeat('$', $row - 1);

			$tab->setLabel($row_token.$tab->getLabel());
		}

		$this->tab_list[] = $tab;
	}

	public function addSeparator($style=null)
	{
		$separator = new Apycom_TabItem("-");

		if(!is_null($style))
			$separator->setTabStyle($style);
	}

###################################################################################################

	public function render($script_tags=true)
	{
		$variable_token = $this->getVariableToken();
		$tab_style_token = $this->getTabStyleToken();
		$tab_item_token = $this->getTabItemToken();

		$apycom_tabs =<<<APYCOM_TABS
		$variable_token\n
		$tab_style_token\n
		$tab_item_token\n

		apy_tabsInit();
APYCOM_TABS;

		###########################################################################################

		if($script_tags)
			$apycom_tabs = '<script type="text/javascript">'.$apycom_tabs.'</script>';

		###########################################################################################

		return $apycom_tabs;
	}

###################################################################################################
# private
###################################################################################################

	private function getVariableToken()
	{
		$system_token =<<<SYSTEM_TOKEN
		var bmenuOrientation = {$this->menu_orientation};
		var bblankImage = "{$this->blank_image}";
		var bselectedItem = {$this->selected_item};
		var bselectedSmItem = {$this->selected_sub_item};
SYSTEM_TOKEN;

		###########################################################################################

		$positioning_token =<<<POSITIONING_TOKEN
		var babsolute = {$this->position};
		var bleft = {$this->pos_x};
		var btop = {$this->pos_y};
POSITIONING_TOKEN;

		###########################################################################################

		$size_token =<<<SIZE_TOKEN
		var bmenuWidth = "{$this->overal_width}";
		var bmenuHeight = "{$this->overal_height}";
SIZE_TOKEN;

		###########################################################################################

		$is_floatable = (int)$this->is_floatable;

		$floating_token =<<<FLOATING_TOKEN
		var bfloatable = $is_floatable;
		var bfloatIterations = {$this->float_iterations};
FLOATING_TOKEN;

		###########################################################################################

		$tabs_look_token =<<<TABS_LOOK_TOKEN
		var bmenuBackColor = "{$this->background_color}";
		var bmenuBackImage = "{$this->background_image}";
		var bmenuBorderWidth = {$this->border_width};
		var bmenuBorderColor = "{$this->border_color}";
		var bmenuBorderStyle = "{$this->border_style}";
		var browSpace = {$this->row_space};
TABS_LOOK_TOKEN;

		###########################################################################################

		$item_before_image = '["'.$this->item_before_image_normal.'","'.$this->item_before_image_hover.'", "'.$this->item_before_image_selected.'"]';
		$item_after_image = '["'.$this->item_after_image_normal.'","'.$this->item_after_image_hover.'", "'.$this->item_after_image_selected.'"]';
		$item_font_style = '["'.$this->item_font_style_normal.'","'.$this->item_font_style_hover.'", "'.$this->item_font_style_selected.'"]';
		$item_font_color = '["'.$this->item_font_color_normal.'","'.$this->item_font_color_hover.'", "'.$this->item_font_color_selected.'"]';
		$item_font_decoration = '["'.$this->item_font_decoration_normal.'","'.$this->item_font_decoration_hover.'", "'.$this->item_font_decoration_selected.'"]';
		$item_border_color = '["'.$this->item_border_color_normal.'","'.$this->item_border_color_hover.'", "'.$this->item_border_color_selected.'"]';
		$item_border_style = '["'.$this->item_border_style_normal.'","'.$this->item_border_style_hover.'", "'.$this->item_border_style_selected.'"]';
		$item_background_color = '["'.$this->item_background_color_normal.'","'.$this->item_background_color_hover.'", "'.$this->item_background_color_selected.'"]';
		$item_background_image = '["'.$this->item_background_image_normal.'","'.$this->item_background_image_hover.'", "'.$this->item_background_image_selected.'"]';

		$item_look_token =<<<ITEM_LOOK_TOKEN
		var bitemAlign = "{$this->item_text_align}";
		var bitemCursor = "{$this->item_cursor}";
		var bitemTarget = "{$this->item_target}";
		var bitemSpacing = {$this->item_spacing};
		var bitemPadding = {$this->item_padding};

		var bbeforeItemSpace = {$this->item_before_space};
		var bafterItemSpace = {$this->item_after_space};

		var bbeforeItemImage = $item_before_image;
		var bbeforeItemImageW = $this->item_before_image_width;
		var bbeforeItemImageH = $this->item_before_image_height;

		var bafterItemImage = $item_after_image;
		var bafterItemImageW = $this->item_after_image_width;
		var bafterItemImageH = $this->item_after_image_height;

		var bfontStyle = $item_font_style;
		var bfontColor = $item_font_color;
		var bfontDecoration = $item_font_decoration;

		var bitemBorderWidth = {$this->item_border_width};
		var bitemBorderColor = $item_border_color;
		var bitemBorderStyle = $item_border_style;

		var bitemBackColor = $item_background_color;
		var bitemBackImage = $item_background_image;
ITEM_LOOK_TOKEN;

		###########################################################################################

		$icons_token =<<<ICONS_TOKEN
		var biconAlign = "{$this->icon_align}";
		var biconWidth = {$this->icon_width};
		var biconHeight = {$this->icon_height};
ICONS_TOKEN;

		###########################################################################################

		$separator_token =<<<SEPARATOR_TOKEN
		var bseparatorWidth = {$this->separator_width};
SEPARATOR_TOKEN;

		###########################################################################################

		$efects_token =<<<EFECTS_TOKEN
		var btransition = {$this->transition};
		var btransDuration = {$this->transition_duration};
		var btransOptions = "{$this->transition_options}";
EFECTS_TOKEN;

		###########################################################################################

		$enable_subtabs_border = (int)$this->enable_subtabs_border;

		$subtabs_look_token =<<<SUBTABS_LOOK_TOKEN
		var bsmBorderBottomDraw = $enable_subtabs_border;

		var bsmHeight = {$this->subtabs_height};
		var bsmBackColor = "{$this->subtabs_background_color}";
		var bsmBorderWidth = {$this->subtabs_border_width};
		var bsmBoderColor = "{$this->subtabs_border_color}";
		var bsmBorderStyle = "{$this->subtabs_border_style}";
		var bsmItemAlign = "{$this->subtabs_item_text_align}";
		var bsmItemSpacing = {$this->subtabs_item_spacing};
		var bsmItemPadding = {$this->subtabs_item_padding};
SUBTABS_LOOK_TOKEN;

		###########################################################################################

		$system_token = "\t".trim($system_token);
		$positioning_token = "\t".trim($positioning_token);
		$size_token = "\t".trim($size_token);
		$floating_token = "\t".trim($floating_token);
		$tabs_look_token = "\t".trim($tabs_look_token);
		$item_look_token = "\t".trim($item_look_token);
		$icons_token = "\t".trim($icons_token);
		$separator_token = "\t".trim($separator_token);
		$efects_token = "\t".trim($efects_token);
		$subtabs_look_token = "\t".trim($subtabs_look_token);

		###########################################################################################

		$variable_token =<<<VARIABLE_TOKEN
		$system_token\n
		$positioning_token\n
		$size_token\n
		$floating_token\n
		$tabs_look_token\n
		$item_look_token\n
		$icons_token\n
		$separator_token\n
		$efects_token\n
		$subtabs_look_token
VARIABLE_TOKEN;

		return $variable_token;
	}

###################################################################################################

	private function getTabStyleToken()
	{
		$tab_style_token = '[],';

		###########################################################################################

		foreach($this->tab_style_list as $tab_style)
		{
			$tab_style_token .= '[';

			$option_list = $tab_style->getOptionList();

			foreach($option_list as $option_name => $option_value)
				$tab_style_token .= sprintf('"%s=%s",', $option_name, $option_value);

			$tab_style_token = rtrim($tab_style_token, ',');

			$tab_style_token .= '],';
		}

		###########################################################################################

		return 'var bstyles = ['.rtrim($tab_style_token, ',').'];';
	}

###################################################################################################

	private function getTabItemToken()
	{
		$tab_items_token = null;

		###########################################################################################

		foreach($this->tab_list as $tab)
		{
			$label = $tab->getLabel();
			$object = $tab->getObject();
			$normal_icon = $tab->getNormalIcon();
			$hover_icon = $tab->getHoverIcon();
			$selected_icon = $tab->getSelectedIcon();
			$tooltip = $tab->getTooltip();
			$tab_style = $this->findStyleIndex($tab->getTabStyle());

			$tab_items_token .= sprintf('["%s", "%s", "%s", "%s", "%s", "%s", %s],', $label, $object, $normal_icon, $hover_icon, $selected_icon, $tooltip, $tab_style);
		}

		if(!is_null($tab_items_token))
			$tab_items_token = 'var bmenuItems = ['.rtrim($tab_items_token, ',').'];';
		else
			$tab_items_token = 'var bmenuItems = [];';

		###########################################################################################

		return $tab_items_token;
	}

###################################################################################################

	private function findStyleIndex($name)
	{
		if(!isset($this->tab_style_list[$name]))
			return null;

		$index = 0;

		foreach($this->tab_style_list as $style_name => $value)
		{
			if($style_name == $name)
				return $index + 1;

			++$index;
		}
	}
}

###################################################################################################
###################################################################################################
###################################################################################################

class Apycom_TabStyle
{
	private $name = null;

	private $option_list = array();

###################################################################################################
# public
###################################################################################################

	public function __construct($name) { $this->name = $name; }

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

class Apycom_TabItem
{
	private $label = null;
	private $object = null;
	private $normal_icon = null;
	private $hover_icon = null;
	private $selected_icon = null;
	private $tooltip = null;
	private $tab_style = null;

###################################################################################################
# public
###################################################################################################

	public function __construct($label=null, $object=null, $normal_icon=null, $hover_icon=null, $selected_icon=null, $tooltip=null, $tab_style=null)
	{
		$this->label = $label;
		$this->object = $object;
		$this->normal_icon = $normal_icon;
		$this->hover_icon = $hover_icon;
		$this->selected_icon = $selected_icon;
		$this->tooltip = $tooltip;
		$this->tab_style = $tab_style;
	}

###################################################################################################

	public function setLabel($label) { $this->label = trim($label); }
	public function setObject($object) { $this->object = trim($object); }
	public function setNormalIcon($normal_icon) { $this->normal_icon = trim($normal_icon); }
	public function setHoverIcon($hover_icon) { $this->hover_icon = trim($hover_icon); }
	public function setSelectedIcon($selected_icon) { $this->selected_icon = trim($selected_icon); }
	public function setTooltip($tooltip) { $this->tooltip = trim($tooltip); }
	public function setTabStyle($tab_style) { $this->tab_style = trim($tab_style); }

###################################################################################################

	public function getLabel() { return  $this->label; }
	public function getObject() { return $this->object; }
	public function getNormalIcon() { return $this->normal_icon; }
	public function getHoverIcon() { return $this->hover_icon; }
	public function getSelectedIcon() { return $this->selected_icon; }
	public function getTooltip() { return $this->tooltip; }
	public function getTabStyle() { return $this->tab_style; }

###################################################################################################

	public function clear()
	{
		$this->label = null;
		$this->object = null;
		$this->normal_icon = null;
		$this->hover_icon = null;
		$this->selected_icon = null;
		$this->tooltip = null;
		$this->tab_style = null;
	}
}

endif;

?>