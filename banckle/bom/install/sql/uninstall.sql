-- settings
SET @iCategId = (SELECT `ID` FROM `sys_options_cats` WHERE `name` = 'Banckle Online Meeting' LIMIT 1);
DELETE FROM `sys_options` WHERE `kateg` = @iCategId;
DELETE FROM `sys_options_cats` WHERE `ID` = @iCategId;
DELETE FROM `sys_options` WHERE `Name` = 'banckle_bom_permalinks';

-- permalinks
DELETE FROM `sys_permalinks` WHERE `standard` = 'modules/?r=banckle-online-meeting/';

-- admin menu
DELETE FROM `sys_menu_admin` WHERE `name` = 'banckle_bom';

-- pageblock
DELETE FROM `sys_page_compose` WHERE caption = 'Banckle Online Meeting';
