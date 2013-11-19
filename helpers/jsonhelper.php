<?php	defined('_JEXEC') or die('Restricted access');

class PindustryJsonHelper
{
    
    function getAreasZip($area_by_query=null){
        global $com_pindustry_languages;
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'jsondata.php';
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'pindustry.php';
        $areas = PindustryModelJsonData::getCompanyArea($_POST['jform']['id']);
        if(!$areas){
            if(count($area_by_query)>1){
                $areas = $area_by_query;
            }else{
                $areas[] = $area_by_query;
            }
        }
        if($areas[0]==null && count($areas)==1){
            return false;
        }
        foreach ($areas as $area_id){
           $area['id'] = $area_id;
           $empresas[$area['id']] = PindustryModelJsonData::getEmpresas($area['id'],0);
           foreach ($empresas[$area['id']] as $key => $empresa){
               if ($empresa){
                   $empresas[$area['id']][$key]['name']=PindustryJsonHelper::extractLanguageDataConditional($empresa['name']);
                   $empresas[$area['id']][$key]['intro']=PindustryJsonHelper::extractLanguageDataConditional($empresa['intro']);
                   $empresas[$area['id']][$key]['description']=PindustryJsonHelper::extractLanguageDataConditional($empresa['description']);
                   $empresas[$area['id']][$key]['adress']=PindustryJsonHelper::extractLanguageDataConditional($empresa['adress']);
                   $empresas[$area['id']][$key]['postalcode']=PindustryJsonHelper::extractLanguageDataConditional($empresa['postalcode']);
                   $empresas[$area['id']][$key]['place']=PindustryJsonHelper::extractLanguageDataConditional($empresa['place']);
                   $empresas[$area['id']][$key]['country']=PindustryJsonHelper::extractLanguageDataConditional($empresa['country']);
                   $empresas[$area['id']][$key]['url']=PindustryJsonHelper::extractLanguageDataConditional($empresa['url']);
                   $empresas[$area['id']][$key]['contactfunction']=PindustryJsonHelper::extractLanguageDataConditional($empresa['contactfunction']);
                   if ($empresa["image"]){
                       $images[$area['id']][$empresa['id']]['path']= $empresa['id'].DS."app".DS.$empresa['image'];
                       $images[$area['id']][$empresa['id']]['img']= $empresa['image'];
                   }
                   
                   $video = PindustryModelJsonData::getDefaultVideo($empresa['id']);
                   if($video){
                       $video[0]['video'] = PindustryHelper::unserialize($video[0]['video']);
                       $empresas[$area['id']][$key]['video']['type'] = $video[0]['type'];
                       $empresas[$area['id']][$key]['video']['id'] = $video[0]['video'];
                   }else{
                       $videos = PindustryModelJsonData::getOtherVideo($empresa['id']);
                       if($videos){
                           $videos[0]['video'] = PindustryHelper::unserialize($videos[0]['video']);
                           $empresas[$area['id']][$key]['video']['type'] = $videos[0]['type'];
                           $empresas[$area['id']][$key]['video']['id'] = $videos[0]['video'];    
                       }
                   }
               }
               $names[$key] = $empresas[$area['id']][$key]['name']['pt-PT'];
           }
           if($names){
                array_multisort($names, SORT_ASC, $empresas[$area['id']]);    
           }
           unset($names);
           if ($empresas[$area['id']]){
               PindustryJsonHelper::unsetEmptyFields($empresas[$area['id']],$com_pindustry_languages['defaultlang']);
               $destination = JPATH_ROOT.DS."media".DS."portugalindustry_zip";
               if(!file_exists($destination)){
                   mkdir($destination);
               }
               $destination = JPATH_ROOT.DS."media".DS."portugalindustry_zip".DS.$area['id'];
               if(!file_exists($destination)){
                   mkdir($destination);
               }
               $fp = fopen($destination.DS."companies.json", "w");
               fwrite($fp, json_encode($empresas[$area['id']]));
               fclose($fp);
               $files[$area['id']][]= $destination.DS."companies.json";
               $destination = JPATH_ROOT.DS."media".DS."portugalindustry_zip".DS.$area['id'].DS."images";
               $files[$area['id']][]= $destination;
               if(!file_exists($destination)){
                   mkdir($destination);
               }
               if ($images){
                    foreach ($images[$area['id']] as $img){
                        $file = JPATH_ROOT.DS."images".DS."portugalindustry".DS."companies".DS.$img['path'];
                        copy($file, $destination.DS.$img['img']);
                    }
               }
               PindustryJsonHelper::zipareas(JPATH_ROOT.DS."media".DS."portugalindustry_zip",$area['id'],$files[$area['id']]);
           }
        }
        return true;
    }
        
