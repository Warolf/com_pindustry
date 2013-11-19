<?php	defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class PindustryViewBusinessareas extends JViewLegacy
{

	function display($tpl = null)
	{
        global $com_pindustry_languages;
        
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
        
		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
        
		$this->items = $items;
		$this->pagination = $pagination;

		$this->addToolBar();

		parent::display($tpl);
	}

	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_ANIEWS_MANAGER_MANGAS'));
		JToolBarHelper::addNew('businessarea.add');
		JToolBarHelper::editList('businessarea.edit');
		JToolBarHelper::divider();
		JToolBarHelper::publish('businessareas.publish', 'JTOOLBAR_PUBLISH', true);
		JToolBarHelper::unpublish('businessareas.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		JToolBarHelper::divider();
		JToolBarHelper::deleteList('', 'businessareas.delete');
        JToolBarHelper::divider();
        JToolBarHelper::preferences('com_pindustry');
	}

}