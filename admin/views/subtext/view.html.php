<?php
/**
 * Subtext Default View
 * 
 * @package		Subtext
 * @subpackage	Components
 * @license		GNU/GPL
 */

// NO DIRECT ACCESS
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class SubtextViewSubtext extends JViewLegacy
{
	/**
	 * Subtext view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		$layout = JRequest::getVar('layout', 'list', 'get', STRING);
		switch($layout){
		case "list":
			JToolBarHelper::title(JText::_('COM_SUBTEXT_VIEW_SUBTEXT_LIST_TITLE'), 'generic.png');
			JToolBarHelper::addNewX('subtext.add');
			JToolBarHelper::editListX('subtext.edit');
			JToolBarHelper::deleteListX(JText::_('COM_SUBTEXT_MSG_DELETE_CONFIRM'), 'subtext.delete');
			JToolBarHelper::preferences('com_subtext', '500');
			// GET DATA FROM THE MODEL
			$this->filter = $this->get('Filter');
			$this->items = $this->get('List');
			$this->page = $this->get('Pagination');
			break;
		default:
			JRequest::setVar('hidemainmenu', 1);
			JToolBarHelper::title(JText::_('COM_SUBTEXT_VIEW_SUBTEXT_EDIT_TITLE'), 'generic.png');
			JToolBarHelper::save('subtext.save');
			JToolBarHelper::apply('subtext.apply');
			JToolBarHelper::cancel('subtext.cancel');
			$this->form = $this->get('Form');
			break;
		}
		parent::display($tpl);
	}
}