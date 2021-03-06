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
		$input = JFactory::getApplication()->input;
		$layout = $input->get->get('layout', 'list', 'string');
		$this->setLayout($layout);
		switch($layout){
		case "list":
			JToolBarHelper::title(JText::_('COM_SUBTEXT_VIEW_SUBTEXT_LIST_TITLE'), 'generic.png');
			JToolBarHelper::addNew('subtext.add', 'JTOOLBAR_NEW');
			JToolBarHelper::editList('subtext.edit', 'JTOOLBAR_EDIT', true);
			JToolBarHelper::deleteList(JText::_('COM_SUBTEXT_MSG_DELETE_CONFIRM'), 'subtext.delete', 'JTOOLBAR_DELETE', true);
			JToolBarHelper::preferences('com_subtext', '500');
			// GET DATA FROM THE MODEL
			$this->filter = $this->get('State');
			$this->items = $this->get('List');
			$this->page = $this->get('Pagination');
			break;
		default:
			$input->set('hidemainmenu', 1);
			JToolBarHelper::title(JText::_('COM_SUBTEXT_VIEW_SUBTEXT_EDIT_TITLE'), 'generic.png');
			JToolBarHelper::apply('subtext.apply');
			JToolBarHelper::save('subtext.save');
			JToolBarHelper::save2new('subtext.save2new');
			JToolBarHelper::cancel('subtext.cancel');
			$this->form = $this->get('Form');
			break;
		}
		parent::display($tpl);
	}
}
