 <?php

if(!defined('CMS_MENU_PHP')):
	define('CMS_MENU_PHP', true);

/**
 *
 * Reprezentuje jedno menu.
 * Obsahuje metody na pristup k hodnotam jednotlivych stlpcov.
 *
 * @package Core
 * @subpackage Menus
 */

class CMS_Menu extends CMS_Entity
{
	const ENTITY_ID = 4;

###################################################################################################
# public
###################################################################################################

	/**
	 * Default konstruktor.
	 *
	 * @param mixed $menu_id - cislo alebo nazov menu
	 */
	public function __construct($menu_id=NULL)
	{
		if(!is_numeric($menu_id) && !empty($menu_id))
		{
			$query = new CN_SqlQuery("SELECT `id` FROM menus WHERE `name` = '$menu_id'");
			$query->execute();

			$menu_id = $query->fetchValue();
		}

		parent::__construct(CMS_Entity::ENTITY_MENU, $menu_id);
	}

###################################################################################################

	public function discard()
	{
		$query = new CN_SqlQuery("UPDATE `menus` SET `is_trash` = 1 WHERE `id` = {$this->id}");
		$query->execute();

		$this->setIsTrash(true);
	}

	public function restore()
	{
		$query = new CN_SqlQuery("UPDATE `menus` SET `is_trash`=0 WHERE `id` = {$this->id}");
		$query->execute();

		$this->setIsTrash(false);
	}

###################################################################################################

	public function isDisplayable()
	{
		if($this->getIsTrash() == 1)
			return false;

		return true;
	}

###################################################################################################

	/**
	 * Vrati zoznam objektov vsetkych clenov menu.
	 *
	 * @return CN_Vector $object_list
	 */
	public function getItems($item_type=null, $displayable_only=false, $offset=null, $limit=null, $execute=true)
	{
		$vector = new CN_Vector();

		###########################################################################################

		$where_token = null;

		if(!is_null($item_type))
		{
			$entity_table_name = null;
			$list_class_name = null;

			$display_conditions = null;

			$language = CN_Application::getSingleton()->getLanguage();

			#######################################################################################

			switch($item_type)
			{
				case CMS_Category::ENTITY_ID:
					$entity_table_name = 'categories, categories_lang';
					$list_class_name = 'CMS_CategoryList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, '`id` = `item_id`' => true, '`category_id`' => '`item_id`', 'language' => "'$language'", 'language_is_visible' => 1);
					break;

				case CMS_Article::ENTITY_ID:
					$entity_table_name = 'articles, articles_lang';
					$list_class_name = 'CMS_ArticleList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, 'is_archive' => 0, '(`expiration` >= CURRENT_DATE OR `expiration` IS NULL)' => true, '`id` = `item_id`' => true, '`article_id` = `item_id`' => true, 'language' => "'$language'", 'language_is_visible' => 1);
					break;

				case CMS_Weblink::ENTITY_ID:
					$entity_table_name = 'weblinks, weblinks_lang';
					$list_class_name = 'CMS_WeblinkList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, '`id` = `item_id`' => true, '`weblink_id`' => '`item_id`', 'language' => "'$language'", 'language_is_visible' => 1);
					break;

				// not good
				case 141:
					$entity_table_name = 'job_offer_ads';
					$list_class_name = 'CMS_Job_OfferAdList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, 'CURRENT_DATE BETWEEN `valid_from` AND `valid_to`' => true);
					break;

				case 142:
					$entity_table_name = 'job_search_ads';
					$list_class_name = 'CMS_Job_SearchAdList';
					$display_conditions = array('is_published' => 1, 'is_trash' => 0, 'CURRENT_DATE BETWEEN `valid_from` AND `valid_to`' => true);
					break;
			}

			#######################################################################################

			$list = new $list_class_name($offset, $limit);
			$list->setTableName('menus_bindings');
			$list->setIdColumnName('item_id');
			$list->setSortBy('item_id');

			$list->addCondition('menu_id', $this->id);
			$list->addCondition('item_type', $item_type);

			if($displayable_only === true)
			{
				// strasny hack, bude tot treba prerobit ak bude entitylist v nejakej rozumnej forme

				$list->setTableName('`menus_bindings`, `'.$entity_table_name.'`');
				$list->addCondition('id', '`item_id`');

				if(CMS_UserLogin::getSingleton()->isUserLogedIn() === true)
					$list->addCondition('(`access` = '.CMS::ACCESS_PUBLIC.' OR `access` = '.CMS::ACCESS_REGISTERED.')', null, null, true);
				else
					$list->addCondition('access', CMS::ACCESS_PUBLIC);

				foreach($display_conditions as $column => $value)
				{
					if(is_bool($value))
						$list->addCondition($column, null, null, true);
					else
						$list->addCondition($column, $value);
				}
			}

			if($execute === true)
				$list->execute();

			return $list;
		}

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`menus_bindings`
		WHERE
			`menu_id` = {$this->id}

		ORDER BY `order`
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			####################################################################################

			$class_name = CMS_Entity::getEntityNameById($record->getValue('item_type'));

			$menu_item = new $class_name($record->getValue('item_id'));

			if($displayable_only === true)
			{
				if($menu_item->isDisplayable())
					$vector->append($menu_item);
			}
			else
				$vector->append($menu_item);

			/*switch($record->getValue('item_type'))
			{
				case CMS_Category::ENTITY_ID:
					$category = new CMS_Category($record->getValue('item_id'));

					if($displayable_only === true)
					{
						if($category->isDisplayable())
							$vector->append($category);
					}
					else
						$vector->append($category);

					break;

				case CMS_Article::ENTITY_ID:
					$article = new CMS_Article($record->getValue('item_id'));

					if($displayable_only === true)
					{
						if($article->isDisplayable())
							$vector->append($article);
					}
					else
						$vector->append($article);

					break;

				case CMS_Weblink::ENTITY_ID:
					$weblink = new CMS_Weblink($record->getValue('item_id'));

					if($displayable_only === true)
					{
						if($weblink->isDisplayable())
							$vector->append($weblink);
					}
					else
						$vector->append($weblink);

					break;

				// not good
				case 141: // job search ad
					$entity = new CMS_Job_Search_Ad($record->getValue('item_id'));

					if($displayable_only === true)
					{
						if($entity->isDisplayable())
							$vector->append($entity);
					}
					else
						$vector->append($entity);
					break;

				case 142: // job offer ad
					$entity = new CMS_Job_Search_Ad($record->getValue('item_id'));

					if($displayable_only === true)
					{
						if($entity->isDisplayable())
							$vector->append($entity);
					}
					else
						$vector->append($entity);
					break;
			}*/
		}

