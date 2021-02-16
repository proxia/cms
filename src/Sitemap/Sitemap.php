<?php
declare(strict_types=1);

namespace App\Sitemap;

use CN_Exception;
use CN_Singleton;
use CN_SqlQuery;

final class Sitemap extends CN_Singleton
{
###################################################################################################
# public
###################################################################################################

	public function __construct() { parent::__construct($this); }
	public function __destruct() { $this->removeSingleton(__CLASS__); }

###################################################################################################

	public function addItem($entity_instance, $show_subitems=false)
	{
		if(!is_subclass_of($entity_instance, 'CMS_Entity'))
			throw new CN_Exception(tr('`$entity_instance` must be valid subclass of CMS_Entity.'), E_ERROR);

		$show_subitems = $show_subitems === true ? 1 : 0;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			MAX(`order`)
		FROM
			`sitemap`
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$order = $query->fetchValue() === null ? 1 : $query->fetchValue() + 1;

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`sitemap`
			(
				`item_id`,
				`item_type`,
				`show_subitems`,
				`order`
			)
		VALUES
			(
				{$entity_instance->getId()},
				{$entity_instance->getType()},
				$show_subitems,
				$order
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function removeItem($entity_instance)
	{
		if(!is_subclass_of($entity_instance, 'CMS_Entity'))
			throw new CN_Exception(tr('`$entity_instance` must be valid subclass of CMS_Entity.'), E_ERROR);

		###########################################################################################

		$sql =<<<SQL
		DELETE
		FROM
			`sitemap`
		WHERE
			`item_id` = {$entity_instance->getId()} AND
			`item_type` = {$entity_instance->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function getItems()
	{
		$item_list = array();

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`sitemap`
		ORDER BY
			`order` ASC
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$class_name = CMS_Entity::getEntityById($record->getValue('item_type'));

			$array['item_instance'] = new $class_name($record->getValue('item_id'));
			$array['show_subitems'] = $record->getValue('show_subitems') == 1 ? true : false;

			$item_list[] = $array;
		}

		###########################################################################################

		return $item_list;
	}

	public function itemExists($entity_instance)
	{
		if(!is_subclass_of($entity_instance, 'CMS_Entity'))
			throw new CN_Exception(tr('`$entity_instance` must be valid subclass of CMS_Entity.'), E_ERROR);

		###########################################################################################

		$sql =<<<SQL
		SELECT
			COUNT(*)
		FROM
			`sitemap`
		WHERE
			`item_id` = {$entity_instance->getId()} AND
			`item_type` = {$entity_instance->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->fetchValue() >= 1);
	}

###################################################################################################

	public function moveUp($entity_instance, $move_by=1)
	{
		$vector = new CN_Vector();
		$current_index = null;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`sitemap`
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

		###########################################################################################

		foreach($vector as $order => $v_item)
		{
			if($v_item['id'] == $this->id)
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

		foreach($vector as $order => $item)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`sitemap`
			SET
				`order` = $new_order
			WHERE
				`item_id` = {$item['id']} AND
				`item_type` = {$item['type']}
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();
		}

		return $new_index + 1;
	}

	public function moveDown($entity_instance, $move_by=1)
	{
		$vector = new CN_Vector();
		$current_index = null;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`sitemap`
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

		###########################################################################################

		foreach($vector as $order => $v_item)
		{
			if($v_item['id'] == $this->id)
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

		foreach($vector as $order => $item)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`sitemap`
			SET
				`order` = $new_order
			WHERE
				`item_id` = {$item['id']} AND
				`item_type` = {$item['type']}
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();
		}

		return $new_index + 1;
	}

	public function moveToTop($entity_instance)
	{
		$vector = new CN_Vector();
		$current_index = null;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`sitemap`
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

		###########################################################################################

		foreach($vector as $order => $v_item)
		{
			if($v_item['id'] == $this->id)
			{
				$current_index = $order;
				break;
			}
		}

		if($current_index === null)
			return null;

		$vector->move($current_index, 0);

		$iterator = new CN_VectorIterator($vector);

		foreach($iterator as $order => $item)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`sitemap`
			SET
				`order` = $new_order
			WHERE
				`item_id` = {$item['id']} AND
				`item_type` = {$item['type']}
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();
		}

		return 1;
	}

	public function moveToBottom($entity_instance)
	{
		$vector = new CN_Vector();
		$current_index = null;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`sitemap`
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

		###########################################################################################

		foreach($vector as $order => $v_item)
		{
			if($v_item['id'] == $this->id)
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

		foreach($iterator as $order => $item)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`sitemap`
			SET
				`order` = $new_order
			WHERE
				`item_id` = {$item['id']} AND
				`item_type` = {$item['type']}
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();
		}

		return $new_index + 1;
	}

###################################################################################################

	public function clear()
	{
		$query = new CN_SqlQuery("DELETE FROM `sitemap`");
		$query->execute();
	}

###################################################################################################
# public static
###################################################################################################

	public static function getSingleton() { return parent::getSingleton(__CLASS__); }
}
