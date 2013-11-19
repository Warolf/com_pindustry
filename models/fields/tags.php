<?php    defined('JPATH_PLATFORM') or die;

jimport('joomla.form.formfield');

class JFormFieldTags extends JFormField
{
    protected $type = 'Tags';

    protected function getInput()
    {
        global $com_pindustry_languages;
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'pindustry.php';
        
        $fieldValues=$this->value;

        jimport('joomla.html.pane');
        
        $pane =& JPane::getInstance('tabs');
        $ret='<div class="clr"></div>';
        $ret.=$pane->startPane('pane'.$this->fieldname);
        foreach ($com_pindustry_languages['languages'] as $language) {
            $ret.=$pane->startPanel($language['name'], $language['tag']);
            $ret.='<input type="text" style="float:none;clear:both;"';
            $ret.=' name="'.$this->name.'"';
            $ret.=' id="'.$this->id.'"';
            $ret.=' value="'.htmlspecialchars($fieldValues, ENT_COMPAT, 'UTF-8').'"';
            $ret.=' size="120"/>';
            $ret.=$pane->endPanel();
        }
        $ret.=$pane->endPane();

        return $ret;
    }

}
