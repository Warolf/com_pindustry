 <?php	defined('JPATH_PLATFORM') or die;

jimport('joomla.form.helper');
jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('list');

class JFormFieldPindustrybusinessarea extends JFormFieldList
{
	protected $type = 'Emenukmenuofdaysection';

	public function getOptions()
	{
		$options = array();

        global $com_pindustry_languages;
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		/*$query->select('ca.id_area AS value, GetTitle(ba.description, "'.$com_pindustry_languages['defaultlang'].'", "'.$com_pindustry_languages['defaultlang'].'") AS text');
		$query->from('#__pindustry_company_area AS ca');
        $query->join('LEFT', '#__aniews_manga AS ba ON (ca.id_area = ba.id)');
        $query->group('ca.id_area');
        $query->order('text');
        
		$db->setQuery($query);
		$options = $db->loadObjectList();

		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());		}
            	
		array_unshift($options, JHtml::_('select.option', '0', JText::_('COM_ANIEWS_ANIME_SELECT_IDMANGA')));

		return $options;*/
	}
}
