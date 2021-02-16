<?php

if(!defined('CMS_INQUIRY_ANSWER_PHP')):
	define('CMS_INQUIRY_ANSWER_PHP', true);

class CMS_Inquiry_Answer extends CMS_Entity
{
	const ENTITY_ID = 112;

###################################################################################################
# public
###################################################################################################

	public function __construct($answer_id=null)
	{
		$this->main_table = 'inquiry_answers';
		$this->lang_table = 'inquiry_answers_lang';
		$this->id_column_name = 'answer_id';

		###########################################################################################

		parent::__construct(self::ENTITY_ID, $answer_id);
	}

###################################################################################################

	public function setCount($count)
	{
		if($this->id == null)
			exit;

		$query = new CN_SqlQuery("UPDATE `{$this->main_table}` SET `count` = $count WHERE `id` = {$this->id}");
		$query->execute();
	}

	public function increaseCount($increase_by=1)
	{
		if($this->id == null)
			exit;

		$query = new CN_SqlQuery("UPDATE `{$this->main_table}` SET `count` = `count`+$increase_by WHERE `id` = {$this->id}");
		$query->execute();
	}

###################################################################################################

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
			`question_id` = {$this->current_data[$this->main_table]['question_id']}
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

		foreach($iterator as $order => $answer)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`{$this->main_table}`
			SET
				`order` = $new_order
			WHERE
				`id` = $answer
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
			`question_id` = {$this->current_data[$this->main_table]['question_id']}
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

		foreach($iterator as $order => $answer)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`{$this->main_table}`
			SET
				`order` = $new_order
			WHERE
				`id` = $answer
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
			`question_id` = {$this->current_data[$this->main_table]['question_id']}
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

		foreach($iterator as $order => $answer)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`{$this->main_table}`
			SET
				`order` = $new_order
			WHERE
				`id` = $answer
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
			`question_id` = {$this->current_data[$this->main_table]['question_id']}
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

		foreach($iterator as $order => $answer)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`{$this->main_table}`
			SET
				`order` = $new_order
			WHERE
				`id` = $answer
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
			$this->insertAnswer();
		else
			$this->updateAnswer();

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

	private function insertAnswer()
	{
		$question_id = 0;
		$image = 'NULL';
		$count = 0;

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['question_id']))
			$question_id = $this->new_data[$this->main_table]['question_id'] === 'NULL' ? $question_id : $this->new_data[$this->main_table]['question_id'];
		if(isset($this->new_data[$this->main_table]['image']))
			$image = $this->new_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->new_data[$this->main_table]['image']}'";
		if(isset($this->new_data[$this->main_table]['count']))
			$count = $this->new_data[$this->main_table]['count'] === 'NULL' ? $count : $this->new_data[$this->main_table]['count'];

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`question_id`,
				`image`,
				`count`
			)
		VALUES
			(
				$question_id,
				$image,
				$count
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateAnswer()
	{
		$question_id = 0;
		$image = 'NULL';
		$count = 0;

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['question_id']))
			$question_id = $this->new_data[$this->main_table]['question_id'] === 'NULL' ? $question_id : $this->new_data[$this->main_table]['question_id'];
		else
			$question_id = $this->current_data[$this->main_table]['question_id'] === 'NULL' ? $question_id : $this->current_data[$this->main_table]['question_id'];
			
		if(isset($this->new_data[$this->main_table]['image']))
			$image = $this->new_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->new_data[$this->main_table]['image']}'";
		else
			$image = $this->current_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->current_data[$this->main_table]['image']}'";

		if(isset($this->new_data[$this->main_table]['count']))
			$count = $this->new_data[$this->main_table]['count'] === 'NULL' ? $count : $this->new_data[$this->main_table]['count'];
		else
			$count = $this->current_data[$this->main_table]['count'] === 'NULL' ? $count : $this->current_data[$this->main_table]['count'];

		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`question_id` = $question_id,
			`image` = $image,
			`count` = $count
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
		$answer = "''";

		###########################################################################################

		foreach($this->new_data[$this->lang_table] as $language => $language_version)
		{
			if(isset($language_version['answer']))
				$answer = $language_version['answer'] == 'NULL' ? $answer : "'{$language_version['answer']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['answer']))
				$answer = $this->current_data[$this->lang_table][$language]['answer'] == 'NULL' ? $answer : "'{$this->current_data[$this->lang_table][$language]['answer']}'";

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
						`answer`
					)
				VALUES
					(
						{$this->id},
						'$language',
						$answer
					)
SQL;
			}
			elseif($record_count == 1)
			{
				$sql =<<<SQL
				UPDATE
					`{$this->lang_table}`
				SET
					`answer` = $answer
				WHERE
					`{$this->id_column_name}` = {$this->id} AND
					`language`='$language'
SQL;
			}
			else
				die('haluz'); // throw

			$query = new CN_SqlQuery($sql);
			$query->execute();

			#######################################################################################

			$answer = "''";
		}

		###########################################################################################

		$this->readData(CMS::READ_LANG_DATA);
	}
}

endif;

?>