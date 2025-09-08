 <?php

 use cms_modules\cms_catalog\classes\CMS_Catalog;

 if(!defined('APYCOM_MENU_PHP')):
	define('APYCOM_MENU_PHP', true);

class Apycom_Menu
{
	const ALIGNMENT_VERTICAL = 0;
	const ALIGNMENT_HORIZONTAL = 1;

	const POSITION_RELATIVE = 0;
	const POSITION_ABSOLUTE = 1;

###################################################################################################

	/* system */
	private $path_prefix = null;
	private $blank_image = null;
	private $status_string = 'link';
	private $pressed_item = '-2';

	/* positioning */
	private $alignment = null;
	private $position = null;

	private $pos_x = 190;
	private $pos_y = 160;
	private $top_dx = 0;
	private $top_dy = 0;
	private $dx = -3;
	private $dy = 0;

	private $submenu_alignment = 'left';

	/* size */
	private $menu_width = null;

	/* floating */
	private $is_floatable = false;
	private $float_iterations = 8;

	/* movement */
	private $is_movable = false;
	private $move_cursor = 'move';
	private $drag_spacer_image = null;
	private $drag_spacer_width = 12;
	private $drag_spacer_height = 24;

	/* menu look */
	private $background_image = null;
	private $background_color = '#ffffff';
	private $border_color = '#cccccc';
	private $border_style = 'solid';
	private $border_width = 1;

	private $font_style = null;
	private $font_color_normal = '#ffffff';
	private $font_color_hover = '#444444';
	private $font_decoration_normal = 'none';
	private $font_decoration_hover = 'none';

	/* item look */
	private $enable_highlighting = true;

	private $item_background_image_normal = null;
	private $item_background_image_hover = null;
	private $item_background_color_normal = '#ffffff';
	private $item_background_color_hover = '#4792e6';
	private $item_alignment = 'left';
	private $item_spacing = 0;
	private $item_padding = 4;
	private $item_cursor = 'default';
	private $item_default_target = '_self';
	private $item_border_color_normal = '#6655ff';
	private $item_border_color_hover = '#665500';
	private $item_border_style_normal = 'solid';
	private $item_border_style_hover = 'solid';
	private $item_border_width = 0;

	/* icons */
	private $icon_width = 16;
	private $icon_height = 16;
	private $icon_top_width = 24;
	private $icon_top_height = 24;

	/* arrow images */
	private $main_arrow_image_normal = null;
	private $main_arrow_image_hover = null;
	private $sub_image_arrow_normal = null;
	private $sub_image_arrow_hover = null;
	private $arrow_width = 9;
	private $arrow_height = 9;

	/* separator */
	private $separator_image = null;
	private $separator_width = '100%';
	private $separator_height = 3;
	private $separator_alignment = 'right';
	private $separator_vertical_image = null;
	private $separator_vertical_width = 5;
	private $separator_vertical_height = 16;

	/* effects */
	private $transparency = 0;
	private $transition = 3;
	private $trans_options = null;
	private $trans_duration = 300;
	private $shadow_color = '#777777';
	private $shadow_length = 3;
	private $enable_top_shadow = true;

###################################################################################################

	private $enable_css_mode = false;

	private $menu_style_list = array();
	private $item_style_list = array();
	private $item_list = array();

###################################################################################################

	private static $system_global_params = array();
	private static $system_global_entity_params = array();
	private static $system_entity_params = array();
	private static $menu_item_style_params = array();

###################################################################################################
# public
###################################################################################################

