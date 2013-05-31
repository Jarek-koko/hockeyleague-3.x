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
class HockeyModelTables extends JModelList
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
                'team_id', 'a.team_id',
                'matchday', 'a.matchday',
                'points', 'a.points',
                'won', 'a.won',
                'ties', 'a.ties',
                'lost', 'a.lost',
                'goals_scored', 'a.goals_scored',
                'goals_against', 'a.goals_against',
                'difference', 'a.difference',
                'system_id', 'a.system_id',
                'ordering', 'a.ordering',
                'group', 'a.group',
                'state', 'a.state',
                'created_by', 'a.created_by',
                'created', 'a.created',
                'modified_by', 'a.modified_by',
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
        $query->select(
            $this->getState(
                'list.select', 'a.*'
            )
        );
        $query->from('`#__hockey_tables` AS a');


        // Join over the user field 'modified_by'
        $query->select('t.name AS team');
        $query->join('INNER', '#__hockey_teams AS t ON t.id = a.team_id');

        $query->where('id_system =' . HockeyHelper::getSezon());

        // Filter by published state
        $published = $this->getState('filter.state');
        if (is_numeric($published)) {
            $query->where('a.state = ' . (int) $published);
        } else if ($published === '') {
            $query->where('(a.state IN (0, 1))');
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');

        if ($orderCol && $orderDirn) {
            if ($orderCol == "a.id") {
                $query->order('a.group ASC, a.points DESC, a.ordering ASC');
            } else {
                $query->order($db->escape($orderCol . ' ' . $orderDirn));
            }
        }

        return $query;
    }

}
