<?php	defined('JPATH_PLATFORM') or die;

jimport('joomla.form.formfield');

class JFormFieldTextareatr extends JFormField
{
	protected $type = 'Textareatr';

	protected function getInput()
	{
		$class		= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
		$disabled	= ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';
		$columns	= $this->element['cols'] ? 'cols="'.$this->element['cols'].'"' : 'cols="30"';
		$rows		= $this->element['rows'] ? 'rows="'.$this->element['rows'].'"' : 'rows="15"';

		$onchange	= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';

		global $com_pindustry_languages;
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'pindustry.php';
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'companie.php';
        if(substr($this->fieldname, 0, -1) == "files_desc"){
            $id = JRequest::getInt('id');
            $file = PindustryModelCompanie::getfile($id,substr($this->fieldname, -1));
            $file = PindustryHelper::unserialize($file);
            $fieldValues = $file['description'];
        }
		$fieldValues=(is_string($this->value)) ? PindustryHelper::unserialize($this->value) : $this->value;
                                        
		jimport('joomla.html.pane');

		$pane =& JPane::getInstance('tabs', array('startOffset'=>2));
		$ret='<div class="clr"></div>';
		$ret.=$pane->startPane('pane'.$this->fieldname);
        if($this->element['editor']==true){
            $ret.='<style type="text/css">#editor-xtd-buttons{margin-bottom:20px;}div.current textarea{float:none;}</style>';
            jimport('joomla.html.editor');
            
            // Build the buttons array.
            $buttons = (string) $this->element['buttons'];
            if ($buttons == 'true' || $buttons == 'yes' || $buttons == '1')
            {
                $buttons = true;
            }
            elseif ($buttons == 'false' || $buttons == 'no' || $buttons == '0')
            {
                $buttons = false;
            }
            else
            {
                $buttons = explode(',', $buttons);
            }
            $hide = ((string) $this->element['hide']) ? explode(',', (string) $this->element['hide']) : array();

            // Get an editor object.
            $editor = $this->getEditor();

            foreach ($com_pindustry_languages['languages'] as $language) {
                $ret.=$pane->startPanel($language['name'], $language['tag']);
                $ret.=$editor
                    ->display(
                    $this->name.'['.$language['tag'].']', htmlspecialchars($fieldValues[$language['tag']], ENT_COMPAT, 'UTF-8'), '100%', $height, filter_var($columns, FILTER_SANITIZE_NUMBER_INT), filter_var($rows, FILTER_SANITIZE_NUMBER_INT),
                    $buttons ? (is_array($buttons) ? array_merge($buttons, $hide) : $hide) : false, $this->name.'['.$language['tag'].']', $asset,
                    $this->form->getValue($authorField)
                );
                $ret.=$pane->endPanel();
            }
        }else{
		    foreach ($com_pindustry_languages['languages'] as $language) {
			    $ret.=$pane->startPanel($language['name'], $language['tag']);
			    $ret.='<textarea style="float:none;clear:both;"';
			    $ret.=' name="'.$this->name.'['.$language['tag'].']"';
			    $ret.=' id="'.$this->id.'['.$language['tag'].']"';
			    $ret.=$columns.$rows.$class.$disabled.$onchange.' >';
			    $ret.=htmlspecialchars($fieldValues[$language['tag']], ENT_COMPAT, 'UTF-8');
			    $ret.='</textarea>';
			    $ret.=$pane->endPanel();
		    }
        }
        $ret.=$pane->endPane();

		return $ret;
	}
    
    protected function &getEditor()
    {
        // Only create the editor if it is not already created.
        if (empty($this->editor))
        {
            // Initialize variables.
            $editor = null;

            // Get the editor type attribute. Can be in the form of: editor="desired|alternative".
            $type = trim((string) $this->element['editor']);

            if ($type)
            {
                // Get the list of editor types.
                $types = explode('|', $type);

                // Get the database object.
                $db = JFactory::getDBO();

                // Iterate over teh types looking for an existing editor.
                foreach ($types as $element)
                {
                    // Build the query.
                    $query = $db->getQuery(true);
                    $query->select('element');
                    $query->from('#__extensions');
                    $query->where('element = ' . $db->quote($element));
                    $query->where('folder = ' . $db->quote('editors'));
                    $query->where('enabled = 1');

                    // Check of the editor exists.
                    $db->setQuery($query, 0, 1);
                    $editor = $db->loadResult();

                    // If an editor was found stop looking.
                    if ($editor)
                    {
                        break;
                    }
                }
            }

            // Create the JEditor instance based on the given editor.
            $this->editor = JFactory::getEditor($editor ? $editor : null);
        }

        return $this->editor;
    }

}
