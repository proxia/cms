<?php

if(!defined('CMS_WEBLINK_PHP')):
	define('CMS_WEBLINK_PHP', TRUE);

class CMS_Weblink extends CMS_Entity
{
	const ENTITY_ID = 5;

###################################################################################################
# public
###################################################################################################

	public function __construct($weblink_id=null)
	{
		parent::__construct(self::ENTITY_ID, $weblink_id);
	}

###################################################################################################

	public function discard()
	{
		$query = new CN_SqlQuery("UPDATE `weblinks` SET `is_trash` = 1 WHERE `id` = {$this->id}");
		$query->execute();

		$this->setIsTrash(true);
	}

	public function restore()
	{
		$query = new CN_SqlQuery("UPDATE `weblinks` SET `is_trash` = 0 WHERE `id` = {$this->id}");
		$query->execute();

		$this->setIsTrash(false);
	}

###################################################################################################

	public function isDisplayable()
	{
		if($this->getIsPublished() == 0)
			return false;

		if(!isset($this->current_data[$this->lang_table][$this->context_language]) || $this->getLanguageIsVisible() == 0)
			return false;

		if(CMS_UserLogin::getSingleton()->isUserLogedIn() !== true)
		{
			if($this->getAccess() == CMS::ACCESS_REGISTERED)
				return false;
		}

		return true;
	}

###################################################################################################

	public function hasParent()
	{
		$item_type = self::ENTITY_ID;

		$sql =<<<SQL
		SELECT
			COUNT(DISTINCT `category_id`)
		FROM
			`categories_bindings`
		WHERE
			`item_id` = {$this->id} AND
			`item_type` = $item_type
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->fetchValue() > 0);
	}

	public function getParentCount()
	{
		$item_type = self::ENTITY_ID;

		$sql =<<<SQL
		SELECT
			COUNT(DISTINCT `category_id`)
		FROM
			`categories_bindings`
		WHERE
			`item_id` = {$this->id} AND
			`item_type` = $item_type
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return $query->fetchValue();
	}

	public function getParents($id_only=false)
	{
		$parent_list = new CN_Vector();

		###########################################################################################

		$item_type = self::ENTITY_ID;

		$sql =<<<SQL
		SELECT
			DISTINCT `category_id`
		FROM
			`categories_bindings`
		WHERE
			`item_id` = {$this->id} AND
			`item_type` = $item_type
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			if($id_only === true)
				$parent_list->append($record->getValue('category_id'));
			else
				$parent_list->append(new CMS_Category($record->getValue('category_id')));
		}

		###########################################################################################

		return $parent_list;
	}

###################################################################################################

	public function getMenuList($id_only=false)
	{
		$vector = new CN_Vector();

		###########################################################################################

		$item_type = self::ENTITY_ID;

		$sql =<<<SQL
		SELECT
			`menu_id`
		FROM
			`menus_bindings`
		WHERE
			`item_type` = $item_type AND
			`item_id`={$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			if($id_only === true)
				$vector->append($record->getValue('menu_id'));
			else
				$vector->append(new CMS_Menu($record->getValue('menu_id')));
		}

		###########################################################################################

		return $vector;
	}

###################################################################################################
# move methods ####################################################################################

# move in category ################################################################################

	/**
	 * Posunie weblink o jeden alebo viac stupnov hore. Musi byt nastavene $context_parent_id.
	 *
	 * @param int $move_by - o kolko stupnov hore sa ma clanok posunut
	 * @return int $new_position
	 */
	public function moveUpInCategory($category_id, $move_by=1) { return $this->moveUpInEntity($category_id, 'category_id', 'categories_bindings', $move_by); }

	/**
	 * Posunie weblink o jeden alebo viac stupnov dole. Musi byt nastavene $context_parent_id.
	 *
	 * @param int $move_by - o kolko stupnov sa ma clanok posunut
	 * @return int $new_position
	 */
	public function moveDownInCategory($category_id, $move_by=1) { return $this->moveDownInEntity($category_id, 'category_id', 'categories_bindings', $move_by); }
	
	/**
	 * Posunie weblink na vrch v hierarchii. Musi byt nastavene $context_parent_id.
	 *
	 * @return int $new_position
	 */
	public function moveToTopInCategory($category_id) { return $this->moveToTopInEntity($category_id, 'category_id', 'categories_bindings'); }
	
	/**
	 * Posunie weblink na spodok v hierarchii. Musi byt nastavene $context_parent_id.
	 *
	 * @return int $new_position
	 */
	public function moveToBottomInCategory($category_id) { return $this->moveToBottomInEntity($category_id, 'category_id', 'categories_bindings'); }

# move in menu ####################################################################################

	public function moveUpInMenu($menu_id, $move_by=1) { return $this->moveUpInEntity($menu_id, 'menu_id', 'menus_bindings', $move_by); }
	public function moveDownInMenu($menu_id, $move_by=1) { return $this->moveDownInEntity($menu_id, 'menu_id', 'menus_bindings', $move_by); }
	public function moveToTopInMenu($menu_id) { return $this->moveToTopInEntity($menu_id, 'menu_id', 'menus_bindings'); }
	public function moveToBottomInMenu($menu_id) { return $this->moveToBottomInEntity($menu_id, 'menu_id', 'menus_bindings'); }

