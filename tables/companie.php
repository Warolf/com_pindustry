<?php	defined( '_JEXEC' ) or die( 'Restricted access' );

class PindustryTableCompanie extends PindustryTable
{
	var $id = null;
	var $name = null;
	var $creator = null;
	var $yearc = null;
	var $season = null;
	var $description = null;
	var $ordering = null;
	var $published = 1;
    var $image = null;
    var $tag_pt = null;

	function PindustryTableCompanie(& $db){
		parent::__construct('#__aniews_anime', 'id', $db);
	}

	public function check()
	{
        global $com_pindustry_languages;
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'companie.php';
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'pindustry.php';
        $siteDefaultLang=&$this->_com_pindustry_langs['defaultlang'];

        if(!$this->id){
            $id = PindustryModelCompanie::getLast() + 1;
        }else{
            $id = $this->id;
        }
        
		if ($this->idbusinessarea == "0") {
			$this->setError(JText::_('COM_ANIEWS_ERROR_PROVIDE_VALID_IDMANGA'));
			return false;
		}
        
        if (trim($this->name[$siteDefaultLang]) == '') {
            $this->setError(JText::_('COM_ANIEWS_ERROR_PROVIDE_VALID_NAME'));
            return false;
        }
        
        if (trim($this->creator[$siteDefaultLang]) == '') {
            $this->setError(JText::_('COM_ANIEWS_ERROR_PROVIDE_VALID_INTRO'));
            return false;
        }
        
        if (trim($this->description[$siteDefaultLang]) == '') {
            $this->setError(JText::_('COM_ANIEWS_ERROR_PROVIDE_VALID_DESCRIPTION'));
            return false;
        }
        
        if (trim($this->yearc[$siteDefaultLang]) == '') {
            $this->setError(JText::_('COM_ANIEWS_ERROR_PROVIDE_VALID_ADRESS'));
            return false;
        }
        
        if (trim($this->season[$siteDefaultLang]) == '') {
            $this->setError(JText::_('COM_ANIEWS_ERROR_PROVIDE_VALID_POSTALCODE'));
            return false;
        }
        
        
        if (trim($this->published[$siteDefaultLang]) == '') {
            $this->setError(JText::_('COM_ANIEWS_ERROR_PROVIDE_VALID_COUNTRY'));
            return false;
        }
        
        if (trim($this->image) != ''){
            $image_split = explode("/",$this->image);
            $img = end($image_split);
            $destination = JPATH_ROOT.DS."images".DS."portugalindustry";
            $Width = "65";
            $Height = "45";
            $files[] = $img;
			$params['limit']['x'] = "65";
			$params['limit']['y'] = "45";
            $params['canvas'] = false;
            $params['company_id'] = $id;
            if(!file_exists(JPATH_ROOT.DS."images".DS."portugalindustry".DS."companies".DS.$id)){
                   mkdir(JPATH_ROOT.DS."images".DS."portugalindustry".DS."companies".DS.$id);
            }
            if(!file_exists(JPATH_ROOT.DS."images".DS."portugalindustry".DS."companies".DS.$id.DS."app")){
                   mkdir(JPATH_ROOT.DS."images".DS."portugalindustry".DS."companies".DS.$id.DS."app");
            }
            if(!file_exists(JPATH_ROOT.DS."images".DS."portugalindustry".DS."companies".DS.$id.DS."site")){
                   mkdir(JPATH_ROOT.DS."images".DS."portugalindustry".DS."companies".DS.$id.DS."site");
            }
            if(!file_exists(JPATH_ROOT.DS."images".DS."portugalindustry".DS."companies".DS.$id.DS."site_company")){
                   mkdir(JPATH_ROOT.DS."images".DS."portugalindustry".DS."companies".DS.$id.DS."site_company");
            }
            self::saveImage($files, $destination, $Width, $Height, $params);
            $this->image = $img;
            $Width = "150";
            $Height = "100";
            $params['limit']['x'] = "150";
            $params['limit']['y'] = "100";
            self::saveImage2($files, $destination, $Width, $Height, $params);
            $Width = "250";
            $Height = "175";
            $params['limit']['x'] = "250";
            $params['limit']['y'] = "175";
            self::saveImage3($files, $destination, $Width, $Height, $params);
        }
        
        $this->name = PindustryHelper::serialize($this->name);
        $this->creator = PindustryHelper::serialize($this->creator);
        $this->description = PindustryHelper::serialize($this->description);
        $this->yearc = PindustryHelper::serialize($this->yearc);
        $this->season = PindustryHelper::serialize($this->season);
        
        return true;
	}
    