	public function __construct()
	{
		$this->alignment = self::ALIGNMENT_HORIZONTAL;
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

	//public function enableCssMode($enable) { $this->enable_css_mode = (bool)$enable; }

###################################################################################################

	public function registerItemStyle(Apycom_ItemStyle $item_style) { $this->item_style_list[$item_style->getName()] = $item_style; }
	public function registerMenuStyle(Apycom_MenuStyle $menu_style) { $this->menu_style_list[$menu_style->getName()] = $menu_style; }

###################################################################################################

	public function addItem(Apycom_MenuItem $item) { $this->item_list[] = $item; }
	public function getItems() { return $this->item_list; }

###################################################################################################

	public function render($script_tags=true)
	{
		$variabale_token = $this->getVariableToken();
		$menu_style_token = $this->getMenuStyleToken();
		$item_style_token = $this->getItemStyleToken();
		$menu_item_token = $this->getMenuItemToken();

		###########################################################################################

		$apycom_menu =<<<APYCOM_MENU
		$variabale_token\n
		$menu_style_token\n
		$item_style_token\n
		$menu_item_token

		apy_init();\n
APYCOM_MENU;

		###########################################################################################

		if($script_tags)
			$apycom_menu = '<script type="text/javascript">'.$apycom_menu.'</script>';

		###########################################################################################

		return $apycom_menu;
	}

###################################################################################################
# private
###################################################################################################

	private function getVariableToken()
	{
		$enable_css_mode = $this->enable_css_mode == 'true' ? 1 : 0;

		$system_token =<<<SYSTEM_TOKEN
			var pathPrefix = "{$this->path_prefix}";
			var blankImage = "{$this->blank_image}";
			var statusString = "{$this->status_string}";
			var pressedItem = {$this->pressed_item};

			var cssStyle = $enable_css_mode;
SYSTEM_TOKEN;

		###########################################################################################

		$positioning_token =<<<POSITIONING_TOKEN
			var isHorizontal = {$this->alignment};
			var absolutePos = {$this->position};

			var posX = {$this->pos_x};
			var posY = {$this->pos_y};
			var topDX = {$this->top_dx};
			var topDY = {$this->top_dy};
			var DX = {$this->dx};
			var DY = {$this->dy};

			var subMenuAlign = "{$this->submenu_alignment}";
POSITIONING_TOKEN;

		###########################################################################################

		$menu_width = is_null($this->menu_width) ? '0' : $this->menu_width;

		$size_token =<<<SIZE_TOKEN
			var menuWidth = "{$menu_width}";
SIZE_TOKEN;

		###########################################################################################

		$is_floatable = (int)$this->is_floatable;

		$floating_token =<<<FLOATING_TOKEN
			var floatable = {$is_floatable};
			var floatIterations = {$this->float_iterations};
FLOATING_TOKEN;

		###########################################################################################

		$is_movable = (int)$this->is_movable;

		$movement_token =<<<MOVEMENT_TOKEN
			var movable = {$is_movable};
			var moveCursor = "{$this->move_cursor}";
			var moveImage = "{$this->drag_spacer_image}";
			var moveWidth = {$this->drag_spacer_width};
			var moveHeight = {$this->drag_spacer_height};
MOVEMENT_TOKEN;

		###########################################################################################

		$menu_look_token =<<<MENU_LOOK_TOKEN
			var menuBackImage = "{$this->background_image}";
			var menuBackColor = "{$this->background_color}";
			var menuBorderColor = "{$this->border_color}";
			var menuBorderStyle = ["{$this->border_style}"];
			var menuBorderWidth = $this->border_width;

			var fontStyle = "{$this->font_style}";
			var fontColor = ["{$this->font_color_normal}", "{$this->font_color_hover}"];
			var fontDecoration = ["{$this->font_decoration_normal}", "{$this->font_decoration_hover}"];
MENU_LOOK_TOKEN;

		###########################################################################################

		$enable_highlighting = $this->enable_highlighting == 'true' ? 1 : 0;

		$item_look_token =<<<ITEM_LOOK_TOKEN
			var saveNavigationPath = $enable_highlighting;

			var itemBackImage = ["{$this->item_background_image_normal}", "{$this->item_background_image_hover}"];
			var itemBackColor = ["{$this->item_background_color_normal}", "{$this->item_background_color_hover}"];
			var itemAlign = "{$this->item_alignment}";
			var itemSpacing = {$this->item_spacing};
			var itemPadding = {$this->item_padding};
			var itemCursor = "{$this->item_cursor}";
			var itemTarget = "{$this->item_default_target}";
			var itemBorderColor = ["{$this->item_border_color_normal}", "{$this->item_border_color_hover}"];
			var itemBorderStyle = ["{$this->item_border_style_normal}", "{$this->item_border_style_hover}"];
			var itemBorderWidth = {$this->item_border_width};
ITEM_LOOK_TOKEN;

		###########################################################################################

		$icons_token =<<<ICONS_TOKEN
			var iconWidth = {$this->icon_width};
			var iconHeight = {$this->icon_height};
			var iconTopWidth = {$this->icon_top_width};
			var iconTopHeight = {$this->icon_top_height};
ICONS_TOKEN;

		###########################################################################################

		$arrow_images_token =<<<ARROW_IMAGES_TOKEN
			var arrowImageMain = ["{$this->main_arrow_image_normal}", "{$this->main_arrow_image_hover}"];
			var arrowImageSub = ["{$this->sub_image_arrow_normal}", "{$this->sub_image_arrow_hover}"];
			var arrowWidth = {$this->arrow_width};
			var arrowHeight = {$this->arrow_height};
ARROW_IMAGES_TOKEN;

		###########################################################################################

		$separator_token =<<<SEPARATOR_TOKEN
			var separatorImage = "{$this->separator_image}";
			var separatorWidth = "{$this->separator_width}";
			var separatorHeight = {$this->separator_height};
			var separatorAlignment = "{$this->separator_alignment}";
			var separatorVImage = "{$this->separator_vertical_image}";
			var separatorVWidth = {$this->separator_vertical_width};
			var separatorVHeight = {$this->separator_vertical_height};
SEPARATOR_TOKEN;

		###########################################################################################

		$enable_top_shadow = (int)$this->enable_top_shadow;

		$effects_token =<<<EFFECTS_TOKEN
			var transparency = {$this->transparency};
			var transition = {$this->transition};
			var transOptions = "{$this->trans_options}";
			var transDuration = {$this->trans_duration};
			var shadowColor = "{$this->shadow_color}";
			var shadowLen = {$this->shadow_length};
			var shadowTop = $enable_top_shadow;
EFFECTS_TOKEN;

		###########################################################################################

		$system_token = "\t".trim($system_token);
		$positioning_token = "\t".trim($positioning_token);
		$size_token = "\t".trim($size_token);
		$floating_token = "\t".trim($floating_token);
		$movement_token = "\t".trim($movement_token);
		$menu_look_token = "\t".trim($menu_look_token);
		$item_look_token = "\t".trim($item_look_token);
		$icons_token = "\t".trim($icons_token);
		$arrow_images_token = "\t".trim($arrow_images_token);
		$separator_token = "\t".trim($separator_token);

		$effects_token = "\t".trim($effects_token);

		###########################################################################################

		$variable_token =<<<VARIABLE_TOKEN
		$system_token\n
		$positioning_token\n
		$size_token\n
		$floating_token\n
		$movement_token\n
		$menu_look_token\n
		$item_look_token\n
		$icons_token\n
		$arrow_images_token\n
		$separator_token

		$effects_token
VARIABLE_TOKEN;

		return $variable_token;
	}

###################################################################################################

	private function getMenuStyleToken()
	{
		$menu_style = '[], ';

		###########################################################################################

		foreach($this->menu_style_list as $menu)
		{
			$menu_style .= '[';

			$option_list = $menu->getOptionList();

			foreach($option_list as $option_name => $option_value)
				$menu_style	.= sprintf('"%s=%s", ', $option_name, $option_value);

			$menu_style .= '],';
		}

		###########################################################################################

		return 'var menuStyles = ['.rtrim($menu_style, ',').'];';
	}

###################################################################################################

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

		return 'var itemStyles = ['.rtrim($item_style, ',').'];';
	}

###################################################################################################

