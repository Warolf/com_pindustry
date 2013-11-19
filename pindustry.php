<?php	defined('_JEXEC') or die;

if (!JFactory::getUser()->authorise('core.manage', 'com_pindustry')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
require_once JPATH_COMPONENT.DS.'helpers'.DS.'pindustry.php';

jimport('joomla.application.component.controller');

$origTask=JRequest::getCmd('task');

$controller	= JControllerLegacy::getInstance('Pindustry');

//$task=JRequest::getCmd('task');
//$controller->execute($task);
$controller->execute( JFactory::getApplication()->input->get('task') );

$hasRedirect=$controller->get('redirect');

if ($hasRedirect)    {
    switch ($origTask) {
        case 'video.edit':
            $filter_company_id=JRequest::getInt('filter_company_id');
            if ($filter_company_id)    {
                $controller->setRedirect($hasRedirect.'&filter_company_id='.$filter_company_id);            }
            break;
        case 'new.edit':
            if($_POST['search']){
                $hasRedirect = $hasRedirect.'&search='.$_POST['search'];
                $controller->setRedirect($hasRedirect);
            }
            if($_POST['companies_id']){
                $hasRedirect = $hasRedirect.'&companies_id='.$_POST['companies_id'];
                $controller->setRedirect($hasRedirect);
            }
            break;            
    }
}
$controller->redirect();

?>
