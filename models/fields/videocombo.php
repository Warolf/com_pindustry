<?php    defined('JPATH_PLATFORM') or die;

jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('list');

class JFormFieldVideocombo extends JFormFieldList
{
    protected $type = 'Videocombo';

    protected function getOptions()
    {
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'jsonhelper.php';
        $options = array();

        $selecttext = $this->element['selecttext'] ? JText::_($this->element['selecttext']) : false;
        $pleaseselecttext = $this->element['pleaseselectedtext'] ? JText::_($this->element['pleaseselectedtext']) : false;
        $table    = (string) $this->element['table'];
        
        if ($table)    {
            if($company=$this->form->getField('company_id')->value){
                global $com_pindustry_languages;
                $db = JFactory::getDbo();

                $query    = $db->getQuery(true);

                $query->select('id AS value, GetTitle(name, "'.$com_pindustry_languages['defaultlang'].'", "'.$com_pindustry_languages['defaultlang'].'") AS text');
                $query->from($table);
                $query->where('published=1');
                $query->where('company_id='.$company);    
                $query->order('text');
                $db->setQuery($query);
                $options = $db->loadObjectList();
            
                if ($db->getErrorNum()) {
                    JError::raiseWarning(500, $db->getErrorMsg());
                }

                if ($selecttext)    {
                    array_unshift($options, JHtml::_('select.option', '0', $selecttext));
                }
            }else{
                array_unshift($options, JHtml::_('select.option', '0', $pleaseselecttext)); 
            }

        }

        return $options;
    }

}