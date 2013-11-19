<?php	defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controllerform');

class PindustryControllerBusinessarea extends JControllerForm
{
	protected $text_prefix = 'COM_ANIEWS_MANGA';
    
    function save(){   
        if (parent::save()) {
            require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'businessarea.php';
            $lastid = PindustryModelBusinessarea::getLast();
            $destination = JPATH_ROOT.DS."media".DS."portugalindustry_zip".DS.$lastid;
            if(!file_exists($destination)){
                mkdir($destination);
            }
        }else{
            return false;
        }
    }    
}