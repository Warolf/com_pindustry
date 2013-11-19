<?php	defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controlleradmin');

class PindustryControllerCompanies extends JControllerAdmin
{
	protected $text_prefix = 'COM_ANIME';

	public function getModel($name='Companie', $prefix='PindustryModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
    
 /*   function delete(){
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'jsonhelper.php';
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'companie.php';
        $delete=parent::delete();
        $cid=$_POST['cid'];
        foreach($cid as $id){
            $areas = PindustryModelCompanie::getCompanyArea($id);
            $db = JFactory::getDBO();
            $db->setQuery('DELETE FROM #__aniews_anime WHERE id='.$id);
            $db->query();
            foreach($areas as $area){
                PindustryJsonHelper::getAreasZip($area['id']);
            }
        }
    }*/

}