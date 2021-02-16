<?php
class TPL_List
{

	// MINI MANUAL TPL_List 20.9.2006 REMO
	
	// setTable ('border',1)
	// setTr ('bgcolor','#f3f3f3')
	// setTd ('bgcolor','#f3f3f3')
	// setHeadTr ('bgcolor','#f3f3f3')
	// setLineTr ('bgcolor','#f3f3f3')
	// setListTr ('bgcolor','#f3f3f3')
	
	// setPropertyXx(y) - nastavi vlastnost xx na hodnotu y
	// getPropertyXx() - vrati hodnotu vlastnosti xx
	
	// setColumn ('nazov stlpca', 'nazov vlastnosti', 'hodnota vlastnosti') nazov a hodnota vlastnosti su nepovinne
	
	//	 podporovane nazvy stlpcov su :
	
	// 	NUMBER
	//		title	{#}
	//		header_properties
	//		list_properties
	
	//	CHECKBOX
	//		title
	//		header_properties
	//		list_properties
	
	//	ENTITY_FLAG
	//		title
	//		header_properties
	//		list_properties
	
	//	TITLE
	//		title	{tr('Názov')}
	//		orderby	{TRUE}
	//		orderby_code	{'title'}
	//		onclick		{TRUE}
	//		privileges
	//		view_language_tag	{TRUE}
	//		href	{'./?cmd={FUNCTION_getObjectType_<OBJECT>_"updatelink"}&row_id[]=<ID>&s_category=<_GET_s_category>'}
	//		header_properties	{'class="td_valign_top"'}
	//		list_properties
	
	//	TRANSLATION
	//		title	{tr('Preklad')}
	//		header_properties	{'class="td_valign_top_center"'}
	//		list_properties
	//		onclick		{TRUE}
	//		privileges
	//		href	{'./?cmd={FUNCTION_getObjectType_<OBJECT>_"updatelink"}&row_id[]=<ID>&s_category=<_GET_s_category>&setLocalLanguage=<LANGUAGE>'}
	
	//	VISIBILITY
	//		title	{tr('Viditenosť')}
	//		orderby		{TRUE}
	//		orderby_code	{'visibility'}
	//		header_properties	{'class="td_valign_top_center"'}
	//		list_properties		{'class="td_align_center"'}
	//		onclick		{TRUE}
	//		privileges
	//		href	{'javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isPublished\',<VISIBILITY_NEQ>,\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"section"}\',\'box<INCREMENT>\')'}
	
	//	ORDER
	//		title	{tr('Poradie')}
	//		header_properties	{'class="td_valign_top_center"'}
	//		list_properties	{'class="td_align_center"'}
	//		orderby	{TRUE}
	//		orderby_code	{'order'}
	//		href_down	{'javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_down_in_menu\',{FUNCTION_getObjectType_<OBJECT>_"number"},\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"realname"}\',\'box<INCREMENT>\')'}
	//		href_up		{'javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_up_in_menu\',{FUNCTION_getObjectType_<OBJECT>_"number"},\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"realname"}\',\'box<INCREMENT>\')'}
	//		privileges
	//		onclick	{TRUE}
	
	//	ID
	//		title	{tr('ID')}
	//		header_properties	{'class="td_valign_top_center"'}
	//		list_properties
	//		orderby	{TRUE}
	//		orderby_code	{'id'}
	
	//	PARENT_MENU
	//		title	{tr('Nadradené menu')}
	//		header_properties	{'class="td_valign_top"'}
	//		list_properties
	
	//	PARENT_CATEGORY
	//		title	{tr('Nadradená kategória')}
	//		header_properties	{'class="td_valign_top"'}
	//		list_properties
	
	//	ENTITY_NAME
	//		title	{tr('Typ záznamu')}
	//		header_properties	{'class="td_valign_top"'}
	//		list_properties
	
	//	VALIDITY
	//		title	{'class="td_valign_top"'}
	//		header_properties
	//		list_properties
	
	//	AUTHOR
	//		title	{tr('Autor')}
	//		header_properties	{'class="td_valign_top"'}
	//		list_properties
	
	//	DATE
	//		title	{tr('Dátum')}
	//		header_properties	{'class="td_valign_top"'}
	//		list_properties
	//		orderby		{TRUE}
	//		orderby_code	{'date'}
	//		date_format	{'j.n.Y H:i'}
	
	//	FLASH_NEWS
	//		title	{tr('Flash novinka')}
	//		header_properties	{'class="td_valign_top"'}
	//		list_properties
	
	//	NEWS
	//		title	{tr('Novinka')}
	//		header_properties	{'class="td_valign_top"'}
	//		list_properties
	
	//	FRONTPAGE
	//		title	{tr('Frontpage')}
	//		header_properties	{'class="td_valign_top"'}
	//		list_properties
	
	//	BINDINGS_MENU
	//		title	{tr('Väzby menu')}
	//		header_properties	{'class="td_valign_top"'}
	//		list_properties
	//		onclick		{TRUE}
	//		privileges
	//		href	{'./?cmd=23&s_category=<ID>'}
	
	//	BINDINGS_CATEGORY
	//		title	{tr('Väzby kategórie')}
	//		header_properties	{'class="td_valign_top"'}
	//		list_properties
	//		onclick	{TRUE}
	//		privileges
	//		href	{'./?cmd=22&s_category=<ID>'}
	
	//	ACCESS
	//		title	{tr('Práva')}
	//		header_properties
	//		list_properties

	// ZOZNAM VSETKYCH VLASTNOSTI STLPCOV :
	
	//	title - nazov stlpca
	//	orderby - bool order by
	//	orderby_code - kod zasielany v url pri orderby napr. title
	//	onclick - bool ci sa da kliknut na dany link
	//	privileges - array list prav ktore sa vztahuju na polozku v logike OR
	//	view_language_tag - bool ci ma doplnat [default_language] v nazvoch ak nie je dana jazykova verzia vyplnena
	//	href* - pattern odkazu
	//	header_properties - vlastnosti bunky TD v prvom riadku tabulky
	//	list_properties - vlastnosti bunky TD v ostatnych riadkoch tabulky
	//	date_format - datumovy format pre funkciu DATE napr. "j.n.Y H:i"
	//	href_down* - pattern odkazu pri order
	//	href_up* - pattern odkazu pri order
	
	
	// ZOZNAM HLAVNYCH VLASTNOSTI
	
	//	show_tr_line - bool zobrazit oddelovaciu ciaru
	//	show_is_trash - bool testuje ci sa dany objekt nenachadza v kosi
	//	img_path - cesta k obrazkom
	//	form_name - nazov formulara
	//	table_properties - vlastnasti tabulky napr. class='tb_list2'
	//	cell_properties - vlastnosti vsetkych buniek
	//	row_properties - vlastnosti riadka
	//	head_row_properties - vlastnosti prveho riadka <tr ..vlastnosti..>
	//	line_row_properties* - vlastnosti ostatnych riadkov <tr ..vlastnosti..>
	
	// * uvedene vlastnosti prechadzaju cez translator

	// TRANSLATE PATTERN
	//	<ID> - nahradi aktualne id objektu
	//	<LANGUAGE> - nahradi $input['language_id']
	//	<VISIBILITY_NEQ> - nahradi $input['visibility_neq']
	//	<INCREMENT> - nahradi aktualne cislo riadka
	//	<FORM_NAME> - nahradi nazvom formulara
	//	<MAX_LIST> - nahradi cislom maximalneho poctu prave zobrazovanych zaznamov
	//	<_GET_nazov> - doplni $_GET['nazov']
	//	<_POST_nazov> - doplni $_POST['nazov']
	//	<_REQUEST_nazov> - doplni $_REQUEST['nazov']
	//	<GLOBALS_nazov> - doplni $GLOBALS['nazov']
	//	<_SESSION_nazov> - doplni $_SESSION['nazov']
	//	<OBJECT> - nahradi aktualnym objektom pouziva sa v parametri funkcie
	//	{FUNCTION_nazov_parameter_parameter_parameter....} - zavola funkciu(nazov) a posle jej dane parametre
	
	
	public $COL = array();
	
	protected $column = array();
	
	protected $list = null;
	
	protected $max_list = 0;
	
	protected $colspan = 0;
	
	protected $increment_row_number = 1;
	
	protected $increment_id = 1;
	
	protected $show_tr_line = TRUE;
	
	protected $show_is_trash = FALSE;
	
	protected $img_path = 'images/';
	
	protected $form_name = 'form1';
	
	protected $table_properties = 'class="tb_list2"';
	
	protected $cell_properties = '';
	
	protected $row_properties = '';
	
	protected $head_row_properties = 'class="tr_header"';
	
	protected $line_row_properties = 'class="td_link_space"';
	
	// OLD SCRIPT : protected $list_row_properties = 'onmouseover="pozadie(\'#f5f5f5\',this)" onmouseout="pozadie(\'#ffffff\',this)"';
	
	protected $list_row_properties = 'id="row<INCREMENT>" onmouseover="pozadieIN(\'<FORM_NAME>\',\'<INCREMENT>\')" onmouseout="pozadieOUT(\'<FORM_NAME>\',\'<INCREMENT>\')"';
	
	###################################################################################################
	# PUBLIC CONSTRUCT
	###################################################################################################
	
