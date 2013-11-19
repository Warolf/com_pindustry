<?php	defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modeladmin');

class PindustryModelVideo extends JModelAdmin
{

	public function getTable($type='Video', $prefix='PindustryTable', $config=array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data=array(), $loadData=true)
	{
		$form=$this->loadForm('com_pindustry.video', 'video', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		return $form;
	}

	protected function loadFormData()
	{
		$data=JFactory::getApplication()->getUserState('com_pindustry.edit.video.data', array());
		if (empty($data))
		{
			$data=$this->getItem();
		}
		return $data;
	}
    
    public function setdefault($company_id, $videoid)
    {
        $table=$this->getTable();

        return $table->setdefault($company_id, $videoid);
    }

}
