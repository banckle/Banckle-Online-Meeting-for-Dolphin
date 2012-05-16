<?
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

bx_import('BxDolModuleDb');

class BanckleBomDb extends BxDolModuleDb {

	function BanckleBomDb(&$oConfig) {
		parent::BxDolModuleDb();
        $this->_sPrefix = $oConfig->getDbPrefix();
    }
	
	function getSettingsCategory() {
        return $this->getOne("SELECT `ID` FROM `sys_options_cats` WHERE `name` = 'Banckle Online Meeting' LIMIT 1");
    }
	
	function setOption($Id,$arr)
	{
		foreach($arr as $name => $value)
		{
			$qry = "UPDATE sys_options SET VALUE = '". mysql_real_escape_string($value)."' WHERE Name = '$name' AND kateg = '$Id' AND value != '$value';";		
			mysql_query($qry) or die ("setOptions:".mysql_error());
		}		
				
		return true;
	}
	
	function savePageContent($widgetCode = "")
	{
		$qry = "UPDATE sys_page_compose SET Content = '". mysql_real_escape_string($widgetCode) ."' WHERE Caption = 'Banckle Online Meeting'";
		mysql_query($qry) or die (mysql_error());
	}
}

?>
