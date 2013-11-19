<?php	defined('JPATH_PLATFORM') or die;

jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('list');

class JFormFieldCombotr extends JFormFieldList
{
	protected $type = 'Combotr';

	protected function getOptions()
	{
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'jsonhelper.php';
		$options = array();

		$selecttext = $this->element['selecttext'] ? JText::_($this->element['selecttext']) : false;
		$table	= (string) $this->element['table'];
        
		if ($table)	{
			global $com_pindustry_languages;
			$db = JFactory::getDbo();

			$query	= $db->getQuery(true);

			$query->select('id AS value, GetTitle(description, "'.$com_pindustry_languages['defaultlang'].'", "'.$com_pindustry_languages['defaultlang'].'") AS text');
			$query->from($table);
			$query->where('published=1');
			$query->order('text');
			$db->setQuery($query);
			$options = $db->loadObjectList();
			
			if ($db->getErrorNum()) {
				JError::raiseWarning(500, $db->getErrorMsg());			}

			if ($selecttext)	{
				array_unshift($options, JHtml::_('select.option', '0', $selecttext));			}

		}

		return $options;
	}

}