<?php
/**
 * Subtext Controller
 *
 * @package		Subtext
 * @subpackage	Components
 */

// NO DIRECT ACCESS
defined( '_JEXEC' ) or die( 'Restricted access' );

// DEFINE DS CONSTANT
if(!defined('DS')) define( 'DS', DIRECTORY_SEPARATOR );

// PRIVILEGE CHECK
if(!JFactory::getUser()->authorise('core.manage', 'com_subtext')){
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// REQUIRE HELPER FILE
JLoader::register('SubtextHelper', dirname(__FILE__).DS.'helpers'.DS.'subtext.php');

// IMPORT CONTROLLER LIBRARY
jimport('joomla.application.component.controller');

// GET CONTROLLER INSTANCE
$controller = JControllerLegacy::getInstance('Subtext');

// PERFORM THE REQUESTED TASK
$controller->execute(JFactory::getApplication()->input->get('task'));

// REDIRECT IF NECESSARY
$controller->redirect();
