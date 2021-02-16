<?php

if(!defined('CMS_EVENTCALENDAR_EVENTLIST_PHP')):
	define('CMS_EVENTCALENDAR_EVENTLIST_PHP', true);

class CMS_EventCalendar_EventList extends CMS_EntityList
{
###################################################################################################
# public
###################################################################################################

	public function __construct($offset=null, $limit=null)
	{
		parent::__construct();

		###########################################################################################

		if(!is_null($offset))
			$this->offset = $offset;
		if(!is_null($limit))
			$this->limit = $limit;

		$this->table_name = 'event_calendar_events';
		$this->entity_class_name = 'CMS_EventCalendar_Event';
	}

###################################################################################################
}

endif;

?>