	private function getMenuItemToken()
	{
		$menu_items = null;

		###########################################################################################

		foreach($this->item_list as $item)
		{
			$label = $item->getLabel();
			$link = $item->getLink();
			$normal_icon = $item->getNormalIcon();
			$hover_icon = $item->getHoverIcon();
			$tooltip = $item->getTooltip();
			$target = $item->getTarget();
			$item_style = $this->findStyleIndex($item->getItemStyle(), 'item');
			$menu_style = $this->findStyleIndex($item->getMenuStyle(), 'menu');

			$menu_items .= sprintf('["%s", "%s", "%s", "%s", "%s", "%s", %s, %s],', $label, $link, $normal_icon, $hover_icon, $tooltip, $target, $item_style, $menu_style);

			if(count($item->getChildItemList()))
				$menu_items .= $this->buildSubMenu($item, 1);
		}

		if(!is_null($menu_items))
			$menu_items = 'var menuItems = ['.rtrim($menu_items, ',').'];';
		else
			$menu_items = 'var menuItems = [];';

		###########################################################################################

		return $menu_items;
	}

	private function buildSubMenu(Apycom_MenuItem $parent_item, $level)
	{
		$child_items = null;
		$child_item_list = $parent_item->getChildItemList();

		foreach($child_item_list as $item)
		{
			$label = str_repeat('|', $level).$item->getLabel();
			$link = $item->getLink();
			$normal_icon = $item->getNormalIcon();
			$hover_icon = $item->getHoverIcon();
			$tooltip = $item->getTooltip();
			$target = $item->getTarget();
			$item_style = $this->findStyleIndex($item->getItemStyle(), 'item');
			$menu_style = $this->findStyleIndex($item->getMenuStyle(), 'menu');

			$child_items .= sprintf('["%s", "%s", "%s", "%s", "%s", "%s", %s, %s],', $label, $link, $normal_icon, $hover_icon, $tooltip, $target, $item_style, $menu_style);

			#######################################################################################

			if(count($item->getChildItemList()) > 0)
				$child_items .= $this->buildSubMenu($item, $level + 1);
		}

		return $child_items;
	}

###################################################################################################

