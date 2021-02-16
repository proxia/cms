 <?php

abstract class CMS_EntityList implements Iterator, Countable
{
	const DIRECTION_ASCENDING = 'ASC';
	const DIRECTION_DESCENDING = 'DESC';

	protected $table_name = null;
	protected $entity_class_name = null;
	protected $id_column_name = 'id';

	protected $offset = null;
	protected $limit = null;

	protected $sort_by = null;
	protected $sort_direction = null;

	protected $where_condition_map = array();

	private $total_record_count = null;
	private $page_count = null;
	private $current_page = 1;

	private $result_size = null;
	private $result_iterator = null;

###################################################################################################
# public
###################################################################################################

	public function __construct()
	{
		$this->result_iterator = new CN_VectorIterator(new CN_Vector()); // bogus ked je list prazdny tak foreach spadne.

		$this->sort_direction = self::DIRECTION_ASCENDING;
	}

###################################################################################################

	public function getSql() { return $this->buildQuery(); }

###################################################################################################

	public function setOffset($offset) { $this->offset = $offset; }
	public function setLimit($limit) { $this->limit = $limit; }
	public function setSortBy($sort_by) { $this->sort_by = $sort_by; }
	public function setSortDirection($sort_direction) { $this->sort_direction = $sort_direction; }

	public function setTableName($table_name) { $this->table_name = trim($table_name); }
	public function setEntityClassName($entity_class_name) { $this->entity_class_name = trim($entity_class_name); }
	public function setIdColumnName($id_column_name) { $this->id_column_name = trim($id_column_name); }

###################################################################################################

	public function getTotalRecordCount() { return $this->total_record_count; }
	public function getOffset() { return $this->offset; }
	public function getLimit() { return $this->limit; }
	public function getSortBy() { return $this->sort_by; }
	public function getSortDirection() { return $this->sort_direction; }
	public function getSize() { return $this->result_size; }

###################################################################################################

	public function addCondition($column_name, $column_value, $operator='=', $as_is=false)
	{
		$array['name'] = trim($column_name);
		$array['operator'] = trim($operator);
		$array['value'] = trim($column_value);
		$array['as_is'] = $as_is;

		$this->where_condition_map[] = $array;
	}

	public function removeCondition($column_name)
	{
		foreach($this->where_condition_map as $index => $condition)
		{
			if($condition['name'] == $column_name)
				unset($this->where_condition_map[$index]);
		}
	}

	public function resetConditions() { $this->where_condition_map = array(); }

###################################################################################################

	public function setCurrentPage($current_page)
	{
		$this->current_page = $current_page;
		$this->offset = $this->limit * ($current_page - 1);
	}

###################################################################################################
# paging calculations #############################################################################

	public function getPageCount() { return $this->page_count; }
	public function getCurrentPage() { return $this->current_page; }

	public function getNextPage()
	{
		$next_page = null;

		if($this->current_page < $this->page_count)
			$next_page = $this->current_page + 1;

		return $next_page;
	}

	public function getPreviousPage()
	{
		$previous_page = null;

		if($this->current_page > 1)
			$previous_page = $this->current_page - 1;

		return $previous_page;
	}

	public function getFirstPage() { return 1; }
	public function getLastPage() { return $this->page_count; }

	public function getNextPageOffset() { return $this->offset + $this->limit; }
	public function getPreviousPageOffset() { return $this->offset - $this->limit; }
	public function getFirstPageOffset() { return 0; }
	public function getLastPageOffset() { return $this->limit * ($this->page_count - 1); }


###################################################################################################

	public function execute()
	{
		$where_token = $this->getParsedConditions();
		$record_count = 0;

		###########################################################################################

		$query = new CN_SqlQuery("SELECT COUNT(*) FROM {$this->table_name} {$where_token->getRawString()}");
		$query->execute();

		if($query->getSize() > 0)
		{
			$record_count = $query->fetchValue();
			$this->total_record_count = $record_count;
		}
		else
			$this->total_record_count = $record_count;

		###########################################################################################

		/* page count */

		if(!is_null($this->limit))
			$this->page_count = ceil($record_count / $this->limit);
		else
			$this->page_count = 1;

		###########################################################################################

		/* current_page */

		if((!is_null($this->offset) || $this->offset) != 0 && (!is_null($this->limit) || $this->limit != 0))
		{
			$cp = ceil($this->offset / $this->limit) + 1;

			$this->current_page = $cp <= 0 ? 1 : $cp;
		}
		else
			$this->current_page = 1;

		###########################################################################################

		$vector = new CN_Vector();
		$sql = $this->buildQuery();

		$query = new CN_SqlQuery($sql);
		$query->execute();
	
		if($query->getSize() > 0)
		{
			while($query->next())
			{
				$record = $query->fetchRecord();

				$vector->append(new $this->entity_class_name($record->getValue($this->id_column_name)));
			}
		}
		
		$this->result_size = $vector->getSize();
		$this->result_iterator = new CN_VectorIterator($vector);
	}

###################################################################################################
# implementation of `Iterator` interface
###################################################################################################

	public function current() { return $this->result_iterator->current(); }
	public function key() { return $this->result_iterator->key(); }
	public function next() { return $this->result_iterator->next(); }
	public function rewind() { $this->result_iterator->rewind(); }
	public function valid() { return $this->result_iterator->valid(); }

###################################################################################################
# implementation of `Countable` interface
###################################################################################################

	public function count() { return $this->getSize(); }

###################################################################################################
# protected
###################################################################################################

	protected function buildQuery()
	{
		$where_token = $this->getParsedConditions();
		$limit_token = new CN_String('');

		###########################################################################################

		if(!is_null($this->limit))
		{
			$limit_token->append($this->limit);

			if(!is_null($this->offset))
				$limit_token->prepend($this->offset.', ');

			$limit_token->prepend(' LIMIT ');
		}

		###########################################################################################

		$order_token = null;
		
		if($this->sort_by !== null)
		{
			if(ctype_alpha($this->sort_by))
				$order_token = "ORDER BY `{$this->sort_by}` {$this->sort_direction}";
			else
				$order_token = "ORDER BY {$this->sort_by} {$this->sort_direction}";
		}

		$sql = null;

		$sql =<<<SQL
		SELECT
			*
		FROM
			{$this->table_name}
		{$where_token->getRawString()}
		$order_token
		{$limit_token->getRawString()}
SQL;

		return $sql;
	}

	protected function getParsedConditions($with_where_clause=true)
	{
		$where_token = new CN_String('');

		###########################################################################################

		$condition_count = count($this->where_condition_map);
		$i = 0;

		foreach($this->where_condition_map as $data)
		{
			if($data['as_is'] === true)
				$where_token->append($data['name'].' '.$data['value']);
			else
				$where_token->append("`{$data['name']}` {$data['operator']} {$data['value']}");

			if($i != $condition_count - 1)
				$where_token->append(' AND ');

			++$i;
		}

		if($with_where_clause && !$where_token->isEmpty())
			$where_token->prepend('WHERE ');

		###########################################################################################

		return $where_token;
	}
}
