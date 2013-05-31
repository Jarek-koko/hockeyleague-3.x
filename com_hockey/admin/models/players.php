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
class HockeyModelPlayers extends JModelList
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
                'state', 'a.state',
                'created', 'a.created',
                'created_by', 'a.created_by',
                'modified', 'a.modified',
                'modified_by', 'a.modified_by',
                'name', 'a.name',
                'first_name', 'a.first_name',
                'position', 'a.position',
                'date_of_birth', 'a.date_of_birth',
                'height', 'a.height',
                'weight', 'a.weight',
                'team_id', 'a.team_id',
                'team', 'team',
                'team_old', 'a.team_old',
                'photo', 'a.photo',
                'description', 'a.description',
                'number', 'a.number',
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

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        //Filtering team
        $this->setState('filter.team_id', $app->getUserStateFromRequest($this->context . '.filter.team_id', 'filter_team_id', '', 'int'));

       //Filtering position 
        $this->setState('filter.position', $app->getUserStateFromRequest($this->context . '.filter.position', 'filter_position', '', 'int'));
        
        // Load the parameters.
        $params = JComponentHelper::getParams('com_hockey');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.name', 'asc');
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
        $id.= ':' . $this->getState('filter.search');
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
        $query->from('`#__hockey_players` AS a');


        // Join over the user field 'team'
        $query->select('teams.name AS team');
        $query->join('LEFT', '#__hockey_teams AS teams ON teams.id = a.team_id');
       
        // Filter by published state
        $published = $this->getState('filter.state');
        if (is_numeric($published)) {
            $query->where('a.state = ' . (int) $published);
        } else if ($published === '') {
            $query->where('(a.state IN (0, 1))');
        }


        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote($db->escape($search, true) . '%');
                $query->where('( a.name LIKE ' . $search . ')');
            }
        }

        //Filtering team
        $filter_team = $this->state->get("filter.team_id");
        if ($filter_team) {
            $query->where("a.team_id = '" . $db->escape($filter_team) . "'");
        }

        //Filtering position
        $filter_position = $this->state->get("filter.position");
        if ($filter_position) {
            $query->where("a.position = '" . $db->escape($filter_position) . "'");
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
	 * Build a list of teams
	 *
	 * @return  JDatabaseQuery
	 * @since   1.6
	 */
	public function getTeams()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$query->select('t.id AS value, t.name AS text')
			->from('#__hockey_players AS p')
			->join('INNER', '#__hockey_teams AS t ON t.id = p.team_id')
			->group('t.id, t.name')
			->order('t.name');

		// Setup the query
		$db->setQuery($query);

		// Return the result
		return $db->loadObjectList();
	}


}
