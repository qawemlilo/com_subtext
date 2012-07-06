<?php
/**
 * Subtext Admin View Controller
 *
 * @package		Subtext
 * @subpackage	Components
 * @license		GNU/GPL
 */

// NO DIRECT ACCESS
defined( '_JEXEC' ) or die( 'Restricted access' );

// PRIVILEGE CHECK
if(!JFactory::getUser()->authorise('core.manage', 'com_subtext')){
	return JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));
}

// IMPORT CONTROLLER LIBRARY
jimport('joomla.application.component.controller');

class SubtextController extends JController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	public function __construct($config = array())
	{
		// DEFAULT LAYOUT TO LIST INSTEAD OF DEFAULT
		$layout = JRequest::getVar('layout', 'list', 'get', STRING);
		JRequest::setVar('layout', $layout);
		parent::__construct();
	}
	
	/**
	 * Medthod to display the correct view and layout
	 *
	 * @return  JController  A JController object to support chaining.
	 */
	public function display($cachable = false, $urlparams = false)
	{
		parent::display($cachable, $urlparams);
	}
}
