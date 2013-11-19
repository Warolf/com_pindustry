<?php    defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class PindustryModelJsonData extends JModelList
{
    
    function getAreas($json = null){
        $db = JFactory::getDBO();
        $query = "SELECT id, description FROM #__aniews_manga WHERE published = 1 ORDER BY ordering ASC"; 
        $db->setQuery($query);
        $data= $db->loadAssocList();
        if ($json){
            return json_encode($data);    
        }
        return $data;
    }
    
    function getEmpresas($areaid,$json){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('c.*');
        $query->from('#__pindustry_company_area AS ca');
        $query->join('left','#__aniews_anime AS c ON (c.id=ca.id_company)');
        $query->where('ca.id_area='.$areaid);
        $query->where('c.published=1');
        $db->setQuery($query);
        $data= $db->loadAssocList();
        if ($json){
            return json_encode($data);    
        }
        return $data;
    }
    
    function getEmpresa($empid){
        $db =& JFactory::getDBO();
        $query="SELECT *"
        ." FROM #__aniews_anime"
        ." WHERE id = ".$empid;
        $db->setQuery($query);
        $data= $db->loadAssoc();
        return $data;
    }
    
    function getDefaultVideo($id){
        $db = JFactory::getDBO();
        $db->setQuery('Select type, video FROM #__aniews_videos WHERE company_id = '.$id.' AND `default` = 1');
        return $db->loadAssocList();
    }
    
    function getOtherVideo($id){
        $db = JFactory::getDBO();
        $db->setQuery('Select type, video FROM #__aniews_videos WHERE company_id = '.$id);
        return $db->loadAssocList();
    }
    
    function getCompanyArea($id){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
//        $query->select('id_area');
//        $query->from('jos_pindustry_company_area');
//        $query->group('id_area');
        $query->select('id_area');
        $query->from('jos_pindustry_company_area');
        $query->where('id_company='.$id);
        $db->setQuery($query);
        return $db->loadResultArray();
    }
    
}
?>
