-- settings
SET @iMaxOrder = (SELECT `menu_order` + 1 FROM `sys_options_cats` ORDER BY `menu_order` DESC LIMIT 1);
INSERT INTO `sys_options_cats` (`name`, `menu_order`) VALUES ('Banckle Online Meeting', @iMaxOrder);
SET @iCategId = (SELECT LAST_INSERT_ID());
INSERT INTO `sys_options` (`Name`, `VALUE`, `kateg`, `desc`, `Type`, `check`, `err_text`, `order_in_kateg`, `AvailableValues`) VALUES
('banckle_bom_permalinks', 'on', 26, 'Enable friendly permalinks in Banckle Online Meeting', 'checkbox', '', '', '0', ''),
('banckle_bom_widget', '', @iCategId, 'Banckle Online Meeting Widget Code', 'checkbox', '', '', '1', '');

-- permalinks
INSERT INTO `sys_permalinks` VALUES (NULL, 'modules/?r=banckle-online-meeting/', 'm/banckle-online-meeting/', 'banckle_bom_permalinks');

-- admin menu
SET @iMax = (SELECT MAX(`order`) FROM `sys_menu_admin` WHERE `parent_id` = '2');
INSERT IGNORE INTO `sys_menu_admin` (`parent_id`, `name`, `title`, `url`, `description`, `icon`, `order`) VALUES
(2, 'banckle_bom', '_banckle_bom', '{siteUrl}modules/?r=banckle-online-meeting/administration/', 'Online Meeting by Banckle', 'modules/banckle/bom/|icon.png', @iMax+1);

-- pageblock
INSERT INTO `sys_page_compose` (`ID`, `Page`, `PageWidth`, `Desc`, `Caption`, `Column`, `Order`, `Func`, `Content`, `DesignBox`, `ColWidth`, `Visible`, `MinWidth`, `Cache`) VALUES
(NULL, 'index', '998px', 'Banckle Online Meeting Widget', 'Banckle Online Meeting', 2, 4, 'PHP', '', 1, 50, 'non,memb', 0, 0);