###################################################################################################

	public function save()
	{
		if(is_null($this->id))
			$this->insertWeblink();
		else
			$this->updateWeblink();

		$this->updateLanguageVersions();
	}

	public function delete()
	{
		{
			$menu_list = $this->getMenuList(true);

			#######################################################################################

			$query = new CN_SqlQuery("DELETE FROM `menus_bindings` WHERE `item_id`={$this->id} AND `item_type` = ".self::ENTITY_ID);
			$query->execute();

			#######################################################################################

			$iterator = new CN_VectorIterator($menu_list);

			foreach($iterator as $menu_id)
				CMS_Menu::fixMenuOrder($menu_id);
		}

		###########################################################################################

		{
			$parent_list = $this->getParents(true);

			#######################################################################################

			$query = new CN_SqlQuery("DELETE FROM `categories_bindings` WHERE `item_id` = {$this->id} AND `item_type` = ".self::ENTITY_ID);
			$query->execute();

			#######################################################################################

			$iterator = new CN_VectorIterator($parent_list);

			foreach($iterator as $category_id)
				CMS_Category::fixCategoryOrder($category_id);
		}

		###########################################################################################

		$query = new CN_SqlQuery("DELETE FROM `weblinks_lang` WHERE `weblink_id`={$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM `weblinks` WHERE `id`={$this->id}");
		$query->execute();

		$this->id = null;
		$this->current_data = null;
		$this->new_data = null;
	}

