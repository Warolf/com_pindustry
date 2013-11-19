<?php	defined('_JEXEC') or die('Restricted access');

class PindustryTableVideo extends PindustryTable
{
	var $id = null;
	var $company_id = null;
	var $type = null;
	var $video = null;
	var $ordering = 0;
	var $published = 1;
    var $default = 0;
    var $name = null;
    var $skip = null;

	function PindustryTableVideo(& $db){
		parent::__construct('#__aniews_videos', 'id', $db);
	}

	public function check()
	{
		$siteDefaultLang=&$this->_com_pindustry_langs['defaultlang'];
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'pindustry.php';
        
        if ($this->ordering==0){
            $this->ordering=$this->getNextOrder("company_id={$this->company_id}");
        }
        
        $this->skip = PindustryHelper::serialize($this->skip);
        $this->name = PindustryHelper::serialize($this->name);
        if($this->video){
            foreach($this->video as $key => $video){
                $this->video[$key] = trim($video);
            }
        }
        $this->video = PindustryHelper::serialize($this->video);
		return true;
	}

    public function reorder($where = '')
    {
        $ret=parent::reorder("company_id={$this->company_id}");

        return $ret;
    }

    public function move($delta, $where = '')
    {
        $ret=parent::move($delta, "company_id={$this->company_id}");

        return $ret;
    }
    
    public function setdefault($company_id, $videoid)
    {
        $db = JFactory::getDBO();

        $query = $db->getQuery(true);
        $query->update('#__aniews_videos');
        $query->set("`default`=(id={$videoid})");
        $query->where("company_id={$company_id}");
        $db->setQuery($query);

        return $db->query();
    }

}