	private function findStyleIndex($name, $type)
	{
		$search_target = $type == 'item' ? $this->item_style_list : $this->menu_style_list;

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

	public static function loadFromFile($file_name,$show_title_as_image = false, $show_title_image_text = false)
	{
		if(!is_readable($file_name))
			throw new CN_Exception(sprintf(_("Definition file `%s` isn't readable or file doesn't exists."), $file_name), E_ERROR);

		# basic variable declaration ##############################################################

		if(function_exists('ioncube_read_file'))
			$xml = simplexml_load_string(ioncube_read_file($file_name));
		else
			$xml = simplexml_load_file($file_name);

		$apycom_menu = new Apycom_Menu();

		###########################################################################################
		# load system params ######################################################################

		# global ##################################################################################

		foreach($xml->system_params[0]->global_params[0] as $param)
			self::$system_global_params[(string)$param['name']] = (string)$param['value'];

		# global entity ###########################################################################
		if(isset($xml->system_params[0]->global_entity_params[0])){
			foreach($xml->system_params[0]->global_entity_params[0] as $entity_node)
			{
				$id_tag = (string)$entity_node['type'];

				$params = array();

				foreach($entity_node as $param)
					$params[(string)$param['name']] = (string)$param['value'];

				self::$system_global_entity_params[$id_tag] = $params;
			}
		}


		# entity ##################################################################################

		foreach($xml->system_params[0]->entity_params[0] as $entity_node)
		{
			$id_tags = (string)$entity_node['id'].'.'.(string)$entity_node['type'];

			$params = array();

			foreach($entity_node as $param)
				$params[(string)$param['name']] = (string)$param['value'];

			self::$system_entity_params[$id_tags] = $params;
		}

		###########################################################################################
		# load menu global params #################################################################

		foreach($xml->menu_params[0]->global_params[0] as $param)
		{
			$param_name = (string)$param['name'];
			$param_value = (string)$param['value'];

			if($param_name == 'orientation') // special case, naming inconsistency
			{
				$param_name = 'alignment';
				$param_value = $param_value == 'vertical' ? self::ALIGNMENT_VERTICAL : self::ALIGNMENT_HORIZONTAL;
			}

			$method_name = 'set'.CN_Utils::getObjectName($param_name);

			$apycom_menu->$method_name($param_value);
		}

		###########################################################################################
		# load menu styles ########################################################################

		foreach($xml->menu_params[0]->menu_styles[0] as $menu_style_node)
		{
			$menu_style = new Apycom_MenuStyle((string)$menu_style_node['name']);

			foreach($menu_style_node as $param)
				$menu_style->setOption((string)$param['name'], (string)$param['value']);

			$apycom_menu->registerMenuStyle($menu_style);
		}

		###########################################################################################
		# load item styles ########################################################################

		foreach($xml->menu_params[0]->item_styles[0] as $item_style_node)
		{
			$style_name = (string)$item_style_node['name'];
			$item_style = new Apycom_ItemStyle($style_name);

			if(isset($item_style_node['apply_to']))
				self::$menu_item_style_params[(string)$item_style_node['apply_to']] = $style_name;

			#######################################################################################

			foreach($item_style_node as $param)
				$item_style->setOption((string)$param['name'], (string)$param['value']);

			$apycom_menu->registerItemStyle($item_style);
		}

		###########################################################################################
		# static content ##########################################################################

		###########################################################################################
		# dynamic content #########################################################################

		if(isset(self::$system_global_params['menu_id']))
		{
			$menu = new CMS_Menu(self::$system_global_params['menu_id']);
			$menu_items = $menu->getItems(null, true);

			foreach($menu_items as $item)
			{
				if(CMS_Privileges::checkWebAccessPrivilege($item) === false)
					continue;

				if(
					isset(self::$system_global_entity_params[$item->getType()])
					&&
					isset(self::$system_global_entity_params[$item->getType()]['disabled'])
					&&
					self::$system_global_entity_params[$item->getType()]['disabled'] == 'true'
					)
					continue;

				$apycom_menu_item = new Apycom_MenuItem();

				if($show_title_as_image)
					$apycom_menu_item->setLabel("<img src='mediafiles/".$item->getImage()."'  />");
				elseif($show_title_image_text)
				{
					if ($item->getType() != 100)
					{
						$apycom_menu_item->setNormalIcon($item->getImage());
						$apycom_menu_item->setHoverIcon($item->getImage());
					}

					$apycom_menu_item->setLabel($item->getTitle());
				}
				else
					$apycom_menu_item->setLabel($item->getTitle());

				$page = str_replace('CMS_', '', CMS_Entity::getEntityNameById($item->getType()));
				$apycom_menu_item->setLink("./$page:{$item->getId()}");

				$id_tag = "{$item->getId()}.{$item->getType()}";

				self::applyGlobalItemParams($item ,$apycom_menu_item);
				self::applyCustomItemParams($id_tag, $item, $apycom_menu_item);

				if(isset(self::$system_entity_params[$id_tag]['expand']) && self::$system_entity_params[$id_tag]['expand'] == 'true')
				{
					if(isset(self::$system_entity_params[$id_tag]['show_expand_caption']) && self::$system_entity_params[$id_tag]['show_expand_caption'] == 'true')
						$apycom_menu->addItem($apycom_menu_item);

					self::buildExpandedTree($item, $apycom_menu, null, $show_title_as_image, $show_title_image_text);
				}
				else
				{
					self::buildSubTree($item, $apycom_menu_item, $show_title_as_image, $show_title_image_text);

					$apycom_menu->addItem($apycom_menu_item,$show_title_as_image, $show_title_image_text);
				}
			}
		}

		return $apycom_menu;
	}

###################################################################################################
# private static
###################################################################################################

	private static function buildSubTree(& $parent_item, & $parent_apycom_menu_item, $show_title_as_image = false, $show_title_image_text = false)
	{
		$item_list = null;

		if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('cms_modules\cms_catalog\classes\CMS_Catalog') === true && $parent_item->getType() === CMS_Catalog::ENTITY_ID)
			$item_list = $parent_item->getChildren(true);
		elseif($parent_item instanceof CMS_Category)
			$item_list = $parent_item->getItems(null, true);

		if($item_list !== null)
		{
			foreach($item_list as $item)
			{
				if(CMS_Privileges::checkWebAccessPrivilege($item) === false)
					continue;

				if(
					isset(self::$system_global_entity_params[$item->getType()])
					&&
					isset(self::$system_global_entity_params[$item->getType()]['disabled'])
					&&
					self::$system_global_entity_params[$item->getType()]['disabled'] == 'true'
					)
					continue;

				$apycom_menu_item = new Apycom_MenuItem();
				//$apycom_menu_item->setLabel($item->getTitle());

				if($show_title_as_image)
					$apycom_menu_item->setLabel("<img src='mediafiles/".$item->getImage()."'  />");
				elseif($show_title_image_text)
				{
					$apycom_menu_item->setNormalIcon($item->getImage());
					$apycom_menu_item->setHoverIcon($item->getImage());
					$apycom_menu_item->setLabel($item->getTitle());
				}
				else
					$apycom_menu_item->setLabel($item->getTitle());

				$page = str_replace('CMS_', '', CMS_Entity::getEntityNameById($item->getType()));
				$apycom_menu_item->setLink("./$page:{$item->getId()}");

				$id_tag = "{$item->getId()}.{$item->getType()}";

				self::applyGlobalItemParams($item ,$apycom_menu_item);
				self::applyCustomItemParams($id_tag, $item, $apycom_menu_item);

				if(isset(self::$system_entity_params[$id_tag]['expand']) && self::$system_entity_params[$id_tag]['expand'] == 'true')
				{
					$apycom_menu_item = (isset(self::$system_entity_params[$id_tag]['show_expand_caption']) && self::$system_entity_params[$id_tag]['show_expand_caption'] == 'true') ? $apycom_menu_item : null;

					self::buildExpandedTree($item, $parent_apycom_menu_item, $apycom_menu_item, $show_title_as_image, $show_title_image_text);
				}
				else
					self::buildSubTree($item, $apycom_menu_item, $show_title_as_image, $show_title_image_text);

				if(!isset(self::$system_entity_params[$id_tag]['expand']) || self::$system_entity_params[$id_tag]['expand'] == 'false')
					$parent_apycom_menu_item->addChildItem($apycom_menu_item);
			}
		}
	}

