<?php	defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PindustryViewBusinessarea extends JViewLegacy
{

	public function display($tpl = null)
	{
		$form = $this->get('Form');

		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		$this->form = $form;

		$this->addToolBar();

		parent::display($tpl);
	}

	protected function addToolBar()
	{
		JRequest::setVar('hidemainmenu', true);
		$isNew = ($this->form->getField('id')->value == 0);
		JToolBarHelper::title($isNew ? JText::_('COM_ANIEWS_MANAGER_MANGA_NEW') : JText::_('COM_ANIEWS_MANAGER_MANGA_EDIT'));
		JToolBarHelper::apply('businessarea.apply');
		JToolBarHelper::save('businessarea.save');
		JToolBarHelper::cancel('businessarea.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
}
