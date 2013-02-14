<?php
/**
 * @package		Subtext
 * @subpackage	Components
 * @license		GNU/GPL
 */
 
// NO DIRECT ACCESS
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// GET CONTROLLER INSTANCE
$controller = JControllerLegacy::getInstance('Subtext');

// PERFORM THE REQUESTED TASK
$controller->execute(JFactory::getApplication()->input->get('task'));

// REDIRECT IF NECESSARY
$controller->redirect();