	public function __construct(){
		$this->COL['NUMBER'] = 1;
		$this->COL['CHECKBOX'] = 2;
		$this->COL['ENTITY_FLAG'] = 3;
		$this->COL['TITLE'] = 4;
		$this->COL['TRANSLATION'] = 5;
		$this->COL['VISIBILITY'] = 6;
		$this->COL['ORDER'] = 7;
		$this->COL['ID'] = 8;
		$this->COL['PARENT_MENU'] = 9;
		$this->COL['PARENT_CATEGORY'] = 10;
		$this->COL['ENTITY_NAME'] = 11;
		$this->COL['VALIDITY'] = 12;
		$this->COL['AUTHOR'] = 13;
		$this->COL['DATE'] = 14;
		$this->COL['FLASH_NEWS'] = 15;
		$this->COL['NEWS'] = 16;
		$this->COL['FRONTPAGE'] = 17;
		$this->COL['BINDINGS_MENU'] = 18;
		$this->COL['BINDINGS_CATEGORY'] = 19;
		$this->COL['ACCESS'] = 20;
		$this->COL['SETUP_VISIBILITY'] = 21;
		$this->COL['SETUP_TRANSLATION'] = 22;
		$this->COL['SETUP_ACCESS'] = 23;
		$this->COL['SETUP_EXPIRE'] = 24;
		$this->COL['UNMAP_MENU'] = 25;
		$this->COL['UNMAP_CATEGORY'] = 26;
		$this->COL['NAME'] = 27;
		$this->COL['UPDATE_EDITOR'] = 28;
		$this->COL['FRONTPAGE_LANGUAGE_VISIBILITY'] = 29;
		
		if ($_GET['start'])
			$this->setPropertyIncrement_row_number($_GET['start']+1);
				
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PUBLIC SET_POWER
	###################################################################################################
	
	public function setPower($object_list){
		$this->list = $object_list;
	}
	###################################################################################################
	
	
	
	###################################################################################################
	# PUBLIC LOAD_DESIGN
	###################################################################################################
	
	public function loadDesign($name_xml){
		
		if (file_exists("design_tables/{$name_xml}.xml")) {
			$xml = simplexml_load_file("design_tables/{$name_xml}.xml");
			
			echo "<pre>";
//			var_dump($xml);
			echo "</pre>";
		}
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PUBLIC SET_COLUMN
	###################################################################################################
	public function setColumn($type, $property_name = null, $property_value = null) {
		
		if ($type)
			$type = strtoupper($type);
		
		$this->type = $this->COL[$type];
		
		if ($property_name)
			$property_name = strtolower($property_name);
		
		if ($property_name == 'privileges')
			$this->column[$this->COL[$type]][$property_name][] = $property_value;
		else
			$this->column[$this->COL[$type]][$property_name] = $property_value;
		
		
		switch($this->type){
			
			case $this->COL['NUMBER']:

				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_align_center"';
					
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';

				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = "#";
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
				
			break;
			
			
			case $this->COL['CHECKBOX']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = "";
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) ) 
					$this->column[$this->COL[$type]]['header_properties'] = '';
				
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) ) 
					$this->column[$this->COL[$type]]['list_properties'] = '';
				
