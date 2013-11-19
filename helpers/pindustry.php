<?php	defined('_JEXEC') or die;

global $com_pindustry_languages;
if (!$com_pindustry_languages)	{
	$com_pindustry_languages=array();
	$com_languages_params = JComponentHelper::getParams('com_languages');
	$com_pindustry_languages['defaultlang']=$com_languages_params->get('site', 'en-GB');
	$com_pindustry_jlang=&JFactory::getLanguage();
	$com_pindustry_languages['languages']=$com_pindustry_jlang->getKnownLanguages();
	unset($com_pindustry_jlang);
	unset($com_languages_params);
}

class PindustryHelper
{

	public static function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(JText::_('COM_ANIME'), 'index.php?option=com_pindustry&view=companies', $vName == 'companies');
		JSubMenuHelper::addEntry(JText::_('COM_MANGA'), 'index.php?option=com_pindustry&view=businessareas', $vName == 'businessareas');
	}

	public static function getActions($categoryId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($categoryId)) {
			$assetName = 'com_pindustry';
		} else {
			$assetName = 'com_pindustry.category.'.(int) $categoryId;
		}

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
    
    public function utf8_decode($st)
    {
        if (is_string($st))    {
            return utf8_decode($st);
        }
        if (is_array($st))    {
            foreach ($st as &$value) {
                $value=self::utf8_decode($value);    }
        }
        return $st;
    }

    public function unserialize($st)
    {
        $arr=unserialize(self::utf8_decode($st));
        if (is_array($arr))    {
            foreach ($arr as &$value) {
                if(is_array($value)){
                    foreach ($value as $val){
                          $val= utf8_encode($val);
                    }
                }else{
                    $value= utf8_encode($value);           
                }
            }            
        }

        return $arr;
    }

    public function serialize($arr)
    {
        if (is_array($arr))    {
            return utf8_encode(serialize(self::utf8_decode($arr)));
        }
    }

}


class PindustryTable extends JTable
{
	var $com_pindustry_langs = null;

	function __construct($table, $key, &$db)
	{
		parent::__construct($table, $key, $db);

		global $com_pindustry_languages;
		$this->_com_pindustry_langs=&$com_pindustry_languages;
	}
    
}