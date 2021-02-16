<?php

if(!defined('CMS_CATALOG_PRODUCTATTRIBUTE_PHP')):
	define('CMS_CATALOG_PRODUCTATTRIBUTE_PHP', true);

class CMS_Catalog_ProductAttribute extends CMS_Entity
{
	const ENTITY_ID = 105;

###################################################################################################
# public
###################################################################################################

	public function __construct($product_id=null)
	{
		$this->main_table = 'catalog_product_attributes';
		$this->lang_table = 'catalog_product_attributes_lang';
		$this->id_column_name = 'product_attribute_id';

		###########################################################################################

		parent::__construct(self::ENTITY_ID, $product_id);
	}


###################################################################################################
# positioning #####################################################################################

	public function moveUp($move_by=1)
	{
		$vector = new CN_Vector();
		$current_index = null;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`{$this->main_table}`
		WHERE
			`product_id` = {$this->getProductId()}
		ORDER BY
			`order` ASC
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append($record->getValue('id'));
		}

		###########################################################################################

		foreach($vector as $order => $v_item)
		{
			if($v_item == $this->id)
			{
				$current_index = $order;
				break;
			}
		}

		if($current_index === null)
			return null;

		$new_index = $current_index - $move_by;

		if($new_index > $vector->getSize() - 1 || $new_index < 0)
			throw new CN_Exception(sprintf(tr("Can't move item out of boundry. Vector index: %1\$s, New index: %2\$s"), $vector->getSize() - 1, $new_index));

		$vector->move($current_index, $new_index);

		$iterator = new CN_VectorIterator($vector);

		foreach($iterator as $order => $attribute)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`{$this->main_table}`
			SET
				`order` = $new_order
			WHERE
				`id` = $attribute
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();
		}

		return $new_index + 1;
	}
	
	public function moveDown($move_by=1)
	{
		$vector = new CN_Vector();
		$current_index = null;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`{$this->main_table}`
		WHERE
			`product_id` = {$this->getProductId()}
		ORDER BY
			`order` ASC
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append($record->getValue('id'));
		}

		###########################################################################################

		foreach($vector as $order => $v_item)
		{
			if($v_item == $this->id)
			{
				$current_index = $order;
				break;
			}
		}

		if($current_index === null)
			return null;

		$new_index = $current_index + $move_by;

		if($new_index > $vector->getSize() - 1 || $new_index < 0)
			throw new CN_Exception(sprintf(tr("Can't move item out of boundry. Vector index: %1\$s, New index: %2\$s"), $vector->getSize() - 1, $new_index));

		$vector->move($current_index, $new_index);

		$iterator = new CN_VectorIterator($vector);

		foreach($iterator as $order => $attribute)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`{$this->main_table}`
			SET
				`order` = $new_order
			WHERE
				`id` = $attribute
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();
		}

		return $new_index + 1;
	}
	
	public function moveToTop()
	{
		$vector = new CN_Vector();
		$current_index = null;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`{$this->main_table}`
		WHERE
			`product_id` = {$this->getProductId()}
		ORDER BY
			`order` ASC
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append($record->getValue('id'));
		}

		###########################################################################################

		foreach($vector as $order => $v_item)
		{
			if($v_item == $this->id)
			{
				$current_index = $order;
				break;
			}
		}

		if($current_index === null)
			return null;

		$vector->move($current_index, 0);

		$iterator = new CN_VectorIterator($vector);

		foreach($iterator as $order => $attribute)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`{$this->main_table}`
			SET
				`order` = $new_order
			WHERE
				`id` = $attribute
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();
		}

		return 1;
	}
	
	public function moveToBottom()
	{
		$vector = new CN_Vector();
		$current_index = null;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`{$this->main_table}`
		WHERE
			`product_id` = {$this->getProductId()}
		ORDER BY
			`order` ASC
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append($record->getValue('id'));
		}

		###########################################################################################

		foreach($vector as $order => $v_item)
		{
			if($v_item == $this->id)
			{
				$current_index = $order;
				break;
			}
		}

		if($current_index === null)
			return null;

		$new_index = $vector->getSize() - 1;

		$vector->move($current_index, $new_index);

		$iterator = new CN_VectorIterator($vector);

		foreach($iterator as $order => $attribute)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`{$this->main_table}`
			SET
				`order` = $new_order
			WHERE
				`id` = $attribute
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();
		}

		return $new_index + 1;
	}

