<?php	defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controllerform');

class PindustryControllerImage extends JControllerForm
{
	protected $text_prefix = 'COM_ANIEWS_IMAGE';

	function cancel()
	{
		$url='index.php?option=com_pindustry&view=images';

        $id=JRequest::getInt("id");
        if ($id)    {
            $url.='&filter_company_id='.$id;
        }
        
		$filter_company_id=JRequest::getInt("filter_company_id");
		if ($filter_company_id)	{
			$url.='&filter_company_id='.$filter_company_id;
        }

		$this->setRedirect(JRoute::_($url, false));
	}
    
        function add()
    {
        $url='index.php?option=com_pindustry&view=image&layout=edit';
        
        $filter_company_id=JRequest::getInt("filter_company_id");
        if ($filter_company_id)    {
            $url.='&filter_company_id='.$filter_company_id;
        }

        $this->setRedirect(JRoute::_($url, false));
    }

}