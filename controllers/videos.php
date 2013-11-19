<?php	defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controlleradmin');

class PindustryControllerVideos extends JControllerAdmin
{
	protected $text_prefix = 'COM_ANIEWS_VIDEOS';

	public function getModel($name='Video', $prefix='PindustryModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
    
    function setDefault()
    {
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $cid = JRequest::getVar('cid', array(0), 'default', 'array');
        $videoid=$cid[0];

        $company_id=JRequest::getInt('filter_company_id');

        $model = $this->getModel('video');
        if ($model->setdefault($company_id, $videoid))
        {
            $msg = JText::_('COM_EMENUK_MENUS_MSG_DEFAULT_MENU_SAVED');
            $type = 'message';
        }
        else
        {
            $msg = $this->getError();
            $type = 'error';
        }

        $filter_company_id=JRequest::getInt("filter_company_id");
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'jsondata.php';
        $area = PindustryModelJsonData::getCompanyArea($filter_company_id);
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'jsonhelper.php';
        PindustryJsonHelper::getAreasZip($area[0]);
        
        $this->setredirect('index.php?option=com_pindustry&view=videos&filter_company_id='.$company_id, $msg, $type);
    }

}