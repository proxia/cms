<?php

if(!defined('CMS_CATALOG_PRICE_PHP')):
	define('CMS_CATALOG_PRICE_PHP', true);

class CMS_Catalog_Price extends	CMS_Entity
{
	const ENTITY_ID = 102;

###################################################################################################
# public
###################################################################################################

	public function __construct($price_id=null)
	{
		$this->main_table = 'catalog_prices';
		$this->lang_table = 'catalog_prices_lang';
		$this->id_column_name = 'price_id';
		
		###########################################################################################

		parent::__construct(self::ENTITY_ID, $price_id);
	}

###################################################################################################

	public function isValid()
	{
		$current_time = strtotime('now');
		$from_time = strtotime($this->current_data[$this->main_table]['valid_from']);
		$to_time = strtotime($this->current_data[$this->main_table]['valid_to']);

		return (($current_time >= $from_time) && ($current_time <= $to_time));
	}

###################################################################################################

	public function save()
	{
		if(is_null($this->id))
			$this->insertPrice();
		else
			$this->updatePrice();

		$this->updateLanguageVersions();
	}

	public function delete()
	{
	
		# main bindings ###########################################################################
		
		$query = new CN_SqlQuery("DELETE FROM `{$this->lang_table}` WHERE `{$this->id_column_name}` = {$this->id}");
		$query->execute();
		
		$query = new CN_SqlQuery("DELETE FROM `{$this->main_table}` WHERE `id` = {$this->id}");
		$query->execute();
		
	}

###################################################################################################
# private
###################################################################################################

