<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
/**
 * player Table class
 */
class HockeyTablePlayer extends JTable
{

    /**
     * Constructor
     *
     * @param JDatabase A database connector object
     */
    public function __construct(&$db)
    {
        parent::__construct('#__hockey_players', 'id', $db);
    }

    /**
     * Overloaded bind function to pre-process the params.
     *
     * @param	array		Named array
     * @return	null|string	null is operation was satisfactory, otherwise returns an error
     * @see		JTable:bind
     * @since	1.5
     */
    public function bind($array, $ignore = '')
    {

        $input = JFactory::getApplication()->input;
        $task = $input->getString('task', '');
        if (($task == 'save' || $task == 'apply') && (!JFactory::getUser()->authorise('core.edit.state', 'com_hockey') && $array['state'] == 1)) {
            $array['state'] = 0;
        }

        if (isset($array['params']) && is_array($array['params'])) {
            $registry = new JRegistry();
            $registry->loadArray($array['params']);
            $array['params'] = (string) $registry;
        }

        return parent::bind($array, $ignore);
    }

    /**
     * Overload the store method for the Weblinks table.
     *
     * @param   boolean	Toggle whether null values should be updated.
     * @return  boolean  True on success, false on failure.
     * @since   1.6
     */
    public function store($updateNulls = false)
    {
        $date = JFactory::getDate();
        $user = JFactory::getUser();
        if ($this->id) {
            // Existing item
            $this->modified = $date->toSql();
            $this->modified_by = $user->get('id');
        } else {

            if (!(int) $this->created) {
                $this->created = $date->toSql();
            }
            if (empty($this->created_by)) {
                $this->created_by = $user->get('id');
            }
            
            // Verify that the alias is unique
            $table = JTable::getInstance('Player', 'HockeyTable');
			if ($table->load(array('alias' => $this->alias)) && ($table->id != $this->id || $this->id == 0))
			{
				$this->setError(JText::_('COM_HOCKEY_ERROR_UNIQUE_ALIAS'));
				return false;
			}
        }
        
        return parent::store($updateNulls);
    }

    /**
     * Overloaded check function
     */
    public function check()
    {
        
        // Set alias
		$this->alias = JApplication::stringURLSafe($this->alias);
		if (empty($this->alias))
		{
			$this->alias = JApplication::stringURLSafe($this->name.'_'.$this->first_name);
		}

        if (trim($this->name == '')) {
            $this->setError(JText::_('COM_HOCKEY_ERR_PLAYER_NAME'));
            return false;
        }
        if (trim($this->first_name == '')) {
            $this->setError(JText::_('COM_HOCKEY_ERR_PLAYER_FIRST_NAME'));
            return false;
        }
        if (trim($this->team_id == '') || ($this->team_id == 0) ) {
            $this->setError(JText::_('COM_HOCKEY_ERR_PLAYER_TEAM'));
            return false;
        }

        return parent::check();
    }

    /**
     * Method to set the publishing state for a row or list of rows in the database
     * table.  The method respects checked out rows by other users and will attempt
     * to checkin rows that it can after adjustments are made.
     *
     * @param    mixed    An optional array of primary key values to update.  If not
     *                    set the instance property value is used.
     * @param    integer The publishing state. eg. [0 = unpublished, 1 = published]
     * @param    integer The user id of the user performing the operation.
     * @return    boolean    True on success.
     * @since    1.0.4
     */
    public function publish($pks = null, $state = 1, $userId = 0)
    {
        // Initialise variables.
        $k = $this->_tbl_key;

        // Sanitize input.
        JArrayHelper::toInteger($pks);
        $userId = (int) $userId;
        $state = (int) $state;

        // If there are no primary keys set check to see if the instance key is set.
        if (empty($pks)) {
            if ($this->$k) {
                $pks = array($this->$k);
            }
            // Nothing to set publishing state on, return false.
            else {
                $this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
                return false;
            }
        }

        // Build the WHERE clause for the primary keys.
        $where = $k . '=' . implode(' OR ' . $k . '=', $pks);

        // Update the publishing state for rows with the given primary keys.
        $this->_db->setQuery(
            'UPDATE ' . $this->_db->quoteName($this->_tbl) .
            ' SET ' . $this->_db->quoteName('state') . ' = ' . (int) $state .
            ' WHERE (' . $where . ')');

        try {
            $this->_db->execute();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());
            return false;
        }


        // If the JTable instance value is in the list of primary keys that were set, set the instance.
        if (in_array($this->$k, $pks)) {
            $this->state = $state;
        }

        $this->setError('');
        return true;
    }

}
