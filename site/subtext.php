<?php
/**
 * @package		Subtext
 * @subpackage	Components
 * @license		GNU/GPL
 */
 
// NO DIRECT ACCESS
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// IMPORT CONTROLLER LIBRARY
jimport('joomla.application.component.controller');

// GET CONTROLLER INSTANCE
$controller = JControllerLegacy::getInstance('Subtext');

// PERFORM THE REQUESTED TASK
$controller->execute(JRequest::getCmd('task'));

// REDIRECT IF NECESSARY
$controller->redirect();
