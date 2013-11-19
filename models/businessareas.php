<?php	defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class PindustryModelBusinessareas extends JModelList
{

	protected function getListQuery()
	{
        global $com_pindustry_languages;
		$db = JFactory::getDBO();

		$query = $db->getQuery(true);

		$query->select('id,GetTitle(description, "'.$com_pindustry_languages['defaultlang'].'", "pt-PT") AS description,ordering,published');
		$query->from('#__aniews_manga');
        $query->order('description ASC');
        
		return $query;
	}
    
    function delete($id){
        $db = JFactory::getDBO();
        $db->setQuery('DELETE FROM #__aniews_manga WHERE id IN ('.$id.')');
        $db->query();
        return true;
    }
    
    function getEmpresas($areaid){
        $db =& JFactory::getDBO();
        $query = "SELECT *"
        ." FROM #__pindustry_company_area"
        ." WHERE id_area IN (".$areaid.")";
        $db->setQuery($query);
        return $db->loadObjectList();
    }
    
}

?>