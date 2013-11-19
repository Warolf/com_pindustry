<?php	defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modeladmin');

class PindustryModelBusinessarea extends JModelAdmin
{

	public function getTable($type='Businessarea', $prefix='PindustryTable', $config=array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data=array(), $loadData=true)
	{
		$form=$this->loadForm('com_pindustry.businessarea', 'businessarea', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		return $form;
	}

	protected function loadFormData()
	{
		$data=JFactory::getApplication()->getUserState('com_pindustry.edit.businessarea.data', array());
		if (empty($data))
		{
			$data=$this->getItem();
		}
		return $data;
	}
    
    function getLast(){
        $db = JFactory::getDBO();
        $db->setQuery('SELECT id FROM #__aniews_manga ORDER BY id DESC LIMIT 0,1');
        return $db->loadResult();
    }

}