	private static function buildExpandedTree(& $parent_item, & $parent_apycom, $base_apycom_menu_item=null,$show_title_as_image = false, $show_title_image_text = false)
	{
		if($base_apycom_menu_item !== null)
		{
			if($parent_apycom instanceof Apycom_Menu)
				$parent_apycom->addItem($base_apycom_menu_item);
			elseif($parent_apycom instanceof Apycom_MenuItem)
				$parent_apycom->addChildItem($base_apycom_menu_item);
		}

		#######################################################################################

		$item_list = null;

		if(CMS_ProjectConfig::getSingleton()->checkModuleAvailability('cms_modules\cms_catalog\classes\CMS_Catalog') === true && $parent_item->getType() === CMS_Catalog::ENTITY_ID)
			$item_list = $parent_item->getChildren(true);
		elseif($parent_item instanceof CMS_Category)
			$item_list = $parent_item->getItems(null, true);

		if($item_list !== null)
		{
			foreach($item_list as $item)
			{
				if(CMS_Privileges::checkWebAccessPrivilege($item) === false)
					continue;

				if(
					isset(self::$system_global_entity_params[$item->getType()])
					&&
					isset(self::$system_global_entity_params[$item->getType()]['disabled'])
					&&
					self::$system_global_entity_params[$item->getType()]['disabled'] == 'true'
					)
					continue;

				$apycom_menu_item = new Apycom_MenuItem();
				if($show_title_as_image)
					$apycom_menu_item->setLabel("<img src='mediafiles/".$item->getImage()."'  />");
				elseif($show_title_image_text)
				{
					$apycom_menu_item->setNormalIcon($item->getImage());
					$apycom_menu_item->setHoverIcon($item->getImage());
					$apycom_menu_item->setLabel($item->getTitle());
				}
				else
					$apycom_menu_item->setLabel($item->getTitle());

				$page = str_replace('CMS_', '', CMS_Entity::getEntityNameById($item->getType()));
				$apycom_menu_item->setLink("./$page:{$item->getId()}");

				$id_tag = "{$item->getId()}.{$item->getType()}";

				self::applyGlobalItemParams($item ,$apycom_menu_item);
				self::applyCustomItemParams($id_tag, $item, $apycom_menu_item);

				###################################################################################

				if(isset(self::$system_entity_params[$id_tag]['expand']) && self::$system_entity_params[$id_tag]['expand'] == 'true')
				{
					$apycom_menu_item = (isset(self::$system_entity_params[$id_tag]['show_expand_caption']) && self::$system_entity_params[$id_tag]['show_expand_caption'] == 'true') ? $apycom_menu_item : null;

					self::buildExpandedTree($item, $parent_apycom, $apycom_menu_item, $show_title_as_image, $show_title_image_text);
				}
				else
					self::buildSubTree($item, $apycom_menu_item, $show_title_as_image, $show_title_image_text);

				###################################################################################

				if(!isset(self::$system_entity_params[$id_tag]['expand']) || self::$system_entity_params[$id_tag]['expand'] == 'false')
				{
					if($parent_apycom instanceof Apycom_Menu)
						$parent_apycom->addItem($apycom_menu_item);
					elseif($parent_apycom instanceof Apycom_MenuItem)
						$parent_apycom->addChildItem($apycom_menu_item);
				}
			}
		}
	}

###################################################################################################
# apply item params ###############################################################################

