<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;


jimport('joomla.application.component.modellist');
/**
 * Methods supporting a list of Hockey records.
 */
class HockeyModelLeagues extends JModelList
{
    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'ordering', 'a.ordering',
                'state', 'a.state',
                'created_by', 'a.created_by',
                'team_1', 'a.team_1',
                'team_2', 'a.team_2',
                'score_1', 'a.score_1',
                'score_2', 'a.score_2',
                'overtime', 'a.overtime',
                'shutouts', 'a.shutouts',
                'id_kolejka', 'a.id_kolejka',
                'data', 'a.data',
                'time', 'a.time',
                'place', 'a.place',
                'id_system', 'a.id_system',
                'type_of_match', 'a.type_of_match',
                'w1p1', 'a.w1p1',
                'w2p1', 'a.w2p1',
                'w1p2', 'a.w1p2',
                'w2p2', 'a.w2p2',
                'w1p3', 'a.w1p3',
                'w2p3', 'a.w2p3',
                'w1ot', 'a.w1ot',
                'w2ot', 'a.w2ot',
                'w1so', 'a.w1so',
                'w2so', 'a.w2so',
                'uscore', 'a.uscore',
                'id_referee1', 'a.id_referee1',
                'id_referee2', 'a.id_referee2',
                'id_referee3', 'a.id_referee3',
                'id_referee4', 'a.id_referee4',
                'description', 'a.description',
                'modified_by', 'a.modified_by',
                'created', 'a.created',
                'modified', 'a.modified',
            );
        }
        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null)
    {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        $type = $app->getUserStateFromRequest($this->context . '.filter.id_kolejka', 'filter_id_kolejka', 1, 'int');
        $this->setState('filter.id_kolejka', $type);

        // Load the parameters.
        $params = JComponentHelper::getParams('com_hockey');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.id', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '')
    {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.id_kolejka');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery()
    {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select($this->getState('list.select', 'a.*'));
        $query->from('`#__hockey_match` AS a');

        $query->where('a.id_system =' . HockeyHelper::getSezon());
        $query->where('a.type_of_match = 0');
        
        // Join over the users for the checked out user.
        $query->select('uc.name AS editor');
        $query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

     
        // Join over the team 1
        $query->select('t1.name AS team1');
        $query->join('LEFT', '#__hockey_teams AS t1 ON t1.id = a.team_1');

         // Join over the team 2
        $query->select('t2.name AS team2');
        $query->join('LEFT', '#__hockey_teams AS t2 ON t2.id = a.team_2');


        // Filter by published state
        $published = $this->getState('filter.state');
        if (is_numeric($published)) {
            $query->where('a.state = '. (int) $published);
        } else if ($published === '') {
            $query->where('(a.state IN (0, 1))');
        }

        
         // Filter by id_kolejka
        $id_kolejka = $this->getState('filter.id_kolejka');
        if (is_numeric($id_kolejka) && ($id_kolejka != 0)) {
            $query->where('a.id_kolejka = '. (int) $id_kolejka);
        } 

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    /**
     * Build a list of matchdays or type of match
     *
     * @return  JDatabaseQuery
     * @since   1.6
     */
    public function getMatchdays()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $id_system = HockeyHelper::getSezon();
        
        $query->select('m.id_kolejka')
                ->from('#__hockey_match AS m')
                ->where(' m.id_system  = '.$db->quote($id_system) .' AND m.type_of_match =0')
                ->group('m.id_kolejka')
                ->order('m.id_kolejka');

        // Setup the query
        $db->setQuery($query);

        // Return the result
        return $db->loadColumn();
    }

}
