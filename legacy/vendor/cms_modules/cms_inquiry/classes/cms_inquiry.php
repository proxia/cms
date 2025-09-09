<?php

if(!defined('CMS_INQUIRY_PHP')):
	define('CMS_INQUIRY_PHP', true);

class CMS_Inquiry extends CMS_Entity
{
	const ENTITY_ID = 110;

###################################################################################################
# public
###################################################################################################

	public function __construct($inquiry_id=null)
	{
		$this->main_table = 'inquiry_inquiries';
		$this->lang_table = 'inquiry_inquiries_lang';
		$this->id_column_name = 'inquiry_id';

		##########################################################################################

		parent::__construct(self::ENTITY_ID, $inquiry_id);
	}

###################################################################################################

	public function getQuestions($offset=null, $limit=null, $execute=true)
	{
		$question_list = new CMS_Inquiry_QuestionList($offset, $limit);
		$question_list->addCondition('inquiry_id', $this->id);

		if($execute === true)
			$question_list->execute();

		return $question_list;
	}

	public function addQuestion(CMS_Inquiry_Question $question)
	{
		$sql = <<<SQL
		SELECT
			MAX(`order`)
		FROM
			`inquiry_inquiries_bindings`
		WHERE
			`inquiry_id` = {$this->id}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$order = $query->fetchValue() + 1;

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`inquiry_inquiries_bindings`
			(
				`inquiry_id`,
				`question_id`,
				`order`
			)
		VALUES
			(
				{$this->id},
				{$question->getId()},
				$order
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

	public function removeQuestion(CMS_Inquiry_Question $question)
	{
		$sql =<<<SQL
		DELETE FROM
			`inquiry_inquiries_bindings`
		WHERE
			`inquiry_id` = {$this->id} AND
			`question_id` = {$question->getId()}
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();
	}

###################################################################################################

	/**
	 * Ulozi vsetky zmeny v hodnotach do databazy.
	 *
	 * @return void
	 */
	public function save()
	{
		if(is_null($this->id))
			$this->insertInquiry();
		else
			$this->updateInquiry();

		$this->updateLanguageVersions();
	}

	/**
	 * Odtrani anketu a vsetky vazby z databazy.
	 *
	 * @return void
	 */
	public function delete()
	{
		# question bindings #######################################################################

		$question_list = $this->getQuestions();

		foreach($question_list as $question)
			$question->delete();

		# main bindings ###########################################################################

		$query = new CN_SqlQuery("DELETE FROM `{$this->lang_table}` WHERE `inquiry_id` = {$this->id}");
		$query->execute();

		$query = new CN_SqlQuery("DELETE FROM `{$this->main_table}` WHERE `id` = {$this->id}");
		$query->execute();
	}

###################################################################################################
# private
###################################################################################################

	private function insertInquiry()
	{
		$valid_for = 'NULL';
		$image = 'NULL';
		$show_results = true;
		$is_published = true;

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['valid_for']))
			$valid_for = $this->new_data[$this->main_table]['valid_for'] === 'NULL' ? $valid_for : $this->new_data[$this->main_table]['valid_for'];
		if(isset($this->new_data[$this->main_table]['image']))
			$image = $this->new_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->new_data[$this->main_table]['image']}'";
		if(isset($this->new_data[$this->main_table]['show_results']))
			$show_results = $this->new_data[$this->main_table]['show_results'] === 'NULL' ? (int)$show_results : (int)$this->new_data[$this->main_table]['show_results'];
		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? (int)$is_published : (int)$this->new_data[$this->main_table]['is_published'];

		###########################################################################################

		$sql =<<<SQL
		INSERT INTO
			`{$this->main_table}`
			(
				`creation`,
				`valid_for`,
				`image`,
				`show_results`,
				`is_published`
			)
		VALUES
			(
				NOW(),
				$valid_for,
				$image,
				$show_results,
				$is_published
			)
SQL;

		$query = new CN_SqlQuery($sql);
		$query->execute();

		$this->id = $query->getInsertId();

		###########################################################################################

		$this->readData(CMS::READ_MAIN_DATA);
	}

	private function updateInquiry()
	{
		$valid_for = 'NULL';
		$image = 'NULL';
		$show_results = true;
		$is_published = true;

		###########################################################################################

		if(isset($this->new_data[$this->main_table]['valid_for']))
			$valid_for = $this->new_data[$this->main_table]['valid_for'] === 'NULL' ? $valid_for : $this->new_data[$this->main_table]['valid_for'];
		else
			$valid_for = $this->current_data[$this->main_table]['valid_for'] === 'NULL' ? $valid_for : $this->current_data[$this->main_table]['valid_for'];
			
		if(isset($this->new_data[$this->main_table]['image']))
			$image = $this->new_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->new_data[$this->main_table]['image']}'";
		else
			$image = $this->current_data[$this->main_table]['image'] === 'NULL' ? $image : "'{$this->current_data[$this->main_table]['image']}'";

		if(isset($this->new_data[$this->main_table]['show_results']))
			$show_results = $this->new_data[$this->main_table]['show_results'] === 'NULL' ? (int)$show_results : (int)$this->new_data[$this->main_table]['show_results'];
		else
			$show_results = $this->current_data[$this->main_table]['show_results'] === 'NULL' ? (int)$show_results : (int)$this->current_data[$this->main_table]['show_results'];

		if(isset($this->new_data[$this->main_table]['is_published']))
			$is_published = $this->new_data[$this->main_table]['is_published'] === 'NULL' ? (int)$is_published : (int)$this->new_data[$this->main_table]['is_published'];
		else
			$is_published = $this->current_data[$this->main_table]['is_published'] === 'NULL' ? (int)$is_published : (int)$this->current_data[$this->main_table]['is_published'];

		###########################################################################################

		$sql =<<<SQL
		UPDATE
			`{$this->main_table}`
		SET
			`valid_for` = $valid_for,
			`image` = $image,
			`show_results` = $show_results,
			`is_published` = $is_published
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


		if(isset($language_version['language_is_visible']))
				$language_is_visible = $language_version['language_is_visible'] == 'NULL' ? $language_is_visible : "'{$language_version['language_is_visible']}'";
			elseif(isset($this->current_data[$this->lang_table][$language]['language_is_visible']))
				$language_is_visible = $this->current_data[$this->lang_table][$language]['language_is_visible'] == 'NULL' ? $language_is_visible : "'{$this->current_data[$this->lang_table][$language]['language_is_visible']}'";

			#######################################################################################

			$sql =<<<SQL
			SELECT
				COUNT(*)
			FROM
				`{$this->lang_table}`
			WHERE
				`inquiry_id` = {$this->id} AND
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
						`inquiry_id`,
						`language`,
						`title`,
						`description`,
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
					`{$this->lang_table}`
				SET
					`title` = $title,
					`description` = $description,
					`language_is_visible` = $language_is_visible
				WHERE
					`inquiry_id`={$this->id} AND
					`language`='$language'
SQL;
			}
			else
				die('haluz'); // throw

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
