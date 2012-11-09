<?php
class DepartmentData
{
    var $db;
    function __construct(&$db)
    {
        $this->db = & $db;

    }
    //////////////////////////////
    // PUBLIC METHODS
    //////////////////////////////
    public function GetDepartments($id = NULL)
    {
        $sql = $this->getDepartmentsSQL($id);
        $res = $this->db->dbQuery($sql);
        if ($res) {
            while ($row = $this->db->dbFetchAssoc($res)) $arr[] = $row;
            $this->db->dbFreeResult($res);

        }
        return $arr;

    }
    public function GetDepartmentMembers($id = NULL)
    {
        $sql = $this->getDepartmentMembersSQL($id);
        $res = $this->db->dbQuery($sql);
        if ($res) {
            while ($row = $this->db->dbFetchAssoc($res)) $arr[] = $row;
            $this->db->dbFreeResult($res);

        }
        return $arr;

    }
    //////////////////////////////
    // PRIVATE METHODS
    //////////////////////////////
    private function getDepartmentsSQL($id = NULL)
    {
        $sql = "SELECT DeptId, DeptName 
				FROM settbl_departments
				WHERE 1=1 ";
        $sql.= $id ? " AND DeptId = '$id' " : "";
        $sql.= "ORDER BY DeptName ASC";
        return $sql;

    }
    private function getDepartmentMembersSQL($id)
    {
        $sql = "SELECT * 
				FROM dtltbl_departmentmembers d INNER JOIN dattbl_orgusers o
				ON o.OrgUserId = d.OrgUserId
				WHERE d.DeptId = '" . $id . "'
				ORDER BY o.LastName ASC;";
        return $sql;

    }

}
?>

