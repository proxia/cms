<?php

if(!defined('CN_SQLCOLUMNINFO_PHP')):
	define('CN_SQLCOLUMNINFO_PHP', TRUE);

class CN_SqlColumnInfo
{
	private $object_driver = NULL;
	private $connection_name = 'default_connection';

	private $name = NULL;
	private $table_name = NULL;

	private $type = NULL;
	private $collation = NULL;
	private $allow_null = FALSE;
	private $is_primary = FALSE;
	private $default_value = NULL;
	private $extra = NULL;
	private $privileges = NULL;
	private $comment = NULL;


	public function __construct($name, $table_name, $connection_name)
	{
		$this->connection_name = $connection_name;
		
		$this->object_driver = CN_SqlDatabase::getDatabase($this->connection_name)->getDriverInstance();
		$this->name = trim($name);

		$query = new CN_SqlQuery("SHOW FULL COLUMNS FROM `$table_name`", $this->connection_name);
		$query->execute();

		while($query->next())
		{
			$record = $query->fetchRecord();

			if($record->getValue('Field') == $this->name)
			{
				$this->type = $record->getValue('Type');
				$this->collation = $record->getValue('Collation');
				$this->default_value = $record->getValue('Default');
				$this->extra = $record->getValue('Extra');
				$this->privileges = $record->getValue('Privileges');
				$this->comment = $record->getValue('Comment');

				if($record->getValue('Null') == 'YES')
					$this->allow_null = TRUE;
				if(strcasecmp($record->getValue('Key'), 'pri') == 0)
					$this->is_primary = TRUE;

				break;
			}
		}
	}


	public function getName() { return $this->name; }
	public function getType() { return $this->type; }
	public function getCollation() { return $this->collation; }
	public function getDefaultValue() { return $this->default_value; }
	public function getExtra() { return $this->extra; }
	public function getPrivileges() { return $this->privileges; }
	public function getComment() { return $this->comment; }

	public function isPrimary() { return $this->is_primary; }
}

endif;

?>