<?php

if(!defined('CMS_CATALOG_ATTRIBUTEDEFINITION_PHP')):
	define('CMS_CATALOG_ATTRIBUTEDEFINITION_PHP', true);

class CMS_Catalog_AttributeDefinition extends CMS_Entity
{
	const ENTITY_ID = 103;

###################################################################################################
# public
###################################################################################################

	public function __construct($attribute_id=null)
	{
		$this->main_table = 'catalog_attributes_definition';
		$this->lang_table = 'catalog_attributes_definition_lang';
		$this->id_column_name = 'attribute_definition_id';

		###########################################################################################

		parent::__construct(self::ENTITY_ID, $attribute_id);
	}

###################################################################################################

	public function getProducts($offset=null, $limit=null, $execute=true)
	{
		$product_list = new CMS_Catalog_ProductList($offset, $limit);
		$product_list->setTableName('catalog_product_attributes');
		$product_list->setIdColumnName('product_id');
		$product_list->addCondition('attribute_definition_id', $this->id);

		if($execute === true)
			$product_list->execute();

		return $product_list;
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
		# product bindings ########################################################################

		$attribute_list = new CMS_Catalog_ProductAttributeList();
		$attribute_list->addCondition('attribute_definition_id', $this->id);
		$attribute_list->execute();

		foreach($attribute_list as $attribute)
			$attribute->delete();

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
		$catalog_id = 0;
		$image = 'NULL';
		
		###########################################################################################

		if(isset($this->new_data[$this->main_table]['catalog_id']))
			$catalog_id = $this->new_data[$this->main_table]['catalog_id'] === 'NULL' ? $catalog_id : $this->new_data[$this->main_table]['catalog_id'];

		if(isset($this->new_data[$this->main_table]['image']))
			$image = $this->new_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->new_data[$this->main_table]['image']}'";

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`creation`,
				`catalog_id`,
				`image`
			)
		VALUES
			(
				NOW(),
				$catalog_id,
				$image
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
		$catalog_id = 0;
		$image = 'NULL';
	
		###########################################################################################

		if(isset($this->new_data[$this->main_table]['catalog_id']))
			$catalog_id = $this->new_data[$this->main_table]['catalog_id'] === 'NULL' ? $catalog_id : "'{$this->new_data[$this->main_table]['catalog_id']}'";
		else
			$catalog_id = $this->current_data[$this->main_table]['catalog_id'] === 'NULL' ? $catalog_id : "'{$this->current_data[$this->main_table]['catalog_id']}'";

		if(isset($this->new_data[$this->main_table]['image']))
			$image = $this->new_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->new_data[$this->main_table]['image']}'";
		else
			$image = $this->current_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->current_data[$this->main_table]['image']}'";

		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`catalog_id` = $catalog_id,
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
		$title = "''";
		$description = 'NULL';

		foreach($this->new_data[$this->lang_table] as $language => $language_version)
		{
			if(isset($language_version['title']))
				$title = $language_version['title'] === 'NULL' ? $title : "'{$language_version['title']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['title']))
				$title = $this->current_data[$this->lang_table][$language]['title'] == 'NULL' ? $title : "'{$this->current_data[$this->lang_table][$language]['title']}'";

			if(isset($language_version['description']))
				$description = $language_version['description'] === 'NULL' ? 'NULL' : "'{$language_version['description']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['description']))
				$description = $this->current_data[$this->lang_table][$language]['description'] === 'NULL' ? $description : "'{$this->current_data[$this->lang_table][$language]['description']}'";

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
						`title`,
						`description`
					)
				VALUES
					(
						{$this->id},
						'$language',
						$title,
						$description
					)
SQL;
			}
			elseif($record_count == 1)
			{
				$sql =<<<SQL
				UPDATE
					`{$this->lang_table}`
				SET
					`title` = $title,
					`description` = $description
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

			$title = "''";
			$description = 'NULL';
		}

		###########################################################################################

		$this->readData(CMS::READ_LANG_DATA);
	}
}

endif;

?>