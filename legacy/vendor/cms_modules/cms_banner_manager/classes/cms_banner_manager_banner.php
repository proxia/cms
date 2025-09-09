<?php

/*
 * Created on Sep 11, 2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
if(!defined('CMS_BANNERMANAGER_BANNER_PHP')):
	define('CMS_BANNERMANAGER_BANNER_PHP', true);

class CMS_BannerManager_Banner extends CMS_Entity
{
	const ENTITY_ID = 190;

###################################################################################################
# public
###################################################################################################

	public function __construct($banner_id=null)
	{
		$this->main_table = 'banner_manager_banners';
		$this->lang_table = 'banner_manager_banners_lang';
		$this->id_column_name = 'banner_id';
		$this->class_name = __CLASS__;

		###########################################################################################

		parent::__construct(self::ENTITY_ID, $banner_id);
	}

###################################################################################################
# utility methods #################################################################################

	public function isValid()
	{
		$current_date = strtotime('now');
		$valid_from = strtotime($this->current_data[$this->main_table]['valid_from']);
		$valid_to = strtotime($this->current_data[$this->main_table]['valid_to']);

		if($current_date >= $valid_from && $valid_to == null)
			return true;
		elseif($current_date <= $valid_to && $valid_from == null)
			return true;
		elseif(($current_date >= $valid_from) && ($current_date <= $valid_to))
			return true;

		return false;
	}

	public function isDisplayable()
	{
		if($this->getIsPublished() != 1)
			return false;
		
		if($this->isValid() !== true)
			return false;
			
		if($this->getImpressionsPurchased() > 0 && $this->getImpressionsPurchased() < $this->getClickCount())
			return false;
		
		###########################################################################################
		
		return true;		
	}

###################################################################################################
# save an delete ##################################################################################

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
		$author_id = 0;
		$name = "''";
		$is_published = (int)true;
		$valid_from = 'NULL';
		$valid_to = 'NULL';
		$target_url = "''";
		$source_url = "''";
		$width = 0;
		$height = 0;
		$impressions_purchased = 0;
		$show_count = 0;
		$click_count = 0;

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['author_id']))
			$author_id = $this->new_data[$this->main_table]['author_id'] === 'NULL' ? $author_id : $this->new_data[$this->main_table]['author_id'];
			
		if(isset($this->new_data[$this->main_table]['name']))
			$name = $this->new_data[$this->main_table]['name'] === 'NULL' ? $name : "'{$this->new_data[$this->main_table]['name']}'";
			
		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : (int)$this->new_data[$this->main_table]['is_published'];
			
		if(isset($this->new_data[$this->main_table]['valid_from']))
			$valid_from = $this->new_data[$this->main_table]['valid_from'] === 'NULL' ? $valid_from : "'{$this->new_data[$this->main_table]['valid_from']}'";
			
		if(isset($this->new_data[$this->main_table]['valid_from']))
			$valid_from = $this->new_data[$this->main_table]['valid_from'] === 'NULL' ? $valid_from : "'{$this->new_data[$this->main_table]['valid_from']}'";
				
		if(isset($this->new_data[$this->main_table]['valid_to']))
			$valid_to = $this->new_data[$this->main_table]['valid_to'] === 'NULL' ? $valid_to : "'{$this->new_data[$this->main_table]['valid_to']}'";
						
		if(isset($this->new_data[$this->main_table]['target_url']))
			$target_url = $this->new_data[$this->main_table]['target_url'] === 'NULL' ? $target_url : "'{$this->new_data[$this->main_table]['target_url']}'";
			
		if(isset($this->new_data[$this->main_table]['source_url']))
			$source_url = $this->new_data[$this->main_table]['source_url'] === 'NULL' ? $source_url : "'{$this->new_data[$this->main_table]['source_url']}'";
			
		if(isset($this->new_data[$this->main_table]['width']))
			$width = $this->new_data[$this->main_table]['width'] === 'NULL' ? $width : $this->new_data[$this->main_table]['width'];
			
		if(isset($this->new_data[$this->main_table]['height']))
			$height = $this->new_data[$this->main_table]['height'] === 'NULL' ? $height : $this->new_data[$this->main_table]['height'];
				
		if(isset($this->new_data[$this->main_table]['impressions_purchased']))
			$impressions_purchased = $this->new_data[$this->main_table]['impressions_purchased'] === 'NULL' ? $impressions_purchased : $this->new_data[$this->main_table]['impressions_purchased'];
			
		if(isset($this->new_data[$this->main_table]['show_count']))
			$show_count = $this->new_data[$this->main_table]['show_count'] === 'NULL' ? $show_count : $this->new_data[$this->main_table]['show_count'];
			
		if(isset($this->new_data[$this->main_table]['click_count']))
			$click_count = $this->new_data[$this->main_table]['click_count'] === 'NULL' ? $click_count : $this->new_data[$this->main_table]['click_count'];
	
		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`creation`,
				`author_id`,
				`name`,
				`is_published`,
				`valid_from`,
				`valid_to`,
				`target_url`,
				`source_url`,
				`width`,
				`height`,
				`impressions_purchased`,
				`show_count`,
				`click_count`
			)
		VALUES
			(
				NOW(),
				$author_id,
				$name,
				$is_published,
				$valid_from,
				$valid_to,
				$target_url,
				$source_url,
				$width,
				$height,
				$impressions_purchased,
				$show_count,
				$click_count
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
		$author_id = 0;
		$name = "''";
		$is_published = (int)true;
		$valid_from = 'NULL';
		$valid_to = 'NULL';
		$target_url = "''";
		$source_url = "''";
		$impressions_purchased = 0;
		$show_count = 0;
		$click_count = 0;

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['author_id']))
			$author_id = $this->new_data[$this->main_table]['author_id'] === 'NULL' ? $author_id : $this->new_data[$this->main_table]['author_id'];
		else
			$author_id = $this->current_data[$this->main_table]['author_id'] === 'NULL' ? $author_id : $this->current_data[$this->main_table]['author_id'];

		if(isset($this->new_data[$this->main_table]['name']))
			$name = $this->new_data[$this->main_table]['name'] === 'NULL' ? $name : "'{$this->new_data[$this->main_table]['name']}'";
		else
			$name = $this->current_data[$this->main_table]['name'] === 'NULL' ? $name : "'{$this->current_data[$this->main_table]['name']}'";

		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : (int)$this->new_data[$this->main_table]['is_published'];
		else
			$is_published = $this->current_data[$this->main_table]['is_published'] === 'NULL' ? $is_published : (int)$this->current_data[$this->main_table]['is_published'];
		
		if(isset($this->new_data[$this->main_table]['valid_from']))
			$valid_from = $this->new_data[$this->main_table]['valid_from'] === 'NULL' ? $valid_from : "'{$this->new_data[$this->main_table]['valid_from']}'";
		else
			$valid_from = $this->current_data[$this->main_table]['valid_from'] === 'NULL' ? $valid_from : "'{$this->current_data[$this->main_table]['valid_from']}'";

		if(isset($this->new_data[$this->main_table]['valid_to']))
			$valid_to = $this->new_data[$this->main_table]['valid_to'] === 'NULL' ? $valid_to : "'{$this->new_data[$this->main_table]['valid_to']}'";
		else
			$valid_to = $this->current_data[$this->main_table]['valid_to'] === 'NULL' ? $valid_to : "'{$this->current_data[$this->main_table]['valid_to']}'";

		if(isset($this->new_data[$this->main_table]['target_url']))
			$target_url = $this->new_data[$this->main_table]['target_url'] === 'NULL' ? $target_url : "'{$this->new_data[$this->main_table]['target_url']}'";
		else
			$target_url = $this->current_data[$this->main_table]['target_url'] === 'NULL' ? $target_url : "'{$this->current_data[$this->main_table]['target_url']}'";

		if(isset($this->new_data[$this->main_table]['source_url']))
			$source_url = $this->new_data[$this->main_table]['source_url'] === 'NULL' ? $source_url : "'{$this->new_data[$this->main_table]['source_url']}'";
		else
			$source_url = $this->current_data[$this->main_table]['source_url'] === 'NULL' ? $source_url : "'{$this->current_data[$this->main_table]['source_url']}'";

		if(isset($this->new_data[$this->main_table]['width']))
			$width = $this->new_data[$this->main_table]['width'] === 'NULL' ? $width : $this->new_data[$this->main_table]['width'];
		else
			$width = $this->current_data[$this->main_table]['width'] === 'NULL' ? $width : $this->current_data[$this->main_table]['width'];

		if(isset($this->new_data[$this->main_table]['height']))
			$height = $this->new_data[$this->main_table]['height'] === 'NULL' ? $height : $this->new_data[$this->main_table]['height'];
		else
			$height = $this->current_data[$this->main_table]['height'] === 'NULL' ? $height : $this->current_data[$this->main_table]['height'];

		if(isset($this->new_data[$this->main_table]['impressions_purchased']))
			$impressions_purchased = $this->new_data[$this->main_table]['impressions_purchased'] === 'NULL' ? $impressions_purchased : $this->new_data[$this->main_table]['impressions_purchased'];
		else
			$impressions_purchased = $this->current_data[$this->main_table]['impressions_purchased'] === 'NULL' ? $impressions_purchased : $this->current_data[$this->main_table]['impressions_purchased'];

		if(isset($this->new_data[$this->main_table]['show_count']))
			$show_count = $this->new_data[$this->main_table]['show_count'] === 'NULL' ? $show_count : $this->new_data[$this->main_table]['show_count'];
		else
			$show_count = $this->current_data[$this->main_table]['show_count'] === 'NULL' ? $show_count : $this->current_data[$this->main_table]['show_count'];

		if(isset($this->new_data[$this->main_table]['click_count']))
			$click_count = $this->new_data[$this->main_table]['click_count'] === 'NULL' ? $click_count : "'{$this->new_data[$this->main_table]['click_count']}'";
		else
			$click_count = $this->current_data[$this->main_table]['click_count'] === 'NULL' ? $click_count : "'{$this->current_data[$this->main_table]['click_count']}'";

		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`author_id` = $author_id,
			`name` = $name,
			`is_published` = $is_published,
			`valid_from` = $valid_from,
			`valid_to` = $valid_to,
			`target_url` = $target_url,
			`source_url` = $source_url,
			`width` = $width,
			`height` = $height,
			`impressions_purchased` = $impressions_purchased,
			`show_count` = $show_count,
			`click_count` = $click_count
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

		###########################################################################################

		foreach($this->new_data[$this->lang_table] as $language => $language_version)
		{
			if(isset($language_version['title']))
				$title = $language_version['title'] == 'NULL' ? $title : "'{$language_version['title']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['title']))
				$title = $this->current_data[$this->lang_table][$language]['title'] == 'NULL' ? $title : "'{$this->current_data[$this->lang_table][$language]['title']}'";

			if(isset($language_version['description']))
				$description = $language_version['description'] == 'NULL' ? $description : "'{$language_version['description']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['description']))
				$description = $this->current_data[$this->lang_table][$language]['description'] == 'NULL' ? $description : "'{$this->current_data[$this->lang_table][$language]['description']}'";

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

			$title = 'NULL';
			$description = 'NULL';
		}

		###########################################################################################

		$this->readData(CMS::READ_LANG_DATA);
	}
	
###################################################################################################
# public static
###################################################################################################

###################################################################################################
# statistics ######################################################################################

	public static function incrementShows($banner_id)
	{
		$sql =<<<SQL
		UPDATE
			`banner_manager_banners`
		SET
			`show_count` = `show_count` + 1
		WHERE
			`id` = $banner_id
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public static function incrementClicks($banner_id)
	{
		$sql =<<<SQL
		UPDATE
			`banner_manager_banners`
		SET
			`click_count` = `click_count` + 1
		WHERE
			`id` = $banner_id
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}
	
###################################################################################################
# utility methods #################################################################################

	public static function getRandomBanner($max_width, $max_height)
	{
		$banner_list = array();
		
		###########################################################################################	
	
		$sql =<<<SQL
		SELECT
			*
		FROM
			`banner_manager_banners`
		WHERE
			(
				(NOW() BETWEEN `valid_from` AND `valid_to`)
				OR
				(NOW() >= `valid_from` AND `valid_to` IS NULL)
				OR
				(NOW() <= `valid_to` AND `valid_from` IS NULL)
				OR
				(`valid_from` IS NULL AND `valid_to` IS NULL)
			)
			AND		
			(
				(`width`<= $max_width OR `width` IS NULL OR `width` = 0)
				AND
				(`height` <= $max_height OR `height` IS NULL OR `height` = 0)
			)
			AND
				`is_published` = 1
			
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
		
		while($query->next())
		{
			$record = $query->fetchRecord();
			
			$banner_list[$record->getValue('id')] = $record->getValue('show_count');
		}
		
		###########################################################################################
		
		$players = array_keys($banner_list);
		$players_count = count($players);

		if($players_count > 1)
			$winner = mt_rand(0, $players_count - 1);
		else
			$winner = 0;
		
		return $players_count > 0 ? new CMS_BannerManager_Banner($players[$winner]) : null ;
		
	}
}

endif;

?>
