 <?php

if(!defined('CMS_ENTITY_PHP')):
	define('CMS_ENTITY_PHP', true);

abstract class CMS_Entity
{
	const ENTITY_CATEGORY = 1;
	const ENTITY_ARTICLE = 2;
	const ENTITY_MENU = 4;
	const ENTITY_WEBLINK = 5;
	const ENTITY_USER = 6;
	const ENTITY_GROUP = 7;
	const ENTITY_UNIVERSAL = 255;

	protected $type = null;

	protected $main_table = null;
	protected $ext_table = null;
	protected $lang_table = null;

	protected $id_column_name = null;

	protected $id = null;
	protected $context_language = null;

	protected $column_list = array();

	protected $current_data = array();
	protected $new_data = array();

####################################################################################################
# public
####################################################################################################

	public function __construct($entity_type, $id)
	{
		$this->type = $entity_type;

		if(!is_null($id))
			$this->id = $id;

		$this->context_language = CN_Application::getSingleton()->getLanguage();

		############################################################################################

		switch($this->type)
		{
			case self::ENTITY_CATEGORY:
				$this->main_table = 'categories';
				$this->lang_table = 'categories_lang';
				$this->id_column_name = 'category_id';
				break;

			case self::ENTITY_ARTICLE:
				$this->main_table = 'articles';
				$this->lang_table = 'articles_lang';
				$this->id_column_name = 'article_id';
				break;

			case self::ENTITY_MENU:
				$this->main_table = 'menus';
				$this->lang_table = 'menus_lang';
				$this->id_column_name = 'menu_id';
				break;

			case self::ENTITY_USER:
				//$this->main_table = 'users';
				//$this->id_column_name = 'user_id';
				break;

			case self::ENTITY_GROUP:
				$this->main_table = 'groups';
				$this->lang_table = 'groups_lang';
				$this->id_column_name = 'group_id';
				break;

			case self::ENTITY_WEBLINK:
				$this->main_table = 'weblinks';
				$this->lang_table = 'weblinks_lang';
				$this->id_column_name = 'weblink_id';
				break;
		}

		############################################################################################

		$this->current_data[$this->main_table] = array();
		$this->current_data[$this->ext_table] = array();
		$this->current_data[$this->lang_table] = array();
		$this->new_data[$this->main_table] = array();
		$this->new_data[$this->ext_table] = array();
		$this->new_data[$this->lang_table] = array();

		############################################################################################

		$this->readColumnList();
		$this->readData();
	}

####################################################################################################

	public function __toString()
	{
		ob_start();

		print_r($this->current_data);
		$current_data_string = ob_get_contents();

		ob_clean();

		print_r($this->new_data);
		$new_data_string = ob_get_contents();

		ob_end_clean();

		$string =<<<STRING
		<pre style="text-align: left;">
			<span><strong>Current data</strong></span>
			<div>$current_data_string</div>
		</pre>

		<pre style="text-align: left;">
			<span><strong>New Data</strong></span>
			<div>$new_data_string</div>
		</pre>
STRING;

		$string = str_replace("\t", "", $string);

 		return $string;
	}

	public function __call($name, $args)
	{
	
		if(strpos($name, 'set') !== false)
		{
			$var_name = CN_Utils::getRealName(substr($name, 3));
			
//			if( $var_name == "price")
//				var_dump($this->column_list[$this->main_table]);
			########################################################################################

			if(in_array($var_name, $this->column_list[$this->main_table]))
				$this->new_data[$this->main_table][$var_name] = is_null($args[0]) ? 'NULL' : trim($args[0]);
			elseif(!is_null($this->ext_table) && in_array($var_name, $this->column_list[$this->ext_table]))
				$this->new_data[$this->ext_table][$var_name] = is_null($args[0]) ? 'NULL' : trim($args[0]);
			elseif(in_array($var_name, $this->column_list[$this->lang_table]))
				$this->new_data[$this->lang_table][$this->context_language][$var_name] = is_null($args[0]) ? 'NULL' : trim($args[0]);
			else
				throw new Exception('set: zle meno stlpca '.$var_name);//die('set: zle meno stlpca '.$var_name); // throw
		}
		elseif(strpos($name, 'get') !== false)
		{
			$var_name = CN_Utils::getRealName(substr($name, 3));

			########################################################################################

			if(in_array($var_name, $this->column_list[$this->main_table]))
				return $this->current_data[$this->main_table][$var_name] == 'NULL' ? null : $this->current_data[$this->main_table][$var_name];

			elseif(!is_null($this->ext_table))
			{
				if(in_array($var_name, $this->column_list[$this->ext_table]))
				{
					if(isset($this->current_data[$this->ext_table][$var_name]))
						return $this->current_data[$this->ext_table][$var_name] == 'NULL' ? null : $this->current_data[$this->ext_table][$var_name];
					else
						return null;
				}
			}
			elseif(in_array($var_name, $this->column_list[$this->lang_table]))
			{
				if(!isset($this->current_data[$this->lang_table][$this->context_language]))
					return null;
				else
					return $this->current_data[$this->lang_table][$this->context_language][$var_name] == 'NULL' ? NULL : $this->current_data[$this->lang_table][$this->context_language][$var_name];
			}
			else
				throw new Exception('set: zle meno stlpca '.$var_name);//die('get: zle meno stlpca '.$var_name); // throw
		}
		else
				; // throw
	}

####################################################################################################

