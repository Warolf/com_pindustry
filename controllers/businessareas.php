<?php	defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controlleradmin');

class PindustryControllerBusinessareas extends JControllerAdmin
{
	protected $text_prefix = 'COM_MANGA';

	public function getModel($name='Businessarea', $prefix='PindustryModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
    
    function delete(){
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'businessareas.php';
        $cid    = JRequest::getVar('cid', array(), '', 'array');
        if ($data = PindustryModelBusinessareas::getEmpresas(implode(',',$cid))){
            $this->setRedirect('index.php?option=com_pindustry&view=businessareas', 'Lamento mas esta Área de Negocio tem Empresas ligadas, retire as empresas desta área.','error');
            return;
        }
        if (PindustryModelBusinessareas::delete(implode(',',$cid))) {
            foreach ($cid as $id){
                $path = JPATH_ROOT.DS."media".DS."portugalindustry_zip".DS.$id;
                if (file_exists($path)){
                    $d = dir($path);
                    while($entry = $d->read()) { 
                        if ($entry != "." && $entry != "..") { 
                            unlink($path.DS.$entry); 
                        } 
                    }
                    $d->close(); 
                    rmdir($path);
                }   
            }
        }
        $this->setRedirect('index.php?option=com_pindustry&view=businessareas', 'Registo eliminado com sucesso.');
    }
    
}