    function zipareas($destination,$areaid,$files){
        ini_set("max_execution_time", "600");
        ini_set("memory_limit", "64M");
        jimport('joomla.filesystem.file');
        $handle = opendir($destination.DS.$areaid);
        while (false !== ($entry = readdir($handle))) {
            $zip = explode('.',$entry);
            if ($zip[1] == "zip"){
                unlink($destination.DS.$areaid.DS.$entry);
            }
        }
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'zip.php';
        $arch = new Archive_Zip($destination.DS.$areaid.DS.'md5.zip');
		$arch->create($files,array('remove_all_path' => true));
        $md5 = md5_file($destination.DS.$areaid.DS.'md5.zip');
        rename($destination.DS.$areaid.DS.'md5.zip', $destination.DS.$areaid.DS.$md5.'.zip');
        
        unlink($files[0]);
        $d = dir($files[1]); 
        while($entry = $d->read()) { 
            if ($entry != "." && $entry != "..") { 
                unlink($files[1].DS.$entry); 
            } 
        }
        $d->close(); 
        rmdir($files[1]); 
    }
    
	function unsetEmptyFields(&$data,$lang){   
		if (is_array($data))	{
			PindustryJsonHelper::unsetEmptyFieldsArray($data,$lang);
		} else foreach ($data as $key=>$value) {
			if (is_array($data->$key))	{
				PindustryJsonHelper::unsetEmptyFieldsArray($data->$key,$lang);			}
			if (is_object($data->$key))	{
				PindustryJsonHelper::unsetEmptyFields($data->$key,$lang);			}
			if (empty($data->$key) && $data->$key!="0")	{
				unset($data->$key);			}
		}
	}

	function unsetEmptyFieldsArray(&$data,$lang){
		foreach ($data as $key=>$value) {
			if (is_array($data[$key])){
                PindustryJsonHelper::unsetEmptyFieldsArray($data[$key],$lang);
            }
			if (is_object($data[$key])){
                PindustryJsonHelper::unsetEmptyFields($data[$key],$lang);
            }
			if (empty($data[$key]) && $data->$key!="0"){
                if ($data[$lang]){
                    $data[$key] = $data[$lang];
                }
            }
		}
	}
    
    function extractLanguageDataConditional($data, $lang='', $noslash = 0, $notags = 0, $charLimiter = 0){
        if ($data==''){return $data;}
        $arr=PindustryHelper::unserialize($data);
        if ($noslash){
            foreach ($arr as $key => $language){
                if(is_array($arr)){
                    unset($arr[$key]);
                    if($notags){ 
                        $arr[str_ireplace('-','',$key)] = strip_tags($language);
                        $arr[str_ireplace('-','',$key)] = str_replace(array("\r\n", "\r", "\n", "&nbsp;"), " ", strip_tags($language));
                    }else{
                        $arr[str_ireplace('-','',$key)] = $language;
                    }
                    if($charLimiter == 1){
                    	$arr[str_ireplace('-','',$key)] = substr($arr[str_ireplace('-','',$key)], 0, 705);
                    }
                }
                if(is_object($arr)){
                    unset($arr->$key);
                    $key = str_ireplace('-','',$key);
                    $arr->$key = $language;
                }
            }
        }
        if ($lang!=''){
            return PindustryJsonHelper::extractLanguageDataFromArray($arr, $lang);
        }
        return $arr;
    }
    
    function extractLanguageDataFromArray($data, $lang=null){
        if (!is_array($data))    {
            return null;        }

        if (isset($data[$lang]))    {
            return $data[$lang];        }

        global $com_pindustry_languages;
        
        if (isset($data[$com_pindustry_languages['defaultlang']])){
            return $data[$com_pindustry_languages['defaultlang']];
        }

        foreach ($data as $text) {
            if ($text!='')    {
                return $text;
            }
        }

        return null;
    }

}
