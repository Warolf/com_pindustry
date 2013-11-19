<?php	defined( '_JEXEC' ) or die( 'Restricted access' );

class PindustryTableBusinessarea extends PindustryTable
{
	var $id = null;
	var $description = null;
    var $definition = null;
	var $ordering = 0;
	var $published = 1;

	function PindustryTableBusinessarea(& $db){
		parent::__construct('#__aniews_manga', 'id', $db);
	}

	public function check()
	{
        $siteDefaultLang=&$this->_com_pindustry_langs['defaultlang'];
        
		
        foreach ($this->description as $desc){
            if(trim($desc) == ''){
                $this->setError(JText::_('COM_ANIEWS_ERROR_PROVIDE_VALID_DESCRIPTION'));
                return false;
            }
        }
        
        foreach ($this->definition as $def){
            if(trim($def) == ''){
                $this->setError(JText::_('COM_ANIEWS_ERROR_PROVIDE_VALID_DEFINITION'));
                return false;
            }
        }

		if ($this->ordering==0)	{
			$this->ordering=$this->getNextOrder();
		}
        
        $this->description = PindustryHelper::serialize($this->description);
        $this->definition = PindustryHelper::serialize($this->definition);
        
		return true;
	}

}
