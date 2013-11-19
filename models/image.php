<?php	defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modeladmin');

class PindustryModelImage extends JModelAdmin
{

	public function getTable($type='Image', $prefix='PindustryTable', $config=array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data=array(), $loadData=true)
	{
		$form=$this->loadForm('com_pindustry.image', 'image', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		return $form;
	}

	protected function loadFormData()
	{
		$data=JFactory::getApplication()->getUserState('com_pindustry.edit.image.data', array());
		if (empty($data))
		{
			$data=$this->getItem();
		}
		return $data;
	}

}
