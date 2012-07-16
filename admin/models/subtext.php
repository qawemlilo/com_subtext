<?php
/**
 * Subtext Default Admin Model
 * 
 * @package		Subtext
 * @subpackage	Component
 * @license		GNU/GPL
 */

// CHECK TO ENSURE THIS FILE IS INCLUDED IN JOOMLA!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.modeladmin' );

class SubtextModelSubtext extends JModelAdmin
{
    /**
     * Database records data
     * @var mixed This may be an object or array depending on context.
     */
    var $_data			= null;
    /**
     * Total number of records retrieved
     * @var integer
     */
     var $_total		= null;
    /**
     * Pagination object
     * @var object
     */
     var $_pagination	= null;
 
    /**
     * Retrieves the Products data
     * @return object A stdClass object containing the data for a single record.
     */
    public function getData()
    {
		$id 	= $this->_getCid();
		$row 	= $this->getTable();

		$row->load($id);
		$this->_data = $row;

        return $this->_data;
    }
	/**
	 * Method for getting the form from the model.
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 * @return  mixed  A JForm object on success, false on failure
	 */
	public function getForm($data = array(), $loadData = true)
	{
		if($form = $this->loadForm('com_subtext.subtext', 'subtext', array('control'=>'jform', 'load_data'=>$loadData))){
			return $form;
		}
		JError::raiseError(0, JText::sprintf('JLIB_FORM_INVALID_FORM_OBJECT', 'subtext'));
		return null;
	}
	/**
	 * Method to get the data that should be injected in the form.
	 * @return  array    The default data is an empty array.
	 */
	protected function loadFormData()
	{
		$db		= $this->getDbo();
		$query 	= $db->getQuery(true);
		$row 	= $this->getTable();
		$id 	= $this->_getCid();
		
		$query->select("*");
		$query->from($row->getTableName());
		$query->where("{$row->getKeyName()} = {$id}");
		
		$db->setQuery($query);
		$this->_data = $db->loadAssoc();
		$ini = new JRegistry();
		$ini->loadINI($data['attribs']);
		$this->_data['params'] = $ini->toArray();

		return $this->_data;
	}
    /**
     * Retrieves the Products data
     * @return array Array of objects containing the data from the database.
     */
    public function getList()
    {
    	$mainframe	= JFactory::getApplication();
		$option		= JRequest::getCmd('option', 'com_subtext');
    	$scope		= $this->getName();
    	$row		= $this->getTable();
    	$filter		= array();
    	if($search = addslashes($mainframe->getUserState($option.'.'.$scope.'.filter_search'))){
    		$filter[] = "`subtext_name` LIKE '%{$search}%'";
    	}
    	if(!$ordering = $mainframe->getUserState($option.'.'.$scope.'.filter_order')){
    		$ordering = "`ordering`";
    	}
    	if(!$order_dir = $mainframe->getUserState($option.'.'.$scope.'.filter_order_Dir')){
    		$order_dir = "ASC";
    	}
		$sql = "SELECT SQL_CALC_FOUND_ROWS s.*, v.title AS `access`, u.`name` AS `editor` ".
		"FROM `{$row->getTableName()}` s ".
		"LEFT JOIN `#__viewlevels` v ON s.`access` = v.`id` ".
		"LEFT JOIN `#__users` u ON s.`checked_out` = u.`id`";
		if(count($filter)){
			$sql .= " WHERE " . implode(" AND ", $filter);
		}
		$sql .= " ORDER BY {$ordering} {$order_dir}";
		$this->_data = $this->_getList($sql, $this->getState('limitstart'), $this->getState('limit'));

    	return $this->_data;
    }
    /**
     * Retrieve filter variables from User State
     * @return object
     */
    public function getFilter()
    {
    	$mainframe	= JFactory::getApplication();
		$option		= JRequest::getCmd('option', 'com_subtext');
    	$scope		= $this->getName();
    	$obj		= new stdClass();
 		$limit		= $mainframe->getUserStateFromRequest($option.'.'.$scope.'.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
 		$limitstart	= $mainframe->getUserStateFromRequest($option.'.'.$scope.'.limitstart', 'limitstart', 0, 'int');
  		$limitstart	= ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
  
  		$this->setState('limit', $limit);
  		$this->setState('limitstart', $limitstart);

    	$obj->filter_search			= $mainframe->getUserStateFromRequest($option.'.'.$scope.'.filter_search', 'filter_search', '', 'string');
    	$obj->filter_order			= $mainframe->getUserStateFromRequest($option.'.'.$scope.'.filter_order', 'filter_order', 'ordering', 'cmd');
    	$obj->filter_order_Dir		= $mainframe->getUserStateFromRequest($option.'.'.$scope.'.filter_order_Dir', 'filter_order_Dir', 'asc', 'string');
    	return $obj;
    }
    /**
     * Retrieves a JPagination object
     * @return object
     */
    public function getPagination()
    {
    	$this->_db->setQuery("SELECT FOUND_ROWS()");
    	$this->_total = $this->_db->loadResult();
    	jimport('joomla.html.pagination');
    	$this->_pagination = new JPagination($this->_total, $this->getState('limitstart'), $this->getState('limit'));
    
    	return $this->_pagination;
    }
	/**
	 * A utility method for retrieving an item Id
	 * @return int
	 */
	protected function _getCid(){
		$row = $this->getTable();
		return JRequest::getInt($row->getKeyName(),  0, 'method');
	}
}
