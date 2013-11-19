<?php	defined('JPATH_PLATFORM') or die;

jimport('joomla.form.formfield');

class JFormFieldimagecheck extends JFormField
{
	protected $type = 'Imagecheck';

	protected function getInput()
	{
		$class		= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
		$onchange	= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';

		$ret='';
		$table = $this->element['table'];
		if ($table)	{
			$db = JFactory::getDbo();
			$query	= $db->getQuery(true);

			$query->select('id, title, filename');
			$query->from($table);
			$query->where('published=1');
			$db->setQuery($query);
			$options = $db->loadObjectList();
			if ($db->getErrorNum()) {
				JError::raiseWarning(500, $db->getErrorMsg());
			}

			$val=explode(',', $this->value);
			$ret.='<table id="'.$this->id.'" style="margin:0px;"><tr><td>';
			foreach ($options as $option) {
				$checked=in_array($option->id, $val) ? 'checked="checked"' : '';
				$ret.='<table style="margin:0px;float:left;border:1px solid #DDD;"><tr><td>';
					$ret.='<input style="margin:2px;" type="checkbox" name="'.$this->name.'['.$option->id.']"';
					$ret.=' id="'.$this->id.$option->id.'" value="'.$option->id.'"'.$class.$checked.' />';
					$ret.='<image style="margin:2px;float:none;" src="'.JURI::root().$option->filename.'">';
				$ret.='</td></tr></table>';
			}
			$ret.='</td></tr></table>';
		}

		return $ret;
	}

}