				if ( !isset($this->column[$this->COL[$type]]['onclick']) ) 
					$this->column[$this->COL[$type]]['onclick'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege']) )
					$this->column[$this->COL[$type]]['check_editor_privilege'] = TRUE;
					
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege_cascade']) )
					$this->column[$this->COL[$type]]['check_editor_privilege_cascade'] = TRUE;
				
			break;
			
			case $this->COL['ENTITY_FLAG']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = "";
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
				
			break;
			
			case $this->COL['TITLE']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Názov');
				
				if ( !isset($this->column[$this->COL[$type]]['onclick']) ) 
					$this->column[$this->COL[$type]]['onclick'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['view_language_tag']) ) 
					$this->column[$this->COL[$type]]['view_language_tag'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['href']) ) 
					$this->column[$this->COL[$type]]['href'] = './?cmd={FUNCTION_getObjectType_<OBJECT>_"updatelink"}&row_id[]=<ID>&s_category=<_GET_s_category>';
				
				if ( !isset($this->column[$this->COL[$type]]['href_catalog']) ) 
					$this->column[$this->COL[$type]]['href_catalog'] = './?mcmd=3&setCatalog=<ID>&setProxia=catalog';
				
				if ( !isset($this->column[$this->COL[$type]]['href_gallery']) ) 
					$this->column[$this->COL[$type]]['href_gallery'] = './?mcmd=3&row_id[]=<ID>&module=CMS_Gallery';
				
				if ( !isset($this->column[$this->COL[$type]]['href_event']) ) 
					$this->column[$this->COL[$type]]['href_event'] = './?mcmd=3&row_id[]=<ID>&module=CMS_EventCalendar';

										
				if ( !isset($this->column[$this->COL[$type]]['orderby']) ) 
					$this->column[$this->COL[$type]]['orderby'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['orderby_code']) ) 
					$this->column[$this->COL[$type]]['orderby_code'] = 'title';
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top"';
				
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege']) )
					$this->column[$this->COL[$type]]['check_editor_privilege'] = TRUE;
					
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege_cascade']) )
					$this->column[$this->COL[$type]]['check_editor_privilege_cascade'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;	

				if ( !isset($this->column[$this->COL[$type]]['list_wordwrap']) )
					$this->column[$this->COL[$type]]['list_wordwrap'] = 80;
											
			break;

			case $this->COL['NAME']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Kód');
				
				if ( !isset($this->column[$this->COL[$type]]['onclick']) ) 
					$this->column[$this->COL[$type]]['onclick'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['href']) ) 
					$this->column[$this->COL[$type]]['href'] = './?cmd=35&row_id[]=<ID>';
					
				if ( !isset($this->column[$this->COL[$type]]['orderby']) ) 
					$this->column[$this->COL[$type]]['orderby'] = TRUE;

				if ( !isset($this->column[$this->COL[$type]]['orderby_code']) ) 
					$this->column[$this->COL[$type]]['orderby_code'] = 'name';
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;	
						
			break;

			
			case $this->COL['TRANSLATION']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Preklad');
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) ) 
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top"';
				
				if ( !isset($this->column[$this->COL[$type]]['onclick']) ) 
					$this->column[$this->COL[$type]]['onclick'] = TRUE;
					
				if ( !isset($this->column[$this->COL[$type]]['href']) ) 
					$this->column[$this->COL[$type]]['href'] = './?cmd={FUNCTION_getObjectType_<OBJECT>_"updatelink"}&row_id[]=<ID>&s_category=<_GET_s_category>&setLocalLanguage=<LANGUAGE>';

				if ( !isset($this->column[$this->COL[$type]]['href_catalog']) ) 
					$this->column[$this->COL[$type]]['href_catalog'] = './?mcmd=3&setCatalog=<ID>&setProxia=catalog&setLocalLanguage=<LANGUAGE>';
				
				if ( !isset($this->column[$this->COL[$type]]['href_gallery']) ) 
					$this->column[$this->COL[$type]]['href_gallery'] = './?mcmd=3&row_id[]=<ID>&module=CMS_Gallery&setLocalLanguage=<LANGUAGE>';

				if ( !isset($this->column[$this->COL[$type]]['href_event']) ) 
					$this->column[$this->COL[$type]]['href_event'] = './?mcmd=3&row_id[]=<ID>&module=CMS_EventCalendar&setLocalLanguage=<LANGUAGE>';
					
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege']) )
					$this->column[$this->COL[$type]]['check_editor_privilege'] = TRUE;
					
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege_cascade']) )
					$this->column[$this->COL[$type]]['check_editor_privilege_cascade'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['VISIBILITY']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Viditenosť');
				
				if ( !isset($this->column[$this->COL[$type]]['onclick']) ) 
					$this->column[$this->COL[$type]]['onclick'] = TRUE;
					
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
					
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['href']) ) 
					$this->column[$this->COL[$type]]['href'] = 'javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isPublished\',<VISIBILITY_NEQ>,\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"section"}\',\'box<INCREMENT>\')';
				
				if ( !isset($this->column[$this->COL[$type]]['orderby']) ) 
					$this->column[$this->COL[$type]]['orderby'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['orderby_code']) ) 
					$this->column[$this->COL[$type]]['orderby_code'] = 'visibility';
				
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege']) )
					$this->column[$this->COL[$type]]['check_editor_privilege'] = TRUE;
					
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege_cascade']) )
					$this->column[$this->COL[$type]]['check_editor_privilege_cascade'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['ORDER']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Poradie');
				
				if ( !isset($this->column[$this->COL[$type]]['onclick']) ) 
					$this->column[$this->COL[$type]]['onclick'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
					
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['href_down']) ) 
					$this->column[$this->COL[$type]]['href_down'] = 'javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_down_in_menu\',{FUNCTION_getObjectType_<OBJECT>_"number"},\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"realname"}\',\'box<INCREMENT>\')';
				
				if ( !isset($this->column[$this->COL[$type]]['href_up']) ) 
					$this->column[$this->COL[$type]]['href_up'] = 'javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_up_in_menu\',{FUNCTION_getObjectType_<OBJECT>_"number"},\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"realname"}\',\'box<INCREMENT>\')';
				
				if ( !isset($this->column[$this->COL[$type]]['href_top']) ) 
					$this->column[$this->COL[$type]]['href_top'] = 'javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_top_in_menu\',{FUNCTION_getObjectType_<OBJECT>_"number"},\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"realname"}\',\'box<INCREMENT>\')';
				
				if ( !isset($this->column[$this->COL[$type]]['href_bottom']) ) 
					$this->column[$this->COL[$type]]['href_bottom'] = 'javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'move_bottom_in_menu\',{FUNCTION_getObjectType_<OBJECT>_"number"},\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"realname"}\',\'box<INCREMENT>\')';
					
				if ( !isset($this->column[$this->COL[$type]]['orderby']) ) 
					$this->column[$this->COL[$type]]['orderby'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['orderby_code']) ) 
					$this->column[$this->COL[$type]]['orderby_code'] = 'order';
				
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege']) )
					$this->column[$this->COL[$type]]['check_editor_privilege'] = TRUE;
					
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege_cascade']) )
					$this->column[$this->COL[$type]]['check_editor_privilege_cascade'] = TRUE;	
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['ID']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('ID');
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['orderby']) ) 
					$this->column[$this->COL[$type]]['orderby'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['orderby_code']) ) 
					$this->column[$this->COL[$type]]['orderby_code'] = 'id';
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['PARENT_MENU']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Nadradené menu');
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';

				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['PARENT_CATEGORY']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Nadradená kategória');
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
								
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['ENTITY_NAME']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Typ záznamu');
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['VALIDITY']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Platnosť');
					
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
					
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['AUTHOR']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Autor');
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['DATE']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Dátum');
				
				if ( !isset($this->column[$this->COL[$type]]['date_format']) ) 
					$this->column[$this->COL[$type]]['date_format'] = 'j.n.Y';
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['orderby']) ) 
					$this->column[$this->COL[$type]]['orderby'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['orderby_code']) ) 
					$this->column[$this->COL[$type]]['orderby_code'] = 'date';
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['FLASH_NEWS']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Flash novinka');
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
					
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;

				if ( !isset($this->column[$this->COL[$type]]['href']) ) 
					$this->column[$this->COL[$type]]['href'] = 'javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isFlashNews\',<VISIBILITY_NEQ>,\'box<INCREMENT>\')';

				if ( !isset($this->column[$this->COL[$type]]['onclick']) ) 
					$this->column[$this->COL[$type]]['onclick'] = TRUE;
						
			break;
			
			case $this->COL['NEWS']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Novinka');
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
					
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['FRONTPAGE']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Frontpage');
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
					
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['BINDINGS_MENU']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Väzby menu');
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
					
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['onclick']) ) 
					$this->column[$this->COL[$type]]['onclick'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['href']) ) 
					$this->column[$this->COL[$type]]['href'] = './?cmd=23&s_category=<ID>';

				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege']) )
					$this->column[$this->COL[$type]]['check_editor_privilege'] = TRUE;
					
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege_cascade']) )
					$this->column[$this->COL[$type]]['check_editor_privilege_cascade'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['BINDINGS_CATEGORY']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Väzby kategórie');
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
					
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['onclick']) ) 
					$this->column[$this->COL[$type]]['onclick'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['href']) ) 
					$this->column[$this->COL[$type]]['href'] = './?cmd=22&s_category=<ID>';

				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege']) )
					$this->column[$this->COL[$type]]['check_editor_privilege'] = TRUE;
					
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege_cascade']) )
					$this->column[$this->COL[$type]]['check_editor_privilege_cascade'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['ACCESS']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Práva');
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
					
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['SETUP_VISIBILITY']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Viditenosť');
				
				if ( !isset($this->column[$this->COL[$type]]['onclick']) ) 
					$this->column[$this->COL[$type]]['onclick'] = TRUE;
					
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
					
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['href']) ) 
					$this->column[$this->COL[$type]]['href'] = 'javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isPublished\',<VISIBILITY_NEQ>,\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"section"}\',\'box<INCREMENT>\')';
				
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege']) )
					$this->column[$this->COL[$type]]['check_editor_privilege'] = TRUE;
					
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege_cascade']) )
					$this->column[$this->COL[$type]]['check_editor_privilege_cascade'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			
			case $this->COL['SETUP_TRANSLATION']:
				
			//	if ( !isset($this->column[$this->COL[$type]]['title']) ) 
			//		$this->column[$this->COL[$type]]['title'] = tr('Viditenosť');
				
				if ( !isset($this->column[$this->COL[$type]]['onclick']) ) 
					$this->column[$this->COL[$type]]['onclick'] = TRUE;
					
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
					
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['href']) ) 
					$this->column[$this->COL[$type]]['href'] = 'javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'f_isPublished\',<VISIBILITY_NEQ>,\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"section"}\',\'box<INCREMENT>\')';
				
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege']) )
					$this->column[$this->COL[$type]]['check_editor_privilege'] = TRUE;
					
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege_cascade']) )
					$this->column[$this->COL[$type]]['check_editor_privilege_cascade'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['SETUP_ACCESS']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Zobrazovacie práva');
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top"';
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['SETUP_EXPIRE']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Platnosť');
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top"';
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;
			
			case $this->COL['UNMAP_MENU']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Odmapovať');
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
					
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
				
				if ( !isset($this->column[$this->COL[$type]]['href']) ) 
					$this->column[$this->COL[$type]]['href'] = 'javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'remove_menu_id\',<_GET_s_category>,\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"realname"}\',\'box<INCREMENT>\')';
				
				if ( !isset($this->column[$this->COL[$type]]['onclick']) ) 
					$this->column[$this->COL[$type]]['onclick'] = TRUE;
					
			break;
			
			case $this->COL['UNMAP_CATEGORY']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Odmapovať');
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
					
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
				
				if ( !isset($this->column[$this->COL[$type]]['href']) ) 
					$this->column[$this->COL[$type]]['href'] = 'javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'add_category_id\',-1,\'box<INCREMENT>\')';
				
				if ( !isset($this->column[$this->COL[$type]]['href_2']) ) 
					$this->column[$this->COL[$type]]['href_2'] = 'javascript:listItemTask(\'<FORM_NAME>\',1,<MAX_LIST>,\'add_category_id\',-1,\'section\',\'{FUNCTION_getObjectType_<OBJECT>_"section"}\',\'box<INCREMENT>\')';
					
				if ( !isset($this->column[$this->COL[$type]]['onclick']) ) 
					$this->column[$this->COL[$type]]['onclick'] = TRUE;
					
			break;
			case $this->COL['UPDATE_EDITOR']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Aktualizácia');
				
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
								
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;			
			case $this->COL['FRONTPAGE_LANGUAGE_VISIBILITY']:
				
				if ( !isset($this->column[$this->COL[$type]]['title']) ) 
					$this->column[$this->COL[$type]]['title'] = tr('Viditeľnosť jazykoviek');
				
				if ( !isset($this->column[$this->COL[$type]]['onclick']) ) 
					$this->column[$this->COL[$type]]['onclick'] = TRUE;
					
				if ( !isset($this->column[$this->COL[$type]]['header_properties']) )
					$this->column[$this->COL[$type]]['header_properties'] = 'class="td_valign_top_center"';
					
				if ( !isset($this->column[$this->COL[$type]]['list_properties']) )
					$this->column[$this->COL[$type]]['list_properties'] = 'class="td_align_center"';
				
				if ( !isset($this->column[$this->COL[$type]]['href']) ) 
					$this->column[$this->COL[$type]]['href'] = 'javascript:setFrontpageVisibility(\'<FORM_NAME>\',1,<MAX_LIST>,\'frontpage_language_is_visible\',<VISIBILITY_NEQ>,\'<LANGUAGE>\',\'box<INCREMENT>\')';
				
				if ( !isset($this->column[$this->COL[$type]]['orderby']) ) 
					$this->column[$this->COL[$type]]['orderby'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['orderby_code']) ) 
					$this->column[$this->COL[$type]]['orderby_code'] = 'visibility';
				
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege']) )
					$this->column[$this->COL[$type]]['check_editor_privilege'] = TRUE;
					
				if ( !isset($this->column[$this->COL[$type]]['check_editor_privilege_cascade']) )
					$this->column[$this->COL[$type]]['check_editor_privilege_cascade'] = TRUE;
				
				if ( !isset($this->column[$this->COL[$type]]['header_wordwrap']) )
					$this->column[$this->COL[$type]]['header_wordwrap'] = 8;
					
			break;			
		}
	
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PUBLIC GET_COLUMN_PROPERTY
	###################################################################################################
	
	public function getColumnProperty($cell_name, $property_name) {
		
		$cell_id = $this->COL[strtoupper($cell_name)];
		$property_name = strtolower($property_name);
		
		return $this->column[$cell_id][$property_name];
	}
	###################################################################################################
	
	
	###################################################################################################
	# PRIVATE TRANSLATE_PATTERN
	###################################################################################################
	
	private function TranslatePattern($input) {
		
		$string = $input['string'];
		
		$string = str_replace("<ID>", $this->current_object->getId(), $string);
		
		$string = str_replace("<LANGUAGE>", $input['language_id'], $string);
		
		$string = str_replace("<VISIBILITY_NEQ>", $input['visibility_neq'], $string);
		
		$string = str_replace("<INCREMENT>", $this->increment_id, $string);
		
		$string = str_replace("<FORM_NAME>", $this->form_name, $string);
		
		$string = str_replace("<MAX_LIST>", $this->max_list, $string);
		
		$pattern_code[] = "<_GET_";
		$pattern_code[] = "<_POST_";
		$pattern_code[] = "<_REQUEST_";
		$pattern_code[] = "<GLOBALS_";
		$pattern_code[] = "<_SESSION_";

		$output = "";

		foreach ($pattern_code as $pattern){
			
			$pattern_length = strlen($pattern);
			
			while (strpos($string, $pattern)){
				
				$start = strpos($string, $pattern);
				$length = strpos ($string, ">", $start)+1 - $start;
				$name = substr($string, $start + $pattern_length, $length - $pattern_length - 1);
				
				while (strpos($name, "[")){
					$array_start = strpos($name, "[");
					$name_real = substr($name,0,$array_start);
					$name_array = substr($name,$array_start);
					$name = $name_real;
				}
				
				$pattern_mask = substr($pattern,1);
				$pattern_mask = substr($pattern_mask,0,-1);
				
				$name_string = "\$output = \$".$pattern_mask."['".$name."']".$name_array.";";

				eval($name_string);

				$string = substr_replace($string, $output, $start,$length);
				
			}
		}
		
		
		while (strpos($string, "{FUNCTION_" )){
			
			$start = strpos($string, "{FUNCTION_");
			$length = strpos ($string, "}", $start)+1 - $start;
			$name = substr($string,$start+10,$length-11);
			
			
			
			$param = explode("_",$name);
			
			foreach ($param as &$value){
				if ($value == "<OBJECT>")
					$value = str_replace("<OBJECT>", "\$this->current_object", $value);
			}
			
			$function_name = $param[0];
			unset ($param[0]);
			$param_list = implode(",",$param);
			
			$name_string = "\$output = ".$function_name."(".$param_list.");";
			
			eval($name_string);
			
			$string = substr_replace($string, $output, $start,$length);
			
		}
		
		return $string;
	}
	###################################################################################################
	
	
	
	
	
	###################################################################################################
	# PRIVATE INICIALIZE_MAX_LIST
	###################################################################################################
	
	private function inicializeMaxList(){
		
		$this->getDataRows(FALSE);
		
	}
	###################################################################################################
	
	
	
	
	
	###################################################################################################
	# PRIVATE ORDERBY
	###################################################################################################
	
	private function orderby($cell_name){
		
		$input[] = 'order';
		$link = urlGet($input);
		
		$html = "<a href=\"./?".$link."order=".$this->getColumnProperty($cell_name,'orderby_code')."_asc\">";
		
		$image_path = $this->img_path."arrow_dn.gif";
		if (is_file($image_path))
			$html .= "<img src=\"$image_path\" />";
		
		$html .= "</a>";
		
		$html .= "&nbsp;&nbsp;&nbsp;";
		
		$html .= "<a href=\"./?".$link."order=".$this->getColumnProperty($cell_name,'orderby_code')."_desc\">";
		
		$image_path = $this->img_path."arrow_up.gif";
		if (is_file($image_path))
			$html .= "<img src=\"$image_path\" />";
		
		$html .= "</a>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE GET_PRIVILEGES
	###################################################################################################
	
	private function getPrivileges($cell_name){
		
		if ($GLOBALS['user_login_type'] == CMS_UserLogin::ADMIN_USER)
			return true;
		
		if ($this->column[$this->COL[$cell_name]]['check_editor_privilege'] === TRUE){
			if ($GLOBALS['user_login']->checkEditorPrivilege($this->current_object,$this->column[$this->COL[$cell_name]]['check_editor_privilege_cascade']) === FALSE)
				return FALSE;
			
		}
		
		$checkPrivilege = FALSE;
		
		if (is_array($this->column[$this->COL[$cell_name]]['privileges'])){
			
			foreach ($this->column[$this->COL[$cell_name]]['privileges'] as $privilege){

				if ($GLOBALS['user_login']->checkPrivilege(getObjectType($this->current_object,'privileges'), $privilege) === TRUE)
					$checkPrivilege = true;
					
			}
		}

		
		if ($checkPrivilege === FALSE)
			return false;
		
		return true;
	}
	###################################################################################################
	
	
	
	
	
	###################################################################################################
	# PRIVATE GET_TABLE_START
	###################################################################################################
	
	private function getTableStart(){
		
		if ($this->table_properties)
			$this->table_properties = ' '.$this->table_properties;
		
		$html = "<table".$this->table_properties.">";
		
		return $html;
	}
	###################################################################################################
	
	
	
	###################################################################################################
	# PRIVATE GET_HEAD_ROW
	###################################################################################################
	
	private function getHeadRow(){
		
		$setup_row = FALSE;
		
		if ($this->head_row_properties)
			$this->head_row_properties = ' '.$this->head_row_properties;
		
		if ($this->cell_properties)
			$this->cell_properties = ' '.$this->cell_properties;
		
		if ($this->line_row_properties)
			$this->line_row_properties = ' '.$this->line_row_properties;
		
		$html = "<tr";
		$html .= $this->head_row_properties;
		$html .= ">";
		
		foreach ($this->column as $cell_type => $value){
			
			$this->colspan++;
			$cell_realName = ucfirst(strtolower(array_search($cell_type,$this->COL)));
			$cell_name = "cellHeader".$cell_realName;
			
			$html .= $this->$cell_name();
			
			if (strtoupper(substr($cell_realName,0,5)) == 'SETUP')
				$setup_row = TRUE;
		}

		$html .= "</tr>";
		
		if ($this->show_tr_line === TRUE){
			$html .= "<tr><td colspan=\"".$this->colspan."\"";
			$html .= $this->line_row_properties;
			$html .= "></td></tr>";
			
		}
		
		if ($setup_row === TRUE){
			$html .= "<tr";
			$html .= $this->head_row_properties;
			$html .= ">";
			
			foreach ($this->column as $cell_type => $value){
				
				$this->colspan++;
				
				$cell_name = "cellSet".ucfirst(strtolower(array_search($cell_type,$this->COL)));
				
				$html .= $this->$cell_name();
				
			}
	
			$html .= "</tr>";
		}
		
		if (($this->show_tr_line === TRUE) && ($setup_row === TRUE)){
			$html .= "<tr><td colspan=\"".$this->colspan."\"";
			$html .= $this->line_row_properties;
			$html .= "></td></tr>";
			
		}
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE GET_ROW
	###################################################################################################
	
	private function getRow(){
		
		if ($this->list_row_properties)
			$this->list_row_properties = ' '.$this->list_row_properties;
		
		if ($this->line_row_properties)
			$this->line_row_properties = ' '.$this->line_row_properties;
		
		$input_translate['string'] = $this->list_row_properties;
		$list_row_properties = $this->TranslatePattern($input_translate);
		
		$html = "<tr";
		$html .= $list_row_properties;
		$html .= ">";
		
		foreach ($this->column as $cell_type => $value){
			
			$cell_name = "cellList".ucfirst(strtolower(array_search($cell_type,$this->COL)));
			
			$html .= $this->$cell_name();
			
		}
		
		$html .= "</tr>";
		
		if ($this->show_tr_line === TRUE){
			$html .= "<tr><td colspan=\"".$this->colspan."\"";
			$html .= $this->line_row_properties;
			$html .= "></td></tr>";
			
		}
		
		return $html;
		
	}
	###################################################################################################
	
	
	
	###################################################################################################
	# PRIVATE GET_TABLE_END
	###################################################################################################
	
	private function getTableEnd(){
		$html = "</table>";
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE GET_DATA_ROWS
	###################################################################################################
	
	private function getDataRows($active = TRUE){

		$html = "";

		foreach ($this->list as $row){
			
			if ($this->show_is_trash){
				
				if ($active === TRUE){
					$this->current_object = $row;
					
					$html .= $this->getRow();
					
					$this->increment_row_number++;
					$this->increment_id++;
				}
				else
					$this->max_list++;
			}
			else{
				if ( ($row instanceof CMS_Category) || ($row instanceof CMS_Article) || ($row instanceof CMS_Weblink) || ($row instanceof CMS_Menu)){
					
					if (!$row->getIsTrash()){
						
						if ($active === TRUE){
							$this->current_object = $row;
							
							$html .= $this->getRow();
							
							$this->increment_row_number++;
							$this->increment_id++;
						}
						else
							$this->max_list++;
					
					}
				}
				else{
					if ($active === TRUE){
					$this->current_object = $row;
					
					$html .= $this->getRow();
					
					$this->increment_row_number++;
					$this->increment_id++;
				}
				else
					$this->max_list++;
				}
			}
		}
		return $html;
	}
	###################################################################################################
	
	
	
	
	
	
	###################################################################################################
	# PUBLIC GET_TABLE
	###################################################################################################
	
	public function getTable(){
		
		$this->inicializeMaxList();
		
		$html = $this->getTableStart();
		$html .= $this->getHeadRow();
		$html .= $this->getDataRows();
		$html .= $this->getTableEnd();
		echo $html;
	}
	###################################################################################################
	
	
	
	
	
	
	###################################################################################################
	###################################################################################################
	# HEADER CELLS
	###################################################################################################
	###################################################################################################
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_NUMBER
	###################################################################################################
	
	private function cellHeaderNumber(){
		$cell_name = 'NUMBER';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_CHECKBOX
	###################################################################################################
	
	private function cellHeaderCheckbox(){
		$cell_name = 'CHECKBOX';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		$html .= '<input title="'.tr('vybrať všetko / zrušiť všetko').'" id="box" type="checkbox" name="selectall" value="1" onclick="selectall_2(\''.$this->form_name.'\',1,'.$this->max_list.',\'box\')" />';
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_ENTITY_FLAG
	###################################################################################################
	
	private function cellHeaderEntity_flag(){
		$cell_name = 'ENTITY_FLAG';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_TITLE
	###################################################################################################
	
	private function cellHeaderTitle(){
		$cell_name = 'TITLE';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		if ($this->getColumnProperty($cell_name,'orderby'))
			$html .= "<br />".$this->orderby($cell_name);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	###################################################################################################
	# PRIVATE CELL_HEADER_NAME
	###################################################################################################
	
	private function cellHeaderName(){
		$cell_name = 'NAME';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'name');
		
		if ($this->getColumnProperty($cell_name,'orderby'))
			$html .= "<br />".$this->orderby($cell_name);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_TRANSLATION
	###################################################################################################
	
	private function cellHeaderTranslation(){
		$cell_name = 'TRANSLATION';
		$num_languages = 0;
		foreach ($GLOBALS['LanguageListLocal'] as $language_id){
			$num_languages++;
		}
		
		$this->colspan = $this->colspan + $num_languages - 1;
				
		$html = "<td";
		
		if ($num_languages > 1)
			$html .= " colspan=\"$num_languages\"";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_VISIBILITY
	###################################################################################################
	
	private function cellHeaderVisibility(){
		$cell_name = 'VISIBILITY';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		if ($this->getColumnProperty($cell_name,'orderby'))
			$html .= "<br />".$this->orderby($cell_name);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_ORDER
	###################################################################################################
	
	private function cellHeaderOrder(){
		$cell_name = 'ORDER';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		if ($this->getColumnProperty($cell_name,'orderby'))
			$html .= "<br />".$this->orderby($cell_name);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_ID
	###################################################################################################
	
	private function cellHeaderId(){
		$cell_name = 'ID';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		if ($this->getColumnProperty($cell_name,'orderby'))
			$html .= "<br />".$this->orderby($cell_name);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_PARENT_MENU
	###################################################################################################
	
	private function cellHeaderParent_menu(){
		$cell_name = 'PARENT_MENU';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_PARENT_CATEGORY
	###################################################################################################
	
	private function cellHeaderParent_category(){
		$cell_name = 'PARENT_CATEGORY';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";

		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_ENTITY_NAME
	###################################################################################################
	
	private function cellHeaderEntity_name(){
		$cell_name = 'ENTITY_NAME';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_VALIDITY
	###################################################################################################
	
	private function cellHeaderValidity(){
		$cell_name = 'VALIDITY';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_AUTHOR
	###################################################################################################
	
	private function cellHeaderAuthor(){
		$cell_name = 'AUTHOR';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_DATE
	###################################################################################################
	
	private function cellHeaderDate(){
		$cell_name = 'DATE';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		if ($this->getColumnProperty($cell_name,'orderby'))
			$html .= "<br />".$this->orderby($cell_name);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_FLASH_NEWS
	###################################################################################################
	
	private function cellHeaderFlash_news(){
		$cell_name = 'FLASH_NEWS';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		if ($this->getColumnProperty($cell_name,'orderby'))
			$html .= "<br />".$this->orderby($cell_name);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_NEWS
	###################################################################################################
	
	private function cellHeaderNews(){
		$cell_name = 'NEWS';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		if ($this->getColumnProperty($cell_name,'orderby'))
			$html .= "<br />".$this->orderby($cell_name);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
		
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_FRONTPAGE
	###################################################################################################
	
	private function cellHeaderFrontpage(){
		$cell_name = 'FRONTPAGE';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		if ($this->getColumnProperty($cell_name,'orderby'))
			$html .= "<br />".$this->orderby($cell_name);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_BINDINGS_MENU
	###################################################################################################
	
	private function cellHeaderBindings_menu(){
		$cell_name = 'BINDINGS_MENU';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		if ($this->getColumnProperty($cell_name,'orderby'))
			$html .= "<br />".$this->orderby($cell_name);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_BINDINGS_CATEGORY
	###################################################################################################
	
	private function cellHeaderBindings_category(){
		$cell_name = 'BINDINGS_CATEGORY';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		if ($this->getColumnProperty($cell_name,'orderby'))
			$html .= "<br />".$this->orderby($cell_name);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_ACCESS
	###################################################################################################
	
	private function cellHeaderAccess(){
		$cell_name = 'ACCESS';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		if ($this->getColumnProperty($cell_name,'orderby'))
			$html .= "<br />".$this->orderby($cell_name);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_SETUP_VISIBILITY
	###################################################################################################
	
	private function cellHeaderSetup_visibility(){
		$cell_name = 'SETUP_VISIBILITY';
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		if ($this->getColumnProperty($cell_name,'orderby'))
			$html .= "<br />".$this->orderby($cell_name);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_SETUP_TRANSLATION
	###################################################################################################
	
	private function cellHeaderSetup_translation(){
		$cell_name = 'SETUP_TRANSLATION';
		
		$html = '';
		$num_languages = 0;
		
		foreach ($GLOBALS['LanguageListLocal'] as $language_id){
			
			$num_languages++;
			
			$html .= "<td";
			
			if ($this->getColumnProperty($cell_name,'header_properties'))
				$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
			
			$html .= ">";
			
			$html .= $language_id['code'];
			
			if ($this->getColumnProperty($cell_name,'orderby'))
				$html .= "<br />".$this->orderby($cell_name);
			
			$html .= "</td>";
		
		}
		
		$this->colspan = $this->colspan + $num_languages - 1;
		
		return $html;
	}
	###################################################################################################
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_SETUP_ACCESS
	###################################################################################################
	
	private function cellHeaderSetup_access(){
		$cell_name = 'SETUP_ACCESS';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		if ($this->getColumnProperty($cell_name,'orderby'))
			$html .= "<br />".$this->orderby($cell_name);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_SETUP_EXPIRE
	###################################################################################################
	
	private function cellHeaderSetup_expire(){
		$cell_name = 'SETUP_EXPIRE';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		if ($this->getColumnProperty($cell_name,'orderby'))
			$html .= "<br />".$this->orderby($cell_name);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_UNMAP_MENU
	###################################################################################################
	
	private function cellHeaderUnmap_menu(){
		$cell_name = 'UNMAP_MENU';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		if ($this->getColumnProperty($cell_name,'orderby'))
			$html .= "<br />".$this->orderby($cell_name);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_HEADER_UNMAP_CATEGORY
	###################################################################################################
	
	private function cellHeaderUnmap_category(){
		$cell_name = 'UNMAP_CATEGORY';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		if ($this->getColumnProperty($cell_name,'orderby'))
			$html .= "<br />".$this->orderby($cell_name);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
		###################################################################################################
	# PRIVATE CELL_HEADER_UPDATE_EDITOR
	###################################################################################################
	
	private function cellHeaderUpdate_editor(){
		$cell_name = 'UPDATE_EDITOR';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	###################################################################################################
	# PRIVATE CELL_HEADER_FRONTPAGE_LANGUAGE_VISIBILITY
	###################################################################################################
	
	private function cellHeaderFrontpage_language_visibility(){
		$cell_name = 'FRONTPAGE_LANGUAGE_VISIBILITY';
		$num_languages = 0;
		foreach ($GLOBALS['LanguageListLocal'] as $language_id){
			$num_languages++;
		}
		
		$this->colspan = $this->colspan + $num_languages - 1;
				
		$html = "<td";
		
		if ($num_languages > 1)
			$html .= " colspan=\"$num_languages\"";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		if ($this->getColumnProperty($cell_name,'header_wordwrap'))
			
			$html .= wordwrap($this->getColumnProperty($cell_name,'title'),$this->getColumnProperty($cell_name,'header_wordwrap'),'<br />');
		
		else

			$html .= $this->getColumnProperty($cell_name,'title');
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
		
	
	
	###################################################################################################
	###################################################################################################
	# LIST CELLS
	###################################################################################################
	###################################################################################################
	
	###################################################################################################
	# PRIVATE CELL_LIST__NUMBER
	###################################################################################################
	
	private function cellListNumber(){
		
		$cell_name = 'NUMBER';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		$html .= $this->increment_row_number;
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_CHECKBOX
	###################################################################################################
	
	private function cellListCheckbox(){
		
		$cell_name = 'CHECKBOX';
		
		$disabled = "disabled=\"disabled\"";
		
		if ( ($this->getColumnProperty($cell_name,'onclick') === TRUE) && ($this->getPrivileges($cell_name) === TRUE) )
			$disabled = '';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		$html .= "<input $disabled onclick=\"setRowBgColor('".$this->form_name."',".$this->increment_id.")\" id=\"box".$this->increment_id."\" type=\"checkbox\" name=\"row_id[]\" value=\"".$this->current_object->getId()."\"";
		
		if ($this->getColumnProperty($cell_name,'checked') === TRUE)
			$html .= " checked=\"checked\"";
		
		$html .= "/>";
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_ENTITY_FLAG
	###################################################################################################
	
	private function cellListEntity_flag(){
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		$image_path = $this->img_path.getObjectType($this->current_object,"realname")."_s.gif";
		if (is_file($image_path))
			$html .= "<img src=\"$image_path\" />";
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_TITLE
	###################################################################################################
	
	private function cellListTitle(){
		
		$cell_name = 'TITLE';
		
		$this->current_object->setContextLanguage($GLOBALS['localLanguage']);
		
		
		// LANGUAGE [XXX] ##################
		$defaultView = FALSE;
		
		if (($this->current_object->getTitle() == '') && ($this->getColumnProperty($cell_name,'view_language_tag'))){
			$this->current_object->setContextLanguage($GLOBALS['localLanguageDefault']);
			$defaultView = TRUE;
		}
		
		// LANGUAGE END ##################
		
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		
		if ( ($this->getColumnProperty($cell_name,'onclick') === TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) ){
			
			if (strtolower(substr(get_class($this->current_object),4)) == 'catalog')
				$input_translate['string'] = $this->getColumnProperty($cell_name,'href_catalog');
				
			elseif (strtolower(substr(get_class($this->current_object),4)) == 'gallery')
				$input_translate['string'] = $this->getColumnProperty($cell_name,'href_gallery');

			elseif (strtolower(substr(get_class($this->current_object),4)) == 'eventcalendar_event')
				$input_translate['string'] = $this->getColumnProperty($cell_name,'href_event');
			
			else
				$input_translate['string'] = $this->getColumnProperty($cell_name,'href');
			
			$href = $this->TranslatePattern($input_translate);

			$html .= "<a href=\"$href\">";
		}
		
		if ($defaultView === TRUE)
			$html .= $GLOBALS['defaultViewStartTag'];
		$html .= "<div style='margin-left:5px;'>";
		if ($this->getColumnProperty($cell_name,'list_wordwrap'))
			
			$html .= wordwrap($this->current_object->getTitle(),$this->getColumnProperty($cell_name,'list_wordwrap'),'<br />');
		
		else

			$html .= $this->current_object->getTitle();
		
		$html .= "</div>";		
		if ($defaultView === TRUE)
			$html .= $GLOBALS['defaultViewEndTag'];
			
		if ( ($this->getColumnProperty($cell_name,'onclick') === TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) )
			$html .= "</a>";
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_TITLE
	###################################################################################################
	
	private function cellListName(){
		
		$cell_name = 'NAME';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		
		if ( ($this->getColumnProperty($cell_name,'onclick') === TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) ){
			
			$input_translate['string'] = $this->getColumnProperty($cell_name,'href');
			
			$href = $this->TranslatePattern($input_translate);

			$html .= "<a href=\"$href\">";
		}
		
		if ($defaultView === TRUE)
			$html .= $GLOBALS['defaultViewStartTag'];
		
		if ($this->getColumnProperty($cell_name,'list_wordwrap'))
			
			$html .= wordwrap($this->current_object->getName(),$this->getColumnProperty($cell_name,'list_wordwrap'),'<br />');
		
		else

			$html .= $this->current_object->getName();
		
		
		if ($defaultView === TRUE)
			$html .= $GLOBALS['defaultViewEndTag'];
			
		if ( ($this->getColumnProperty($cell_name,'onclick') === TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) )
			$html .= "</a>";
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
		
	
	###################################################################################################
	# PRIVATE CELL_LIST_TRANSLATION
	###################################################################################################
	
	private function cellListTranslation(){
		
		$html = "";
		$cell_name = 'TRANSLATION';
		
		foreach ($GLOBALS['LanguageListLocal'] as $language_id){
			
			$html .= "<td";
			
			if ($this->getColumnProperty($cell_name,'list_properties'))
				$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
			
			$html .= ">";
			
			if ( ($this->getColumnProperty($cell_name,'onclick') === TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) ){
				
			if (strtolower(substr(get_class($this->current_object),4)) == 'catalog')
			
				$input_translate['string'] = $this->getColumnProperty($cell_name,'href_catalog');
				
			elseif (strtolower(substr(get_class($this->current_object),4)) == 'gallery')
			
				$input_translate['string'] = $this->getColumnProperty($cell_name,'href_gallery');
				
			else
				$input_translate['string'] = $this->getColumnProperty($cell_name,'href');
				
				$input_translate['language_id'] = $language_id['code'];
				
				$href = $this->TranslatePattern($input_translate);
				
				$triedaLang = "class=\"hrefyeslang\"";
				$this->current_object->setContextLanguage($language_id['code']);
				
				if ($this->current_object->getTitle() == '')
					$triedaLang = "class=\"hrefnolang\"";
				
				$html .= "<a $triedaLang href=\"$href\">";
			}
			
			$html .= $language_id['code'];
			
			if ( ($this->getColumnProperty($cell_name,'onclick') === TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) )
				$html .= "</a>&nbsp;";
				
			$html .= "</td>";
			
		}
		return $html;
	}
	###################################################################################################
	
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_VISIBILITY
	###################################################################################################
	
	private function cellListVisibility(){
		
		$cell_name = 'VISIBILITY';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		if ( ($this->getColumnProperty($cell_name,'onclick') == TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) ){
			
			$input_translate['string'] = $this->getColumnProperty($cell_name,'href');
			$input_translate['visibility_neq'] = $this->current_object->getIsPublished() ? 0 : 1;
			$href = $this->TranslatePattern($input_translate);
			
			
			$html .= "<a href=\"$href\">";
		}
		
		$image_name = $this->current_object->getIsPublished() ? 'visible' : 'hidden';
		
		$suffix = '';
		
		if ($this->current_object->getIsPublished()){
			foreach ($GLOBALS['LanguageListLocal'] as $language_id){
				if ($language_id['local_visibility']){
					$this->current_object->setContextLanguage($language_id['code']);
					if ($this->current_object->getLanguageIsVisible() == 0)
						$suffix = 'cb';
				}
			}
		}
		
		$image_path = $this->img_path.$image_name.$suffix.".gif";
		if (is_file($image_path))
			$html .= "<img src=\"$image_path\" />";
			
		
		if ( ($this->getColumnProperty($cell_name,'onclick') == TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) )
			$html .= "</a>";
			
		$html .= "</td>";
		

		return $html;
	}
	###################################################################################################
	
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_ORDER
	###################################################################################################
	
	private function cellListOrder(){
		
		$cell_name = 'ORDER';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		if ( ($this->getColumnProperty($cell_name,'onclick') == TRUE) && ($this->getPrivileges($cell_name) === TRUE) ){
			
			if ($this->increment_row_number != $this->max_list){
				
				if ($this->getColumnProperty($cell_name,'href_bottom')){
					
					$input_translate['string'] = $this->getColumnProperty($cell_name,'href_bottom');
					$href = $this->TranslatePattern($input_translate);
					$html .= "<a href=\"$href\">";
					
				}
				
				$image_path = $this->img_path."bottomarrow.png";
				if (is_file($image_path))
					$html .= "<img src=\"$image_path\" />";
				
				if ($this->getColumnProperty($cell_name,'href_bottom'))
					$html .= "</a>";
				
				if ($this->getColumnProperty($cell_name,'href_down')){
					
					$input_translate['string'] = $this->getColumnProperty($cell_name,'href_down');
					$href = $this->TranslatePattern($input_translate);
					$html .= "<a href=\"$href\">";
					
				}
				
				$image_path = $this->img_path."downarrow.png";
				if (is_file($image_path))
					$html .= "<img src=\"$image_path\" />";
				
				if ($this->getColumnProperty($cell_name,'href_down'))
					$html .= "</a>";
				
			}
			
			if (($this->increment_row_number != $this->max_list) && ($this->increment_row_number > 1))
				$html .= "&nbsp;&nbsp;&nbsp;&nbsp;";
			
			if ($this->increment_row_number > 1){					
				if ($this->getColumnProperty($cell_name,'href_up')){
					
					$input_translate['string'] = $this->getColumnProperty($cell_name,'href_up');
					$href = $this->TranslatePattern($input_translate);
					$html .= "<a href=\"$href\">";
					
				}
				
				$image_path = $this->img_path."uparrow.png";
				if (is_file($image_path))
					$html .= "<img src=\"$image_path\" />";
				
				if ($this->getColumnProperty($cell_name,'href_up'))
					$html .= "</a>";
				
				if ($this->getColumnProperty($cell_name,'href_top')){
					
					$input_translate['string'] = $this->getColumnProperty($cell_name,'href_top');
					$href = $this->TranslatePattern($input_translate);
					$html .= "<a href=\"$href\">";
					
				}
				
				$image_path = $this->img_path."toparrow.png";
				if (is_file($image_path))
					$html .= "<img src=\"$image_path\" />";
				
				if ($this->getColumnProperty($cell_name,'href_top'))
					$html .= "</a>";
				
			}
			
		}
		
		$html .= "</td>";

		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST__ID
	###################################################################################################
	
	private function cellListId(){
		
		$cell_name = 'ID';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		$html .= $this->current_object->getId();
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_PARENT_MENU
	###################################################################################################
	
	private function cellListParent_menu(){
		
		$cell_name = 'PARENT_MENU';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		$input['id'] = $this->current_object->getId();
		$input['class'] = get_class($this->current_object);
		$ParentMenuList = insert_getParentMenuList($input);
		
		foreach ($ParentMenuList as $parent_menu_id){
			$html .= $parent_menu_id->getTitle()." ";
		}
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_PARENT_CATEGORY
	###################################################################################################
	
	private function cellListParent_category(){
		
		$cell_name = 'PARENT_CATEGORY';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		if ($this->current_object instanceof CMS_Category){
			
			$input['id'] = $this->current_object->getId();
			$category_parent = insert_getParentCategoryCat($input);
			
			if(insert_getParentCategoryCat($input)){
				
				$input2['id'] = insert_getParentCategoryCat($input);
				$html .= insert_getNameCategory($input2);
				
			}
			
		}
		
		if ($this->current_object instanceof CMS_Article){
			
			$input['id'] = $this->current_object->getId();
			$category_parents_list = insert_getParentsCategoryArt($input);
			
			foreach ($category_parents_list as $parent_id){
				$html .= $parent_id->getTitle()." ";
			}
			
		}
		
		if ($this->current_object instanceof CMS_Weblink){
			
			$input['id'] = $this->current_object->getId();
			$category_parents_list = insert_getParentsCategoryWeblink($input);
			
			foreach ($category_parents_list as $parent_id){
				$html .= $parent_id->getTitle()."&nbsp;";
			}
		}
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_ENTITY_NAME
	###################################################################################################
	
	private function cellListEntity_name(){
		
		$cell_name = 'ENTITY_NAME';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		$input['item'] = $this->current_object;
		$input['set'] = 'realname';
		$input['return'] = 'name';
		$html .= insert_getObjectType($input);
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_VALIDITY
	###################################################################################################
	
	private function cellListValidity(){
		
		$cell_name = 'VALIDITY';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		$input['item'] = $this->current_object;
		$input['set'] = 'realname';
		$input['return'] = 'name';
		$real_name = insert_getObjectType($input);
		if (insert_getObjectType($input) == 'article'){
			
			if( (($this->current_object->getExpiration() >= date("Y-m-d H:i:s")) || ($this->current_object->getExpiration() == "0000-00-00 00:00:00") || ($this->current_object->getExpiration() == null)) ){
						
				$image_path = $this->img_path."visible.gif";
				if (is_file($image_path))
					$html .= "<img src=\"$image_path\" />";
					
			}
			else{
					
				$image_path = $this->img_path."hidden.gif";
				if (is_file($image_path))
					$html .= "<img src=\"$image_path\" />";
					
			}
			
		}
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_AUTHOR
	###################################################################################################
	
	private function cellListAuthor(){
		
		$cell_name = 'AUTHOR';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		if ($this->current_object instanceof CMS_Article){
			$input['id'] = $this->current_object->getAuthorId();
			$author = insert_getUserInfo($input);
			$author_name = $author->getFamilyname()." ".$author->getFirstname();
			
		if ($this->getColumnProperty($cell_name,'list_wordwrap'))
			
			$html .= wordwrap($author_name,$this->getColumnProperty($cell_name,'list_wordwrap'),'<br />');
		
		else

			$html .= $author_name;
		}
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_DATE
	###################################################################################################
	
	private function cellListDate(){
		
		$cell_name = 'DATE';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		$html .= date($this->getColumnProperty($cell_name,'date_format'), strtotime($this->current_object->getCreation()) );
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_FLASH_NEWS
	###################################################################################################
	
	private function cellListFlash_news(){
		
		$cell_name = 'FLASH_NEWS';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		if ( ($this->getColumnProperty($cell_name,'onclick') == TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) ){
			
			$input_translate['string'] = $this->getColumnProperty($cell_name,'href');
			$input_translate['visibility_neq'] = $this->current_object->getIsFlashNews() ? 0 : 1;
			$href = $this->TranslatePattern($input_translate);
			
			
			$html .= "<a href=\"$href\">";
		}
		
			if ($this->current_object instanceof CMS_Article){
				
				if ($this->current_object->getIsFlashNews()){
					
					$image_path = $this->img_path."visible.gif";
					if (is_file($image_path))
						$html .= "<img src=\"$image_path\" />";
					
				}
				else{
					
					$image_path = $this->img_path."hidden.gif";
					if (is_file($image_path))
						$html .= "<img src=\"$image_path\" />";
					
				}
				
		}
		if ( ($this->getColumnProperty($cell_name,'onclick') == TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) )
			$html .= "</a>";
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_NEWS
	###################################################################################################
	
	private function cellListNews(){
		
		$cell_name = 'NEWS';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		if ($this->current_object instanceof CMS_Article){
			
			if ($this->current_object->getIsNews()){
				
				$image_path = $this->img_path."visible.gif";
				if (is_file($image_path))
					$html .= "<img src=\"$image_path\" />";
				
			}
			else{
				
				$image_path = $this->img_path."hidden.gif";
				if (is_file($image_path))
					$html .= "<img src=\"$image_path\" />";
				
			}
				
		}
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_FRONTPAGE
	###################################################################################################
	
	private function cellListFrontpage(){
		
		$cell_name = 'FRONTPAGE';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		if ($this->current_object instanceof CMS_Article){
			
			$frontpage = CMS_Frontpage::getSingleton();
			if($frontpage->itemExists($this->current_object)){
				
				$image_path = $this->img_path."visible.gif";
				if (is_file($image_path))
					$html .= "<img src=\"$image_path\" />";
				
			}
			else{
				
				$image_path = $this->img_path."hidden.gif";
				if (is_file($image_path))
					$html .= "<img src=\"$image_path\" />";
				
			}
				
		}
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_BINDINGS_MENU
	###################################################################################################
	
	private function cellListBindings_menu(){
		
		$cell_name = 'BINDINGS_MENU';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		if ($this->current_object instanceof CMS_Menu){
			if ( ($this->getColumnProperty($cell_name,'onclick') == TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) ){
				
				$input_translate['string'] = $this->getColumnProperty($cell_name,'href');
				$href = $this->TranslatePattern($input_translate);
				
				$html .= "<a href=\"$href\">";
			}
			
			$image_path = $this->img_path."menu_s_refresh.gif";
			if (is_file($image_path))
				$html .= "<img src=\"$image_path\" />";
			
			if ( ($this->getColumnProperty($cell_name,'onclick') == TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) )
				$html .= "</a>";
		}
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	

	
	
	###################################################################################################
	# PRIVATE CELL_LIST_BINDINGS_CATEGORY
	###################################################################################################
	
	private function cellListBindings_category(){
		
		$cell_name = 'BINDINGS_CATEGORY';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		if ($this->current_object->getType() == CMS_Category::ENTITY_ID){
		
			if ( ($this->getColumnProperty($cell_name,'onclick') == TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) ){
				
				$input_translate['string'] = $this->getColumnProperty($cell_name,'href');
				$href = $this->TranslatePattern($input_translate);
				
				$html .= "<a href=\"$href\">";
			}
			
			$image_path = $this->img_path."category_s_.gif";
			if (is_file($image_path))
				$html .= "<img src=\"$image_path\" />";
			
			if ( ($this->getColumnProperty($cell_name,'onclick') == TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) )
				$html .= "</a>";
				
		}
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_ACCESS
	###################################################################################################
	
	private function cellListAccess(){
		
		$cell_name = 'ACCESS';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		if(get_class($this->current_object) != 'CMS_EventCalendar_Event'){
		
			if ($this->current_object->getAccess() == CMS::ACCESS_PUBLIC)
				$html .= "<img src=\"images/access_public_s.gif\">";
			
			if ($this->current_object->getAccess() == CMS::ACCESS_REGISTERED)
				$html .= "<img src=\"images/access_registered_s.gif\">";
			
			if ($this->current_object->getAccess() == CMS::ACCESS_SPECIAL)
				$html .= "<img src=\"images/access_special_s.gif\">";
		}
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_SETUP_VISIBILITY
	###################################################################################################
	
	private function cellListSetup_visibility(){

		$cell_name = 'SETUP_VISIBILITY';
		$disabled = "disabled=\"disabled\"";
				
		$html = "<td";
		
		if ( ($this->getColumnProperty($cell_name,'onclick') === TRUE) && ($this->getPrivileges($cell_name) === TRUE) )
			$disabled = '';

		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		$html .="<input $disabled id=\"visibility".$this->increment_id."\" name=\"visibility[".$this->current_object->getId()."]\" type=\"checkbox\" value=\"1\"";
		
		$html .= $this->current_object->getIsPublished() ? ' checked="checked"' : '';
		
		$html .= ">";

		$html .= "</td>";

		return $html;
	}
	###################################################################################################
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_SETUP_TRANSLATION
	###################################################################################################
	
	private function cellListSetup_translation(){
		
		$cell_name = 'SETUP_TRANSLATION';
		
		$html = '';
		
		foreach ($GLOBALS['LanguageListLocal'] as $language_id){
			$disabled = "disabled=\"disabled\"";
			
			$this->current_object->setContextLanguage($language_id['code']);
		
			if ( ($this->getColumnProperty($cell_name,'onclick') === TRUE) && ($this->getPrivileges($cell_name) === TRUE) )
				$disabled = '';
			
			$html .= "<td";
			
			if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
			$html .= ">";
			
			$html .="<input $disabled id=\"visibility".$language_id['code'].$this->increment_id."\" name=\"a_languageIsVisible".$language_id['code']."[".$this->current_object->getId()."]\" type=\"checkbox\" value=\"1\"";
			
			$html .= $this->current_object->getLanguageIsVisible() ? ' checked="checked"' : '';
			
			$html .= ">";
	
			$html .= "</td>";
		
		}

		return $html;
	}
	###################################################################################################
	
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_SETUP_ACCESS
	###################################################################################################
	
	private function cellListSetup_access(){
		
		$cell_name = 'SETUP_ACCESS';
				
		$html = "<td";

		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		$html .= "
				<select  name=\"access[".$this->current_object->getId()."]\" id=\"access".$this->increment_id."\">
					<option value=\"".CMS::ACCESS_PUBLIC."\"";
		
		if ($this->current_object->getAccess() == CMS::ACCESS_PUBLIC)
			$html .= " selected=\"selected\"";
		
		$html .= ">".tr('Verejné')."</option>
					<option value=\"".CMS::ACCESS_REGISTERED."\"";
		
		if ($this->current_object->getAccess() == CMS::ACCESS_REGISTERED)
			$html .= " selected=\"selected\"";
		
		$html .= ">".tr('Registrovaným')."</option>
					<option value=\"".CMS::ACCESS_SPECIAL."\"";
		
		if ($this->current_object->getAccess() == CMS::ACCESS_SPECIAL)
			$html .= " selected=\"selected\"";
		
		$html .= ">".tr('Skupiny používateľov')."</option>
				</select>	
				";

		$html .= "</td>";
		

		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_SETUP_EXPIRE
	###################################################################################################
	
	private function cellListSetup_expire(){
		
		$cell_name = 'SETUP_EXPIRE';
		
		$html = "<td";
		
		$disabled = "disabled=\"disabled\"";
			
		if ( ($this->getColumnProperty($cell_name,'onclick') === TRUE) && ($this->getPrivileges($cell_name) === TRUE) )
			$disabled = '';
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		$input['nazov'] = "expire[".$this->current_object->getId()."]";
		$input['value'] = $this->current_object->getExpiration();
		
		ob_start();
		
		insert_makeCalendar($input);
		
		$html .= ob_get_contents();
		
		ob_end_clean();

		$html .= "</td>";
		

		return $html;
	}
	###################################################################################################
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_UNMAP_MENU
	###################################################################################################
	
	private function cellListUnmap_menu(){
		
		$cell_name = 'UNMAP_MENU';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		if ( (get_class($this->current_object) == 'CMS_Category') || (get_class($this->current_object) == 'CMS_Gallery') || (get_class($this->current_object) == 'CMS_Catalog') || (get_class($this->current_object) == 'CMS_EventCalendar_Event') ){
			if ( ($this->getColumnProperty($cell_name,'onclick') == TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) ){
				
				$input_translate['string'] = $this->getColumnProperty($cell_name,'href');
				$href = $this->TranslatePattern($input_translate);
				
				$html .= "<a href=\"$href\">";
			}
			
			$image_path = $this->img_path."category_s_.gif";
			if (is_file($image_path))
				$html .= "<img src=\"$image_path\" />";
			
			if ( ($this->getColumnProperty($cell_name,'onclick') == TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) )
				$html .= "</a>";
				
		}
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	
	###################################################################################################
	# PRIVATE CELL_LIST_UNMAP_CATEGORY
	###################################################################################################
	
	private function cellListUnmap_category(){
		
		$cell_name = 'UNMAP_CATEGORY';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
				
		if ($this->current_object->getType() == CMS_Category::ENTITY_ID){
		
			if ( ($this->getColumnProperty($cell_name,'onclick') == TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) ){
				
				if ($_GET['cmd'] == 1)
					$input_translate['string'] = $this->getColumnProperty($cell_name,'href');
				else
					$input_translate['string'] = $this->getColumnProperty($cell_name,'href_2');
				
				$href = $this->TranslatePattern($input_translate);
				
				$html .= "<a href=\"$href\">";
			}
			
			$image_path = $this->img_path."category_s_.gif";
			if (is_file($image_path))
				$html .= "<img src=\"$image_path\" />";
			
			if ( ($this->getColumnProperty($cell_name,'onclick') == TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) )
				$html .= "</a>";
				
		}
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
		###################################################################################################
	# PRIVATE CELL_LIST_UPDATE_EDITOR
	###################################################################################################
	
	private function cellListUpdate_editor(){
		
		$cell_name = 'UPDATE_EDITOR';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		//$html .= $this->current_object->getUpdateAuthors();
		$update_authors = unserialize($this->current_object->getUpdateAuthors());
		$toHtml = "";
		$pocetEditorov = count($update_authors);
		for($k=$pocetEditorov-1;$k>=0;$k--){
				$pocetUdajov = count($update_authors[$k]);
				$color = "";
				if($update_authors[$k]["user_id"] == $_GET["s_author"])
					$color = "color:darkred;";
				$toHtml .= "<div style='margin:2px;$color'>";
				if($update_authors[$k]["user_type"]==2){
					$userDetail = new CMS_User($update_authors[$k]["user_id"]);
					if($userDetail->getId() != null){
						$toHtml .= $userDetail->getFirstname()." ".$userDetail->getFamilyname();
					}else{
						$toHtml .= tr("Deleted editor");				
					}
				}else{
						$toHtml .= tr("Administrátor");				
				}
				//$phpDate = date_create($update_authors[$k]["date"]);
				$create_date = strtotime($update_authors[$k]["date"]);
				$toHtml .= " :: ".date("d.m.Y H:i:s",$create_date);
				$toHtml .= "</div>";
		}
		$html .= $toHtml;
	//	foreach($update_authors as $key => $value){
			//	$html .= $update_author["editor_id"];
	//	}
	//	$html .= $this->current_object->getUpdateAuthors();
		/*
		$input['id'] = $this->current_object->getId();
		$input['class'] = get_class($this->current_object);
		$ParentMenuList = insert_getParentMenuList($input);
		
		foreach ($ParentMenuList as $parent_menu_id){
			$html .= $parent_menu_id->getTitle()." ";
		}
		*/
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
		###################################################################################################
	# PRIVATE CELL_LIST_FRONTPAGE_LANGUAGE_VISIBILITY
	###################################################################################################
	
	private function cellListFrontpage_language_visibility(){
		
		$html = "";
		$cell_name = 'FRONTPAGE_LANGUAGE_VISIBILITY';
		
		foreach ($GLOBALS['LanguageListLocal'] as $language_id){
			
			$html .= "<td";
			
			if ($this->getColumnProperty($cell_name,'list_properties'))
				$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
			
			$html .= ">";
			
			if ( ($this->getColumnProperty($cell_name,'onclick') === TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) ){
				
				$this->current_object->setContextLanguage($language_id['code']);				
				$input_translate['string'] = $this->getColumnProperty($cell_name,'href');
		  	$input_translate['visibility_neq'] = $this->current_object->getFrontpage_language_is_visible() ? 0 : 1;				
				$input_translate['language_id'] = $language_id['code'];
				
				$href = $this->TranslatePattern($input_translate);


				
				$html .= "<a href=\"$href\">";
			}
			
			$html .= "&nbsp;&nbsp;"; 
			if ($this->current_object->getFrontpage_language_is_visible() == 1)
				$html .= $language_id['code']." : "."<img src=\"images/visible.gif\">";
			else
				$html .= $language_id['code']." : "."<img src=\"images/hidden.gif\">";
					
			if ( ($this->getColumnProperty($cell_name,'onclick') === TRUE) && ($this->getColumnProperty($cell_name,'href')) && ($this->getPrivileges($cell_name) === TRUE) )
				$html .= "</a>&nbsp;";
				
			$html .= "</td>";
			
		}
		return $html;
	}
	###################################################################################################
	
	
	
	###################################################################################################
	###################################################################################################
	# CELLS SETUP
	###################################################################################################
	###################################################################################################
	
	###################################################################################################
	# PRIVATE CELL_SET_SETUP_VISIBILITY
	###################################################################################################
	
	private function cellSetSetup_visibility(){
		$cell_name = 'SETUP_VISIBILITY';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'header_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
		
		$html .= ">";
		
		$html .= "<input title=\"".tr('vybrať všetko / zrušiť všetko')."\" id=\"visibility\" type=\"checkbox\" name=\"selectall\" value=\"1\" onclick=\"selectall_2('".$this->form_name."',1,".$this->max_list.",'visibility')\" />";
		
		$html .= "</td>";
		
		return $html;
	}
	###################################################################################################
	
	
	###################################################################################################
	# PRIVATE CELL_SET_SETUP_LANGUAGE
	###################################################################################################
	
	private function cellSetSetup_translation(){
		$cell_name = 'SETUP_TRANSLATION';
		$html = '';
		
		foreach ($GLOBALS['LanguageListLocal'] as $language_id){
			$html .= "<td";
			
			if ($this->getColumnProperty($cell_name,'header_properties'))
				$html .= " ".$this->getColumnProperty($cell_name,'header_properties');
			
			$html .= ">";
			
			$html .= "<input title=\"".tr('vybrať všetko / zrušiť všetko')."\" id=\"visibility".$language_id['code']."\" type=\"checkbox\" name=\"selectall\" value=\"1\" onclick=\"selectall_2('".$this->form_name."',1,".$this->max_list.",'visibility".$language_id['code']."')\" />";
			
			$html .= "</td>";
		}
		
		return $html;
	}
	###################################################################################################
	
	
	
	###################################################################################################
	# PRIVATE CELL_SET_SETUP_ACCESS
	###################################################################################################
	
	private function cellSetSetup_access(){
		
		$cell_name = 'SETUP_ACCESS';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		$html .= "
				<select name=\"access_default\" id=\"access_default\">
					<option value=\"".CMS::ACCESS_PUBLIC."\">".tr('Verejné')."</option>
					<option value=\"".CMS::ACCESS_REGISTERED."\">".tr('Registrovaným')."</option>
					<option value=\"".CMS::ACCESS_SPECIAL."\">".tr('Skupiny používateľov')."</option>
				</select>	
				";
		
		$html .= "<a href=\"javascript:setSelect('".$this->form_name."','access_default',1,".$this->max_list.")\" title=\"".tr('prednastav')."\"><img src=\"images/paste.gif\" width=\"21\" height=\"21\" border=\"0\"></a>";

		$html .= "</td>";
		

		return $html;
	}
	###################################################################################################
	
	
	
	
	###################################################################################################
	# PRIVATE CELL_SET_SETUP_EXPIRE
	###################################################################################################
	
	private function cellSetSetup_expire(){
		
		$cell_name = 'SETUP_EXPIRE';
		
		$html = "<td";
		
		if ($this->getColumnProperty($cell_name,'list_properties'))
			$html .= " ".$this->getColumnProperty($cell_name,'list_properties');
		
		$html .= ">";
		
		$input['nazov'] = "expiration";
		
		ob_start();
		
		insert_makeCalendar($input);
		
		$html .= ob_get_contents();
		
		ob_end_clean();
		
		$html .= "<a href=\"javascript:setCalendar('".$this->form_name."','f-calendar-field-1',1,".$this->max_list.")\" title=\"".tr('prednastav')."\"><img src=\"images/paste.gif\" width=\"21\" height=\"21\" border=\"0\"></a>";

		$html .= "</td>";
		

		return $html;
	}
	###################################################################################################
	
	
	
	###################################################################################################
	###################################################################################################
	# PUBLIC CALL
	###################################################################################################
	###################################################################################################
	
	public function __call($name, $args) {
		
		if(strpos($name, 'setTable') !== false) {
			
			$properties_name = strtolower(substr($name, 8));
			
			if (strpos($this->table_properties, $properties_name."=\"")){
				
				$start = strpos($this->table_properties, $properties_name."=\"") + strlen($properties_name."=\"");
				
				$length = strpos ($this->table_properties, "\"", $start) - $start;
				
				$this->table_properties = substr_replace($this->table_properties, $args[0], $start, $length);
			}
			else
				$this->table_properties .= " $properties_name=\"{$args[0]}\"";
		
		}
		elseif(strpos($name, 'setTr') !== false) {
			
			$properties_name = strtolower(substr($name, 5));
			
			if (strpos($this->row_properties, $properties_name."=\"")){
				
				$start = strpos($this->row_properties, $properties_name."=\"") + strlen($properties_name."=\"");
				
				$length = strpos ($this->row_properties, "\"", $start) - $start;
				
				$this->row_properties = substr_replace($this->row_properties, $args[0], $start, $length);
			}
			else
				$this->row_properties .= " $properties_name=\"{$args[0]}\"";
		
		}
		elseif(strpos($name, 'setTd') !== false) {
			
			$properties_name = strtolower(substr($name, 5));
			
			if (strpos($this->cell_properties, $properties_name."=\"")){
				
				$start = strpos($this->cell_properties, $properties_name."=\"") + strlen($properties_name."=\"");
				
				$length = strpos ($this->cell_properties, "\"", $start) - $start;
				
				$this->cell_properties = substr_replace($this->cell_properties, $args[0], $start, $length);
			}
			else
				$this->cell_properties .= " $properties_name=\"{$args[0]}\"";
				
		}
		elseif(strpos($name, 'setHeadTr') !== false) {
			
			$properties_name = strtolower(substr($name, 9));
			
			if (strpos($this->head_row_properties, $properties_name."=\"")){
				
				$start = strpos($this->head_row_properties, $properties_name."=\"") + strlen($properties_name."=\"");
				
				$length = strpos ($this->head_row_properties, "\"", $start) - $start;
				
				$this->head_row_properties = substr_replace($this->head_row_properties, $args[0], $start, $length);
			}
			else
				$this->head_row_properties .= " $properties_name=\"{$args[0]}\"";
		
		}
		elseif(strpos($name, 'setLineTr') !== false) {
			
			$properties_name = strtolower(substr($name, 9));
			
			if (strpos($this->line_row_properties, $properties_name."=\"")){
				
				$start = strpos($this->line_row_properties, $properties_name."=\"") + strlen($properties_name."=\"");
				
				$length = strpos ($this->line_row_properties, "\"", $start) - $start;
				
				$this->line_row_properties = substr_replace($this->line_row_properties, $args[0], $start, $length);
			}
			else
				$this->line_row_properties .= " $properties_name=\"{$args[0]}\"";
		
		}
		elseif(strpos($name, 'setListTr') !== false) {
		
			$properties_name = strtolower(substr($name, 9));
			
			if (strpos($this->list_row_properties, $properties_name."=\"")){
				
				$start = strpos($this->list_row_properties, $properties_name."=\"") + strlen($properties_name."=\"");
				
				$length = strpos ($this->list_row_properties, "\"", $start) - $start;
				
				$this->list_row_properties = substr_replace($this->list_row_properties, $args[0], $start, $length);
			}
			else
				$this->list_row_properties .= " $properties_name=\"{$args[0]}\"";
		
		}
		elseif(strpos($name, 'setProperty') !== false){
			
			$var_name = CN_Utils::getRealName(substr($name, 11));
			
			$this->$var_name = $args[0];
		}
		elseif(strpos($name, 'getProperty') !== false){
			
			$var_name = CN_Utils::getRealName(substr($name, 11));
			
			return $this->$var_name;
		}
		elseif(strpos($name, 'cell') !== false){
			
			return "<td>&nbsp;</td>";
		}
		
	}
	###################################################################################################
}

?>
