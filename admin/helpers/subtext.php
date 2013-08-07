<?php
/**
 * Subtext Helper
 * 
 * @package		Subtext
 * @subpackage	Components
 * @license		GNU/GPL
 */

// NO DIRECT ACCESS
defined( '_JEXEC' ) or die( 'Restricted access' );

abstract Class SubtextHelper {
	public static function addSubmenu($submenu){
		// ADD SUBMENU TABS
		//JSubMenuHelper::addEntry(JText::_('COM_SUBTEXT_SUBMENU_SECONDARY'), 'index.php?option=com_subtext', $submenu == 'subtext');
	}
}
