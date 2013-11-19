<?php	defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class PindustryViewCompanies extends JViewLegacy
{
    protected $state;
    
	function display($tpl = null)
	{
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
        $this->state = $this->get('State');
        
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		$this->items = $items;
		$this->pagination = $pagination;

		$this->addToolBar();
        
        require_once JPATH_COMPONENT_ADMINISTRATOR.'/models/fields/businessarea.php';
		parent::display($tpl);
	}

	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_ANIEWS_MANAGER_MANGA'));
		JToolBarHelper::addNew('companie.add');
        JToolBarHelper::editList('companie.edit');
        JToolBarHelper::divider();
        JToolBarHelper::publish('companies.publish', 'JTOOLBAR_PUBLISH', true);
        JToolBarHelper::unpublish('companies.unpublish', 'JTOOLBAR_UNPUBLISH', true);
        JToolBarHelper::divider();
        JToolBarHelper::deleteList('', 'companies.delete');
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_pindustry');
    }

}