###################################################################################################
# private
###################################################################################################

	private function insertWeblink()
	{
		$url = "''";
		$target = "'_NEW'";
		$is_trash = 0;
		$is_published = 1;
		$access = CMS::ACCESS_PUBLIC;
		$access_groups = 'NULL';
		$image = 'NULL';
		$usable_by = CMS_Entity::ENTITY_UNIVERSAL;

		##########################################################################################

		if(isset($this->new_data['weblinks']['url']))
			$url = $this->new_data['weblinks']['url'] === 'NULL' ? "$url" : "'{$this->new_data['weblinks']['url']}'";
		if(isset($this->new_data['weblinks']['target']))
			$target = $this->new_data['weblinks']['target'] === 'NULL' ? "$target" : "'{$this->new_data['weblinks']['target']}'";
		if(isset($this->new_data['weblinks']['is_trash']))
			$is_trash = $this->new_data['weblinks']['is_trash'] === 'NULL' ? $is_trash : (int)$this->new_data['weblinks']['is_trash'];
		if(isset($this->new_data['weblinks']['is_published']))
			$is_published = $this->new_data['weblinks']['is_published'] === 'NULL' ? $is_published : (int)$this->new_data['weblinks']['is_published'];
		if(isset($this->new_data[$this->main_table]['access']))
			$access = $this->new_data[$this->main_table]['access'] === 'NULL' ? $access : $this->new_data[$this->main_table]['access'];
		if(isset($this->new_data[$this->main_table]['access_groups']))
			$access_groups = $this->new_data[$this->main_table]['access_groups'] === 'NULL' ? $access_groups : "'{$this->new_data[$this->main_table]['access_groups']}'";
		if(isset($this->new_data['weblinks']['image']))
			$image = $this->new_data['weblinks']['image'] === 'NULL' ? $image : "'{$this->new_data['weblinks']['image']}'";
		if(isset($this->new_data['weblinks']['usable_by']))
			$usable_by = $this->new_data['weblinks']['usable_by'] === 'NULL' ? $usable_by : $this->new_data['weblinks']['usable_by'];

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`weblinks`
			(
				`creation`,
				`url`,
				`target`,
				`is_trash`,
				`is_published`,
				`access`,
				`access_groups`,
				`image`,
				`usable_by`
			)
		VALUES
			(
				NOW(),
				$url,
				$target,
				$is_trash,
				$is_published,
				$access,
				$access_groups,
				$image,
				$usable_by
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateWeblink()
	{
		$url = $target = $is_trash = $is_published = null;

		$access = CMS::ACCESS_PUBLIC;
		$access_groups = 'NULL';
		$image = 'NULL';
		$usable_by = CMS_Entity::ENTITY_UNIVERSAL;

		###########################################################################################

		if(isset($this->new_data['weblinks']['url']))
			$url = $this->new_data['weblinks']['url'] === 'NULL' ? "''" : "'{$this->new_data['weblinks']['url']}'";
		else
			$url = $this->current_data['weblinks']['url'] === 'NULL' ? "''" : "'{$this->current_data['weblinks']['url']}'";

		if(isset($this->new_data['weblinks']['target']))
			$target = $this->new_data['weblinks']['target'] === 'NULL' ? "'_NEW'" : "'{$this->new_data['weblinks']['target']}'";
		else
			$target = $this->current_data['weblinks']['target'] === 'NULL' ? "'_NEW'" : "'{$this->current_data['weblinks']['target']}'";

		if(isset($this->new_data['weblinks']['is_trash']))
			$is_trash = $this->new_data['weblinks']['is_trash'] === 'NULL' ? 0 : (int)$this->new_data['weblinks']['is_trash'];
		else
			$is_trash = $this->current_data['weblinks']['is_trash'] === 'NULL' ? 0 : (int)$this->current_data['weblinks']['is_trash'];

		if(isset($this->new_data['weblinks']['is_published']))
			$is_published = $this->new_data['weblinks']['is_published'] === 'NULL' ? 0 : (int)$this->new_data['weblinks']['is_published'];
		else
			$is_published = $this->current_data['weblinks']['is_published'] === 'NULL' ? 0 : (int)$this->current_data['weblinks']['is_published'];

		if(isset($this->new_data[$this->main_table]['access']))
			$access = $this->new_data[$this->main_table]['access'] === 'NULL' ? $access : $this->new_data[$this->main_table]['access'];
		else
			$access = $this->current_data[$this->main_table]['access'] === 'NULL' ? $access : $this->current_data[$this->main_table]['access'];

		if(isset($this->new_data[$this->main_table]['access_groups']))
			$access_groups = $this->new_data[$this->main_table]['access_groups'] === 'NULL' ? $access_groups : "'{$this->new_data[$this->main_table]['access_groups']}'";
		else
			$access_groups = $this->current_data[$this->main_table]['access_groups'] === 'NULL' ? $access_groups : "'{$this->current_data[$this->main_table]['access_groups']}'";

		if(isset($this->new_data[$this->main_table]['image']))
			$image = $this->new_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->new_data[$this->main_table]['image']}'";
		else
			$image = $this->current_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->current_data[$this->main_table]['image']}'";

		if(isset($this->new_data[$this->main_table]['usable_by']))
			$usable_by = $this->new_data[$this->main_table]['usable_by'] === 'NULL' ? $usable_by : $this->new_data[$this->main_table]['usable_by'];
		else
			$usable_by = $this->current_data[$this->main_table]['usable_by'] === 'NULL' ? $usable_by : $this->current_data[$this->main_table]['usable_by'];

		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`weblinks`
		SET
			`url` = $url,
			`target` = $target,
			`is_trash` = $is_trash,
			`is_published` = $is_published,
			`access` = $access,
			`access_groups` = $access_groups,
			`image` = $image,
			`usable_by` = $usable_by

		WHERE
			`id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateLanguageVersions()
	{
		$title = $description = $language_is_visible = null;

		###########################################################################################

		foreach($this->new_data['weblinks_lang'] as $language => $language_version)
		{
			if(isset($language_version['title']))
				$title = $language_version['title'] == 'NULL' ? "''" : "'{$language_version['title']}'";
			elseif(isset($this->current_data['weblinks_lang'][$language]['title']))
				$title = $this->current_data['weblinks_lang'][$language]['title'] == 'NULL' ? "''" : "'{$this->current_data['weblinks_lang'][$language]['title']}'";
			else
				$title = "''";

			if(isset($language_version['description']))
				$description = $language_version['description'] == 'NULL' ? 'NULL' : "'{$language_version['description']}'";
			elseif(isset($this->current_data['weblinks_lang'][$language]['description']))
				$description = $this->current_data['weblinks_lang'][$language]['description'] == 'NULL' ? 'NULL' : "'{$this->current_data['weblinks_lang'][$language]['description']}'";
			else
				$description = 'NULL';

			if(isset($language_version['language_is_visible']))
				$language_is_visible = $language_version['language_is_visible'] === 'NULL' ? 0 : $language_version['language_is_visible'];
			elseif(isset($this->current_data['weblinks_lang'][$language]['language_is_visible']))
				$language_is_visible = $this->current_data['weblinks_lang'][$language]['language_is_visible'] === 'NULL' ? 0 : $this->current_data['weblinks_lang'][$language]['language_is_visible'];
			else
				$language_is_visible = 0;

			#######################################################################################

			$sql =<<<SQL
			SELECT
				COUNT(*)
			FROM
				weblinks_lang
			WHERE
				weblink_id = {$this->id} AND
				language = '$language'
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();

			$record_count = $query->fetchValue();

			#######################################################################################

			if($record_count == 0)
			{
				$sql =<<<SQL
				INSERT INTO
					weblinks_lang
					(
						weblink_id,
						language,
						title,
						description,
						`language_is_visible`
					)
				VALUES
					(
						{$this->id},
						'$language',
						$title,
						$description,
						$language_is_visible
					)
SQL;
			}
			elseif($record_count == 1)
			{
				$sql =<<<SQL
				UPDATE
					weblinks_lang
				SET
					title = $title,
					description = $description,
					`language_is_visible` = $language_is_visible
				WHERE
					weblink_id = {$this->id} AND
					language = '$language'
SQL;
			}
			else
				die('haluz'); // throw

			$query = new CN_SqlQuery($sql);
			$query->execute();

			#######################################################################################

			$title = $description = $language_is_visible = null;
		}

		###########################################################################################

		$this->readData(CMS::READ_LANG_DATA);
	}
}

endif;

?>