###################################################################################################

	public function save()
	{
		if(is_null($this->id))
			$this->insertEntity();
		else
			$this->updateEntity();

		$this->updateLanguageVersions();
	}

	public function delete()
	{
		# price bindings ##########################################################################

		

		# main bindings ###########################################################################

		$query = new CN_SqlQuery("DELETE FROM `{$this->lang_table}` WHERE `{$this->id_column_name}` = {$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM `{$this->main_table}` WHERE `id` = {$this->id}");
		$query->execute();
	}

###################################################################################################
# private
###################################################################################################

	private function insertEntity()
	{
		$attribute_definition_id = 0;
		$product_id = 0;
		$image = 'null';
	
		###########################################################################################

		if(isset($this->new_data[$this->main_table]['attribute_definition_id']))
			$attribute_definition_id = $this->new_data[$this->main_table]['attribute_definition_id'] === 'NULL' ? $attribute_definition_id : $this->new_data[$this->main_table]['attribute_definition_id'];
		if(isset($this->new_data[$this->main_table]['product_id']))
			$product_id = $this->new_data[$this->main_table]['product_id'] === 'NULL' ? $product_id : $this->new_data[$this->main_table]['product_id'];
		if(isset($this->new_data[$this->main_table]['image']))
			$image = $this->new_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->new_data[$this->main_table]['image']}'";
		
		###########################################################################################
	
		$sql =<<<SQL
		SELECT
			MAX(`order`)
		FROM
			`{$this->main_table}`
		WHERE
			`product_id` = $product_id
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
		
		$order = $query->fetchValue() + 1;
	
		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`attribute_definition_id`,
				`product_id`,
				`image`,
				`order`
			)
		VALUES
			(
				$attribute_definition_id,
				$product_id,
				$image,
				$order
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateEntity()
	{
		$attribute_definition_id = 0;
		$product_id = 0;
		$image = 'NULL';

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['attribute_definition_id']))
			$attribute_definition_id = $this->new_data[$this->main_table]['attribute_definition_id'] === 'NULL' ? $attribute_definition_id : $this->new_data[$this->main_table]['attribute_definition_id'];
		else
			$attribute_definition_id = $this->current_data[$this->main_table]['attribute_definition_id'] === 'NULL' ? $attribute_definition_id : $this->current_data[$this->main_table]['attribute_definition_id'];

		if(isset($this->new_data[$this->main_table]['product_id']))
			$product_id = $this->new_data[$this->main_table]['product_id'] === 'NULL' ? $product_id : $this->new_data[$this->main_table]['product_id'];
		else
			$product_id = $this->current_data[$this->main_table]['product_id'] === 'NULL' ? $product_id : $this->current_data[$this->main_table]['product_id'];

		if(isset($this->new_data[$this->main_table]['image']))
			$image = $this->new_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->new_data[$this->main_table]['image']}'";
		else
			$image = $this->current_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->current_data[$this->main_table]['image']}'";

		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`attribute_definition_id` = $attribute_definition_id,
			`product_id` = $product_id,
			`image` = $image
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
		$value = "''";

		foreach($this->new_data[$this->lang_table] as $language => $language_version)
		{
			if(isset($language_version['value']))
				$value = $language_version['value'] === 'NULL' ? $value : "'{$language_version['value']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['value']))
				$value = $this->current_data[$this->lang_table][$language]['value'] == 'NULL' ? $value : "'{$this->current_data[$this->lang_table][$language]['value']}'";

			#######################################################################################

			$sql =<<<SQL
			SELECT
				COUNT(*)
			FROM
				`{$this->lang_table}`
			WHERE
				`{$this->id_column_name}` = {$this->id} AND
				`language` = '$language'
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();

			$record_count = $query->fetchValue();

			#######################################################################################

			if($record_count == 0)
			{
				$sql =<<<SQL
				INSERT INTO
					`{$this->lang_table}`
					(
						`{$this->id_column_name}`,
						`language`,
						`value`
					)
				VALUES
					(
						{$this->id},
						'$language',
						$value
					)
SQL;
			}
			elseif($record_count == 1)
			{
				$sql =<<<SQL
				UPDATE
					`{$this->lang_table}`
				SET
					`value` = $value
				WHERE
					`{$this->id_column_name}` = {$this->id} AND
					`language` = '$language'
SQL;
			}
			else
				throw new CN_Exception(sprintf(tr("There are loose data in table `%1\$s` for `id` %2\$s.", $this->lang_table, $this->id)), E_ERROR);

			$query = new CN_SqlQuery($sql);
			$query->execute();

			#######################################################################################

			$value = "''";
		}

		###########################################################################################

		$this->readData(CMS::READ_LANG_DATA);
	}
}

endif;

?>