    function hex2RGB($hex){
        /*
         * Format Hex Values
         */
        $hex = preg_replace("/[^0-9A-Fa-f]/", '', $hex);
        /*
         * Create The Output Array
         */
        $rgb = array();
        /*
         * Convert To RGB Values
         */
        if (strlen($hex) == 6) {
            $colorValue = hexdec($hex);
            $rgb['red'] = 0xFF & ($colorValue >> 0x10);
            $rgb['green'] = 0xFF & ($colorValue >> 0x8);
              $rgb['blue'] = 0xFF & $colorValue;
        } elseif (strlen($hex) == 3) { 
            $rgb['red'] = hexdec(str_repeat(substr($hex, 0, 1), 2));
            $rgb['green'] = hexdec(str_repeat(substr($hex, 1, 1), 2));
            $rgb['blue'] = hexdec(str_repeat(substr($hex, 2, 1), 2));
        } else {
            /*
             * Error
             * -----
             * Invalid Hex Value Given
             */
            return false;
        }
        return $rgb;
    }
    
    /*
     * Function To Set A Transparency Background
     */
    function setTransparency($new_image,$image_source) 
    { 
            $transparencyIndex = imagecolortransparent($image_source); 
            $transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255); 
             
            if ($transparencyIndex >= 0) { 
                $transparencyColor    = imagecolorsforindex($image_source, $transparencyIndex);    
            }
            