	private static function applyGlobalItemParams(& $item, & $apycom_menu_item)
	{
		if($item instanceof CMS_Weblink)
			$apycom_menu_item->setTarget($item->getTarget());

		if(isset(self::$menu_item_style_params['all'])) 										// apply global item style
			$apycom_menu_item->setItemStyle(self::$menu_item_style_params['all']);
		if(isset(self::$menu_item_style_params[$item->getType()])) 								// apply style for one type
			$apycom_menu_item->setItemStyle(self::$menu_item_style_params[$item->getType()]);

		if(isset(self::$system_global_params['show_tooltip']))
		{
			if(self::$system_global_params['show_tooltip'] == 'true')
				;//$apycom_menu_item->setTooltip(nl2br($item->getDescription()));
		}

		if(isset(self::$system_global_params['target']))
		{
			if($item instanceof CMS_Weblink)
				;
			else
				$apycom_menu_item->setTarget(self::$system_global_params['target']);
		}
	}

	private static function applyCustomItemParams($id_tag, & $item, & $apycom_menu_item)
	{
		if(isset(self::$system_entity_params[$id_tag]))
		{
			if(isset(self::$system_entity_params[$id_tag]['menu_style']))				// apply custom style for menu
				$apycom_menu_item->setMenuStyle(self::$system_entity_params[$id_tag]['menu_style']);
			if(isset(self::$system_entity_params[$id_tag]['item_style']))				// apply custom style for item
				$apycom_menu_item->setItemStyle(self::$system_entity_params[$id_tag]['item_style']);

			if(isset(self::$system_entity_params[$id_tag]['normal_icon']))
				$apycom_menu_item->setNormalIcon(self::$system_entity_params[$id_tag]['normal_icon']);
			if(isset($system_entity_params[$id_tag]['hover_icon']))
				$apycom_menu_item->setHoverIcon(self::$system_entity_params[$id_tag]['hover_icon']);

			if(isset(self::$system_entity_params[$id_tag]['show_tooltip']))
			{
				if(self::$system_entity_params[$id_tag]['show_tooltip'] == 'true')
					;//$apycom_menu_item->setTooltip($item->getDescription());
			}

			if(isset(self::$system_entity_params[$id_tag]['target']))
				$apycom_menu_item->setTarget(self::$system_entity_params[$id_tag]['target']);
		}
	}
}

