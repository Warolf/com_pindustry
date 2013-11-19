<?php	defined('JPATH_PLATFORM') or die;

jimport('joomla.form.formfield');
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

class JFormFieldTexttr extends JFormField
{
	protected $type = 'Texttr';

	protected function getInput()
	{
		$size		= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
		$maxLength	= $this->element['maxlength'];
		$class		= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
		$readonly	= ((string) $this->element['readonly'] == 'true') ? ' readonly="readonly"' : '';
		$disabled	= ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';

		$onchange	= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';
		
		global $com_pindustry_languages;
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'pindustry.php';
        
		$fieldValues=(is_string($this->value)) ? PindustryHelper::unserialize($this->value) : $this->value;

		jimport('joomla.html.pane');

		$pane =JPane::getInstance('tabs');
		$ret='<div class="clr"></div>';
		$ret.=$pane->startPanel('pane'.$this->fieldname);
		foreach ($com_pindustry_languages['languages'] as $language) {
			$ret.=$pane->startPanel($language['name'], $language['tag']);
			$ret.='<input type="text" style="float:none;clear:both;"';
			$ret.=' name="'.$this->name.'['.$language['tag'].']"';
			$ret.=' id="'.$this->id.'['.$language['tag'].']"';
			$ret.=' value="'.htmlspecialchars($fieldValues[$language['tag']], ENT_COMPAT, 'UTF-8').'"';
			$ret.=$class.$size.$disabled.$readonly.$onchange.'/>';
			if($maxLength == 'video'){
                $skip=(is_string($this->form->getValue('skip'))) ? PindustryHelper::unserialize($this->form->getValue('skip')) : $this->form->getValue('skip');
                $ret.='<table>';
                $ret.='<tr>';
                $ret.='<td>'.JText::_('COM_SKIP_HIGHLIGHT').'</td>';
                $ret.='<td><input type="radio" name="jform[skip]['.$language['tag'].']" id="jform_skip['.$language['tag'].']" value="1"';
                if($skip[$language['tag']]){
                    $ret.='checked';
                }
                $ret.='>'.JText::_('COM_ANIEWS_VIDEO_PUBLISHED').'</td>';
                $ret.='<td><input type="radio" name="jform[skip]['.$language['tag'].']" id="jform_skip['.$language['tag'].']" value="0"';
                if(!$skip[$language['tag']]){
                    $ret.='checked';
                }
                $ret.='>'.JText::_('COM_ANIEWS_VIDEO_UNPUBLISHED').'</td>';
                $ret.='</tr>';
                $ret.='</table>';
			}
			$ret.=$pane->endPanel();
		}
		$ret.=$pane->endPane();

		return $ret;
	}

}