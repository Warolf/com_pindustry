<?php	defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class PindustryModelCompanies extends JModelList
{
    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'idbusinessarea',
            );
        }

        parent::__construct($config);
    }
    
    protected function _getListCount($query)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $idbusinessarea = $this->getState('filter.idbusinessarea');
        if (!$idbusinessarea) {
			$query->select('COUNT(c.id)');
			$query->from('#__aniews_anime AS c');
        }else{
			$query->select('COUNT(c.id)');
			$query->from('#__aniews_anime AS c');
			$query->join('LEFT','#__pindustry_company_area AS ca ON (c.id=ca.id_company)');
			$query->where('ca.id_area='.(int)$idbusinessarea);
		}
        $db->setQuery($query);
        return $db->loadResult();
    }
    
	protected function getListQuery()
	{
	    global $com_pindustry_languages;
        $db = JFactory::getDBO();

		$query = $db->getQuery(true);

        $idbusinessarea = $this->getState('filter.idbusinessarea');
        if (!$idbusinessarea) {
			$query->select('c.id,GetTitle(c.name, "'.$com_pindustry_languages['defaultlang'].'", "pt-PT") AS name,c.published');
			$query->from('#__aniews_anime AS c');
			$query->order('name');
        }else{
			$query->select('c.id,GetTitle(c.name, "'.$com_pindustry_languages['defaultlang'].'", "pt-PT") AS name,c.published');
			$query->from('#__aniews_anime AS c');
			$query->join('LEFT','#__pindustry_company_area AS ca ON (c.id=ca.id_company)');
			$query->where('ca.id_area='.(int)$idbusinessarea);
			$query->group('ca.id_company');
			$query->order('name');
		}
        
		return $query;
	}
    
    protected function populateState($ordering = null, $direction = null)
    {
        $app = JFactory::getApplication('administrator');
        
        $idbusinessarea = $this->getUserStateFromRequest($this->context.'.filter.idbusinessarea', 'filter_idbusinessarea', '');
        $this->setState('filter.idbusinessarea', $idbusinessarea);

        parent::populateState('ordering', 'asc');
    }
              
}

?>