	private function insertPrice()
	{
		$product_id = 0;
		$is_published = (int)true;
		$price = 0.0;
		$currency = "'SKK'";
		$valid_from = 'NULL';
		$valid_to = 'NULL';
		$access = CMS::ACCESS_PUBLIC;
		$access_groups = 'NULL';

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['product_id']))
			$product_id = $this->new_data[$this->main_table]['product_id'] === 'NULL' ? $product_id : $this->new_data[$this->main_table]['product_id'];
		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : (int)$this->new_data[$this->main_table]['is_published'];
		if(isset($this->new_data[$this->main_table]['price']))
			$price = $this->new_data[$this->main_table]['price'] === 'NULL' ? $price : $this->new_data[$this->main_table]['price'];
		if(isset($this->new_data[$this->main_table]['currency']))
			$currency = $this->new_data[$this->main_table]['currency'] === 'NULL' ? $currency : "'{$this->new_data[$this->main_table]['currency']}'";
		if(isset($this->new_data[$this->main_table]['valid_from']))
			$valid_from = $this->new_data[$this->main_table]['valid_from'] === 'NULL' ? $valid_from : "'{$this->new_data[$this->main_table]['valid_from']}'";
		if(isset($this->new_data[$this->main_table]['valid_to']))
			$valid_to = $this->new_data[$this->main_table]['valid_to'] === 'NULL' ? $valid_to : "'{$this->new_data[$this->main_table]['valid_to']}'";
		if(isset($this->new_data[$this->main_table]['access']))
			$access = $this->new_data[$this->main_table]['access'] === 'NULL' ? $access : $this->new_data[$this->main_table]['access'];
		if(isset($this->new_data[$this->main_table]['access_groups']))
			$access_groups = $this->new_data[$this->main_table]['access_groups'] === 'NULL' ? $access_groups : "'{$this->new_data[$this->main_table]['access_groups']}'";

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`creation`,
				`product_id`,
				`is_published`,
				`price`,
				`currency`,
				`valid_from`,
				`valid_to`,
				`access`,
				`access_groups`
			)
		VALUES
			(
				NOW(),
				$product_id,
				$is_published,
				$price,
				$currency,
				$valid_from,
				$valid_to,
				$access,
				$access_groups
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updatePrice()
	{
		$product_id = 0;
		$is_published = true;
		$price = 0.0;
		$currency = "'SKK'";
		$valid_from = 'NULL';
		$valid_to = 'NULL';
		$access = CMS::ACCESS_PUBLIC;
		$access_groups = 'NULL';

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['product_id']))
			$product_id = $this->new_data[$this->main_table]['product_id'] === 'NULL' ? $product_id : $this->new_data[$this->main_table]['product_id'];
		else
			$product_id = $this->current_data[$this->main_table]['product_id'] === 'NULL' ? $product_id : $this->current_data[$this->main_table]['product_id'];

		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? (int)$is_published : (int)$this->new_data[$this->main_table]['is_published'];
		else
			$is_published = $this->current_data[$this->main_table]['is_published'] === 'NULL' ? (int)$is_published : (int)$this->current_data[$this->main_table]['is_published'];

		if(isset($this->new_data[$this->main_table]['price']))
			$price = $this->new_data[$this->main_table]['price'] === 'NULL' ? $price : $this->new_data[$this->main_table]['price'];
		else
			$price = $this->current_data[$this->main_table]['price'] === 'NULL' ? $price : $this->current_data[$this->main_table]['price'];

		if(isset($this->new_data[$this->main_table]['currency']))
			$currency = $this->new_data[$this->main_table]['currency'] === 'NULL' ? $currency : "'{$this->new_data[$this->main_table]['currency']}'";
		else
			$currency = $this->current_data[$this->main_table]['currency'] === 'NULL' ? $currency : "'{$this->new_data[$this->main_table]['currency']}'";

		if(isset($this->new_data[$this->main_table]['valid_from']))
			$valid_from = $this->new_data[$this->main_table]['valid_from'] === 'NULL' ? $valid_from : "'{$this->new_data[$this->main_table]['valid_from']}'";
		else
			$valid_from = $this->current_data[$this->main_table]['valid_from'] === 'NULL' ? $valid_from : "'{$this->current_data[$this->main_table]['valid_from']}'";

		if(isset($this->new_data[$this->main_table]['valid_to']))
			$valid_to = $this->new_data[$this->main_table]['valid_to'] === 'NULL' ? $valid_to : "'{$this->new_data[$this->main_table]['valid_to']}'";
		else
			$valid_to = $this->current_data[$this->main_table]['valid_to'] === 'NULL' ? $valid_to : "'{$this->current_data[$this->main_table]['valid_to']}'";

		if(isset($this->new_data[$this->main_table]['access']))
			$access = $this->new_data[$this->main_table]['access'] === 'NULL' ? $access : $this->new_data[$this->main_table]['access'];
		else
			$access = $this->current_data[$this->main_table]['access'] === 'NULL' ? $access : $this->current_data[$this->main_table]['access'];

		if(isset($this->new_data[$this->main_table]['access_groups']))
			$access_groups = $this->new_data[$this->main_table]['access_groups'] === 'NULL' ? $access_groups : "'{$this->new_data[$this->main_table]['access_groups']}'";
		else
			$access_groups = $this->current_data[$this->main_table]['access_groups'] === 'NULL' ? $access_groups : "'{$this->current_data[$this->main_table]['access_groups']}'";

		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`product_id` = $product_id,
			`is_published` = $is_published,
			`price` = $price,
			`currency` = $currency,
			`valid_from` = $valid_from,
			`valid_to` = $valid_to,
			`access` = $access,
			`access_groups` = $access_groups
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
		$note = 'NULL';

		foreach($this->new_data[$this->lang_table] as $language => $language_version)
		{
			if(isset($language_version['note']))
				$note = $language_version['note'] === 'NULL' ? $note : "'{$language_version['note']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['note']))
				$note = $this->current_data[$this->lang_table][$language]['note'] == 'NULL' ? $note : "'{$this->current_data[$this->lang_table][$language]['note']}'";

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
						`note`
					)
				VALUES
					(
						{$this->id},
						'$language',
						$note
					)
SQL;
			}
			elseif($record_count == 1)
			{
				$sql =<<<SQL
				UPDATE
					`{$this->lang_table}`
				SET
					`note` = $note
				WHERE
					`{$this->id_column_name}` = {$this->id} AND
					`language` = '$language'
SQL;
			}
			else
				throw new CN_Exception(sprintf(tr("There are loose data in table `%1\$s` for `id` %2\$s."), $this->lang_table, $this->id), E_ERROR);

			$query = new CN_SqlQuery($sql);
			$query->execute();

			#######################################################################################

			$note = "''";
		}

		###########################################################################################

		$this->readData(CMS::READ_LANG_DATA);
	}
}


endif;

?>
