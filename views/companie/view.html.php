<?php	defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PindustryViewCompanie extends JViewLegacy
{

	public function display($tpl = null)
	{

        $document =& JFactory::getDocument();
        $document->addScript('components/com_pindustry/assets/jquery-1.7.2.min.js');
        $document->addScript('components/com_pindustry/assets/company.js');
        
        $company = JRequest::getInt('id');
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'jsonhelper.php';
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'companie.php';
        if($area=JRequest::getInt('area')){
            PindustryModelCompanie::addArea($company,$area);
            PindustryJsonHelper::getAreasZip($area);
            $app = JFactory::getApplication();
            $app->redirect('index.php?option=com_pindustry&view=companie&layout=edit&id='.$company); 
        }
        if($area=JRequest::getInt('deletearea')){
            PindustryModelCompanie::deleteArea($company,$area);
            PindustryJsonHelper::getAreasZip($area);
            $app = JFactory::getApplication();
            $app->redirect('index.php?option=com_pindustry&view=companie&layout=edit&id='.$company); 
        }
        
        $form = $this->get('Form');
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		if ($form->getField('created_by')->value==0)	{
			$form->setValue('created_by', null, JFactory::getUser()->id);
		}

		$this->form = $form;

		$this->addToolBar();

		parent::display($tpl);
	}

	protected function addToolBar()
	{
		JRequest::setVar('hidemainmenu', true);
        $isNew = ($this->form->getField('id')->value == 0);
        
        $title=$isNew ? JText::_('COM_ANIEWS_MANAGER_ANIME_NEW') : JText::_('COM_ANIEWS_MANAGER_ANIME_EDIT');
        $icon=$isNew ? 'article-add' : 'article-edit';
        JToolBarHelper::title($title, $icon);
        
        if (!$isNew)    {
            JToolBarHelper::custom('video.cancel', 'menus', '', 'COM_ANIEWS_MANAGER_VIDEOS', false);
            JToolBarHelper::custom('image.cancel', 'menus', '', 'COM_ANIEWS_MANAGER_IMAGES', false);
            JToolBarHelper::divider();
        }
        
		JToolBarHelper::apply('companie.apply');
		JToolBarHelper::save('companie.save');
		JToolBarHelper::cancel('companie.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
}