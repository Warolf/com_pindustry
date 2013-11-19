<?php	defined('_JEXEC') or die('Restricted access');

class PindustryTableHighlight extends PindustryTable
{
	var $id = null;
	var $company_id = null;
	var $video_id = null;
	var $ordering = 0;
	var $published = 1;

	function PindustryTableHighlight(& $db){
		parent::__construct('#__pindustry_highlights', 'id', $db);
	}

	public function check()
	{
		$siteDefaultLang=&$this->_com_pindustry_langs['defaultlang'];
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'pindustry.php';
        
        if ($this->ordering==0){
            $this->ordering=$this->getNextOrder();
        }
        
        if ($this->company_id == 0){
            $this->setError(JText::_('COM_ANIEWS_ERROR_PROVIDE_VALID_COMPANY'));
            return false;
        }
        
        if ($this->video_id == 0){
            $this->setError(JText::_('COM_ANIEWS_ERROR_PROVIDE_VALID_VIDEO_HIGHLIGHT'));
            return false;
        }

		return true;
	}

}
