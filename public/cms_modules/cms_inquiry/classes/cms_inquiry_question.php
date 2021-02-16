<?php

if(!defined('CMS_INQUIRY_QUESTION_PHP')):
	define('CMS_INQUIRY_QUESTION_PHP', true);

class CMS_Inquiry_Question extends CMS_Entity
{
	const ENTITY_ID = 111;

###################################################################################################
# public
###################################################################################################

	public function __construct($question_id=null)
	{
		$this->main_table = 'inquiry_questions';
		$this->lang_table = 'inquiry_questions_lang';
		$this->id_column_name = 'question_id';

		###########################################################################################

		parent::__construct(self::ENTITY_ID, $question_id);
	}

###################################################################################################

	public function getAnswers($offset=null, $limit=null, $execute=true)
	{
		$answer_list = new CMS_Inquiry_AnswerList($offset, $limit);
		$answer_list->addCondition('question_id', $this->id);

		if($execute === true)
			$answer_list->execute();

		return $answer_list;
	}

###################################################################################################

	public function moveUp($inquiry_id, $move_by=1)
	{
		$vector = new CN_Vector();
		$current_index = null;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`inquiry_inquiries_bindings`
		WHERE
			`inquiry_id` = $inquiry_id
		ORDER BY
			`order` ASC
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append($record->getValue('question_id'));
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

		foreach($iterator as $order => $question)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`inquiry_inquiries_bindings`
			SET
				`order` = $new_order
			WHERE
				`inquiry_id` = $inquiry_id AND
				`question_id` = $question
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();
		}

		return $new_index + 1;
	}

	public function moveDown($inquiry_id, $move_by=1)
	{
		$vector = new CN_Vector();
		$current_index = null;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`inquiry_inquiries_bindings`
		WHERE
			`inquiry_id` = $inquiry_id
		ORDER BY
			`order` ASC
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append($record->getValue('question_id'));
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

		foreach($iterator as $order => $question)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`inquiry_inquiries_bindings`
			SET
				`order` = $new_order
			WHERE
				`inquiry_id` = $inquiry_id AND
				`question_id` = $question
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();
		}

		return $new_index + 1;
	}

	public function moveToTop($inquiry_id)
	{
		$vector = new CN_Vector();
		$current_index = null;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`inquiry_inquiries_bindings`
		WHERE
			`inquiry_id` = $inquiry_id
		ORDER BY
			`order` ASC
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append($record->getValue('question_id'));
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

		foreach($iterator as $order => $question)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`inquiry_inquiries_bindings`
			SET
				`order` = $new_order
			WHERE
				`inquiry_id` = $inquiry_id AND
				`question_id` = $question
SQL;

			$query = new CN_SqlQuery($sql);
			$query->execute();
		}

		return 1;
	}

	public function moveToBottom($inquiry_id)
	{
		$vector = new CN_Vector();
		$current_index = null;

		###########################################################################################

		$sql =<<<SQL
		SELECT
			*
		FROM
			`inquiry_inquiries_bindings`
		WHERE
			`inquiry_id` = $inquiry_id
		ORDER BY
			`order` ASC
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			$vector->append($record->getValue('question_id'));
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

		foreach($iterator as $order => $question)
		{
			$new_order = $order + 1;

			$sql =<<<SQL
			UPDATE
				`inquiry_inquiries_bindings`
			SET
				`order` = $new_order
			WHERE
				`inquiry_id` = $inquiry_id AND
				`question_id` = $question
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
			$this->insertQuestion();
		else
			$this->updateQuestion();

		$this->updateLanguageVersions();
	}

	public function delete()
	{
		# answer bindings #########################################################################

		$answer_list = $this->getAnswers();

		foreach($answer_list as $answer)
			$answer->delete();

		# main bindings ###########################################################################

		$query = new CN_SqlQuery("DELETE FROM `{$this->lang_table}` WHERE `{$this->id_column_name}` = {$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM `{$this->main_table}` WHERE `id` = {$this->id}");
		$query->execute();
	}

###################################################################################################
# private
###################################################################################################

	private function insertQuestion()
	{
		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`creation`
			)
		VALUES
			(
				NOW()
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateQuestion()
	{
		/*$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`inquiry_id` = $inquiry_id,
			`count` = $count
		WHERE
			`id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);*/
	}

	private function updateLanguageVersions()
	{
		$question = "''";
		$description = 'NULL';

		###########################################################################################

		foreach($this->new_data[$this->lang_table] as $language => $language_version)
		{
			if(isset($language_version['question']))
				$question = $language_version['question'] == 'NULL' ? $question : "'{$language_version['question']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['question']))
				$question = $this->current_data[$this->lang_table][$language]['question'] == 'NULL' ? $question : "'{$this->current_data[$this->lang_table][$language]['question']}'";

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
						`question`,
						`description`
					)
				VALUES
					(
						{$this->id},
						'$language',
						$question,
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
					`question` = $question,
					`description` = $description
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

			$question = "''";
			$description = 'NULL';
		}

		###########################################################################################

		$this->readData(CMS::READ_LANG_DATA);
	}
}

endif;

?>