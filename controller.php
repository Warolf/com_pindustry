<?php	defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class PindustryController extends JControllerLegacy
{

	function display($cachable = false)
	{
		$view = JRequest::getCmd('view', 'companies');

		PindustryHelper::addSubmenu($view);

		JRequest::setVar('view', $view);
		parent::display($cachable);
	}

}