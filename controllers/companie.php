<?php	defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controllerform');

class PindustryControllerCompanie extends JControllerForm
{
	protected $text_prefix = 'COM_ANIEWS_ANIME';
    
    function save()
    {
        $post = $_POST['jform'];
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'jsondata.php';  
        $empresa = PindustryModelJsonData::getEmpresa($post['id']);
        if (!$empresa){
            if (parent::save()) {
                require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'jsonhelper.php';
                PindustryJsonHelper::getAreasZip();  
                return true;   
            }else{
                return false;
            }
        }
        $changes = null;
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'pindustry.php';
        foreach ($empresa as $key => $field){
            if(PindustryHelper::unserialize($field)){
                $empresa[$key] = PindustryHelper::unserialize($field);
            }
        }
        foreach ($post as $key => $field){
            if ($post[$key] != $empresa[$key]){
                $changes = 1;
            }
        }
        if (parent::save()) {
            if($changes){
                require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'jsonhelper.php';
                PindustryJsonHelper::getAreasZip(); 
            }    
            return true;   
        }else{
            return false;
        }
    }
    
}