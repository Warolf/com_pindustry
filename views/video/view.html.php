<?php	defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PindustryViewVideo extends JViewLegacy
{

	public function display($tpl = null)
	{
		$user = JFactory::getUser();

		$form = $this->get('Form');

		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		$this->form = $form;

		$company_id=$this->form->getField('company_id')->value;
		$this->addToolBar();

		parent::display($tpl);
	}

	protected function addToolBar()
	{
		$isNew = ($this->form->getField('id')->value == 0);
		if ($isNew)	{
			$this->form->setValue('company_id', null, JRequest::getInt('filter_company_id', (int)$this->form->getField('company_id')->value));
        }

		$title=$isNew ? JText::_('COM_ANIEWS_MANAGER_VIDEO_NEW') : JText::_('COM_ANIEWS_MANAGER_VIDEO_EDIT');
		$icon=$isNew ? 'article-add' : 'article-edit';
		JToolBarHelper::title($title, $icon);

		JToolBarHelper::apply('video.apply');
		JToolBarHelper::save('video.save');
	    
		JToolBarHelper::cancel('video.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}

}