		###########################################################################################

		return $vector;
	}

###################################################################################################

	public function itemExists($item)
	{
		if(!is_object($item))
			die('haluz'); // throw

		$item_type = $item->getType();

		###########################################################################################

// 		if($item instanceof CMS_Category)
// 			$item_type = CMS_Category::ENTITY_ID;
// 		elseif($item instanceof CMS_Article)
// 			$item_type = CMS_Article::ENTITY_ID;
// 		elseif($item instanceof CMS_Weblink)
// 			$item_type = CMS_Weblink::ENTITY_ID;
// 		else
// 			die('haluz'); // throw

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			menus_bindings
		WHERE
			menu_id = {$this->id} AND
			item_id = {$item->getId()} AND
			item_type = $item_type
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->getSize() > 0);
	}

	/**
	 * Prida do menu noveho clena.
	 *
	 * @param object $item - novy clen menu
	 * @return void
	 */
	public function addItem($item)
	{
		if(!is_object($item))
			die('haluz'); // throw

		$order = NULL;

		###########################################################################################

		$sql = <<<SQL
		SELECT
			MAX(`order`)
		FROM
			menus_bindings
		WHERE
			menu_id = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$order = $query->fetchValue() + 1;

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			menus_bindings
			(
				menu_id,
				item_id,
				item_type,
				`order`
			)
		VALUES
			(
				{$this->id},
				{$item->getId()},
				{$item->getType()},
				$order
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	/**
	 * Odstrani clena z menu.
	 *
	 * @param object $item - clen ktoreho treba odpalit
	 * @return void
	 */
	public function removeItem($item)
	{
		if(!is_object($item))
			; // throw

		###########################################################################################

		$sql =<<<SQL
		DELETE
		FROM
			menus_bindings
		WHERE
			menu_id = {$this->id} AND
			item_id = {$item->getId()} AND
			item_type = {$item->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		###########################################################################################

		$this->fixOrder();
	}

###################################################################################################

	/**
	 * Ulozi zmeny v hodnotach do databazy.
	 *
	 * @return void
	 */
	public function save()
	{
		if(is_null($this->id))
			$this->insertMenu();
		else
			$this->updateMenu();

		$this->updateLanguageVersions();
	}

	/**
	 * Vymaze menu z databazy aj so vsetkymi zavislostami.
	 *
	 * @return void
	 */
	public function delete()
	{
		$query = new CN_SqlQuery("DELETE FROM menus_bindings WHERE menu_id={$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM menus_lang WHERE menu_id={$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM menus WHERE id={$this->id}");
		$query->execute();

		###########################################################################################

		$this->fixOrder();
	}

###################################################################################################
# private
###################################################################################################

	private function insertMenu()
	{
		$name = '';
		$is_trash = 0;
		$editors = 'NULL';

		###########################################################################################

		if(isset($this->new_data['menus']['name']))
			$name = $this->new_data['menus']['name'] == 'NULL' ? '' : "'{$this->new_data['menus']['name']}'";
		if(isset($this->new_data['menus']['is_trash']))
			$is_trash = $this->new_data['menus']['is_trash'] == 'NULL' ? $is_trash : $this->new_data['menus']['is_trash'];
		if(isset($this->new_data['menus']['editors']))
			$editors = $this->new_data['menus']['name'] == 'NULL' ? $editors : "'{$this->new_data['menus']['editors']}'";


		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			menus
			(
				`name`,
				`is_trash`,
				`editors`
			)
		VALUES
			(
				$name,
				$is_trash,
				$editors
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateMenu()
	{
		$name = "''";
		$is_trash = 0;
		$editors = 'NULL';

		###########################################################################################

		if(isset($this->new_data['menus']['name']))
			$name = $this->new_data['menus']['name'] == 'NULL' ? 'NULL' : "'{$this->new_data['menus']['name']}'";
		else
			$name = $this->current_data['menus']['name'] == 'NULL' ? 'NULL' : "'{$this->current_data['menus']['name']}'";

		if(isset($this->new_data['menus']['is_trash']))
			$is_trash = $this->new_data['menus']['is_trash'] == 'NULL' ? $is_trash : "'{$this->new_data['menus']['is_trash']}'";
		else
			$is_trash = $this->current_data['menus']['is_trash'] == 'NULL' ? $is_trash : "'{$this->current_data['menus']['is_trash']}'";

		if(isset($this->new_data['menus']['editors']))
			$editors = $this->new_data['menus']['editors'] == 'NULL' ? $editors : "'{$this->new_data['menus']['editors']}'";
		else
			$editors = $this->current_data['menus']['editors'] == 'NULL' ? $editors : "'{$this->current_data['menus']['editors']}'";

		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`menus`
		SET
			`name` = $name,
			`is_trash` = $is_trash,
			`editors` = $editors
		WHERE
			`id` = $this->id
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateLanguageVersions()
	{
		$title = $description = NULL;

		foreach($this->new_data['menus_lang'] as $language => $language_version)
		{
			if(isset($language_version['title']))
				$title = $language_version['title'] == 'NULL' ? 'NULL' : "'{$language_version['title']}'";
			elseif(isset($this->current_data['menus_lang'][$language]['title']))
				$title = $this->current_data['menus_lang'][$language]['title'] == 'NULL' ? 'NULL' : "'{$this->current_data['menus_lang'][$language]['title']}'";
			else
				$title = 'NULL';

			if(isset($language_version['description']))
				$description = $language_version['description'] == 'NULL' ? 'NULL' : "'{$language_version['description']}'";
			elseif(isset($this->current_data['menus_lang'][$language]['description']))
				$description = $this->current_data['menus_lang'][$language]['description'] == 'NULL' ? 'NULL' : "'{$this->current_data['menus_lang'][$language]['description']}'";
			else
				$description = 'NULL';

			#######################################################################################

			$title_query_token = $title == 'NULL' ? "IS NULL" : "= $title";
			$description_query_token = $description == 'NULL' ? "IS NULL" : "= $description";

			$sql =<<<SQL
			SELECT
				COUNT(*)
			FROM
				menus_lang
			WHERE
				menu_id = $this->id AND
				language = '$language'
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();

			$record_found = $query->fetchValue();

			#######################################################################################

			if($record_found == 0)
			{
				$sql =<<<SQL
				INSERT INTO
					menus_lang
					(
						menu_id,
						language,
						title,
						description
					)
				VALUES
					(
						$this->id,
						'$language',
						$title,
						$description
					)
SQL;
			}
			elseif($record_found == 1)
			{
				$sql =<<<SQL
				UPDATE
					menus_lang
				SET
					title = $title,
					description = $description
				WHERE
					`menu_id` = $this->id AND
					`language` = '$language'
SQL;
			}
			else
				die('haluz'); // throw

			$query = new CN_SqlQuery($sql);
			$query->execute();

			#######################################################################################

			$title = $description = NULL;
		}

		###########################################################################################

		$this->readData(CMS::READ_LANG_DATA);
	}

###################################################################################################

	private function fixOrder()
	{
		$vector = new CN_Vector();

		###########################################################################################

		$query = new CN_SqlQuery("SELECT * FROM `menus_bindings` WHERE `menu_id`={$this->id} ORDER BY `order`");
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append($record->getValue('item_id'));
		}

		###########################################################################################

		$iterator = new CN_VectorIterator($vector);

		foreach($iterator as $order => $item_id)
		{
			$new_order = $order + 1;

			$query = new CN_SqlQuery("UPDATE `menus_bindings` SET `order`=$new_order WHERE `menu_id` = {$this->id} AND `item_id` = $item_id");
			$query->execute();
		}
	}

###################################################################################################
# public static
###################################################################################################

	public static function fixmenuOrder($menu_id)
	{
		$vector = new CN_Vector();

		###########################################################################################

		$query = new CN_SqlQuery("SELECT * FROM `menus_bindings` WHERE `menu_id` = $menu_id ORDER BY `order`");
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append($record->getValue('item_id'));
		}

		###########################################################################################

		$iterator = new CN_VectorIterator($vector);

		foreach($iterator as $order => $item_id)
		{
			$new_order = $order + 1;

			$query = new CN_SqlQuery("UPDATE `menus_bindings` SET `order` = $new_order WHERE `menu_id` = $menu_id AND `item_id` = $item_id");
			$query->execute();
		}
	}
}

endif;

?>
