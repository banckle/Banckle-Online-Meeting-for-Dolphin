<?php
/***************************************************************************
*                            Dolphin Smart Community Builder
*                              -------------------
*     begin                : Mon Mar 23 2006
*     copyright            : (C) 2007 BoonEx Group
*     website              : http://www.boonex.com
* This file is part of Dolphin - Smart Community Builder
*
* Dolphin is free software; you can redistribute it and/or modify it under
* the terms of the GNU General Public License as published by the
* Free Software Foundation; either version 2 of the
* License, or  any later version.
*
* Dolphin is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
* without even the implied warranty of  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
* See the GNU General Public License for more details.
* You should have received a copy of the GNU General Public License along with Dolphin,
* see license.txt file; if not, write to marketing@boonex.com
***************************************************************************/

bx_import('BxDolModule');

class BanckleBomModule extends BxDolModule {

    function BanckleBomModule(&$aModule) {        
        parent::BxDolModule($aModule);
    }

    function actionHome () {
        $this->_oTemplate->pageStart();
		
		$banckle_bom_widget = getParam('banckle_bom_widget');
		
		preg_match('|<iframe [^>]*(src="[^"]+")[^>]*|', $banckle_bom_widget, $matches);

		$url = substr(rtrim($matches[1],'"'),5);
		
		
		$contents = file_get_contents($url);
		$content_arr = json_decode($contents);
		
		if(isset($content_arr->error))
		{
			$banckle_bom_widget = "<h2>Sorry No Active Meeting Available.</h2>";
		}
		
        $aVars = array ('banckle_bom_widget'=>$banckle_bom_widget);
        echo $this->_oTemplate->parseHtmlByName('bom', $aVars);
        $this->_oTemplate->pageCode(_t('_banckle_bom'), true);
    }
	
	function actionAdministration () {

        if (!$GLOBALS['logged']['admin']) {
            $this->_oTemplate->displayAccessDenied ();
            return;
        }
		
		 $this->_oTemplate->pageStart();
		
		$iId = $this->_oDb->getSettingsCategory(); // get our setting category id
        if(empty($iId)) { // if category is not found display page not found
            echo MsgBox(_t('_sys_request_page_not_found_cpt'));
            $this->_oTemplate->pageCodeAdmin (_t('_banckle_bom'));
            return;
        }

        bx_import('BxDolAdminSettings'); // import class
		
		$save_msg = "";

        
        if(isset($_POST['save_wcode']) && isset($_POST['banckle_bom_widget'])) { // save settings            
			unset($_POST['save_wcode']);
			
			$php = '$banckle_bom_widget = "'. addslashes($_POST['banckle_bom_widget']).'";';
			$php .= 'preg_match(\'|<iframe [^>]*(src="[^"]+")[^>]*|\', $banckle_bom_widget, $matches);';
			$php .= '$url = substr(rtrim($matches[1],\'"\'),5);';
			$php .= '$contents = file_get_contents($url);';
			$php .= '$content_arr = json_decode($contents);';
			$php .= 'if(isset($content_arr->error)){ $banckle_bom_widget = "<h2>Sorry No Active Meeting Available.</h2>"; }';
			$php .= 'echo $banckle_bom_widget;';
		
			$postarr['banckle_bom_widget'] = $php;
			
            $this->_oDb->setOption($iId,$_POST);
			$this->_oDb->savePageContent($php);
			$save_msg = "<br /><span style='color:red;'>Widget Code Saved Successfully.</span><br />";
        }
		
		$banckle_bom_widget = getParam('banckle_bom_widget');		
				
       
		
		$aVars = array ('banckle_bom_widget'=>$banckle_bom_widget,'save_message'=>$save_msg);
		$data = $this->_oTemplate->parseHtmlByName('adminpage', $aVars);

        echo DesignBoxAdmin (_t('_banckle_bom'), $data);
        
        $this->_oTemplate->pageCodeAdmin (_t('_banckle_bom'));
    }
		
}

?>