###################################################################################################
###################################################################################################
###################################################################################################
###################################################################################################

class Apycom_ItemStyle
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

class Apycom_MenuStyle
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
			;
	}
}

###################################################################################################
###################################################################################################
###################################################################################################

class Apycom_MenuItem
{
	private $label = null;
	private $link = null;
	private $normal_icon = null;
	private $hover_icon = null;
	private $tooltip = null;
	private $target = null;
	private $item_style = null;
	private $menu_style = null;

	private $child_item_list = array();

###################################################################################################
# public
###################################################################################################

	public function __construct($label=null, $link=null, $normal_icon=null, $hover_icon=null, $tooltip=null, $target=null, $item_style=null, $menu_style=null)
	{
		$this->label = trim($label);
		$this->link = trim($link);
		$this->normal_icon = trim($normal_icon);
		$this->hover_icon = trim($hover_icon);
		$this->tooltip = trim($tooltip);
		$this->target = trim($target);
		$this->item_style = trim($item_style);
		$this->menu_style = trim($menu_style);
	}

###################################################################################################

	public function setLabel($label) { $this->label = trim($label); }
	public function setLink($link) { $this->link = trim($link); }
	public function setNormalIcon($normal_icon) { $this->normal_icon = trim($normal_icon); }
	public function setHoverIcon($hover_icon) { $this->hover_icon = trim($hover_icon); }
	public function setTooltip($tooltip) { $this->tooltip = trim($tooltip); }
	public function setTarget($target) { $this->target = trim($target); }
	public function setItemStyle($item_style) { $this->item_style = trim($item_style); }
	public function setMenuStyle($menu_style) { $this->menu_style = trim($menu_style); }

###################################################################################################

	public function getLabel() { return $this->label; }
	public function getLink() { return $this->link; }
	public function getNormalIcon() { return $this->normal_icon; }
	public function getHoverIcon() { return $this->hover_icon; }
	public function getTooltip() { return $this->tooltip; }
	public function getTarget() { return $this->target; }
	public function getItemStyle() { return $this->item_style; }
	public function getMenuStyle() { return $this->menu_style; }

###################################################################################################

	public function getChildItemList() { return $this->child_item_list; }

###################################################################################################

	public function addChildItem(Apycom_MenuItem $child_item) { $this->child_item_list[] = $child_item; }

###################################################################################################

	public function clear()
	{
		$this->label = null;
		$this->link = null;
		$this->normal_icon = null;
		$this->hover_icon = null;
		$this->tooltip = null;
		$this->target = null;
		$this->item_style = null;
		$this->menu_style = null;

		$this->child_item_list = array();
	}

	public function clearItems() { $this->child_item_list = array(); }
}

endif;

?>