	public function readData($to_read=CMS::READ_ALL)
	{

		if(!is_null($this->id))
		{
			if( is_numeric($this->id))
			{
				if($to_read == CMS::READ_ALL || ($to_read == CMS::READ_MAIN_DATA && !is_null($this->main_table)))
				{
					$this->current_data[$this->main_table] = array();

					$query = new CN_SqlQuery("SELECT * FROM `{$this->main_table}` WHERE `id`={$this->id}");
					$query->execute();

					while($query->next())
					{
						$record = $query->fetchRecord();

						foreach($this->column_list[$this->main_table] as $column_name)
						{
							$value = $record->getValue($column_name);

							$this->current_data[$this->main_table][$column_name] = is_null($value) ? 'NULL' : $value;
						}
					}
				}

				if(($to_read == CMS::READ_ALL && !is_null($this->lang_table)) || ($to_read == CMS::READ_LANG_DATA && !is_null($this->lang_table)))
				{
					$this->current_data[$this->lang_table] = array();

					$query = new CN_SqlQuery("SELECT * FROM `{$this->lang_table}` WHERE `{$this->id_column_name}`={$this->id}");
					$query->execute();

					while($query->next())
					{
						$record = $query->fetchRecord();

						foreach($this->column_list[$this->lang_table] as $column_name)
						{
							$value = $record->getValue($column_name);

							$this->current_data[$this->lang_table][$record->getValue('language')][$column_name] = is_null($value) ? 'NULL' : $value;
							
							if( $this->lang_table == 'articles_lang')
							{
								//var_dump($column_name);
							}
						}
					}
					
				}

				if(($to_read == CMS::READ_ALL && !is_null($this->ext_table)))
				{
					$this->current_data[$this->ext_table] = array();

					$query = new CN_SqlQuery("SELECT * FROM `{$this->ext_table}` WHERE `{$this->id_column_name}`={$this->id}");
					$query->execute();

					while($query->next())
					{
						$record = $query->fetchRecord();

						foreach($this->column_list[$this->ext_table] as $column_name)
						{
							$value = $record->getValue($column_name);

							$this->current_data[$this->ext_table][$column_name] = is_null($value) ? 'NULL' : $value;
						}
					}
				}
		
			}
			else
			{
				exit;
			}
		}
		
		//var_dump($this->current_data);
	}

###################################################################################################

	public function setContextLanguage($context_language) { $this->context_language = $context_language; }

###################################################################################################

	public function getType() { return $this->type; }
	public function getContextLanguage() { return $this->context_language; }

	public function getExtTable() { return $this->ext_table; }

###################################################################################################
# utility methods #################################################################################

	public function columnExists($column_name)
	{
		if(in_array($column_name, $this->column_list[$this->main_table]) || in_array($column_name, $this->column_list[$this->lang_table]))
			return true;

		if(!is_null($this->ext_table))
			return in_array($column_name, $this->column_list[$this->ext_table]);

		return false;
	}

###################################################################################################
# public abstract
###################################################################################################

	abstract public function save();
	abstract public function delete();

###################################################################################################
# protected
###################################################################################################

###################################################################################################
# moving methods ##################################################################################

	public function moveUpInEntity($target_entity_id, $target_id_column_name, $table_name, $move_by=1)
	{
		$vector = new CN_Vector();
		$current_index = null;
		$new_index = null;

		# fetch item list #########################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`$table_name`
		WHERE
			`$target_id_column_name` = $target_entity_id
		ORDER BY
			`order` ASC
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append(array('id' => $record->getValue('item_id'), 'type' => $record->getValue('item_type')));
		}

		# find current index ######################################################################

		foreach($vector as $order => $v_item)
		{
			if($v_item['id'] == $this->id && $v_item['type'] == $this->type)
			{
				$current_index = $order;
				break;
			}
		}

		if($current_index === null)
			return null;

		if($current_index === 0)
			return 1;

		# find new index ##########################################################################

