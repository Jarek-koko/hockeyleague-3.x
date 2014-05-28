<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
// No direct access
defined('_JEXEC') or die;
class HockeyModelModtop extends JModelLegacy
{
    protected $_id;
    protected $_sez;
    protected $_type;
    protected $_idteam;

    public function __construct($config = array())
    {
        parent::__construct($config);
        $app = JFactory::getApplication();
        $this->_id = (int) $app->input->get('id', 0, 'int');
        $this->_sez = (int) $app->input->get('sez', 0, 'int');
        $this->_type = (int) $app->input->get('type', 0, 'int');
        $this->_idteam = (int) $app->input->get('idteam', 0, 'int');
    }

    public function getItems()
    {
        $db = $this->getDbo();

        if ($this->_idteam != 0) {
            $this->_idteam = " AND ( P.team_id=" . $db->Quote($this->_idteam) . ") ";
        } else {
            $this->_idteam = "";
        }

        switch ($this->_id) {
            case 3:
                $query = "SELECT P.id,concat_ws('. ',LEFT(P.first_name,1),P.name) as name, "
                    . "COALESCE(( SELECT COUNT(G.assist1) "
                    . "FROM #__hockey_match M "
                    . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                    . "WHERE ( M.type_of_match =" . $db->Quote($this->_type) . " AND G.assist1 = P.id AND M.id_system=" . $db->Quote($this->_sez) . ")),0) + "
                    . "COALESCE(( SELECT COUNT(G.assist2) "
                    . "FROM #__hockey_match M "
                    . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                    . "WHERE ( M.type_of_match =" . $db->Quote($this->_type) . " AND G.assist2 = P.id AND M.id_system=" . $db->Quote($this->_sez) . ")),0)  AS points "
                    . "FROM #__hockey_players AS P "
                    . "WHERE ( P.state=1 ) AND (P.position !=1 ) " . $this->_idteam
                    . "HAVING points <>'0'  ORDER BY points DESC LIMIT 10";
                break;
            case 2:
                $query = "SELECT P.id,concat_ws('. ',LEFT(P.first_name,1),P.name) as name, "
                    . "COALESCE(( SELECT COUNT(G.shooter) "
                    . "FROM #__hockey_match M "
                    . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                    . "WHERE ( M.type_of_match =" . $db->Quote($this->_type) . " AND G.shooter = P.id AND M.id_system=" . $db->Quote($this->_sez) . ")),0) AS points "
                    . "FROM #__hockey_players AS P "
                    . "WHERE ( P.state=1 ) AND (P.position !=1 ) " . $this->_idteam
                    . "HAVING points <>'0' ORDER BY points DESC LIMIT 10";
                break;
            default:
                $query = "SELECT P.id,concat_ws('. ',LEFT(P.first_name,1),P.name) as name, "
                    . "COALESCE(( SELECT COUNT(G.shooter) "
                    . "FROM #__hockey_match M "
                    . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                    . "WHERE ( M.type_of_match =" . $db->Quote($this->_type) . " AND G.shooter = P.id AND M.id_system=" . $db->Quote($this->_sez) . ")),0) + "
                    . "COALESCE((SELECT COUNT(G.assist1) "
                    . "FROM #__hockey_match M "
                    . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                    . "WHERE ( M.type_of_match =" . $db->Quote($this->_type) . " AND G.assist1 = P.id AND M.id_system=" . $db->Quote($this->_sez) . ")),0) + "
                    . "COALESCE(( SELECT COUNT(G.assist2) "
                    . "FROM #__hockey_match M "
                    . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                    . "WHERE ( M.type_of_match =" . $db->Quote($this->_type) . " AND G.assist2 = P.id AND M.id_system=" . $db->Quote($this->_sez) . ")),0)  AS points "
                    . "FROM #__hockey_players AS P "
                    . "WHERE ( P.state=1 ) AND (P.position !=1 )  " . $this->_idteam
                    . "HAVING points <>'0' ORDER BY points DESC LIMIT 10";
                break;
        }

        $db->setQuery($query);
        return $db->loadObjectList();
    }

}