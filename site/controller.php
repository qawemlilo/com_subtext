<?php
/**
 * Subtext Default Site Controller
 *
 * @package		Subtext
 * @subpackage	Component
 * @license		GNU/GPL
 */

// NO DIRECT ACCESS
defined( '_JEXEC' ) or die( 'Restricted access' );

// IMPORT CONTROLLER LIBRARY
jimport('joomla.application.component.controllerform');

class SubtextController extends JControllerLegacy
{
	/**
	 * Method to display the view
	 *
	 * @access	public
	 */
	function display($cachable = false, $urlparams = false)
	{
		parent::display($cachable, $urlparams);
	}
}