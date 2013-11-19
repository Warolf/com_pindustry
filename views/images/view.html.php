<?php	defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PindustryViewImages extends JViewLegacy
{
	protected $state;
	protected $items;

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

		$this->listOrder = $this->escape($this->state->get('list.ordering'));
		$this->listDirn = $this->escape($this->state->get('list.direction'));
		$this->saveOrder = $this->listOrder=='ordering';
		$this->orderingEnabled = $this->saveOrder;

		$this->addToolBar();
        
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'jsondata.php';
        $this->company_name = PindustryModelImages::getTitle($this->state->get('filter.company_id'));
        
		parent::display($tpl);
	}

	protected function addToolBar()
	{
        JToolBarHelper::title(JText::_('COM_ANIEWS_MANAGER_IMAGES'), 'article');

		JToolBarHelper::addNew('image.add');
		JToolBarHelper::editList('image.edit');
		JToolBarHelper::divider();
		JToolBarHelper::publish('images.publish', 'JTOOLBAR_PUBLISH', true);
		JToolBarHelper::unpublish('images.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		JToolBarHelper::divider();
		JToolBarHelper::deleteList(JText::_('COM_ANIEWS_CONFIRM_DELETE'), 'images.delete');
	}

}
