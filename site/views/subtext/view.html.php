<?php
/**
 * Subtext Default Site View
 
 * @package		Subtext
 * @subpackage	Components
 * @license		GNU/GPL
 */

// REQUIRE THE BASE VIEW
jimport( 'joomla.application.component.view');

class SubtextViewSubtext extends JViewLegacy
{
	function display($tpl = null)
	{
		$this->data = $this->get('Data');
		$this->items = $this->get('List');
		parent::display($tpl);
	}
}
?>