		$skipped_items = 0;
		$v_raw_data = $vector->getRawData();

		for($i = $current_index - 1; $i >= 0; $i--)
		{
			$class_name = CMS_Entity::getEntityNameById($v_raw_data[$i]['type']);
			$entity = new $class_name($v_raw_data[$i]['id']);

			if($entity->columnExists('is_trash') === true)
			{
				if($entity->getIsTrash() == 1)
					continue;
			}

			if($skipped_items == $move_by - 1)
			{
				$new_index = $i;

				break;
			}
			else
				$skipped_items++;
		}

		# move it #################################################################################

		$vector->move($current_index, $new_index);

		foreach($vector as $order => $v_item)
		{
			$order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`$table_name`
			SET
				`order` = $order
			WHERE
				`$target_id_column_name` = $target_entity_id AND
				`item_id` = {$v_item['id']} AND
				`item_type` = {$v_item['type']}
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();
		}

		return $new_index + 1;
	}

	public function moveDownInEntity($target_entity_id, $target_id_column_name, $table_name, $move_by=1)
	{
		$vector = new CN_Vector();
		$current_index = null;
		$new_index = null;

		# fetch item list #########################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`$table_name`
		WHERE
			`$target_id_column_name` = $target_entity_id
		ORDER BY
			`order` ASC
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append(array('id' => $record->getValue('item_id'), 'type' => $record->getValue('item_type')));
		}

		# find current index ######################################################################

		foreach($vector as $order => $v_item)
		{
			if($v_item['id'] == $this->id && $v_item['type'] == $this->type)
			{
				$current_index = $order;
				break;
			}
		}

		if($current_index === null)
			return null;

		if($current_index === $vector->getSize() - 1)
			return $vector->getSize();

		# find new index ##########################################################################

		$skipped_items = 0;
		$v_raw_data = $vector->getRawData();
		$count_raw_data = count($v_raw_data);

		for($i = $current_index + 1; $i < $count_raw_data; $i++)
		{
			$class_name = CMS_Entity::getEntityNameById($v_raw_data[$i]['type']);
			$entity = new $class_name($v_raw_data[$i]['id']);

			if($entity->columnExists('is_trash') === true)
			{
				if($entity->getIsTrash() == 1)
					continue;
			}

			if($skipped_items == $move_by - 1)
			{
				$new_index = $i;

				break;
			}
			else
				$skipped_items++;
		}

		# move it #################################################################################

		$vector->move($current_index, $new_index);

		foreach($vector as $order => $v_item)
		{
			$order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`$table_name`
			SET
				`order` = $order
			WHERE
				`$target_id_column_name` = $target_entity_id AND
				`item_id` = {$v_item['id']} AND
				`item_type` = {$v_item['type']}
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();
		}

		return $new_index + 1;
	}

	public function moveToTopInEntity($target_entity_id, $target_id_column_name, $table_name)
	{
		$vector = new CN_Vector();
		$current_index = null;

		# fetch item list #########################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`$table_name`
		WHERE
			`$target_id_column_name` = $target_entity_id
		ORDER BY
			`order` ASC
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append(array('id' => $record->getValue('item_id'), 'type' => $record->getValue('item_type')));
		}

		# find current index ######################################################################

		foreach($vector as $order => $v_item)
		{
			if($v_item['id'] == $this->id && $v_item['type'] == $this->type)
			{
				$current_index = $order;
				break;
			}
		}

		if($current_index === null)
			return null;

		if($current_index === 0)
			return 1;

		# move it #################################################################################

		$vector->move($current_index, 0);

		foreach($vector as $order => $v_item)
		{
			$order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`$table_name`
			SET
				`order` = $order
			WHERE
				`$target_id_column_name` = $target_entity_id AND
				`item_id` = {$v_item['id']} AND
				`item_type` = {$v_item['type']}
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();
		}

		return 1;
	}

	public function moveToBottomInEntity($target_entity_id, $target_id_column_name, $table_name)
	{
		$vector = new CN_Vector();
		$current_index = null;

		# fetch item list #########################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`$table_name`
		WHERE
			`$target_id_column_name` = $target_entity_id
		ORDER BY
			`order` ASC
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append(array('id' => $record->getValue('item_id'), 'type' => $record->getValue('item_type')));
		}

		# find current index ######################################################################

		foreach($vector as $order => $v_item)
		{
			if($v_item['id'] == $this->id && $v_item['type'] == $this->type)
			{
				$current_index = $order;
				break;
			}
		}

		if($current_index === null)
			return null;

		if($current_index === $vector->getSize() - 1)
			return $vector->getSize();

		# move it #################################################################################

		$new_index = $vector->getSize() - 1;

		$vector->move($current_index, $new_index);

		foreach($vector as $order => $v_item)
		{
			$order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`$table_name`
			SET
				`order` = $order
			WHERE
				`$target_id_column_name` = $target_entity_id AND
				`item_id` = {$v_item['id']} AND
				`item_type` = {$v_item['type']}
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();
		}

		return $new_index + 1;
	}

