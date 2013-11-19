<?php	defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modeladmin');

class PindustryModelCompanie extends JModelAdmin
{

	public function getTable($type='Companie', $prefix='PindustryTable', $config=array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data=array(), $loadData=true)
	{
		$form=$this->loadForm('com_pindustry.companie', 'companie', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		return $form;
	}

	protected function loadFormData()
	{
		$data=JFactory::getApplication()->getUserState('com_pindustry.edit.companie.data', array());
		if (empty($data))
		{
			$data=$this->getItem();
		}
		return $data;
	}
    
    function getLast(){
        $db = JFactory::getDBO();
        $db->setQuery('SELECT id FROM #__aniews_anime ORDER BY id DESC LIMIT 0,1');
        return $db->loadResult();
    }
    
    function getFiles($id){
        $db = JFactory::getDbo();
        $db->setQuery('SELECT file1, file2, file3, file4, file5 FROM #__aniews_anime WHERE id = '.$id);
        return $db->loadAssocList();
    }
    
    function addArea($name,$creator,$year,$season,$description,$tag_pt,$published,$img){
        $db = JFactory::getDBO();
        $db->setQuery('INSERT INTO #__aniews_anime(`name`,`creator`,`yearc`,`season`,`description`, `ordering`,`published`,`tag_pt`,`img`)VALUES('.$name.','.$creator.','.$yearc.','.$season.','.$description.','.$ordering.','.$published.','.$tag_pt.','.$img.')');
        $db->query();
    }

	    function deleteArea($company,$area){
        $db = JFactory::getDBO();
        $db->setQuery('DELETE FROM #__pindustry_company_area WHERE id_company='.$company.' AND id_area='.$area);
        $db->query();
    }
	
}
