<?php	defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class PindustryModelHighlights extends JModelList
{
	protected $whereArray=null;

	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'ordering',
				'published',
                'state'
			);
		}

		parent::__construct($config);
	}

	protected function _getListCount()
	{
		$db = JFactory::getDBO();

		$query=$db->getQuery(true);
		$query->select('COUNT(*)');
		$query->from('#__pindustry_highlights');

		if ($where=$this->getWhereArray())	{
			$query->where($where);
		}

		$db->setQuery($query);

		return $db->loadResult();
	}

	protected function getListQuery()
	{
		global $com_pindustry_languages;
        $db = JFactory::getDBO();

		$query = $db->getQuery(true);

		$query->select('h.id, GetTitle(c.name, "'.$com_pindustry_languages['defaultlang'].'", "pt-PT") AS company, GetTitle(v.name, "'.$com_pindustry_languages['defaultlang'].'", "pt-PT") AS video, v.type, h.published, h.ordering');
		$query->from('#__pindustry_highlights as h');
        $query->join('left','#__aniews_anime as c ON (c.id = h.company_id)');
        $query->join('left','#__aniews_videos as v on (v.id = h.video_id)');

		if ($where=$this->getWhereArray())	{
			$query->where($where);
		}

		$orderCol	= $this->state->get('list.ordering', 'ordering');
		$orderDirn	= $this->state->get('list.direction', 'ASC');

		$query->order($db->getEscaped($orderCol.' '.$orderDirn));

		return $query;
	}

	protected function getWhereArray()
	{
		if (!$this->whereArray)	{
				$where=array();

				$published = $this->getState('filter.state');
				if (is_numeric($published)) {
					$where[] = 'h.published='.(int)$published;
				}

				$this->whereArray=$where;
		}

		return $this->whereArray;
	}

	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		$state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
		$this->setState('filter.state', $state);

		parent::populateState('ordering', 'asc');
	}

}

?>
