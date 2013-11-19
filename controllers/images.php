<?php	defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controlleradmin');

class PindustryControllerImages extends JControllerAdmin
{
	protected $text_prefix = 'COM_ANIEWS_IMAGES';

	public function getModel($name='Image', $prefix='PindustryModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
    
    function delete(){
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'images.php';
        $cid    = JRequest::getVar('cid', array(), '', 'array');
        $data = PindustryModelImages::getImages(implode(',',$cid));
        foreach($data as $delete){
            $destination = JPATH_ROOT.DS."images".DS."portugalindustry".DS."companies".DS.$delete['company_id'];
            unlink($destination.DS.$delete['img']);
            unlink($destination.DS."thumbnails".DS.$delete['img']);
        }
        if(PindustryModelImages::delete(implode(',',$cid))){
            $this->setRedirect('index.php?option=com_pindustry&view=images', 'COM_ANIEWS_DELETE');   
        }
    }

}