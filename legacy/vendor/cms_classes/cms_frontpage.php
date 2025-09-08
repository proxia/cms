<?php

if(!defined('CMS_FRONTPAGE_PHP')):
	define('CMS_FRONTPAGE_PHP', true);

class CMS_Frontpage extends CN_Singleton
{
###################################################################################################
# public
###################################################################################################

	public function __construct()
	{
		parent::__construct($this);
	}

	public function __destruct()
	{
		$this->removeSingleton(__CLASS__);
	}

###################################################################################################

	public function getItems($displayable_only=false)
	{
		$vector = new CN_Vector();

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`frontpage`
		ORDER BY
			`order`
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$article = new CMS_Article($record->getValue('item_id'));

			if($displayable_only === true)
			{
 				if(!$article->isDisplayable() || $article->getFrontpageLanguageIsVisible() == 0)
 					continue;
			}

			$vector->append($article);
		}

		###########################################################################################

		return $vector;
	}

	public function itemExists($item)
	{
		$sql =<<<SQL
		SELECT
			COUNT(*)
		FROM
			`frontpage`
		WHERE
			`item_id` = {$item->getId()} AND
			`item_type` = {$item->getType()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		return ($query->fetchValue() > 0);
	}

###################################################################################################

	public function addItem($item)
	{
		$item_type = $item->getType();

###########################################################################################

		$sql = <<<SQL
		SELECT
			MAX(`order`)
		FROM
			`frontpage`
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$order = $query->fetchValue() + 1;

###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`frontpage`
			(
				`item_id`,
				`item_type`,
				`order`
			)
		VALUES
			(
				{$item->getId()},
				$item_type,
				$order
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function removeItem($item)
	{
		$item_type = null;

		###########################################################################################

		if($item instanceof CMS_Article)
			$item_type = CMS_Entity::ENTITY_ARTICLE;
		else
			throw new CN_Exception(tr("\$item musi byt subclass nejakej entity."));

		$sql =<<<SQL
		DELETE
		FROM
			`frontpage`
		WHERE
			`item_id` = {$item->getId()} AND
			`item_type` = $item_type
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

###################################################################################################
# item moving #####################################################################################

	public function moveUp(CMS_Entity $item, $move_by=1)
	{
		$vector = new CN_Vector();
		$current_index = null;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`frontpage`
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
			if($v_item['id'] == $item->getId())
			{
				$current_index = $order;
				break;
			}
		}

		if($current_index === null)
			return null;

		$new_index = $current_index - $move_by;

		if(($new_index > $vector->getSize() - 1) || ($new_index < 0))
			throw new CN_Exception(sprintf(tr("Can't move item out of boundry. Vector index: %1\$s, New index: %2\$s"), $vector->getSize() - 1, $new_index));

		$vector->move($current_index, $new_index);

		$iterator = new CN_VectorIterator($vector);

		foreach($iterator as $order => $item)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`frontpage`
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

	public function moveDown(CMS_Entity $item, $move_by=1)
	{
		$vector = new CN_Vector();
		$current_index = null;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`frontpage`
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
			if($v_item['id'] == $item->getId())
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

		foreach($iterator as $order => $item)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`frontpage`
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

	public function moveToTop(CMS_Entity $item)
	{
		$vector = new CN_Vector();
		$current_index = null;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`frontpage`
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
			if($v_item['id'] == $item->getId())
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
				`frontpage`
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

	public function moveToBottom(CMS_Entity $item)
	{
		$vector = new CN_Vector();
		$current_index = null;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`frontpage`
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
			if($v_item['id'] == $item->getId())
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
				`frontpage`
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
# public static
###################################################################################################

	public static function getSingleton($name = __CLASS__) { return parent::getSingleton($name); }
}


endif;

?>