###################################################################################################

	protected function createExtQuery($type)
	{
		$sql = "SELECT COUNT(*) FROM `{$this->ext_table}` WHERE `{$this->id_column_name}` = {$this->id}";
		$query = new CN_SqlQuery($sql);
		$query->execute();

		if($query->fetchValue() == 0)
			$type = CN_SqlQuery::TYPE_INSERT;
		else
			$type = CN_SqlQuery::TYPE_UPDATE;

		###########################################################################################

		if($type === CN_SqlQuery::TYPE_INSERT)
		{
			$this->new_data[$this->ext_table][$this->id_column_name] = $this->id; // vlozi klucovy stlpec do pola ext table

			$columns = '';
			$values = '';

			foreach($this->column_list[$this->ext_table] as $column_name)
			{
				$columns .= "`$column_name`, ";

				if(isset($this->new_data[$this->ext_table][$column_name]))
				{
					if(is_string($this->new_data[$this->ext_table][$column_name]))
						$values .= "'{$this->new_data[$this->ext_table][$column_name]}', ";
					else
						$values .= $this->new_data[$this->ext_table][$column_name].", ";
				}
				else
					$values .= 'NULL, ';
			}

			$columns = rtrim($columns, ', ');
			$values = rtrim($values, ', ');

			$sql =<<<SQL
			INSERT INTO
				`{$this->ext_table}`
				(
					$columns
				)
			VALUES
				(
					$values
				)
SQL;

			return $sql;
		}
		elseif($type === CN_SqlQuery::TYPE_UPDATE)
		{
			$rows = '';

			foreach($this->column_list[$this->ext_table] as $column_name)
			{
				$rows .= "`$column_name` = ";

				if(isset($this->new_data[$this->ext_table][$column_name]))
				{
					if(is_string($this->new_data[$this->ext_table][$column_name]))
						$rows .= "'{$this->new_data[$this->ext_table][$column_name]}', ";
					else
						$rows .= $this->new_data[$this->ext_table][$column_name].", ";
				}
				else
				{
					if(is_string($this->current_data[$this->ext_table][$column_name]))
						$rows .= "'{$this->current_data[$this->ext_table][$column_name]}', ";
					else
						$rows .= $this->current_data[$this->ext_table][$column_name].", ";
				}
			}

			$rows = rtrim($rows, ', ');

			$sql =<<<SQL
			UPDATE
				`{$this->ext_table}`
			SET
				$rows
			WHERE
				`{$this->id_column_name}` = {$this->id}
SQL;

			return $sql;
		}
	}

####################################################################################################
# private
####################################################################################################

	private function readColumnList()
	{
		if(!is_null($this->main_table))
		{
			$table_info = CN_SqlTableInfo::getSingleton();
			$table_info->setName($this->main_table);
			$column_list = $table_info->getColumnList();

			foreach($column_list as $column)
				$this->column_list[$this->main_table][] = $column->getName();
		}

		if(!is_null($this->lang_table))
		{
			$table_info = CN_SqlTableInfo::getSingleton();
			$table_info->setName($this->lang_table);
			$column_list = $table_info->getColumnList();

			foreach($column_list as $column)
				$this->column_list[$this->lang_table][] = $column->getName();
				
			if($this->lang_table == 'articles_lang')	
			{
				//echo "<pre>";
				//var_dump($this->column_list);
			}
		}

		if(!is_null($this->ext_table))
		{
			$table_info = CN_SqlTableInfo::getSingleton();
			$table_info->setName($this->ext_table);
			$column_list = $table_info->getColumnList();

			foreach($column_list as $column)
				$this->column_list[$this->ext_table][] = $column->getName();
		}
	}

####################################################################################################
# public static
####################################################################################################

	public static function getEntityNameById($entity_id)
	{
		$entity_map_file = $GLOBALS['cms_root'].DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'entity_map.xml';

		if(function_exists('ioncube_read_file'))
			$xml = simplexml_load_string(ioncube_read_file($entity_map_file));
		else
			$xml = simplexml_load_file($entity_map_file);

		$entity = $xml->xpath("//module/entity[@id='$entity_id']");

		if(empty($entity))
			throw new CN_Exception(tr(sprintf("Entity with id %s doesn't exists.", $entity_id)), E_ERROR);

		return (string)$entity[0]['class_name'];
	}
}

endif;

?>
