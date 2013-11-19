<?php	defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class PindustryModelImages extends JModelList
{
	protected $whereArray=null;

	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id',
				'company_id',
				'img',
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
		$query->from('#__aniews_images');

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

		$query->select('id, company_id, img, published, ordering');
		$query->from('#__aniews_images');

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
					$where[] = 'published='.(int)$published;
				}

				$company_id = $this->getState('filter.company_id');
				if ($company_id) {
					$where[] = 'company_id='.(int)$company_id;		}

				$this->whereArray=$where;
		}

		return $this->whereArray;
	}

	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$company_id = $this->getUserStateFromRequest($this->context.'.filter.company_id', 'filter_company_id', '');
		$this->setState('filter.company_id', $company_id);

		$state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
		$this->setState('filter.state', $state);

		// Set global com_pindustry.company_id state
		if ($company_id)	{
			$this->getUserStateFromRequest('com_pindustry.company_id', 'filter_company_id', $company_id);
        }

		parent::populateState('ordering', 'asc');
	}
    
    function getTitle($id){
        global $com_pindustry_languages;
        $db = JFactory::getDBO();
        $db->setQuery('SELECT GetTitle(name, "'.$com_pindustry_languages['defaultlang'].'", "pt-PT") FROM #__aniews_anime WHERE id ='.$id);
        return $db->loadResult();
    }

    function getImages($id){
        $db = JFactory::getDBO();
        $db->setQuery('Select company_id, img FROM #__aniews_images WHERE id IN ('.$id.')');
        return $db->loadAssocList();
    }
    
    function delete($id){
        $db = JFactory::getDBO();
        $db->setQuery('DELETE FROM #__aniews_images WHERE id IN ('.$id.')');
        $db->query();
        return true;
    }
}

?>