            $transparencyIndex    = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']); 
            imagefill($new_image, 0, 0, $transparencyIndex); 
            imagecolortransparent($new_image, $transparencyIndex); 
        
    } 
    
    /*
     * Resize And Creates A Image Based On Fixed Mesures
     */
    function PictureResize($origFile, $targetFile, $fixedWidth, $fixedHeight = null, $canvasColor = null, $watermark = null, $limit = null, $canvas = null) {
        /*
         * Find Extension Of The Uploaded Image
         */
        $fileExtension = substr($targetFile,strlen($targetFile)-4,4);
        $fileExtension = strtolower($fileExtension);
        if($fileExtension == ".gif") $image = @imagecreatefromgif($origFile);
        if($fileExtension == ".jpg") $image = @imagecreatefromjpeg($origFile);
        if($fileExtension == ".png") $image = @imagecreatefrompng($origFile);
        /*
         * Get Uploaded Image Sizes
         * -Width
         * -Height
         */
        $imageWidth = imagesx($image);
        $imageHeight = imagesy($image);
        /*
         * Find Image Resize Sizes
         */
        if (!$fixedHeight){
            $newWidth = $fixedWidth;
            $newHeight = ($imageHeight / $imageWidth) * $fixedWidth;
            $fixedHeight = $newHeight;
        }else{
            if ($canvas == 0){
                if ($imageHeight > $fixedHeight OR $imageWidth > $fixedWidth){
                    if ($imageHeight > $imageWidth) {
                        $newWidth = $fixedWidth;
                        $ratio = $fixedWidth / $imageWidth;
                        $newHeight = $imageHeight * $ratio;
                    }else{
                        $newHeight = $fixedHeight;
                        $ratio = $fixedHeight / $imageHeight;
                        $newWidth = $imageWidth * $ratio;
                        if ($newWidth < $fixedWidth){
                            $newWidth = $fixedWidth;
                            $ratio = $fixedWidth / $imageWidth;
                            $newHeight = $imageHeight * $ratio;
                        }
                    }   
                }else{
                 $newHeight = $imageHeight;
                 $newWidth = $imageWidth; 
                }
            }else{
                if ($imageHeight > $fixedHeight OR $imageWidth > $fixedWidth){
                    /*
                     * Find Width If Is Bigger Than Fixed Width
                     */
                    if ($imageWidth > $fixedWidth) {
                        $newWidth = $fixedWidth;
                        $ratio = $fixedWidth / $imageWidth;
                        $newHeight = $imageHeight * $ratio;
                    /*
                     * Recalc If Height Still Wrong
                     */
                        if ($newHeight > $fixedHeight){
                            $wrongHeight = $newHeight;
                            $newHeight = $fixedHeight;
                            $ratio = $fixedHeight / $wrongHeight;
                            $newWidth = $newWidth * $ratio;
                        }
                    }else{
                    /*
                     * Find Height If Is Bigger Than Fixed Height
                     */
                        if ($imageHeight > $fixedHeight){
                            $newHeight = $fixedHeight;
                            $ratio = $fixedHeight / $imageHeight;
                            $newWidth = $imageWidth * $ratio;
                        /*
                         * Recalc If Width Still Wrong
                         */
                            if ($newWidth > $fixedWidth){
                                $wrongWidth = $newWidth;
                                $newWidth = $fixedWidth;
                                $ratio = $fixedWidth / $wrongWidth;
                                $newWidth = $newWidth * $ratio;
                            }
                        }
                    }
                        
                }else{
                /*
                 * Case Height and Width Values Are Lower Than The Fixed Values
                 */
                 $newHeight = $imageHeight;
                 $newWidth = $imageWidth; 
                }
            }
        }
        /*
         * Create Temporary Image
         */
        if ($limit['x'] && $newWidth >= $limit['x']){
             $fixedWidth = $limit['x'];
        }
        if ($limit['y'] && $newHeight >= $limit['y']){
            $fixedHeight = $limit['y'];
        }
        $tmp = imagecreatetruecolor($fixedWidth, $fixedHeight);
        /*
         * Place Background (If Color Value Exist)
         */
        if ($canvasColor){
            $canvasColor = self::hex2RGB($canvasColor);
            $canvas = imagecolorallocate($tmp, $canvasColor['red'], $canvasColor['green'], $canvasColor['blue']);
            imagefilledrectangle($tmp, 0, 0, $fixedWidth, $fixedHeight, $canvas);
        }else{
        /*
         * Set White Background If Not Png Or Canvas Included
         */
        if ($fileExtension != '.png' && !$canvasColor){
            $canvas = imagecolorallocate($tmp, 255, 255, 255);
            imagefilledrectangle($tmp, 0, 0, $fixedWidth, $fixedHeight, $canvas);
        }
        if ($fileExtension == '.png' && !$canvasColor){
            self::setTransparency($tmp, $image);
        }
        }
        /*
         * Stick Uploaded Image At Center Of The New Image
         */
        imagecopyresampled($tmp, $image, (($fixedWidth-$newWidth)/2), (($fixedHeight-$newHeight)/2), 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);
        /*
         * Place Watermark (If Watermark Exist)
         */
        if ($watermark){
        $watermarkImage = @imagecreatefrompng($watermark['image']);
        $tmpWidth = imagesx($tmp);
        $tmpHeight = imagesy($tmp);
        $watermarkWidth = imagesx($watermarkImage);
        $watermarkHeight = imagesy($watermarkImage);
        $xPos = $watermark['xpos'];
        $yPos = $watermark['ypos'];
        imagecopy($tmp, $watermarkImage, $xPos, $yPos, 0, 0, $watermarkWidth, $watermarkHeight);
        }
        /*
         * Delete Image In The Target Directory (If Exist)
         */
        if (file_exists($targetFile)) {
            unlink($targetFile);
        }
        /*
         * Create Final Image On The Directory
         */
        if($fileExtension == ".gif") $res = imagegif($tmp, $targetFile);
        if($fileExtension == ".jpg") $res = imagejpeg($tmp, $targetFile);
        if($fileExtension == ".png") $res = ImagePNG($tmp, $targetFile);
    }
    /*
     * Save/Resize Images Process
     * -files (Uploaded Images From Form)
     * -maxSize (Images Uploaded With The Size Above The Value Given Will Be Denied)
     * -destination (Directory Where The New Images Will Be Created)
     * -params (Not Necessary)
     * -----------------------
     * params['background'] (Place A Background Color)
     * params['watermark']['image'] (Watermark Path)
     * params['watermark']['xpos'] (Watermark X Position)
     * params['watermark']['ypos'] (Watermark Y Position)
     */
    function saveImage($files, $destination, $Width, $Height = null, $params = null) {
        global $mainframe;
        /*
         * Process Images Given
         */
        //for($i = 0; $i < count($files['name']); $i++){
        foreach ($files as $file){
            /*
             * Max Size Allowed
             */
                jimport('joomla.filesystem.file');
                /*
                 * Make Name Of Image Safe(Clean)
                 */
                /*
                 * Checkout Given Images Extension
                 */
                if (in_array(strtolower(JFile::getExt($file)), array('jpg', 'jpeg', 'png', 'gif'))) {
                    /*
                     * Check If Original File Was Uploaded
                     */
                    if (file_exists($destination.DS.strtolower($file))){
                        self::PictureResize($destination.DS.($file), $destination.DS."companies".DS.$params['company_id'].DS."app".DS.strtolower($file), $Width, $Height, $params['background'], $params['watermark'], $params['limit'],$params['canvas']); 
                    }
                }
        } 
        return true;
    }
    
    function saveImage2($files, $destination, $Width, $Height = null, $params = null) {
        global $mainframe;
        foreach ($files as $file){
            jimport('joomla.filesystem.file');
            if (in_array(strtolower(JFile::getExt($file)), array('jpg', 'jpeg', 'png', 'gif'))) {
                if (file_exists($destination.DS.strtolower($file))){
                    self::PictureResize($destination.DS.($file), $destination.DS."companies".DS.$params['company_id'].DS."site".DS.strtolower($file), $Width, $Height, $params['background'], $params['watermark'], $params['limit'],$params['canvas']); 
                }
            }
        } 
        return true;
    }
    
    function saveImage3($files, $destination, $Width, $Height = null, $params = null) {
        global $mainframe;
        foreach ($files as $file){
            jimport('joomla.filesystem.file');
            if (in_array(strtolower(JFile::getExt($file)), array('jpg', 'jpeg', 'png', 'gif'))) {
                if (file_exists($destination.DS.strtolower($file))){
                    self::PictureResize($destination.DS.($file), $destination.DS."companies".DS.$params['company_id'].DS."site_company".DS.strtolower($file), $Width, $Height, $params['background'], $params['watermark'], $params['limit'],$params['canvas']); 
                }
            }
        } 
        return true;
    }
}