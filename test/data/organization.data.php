<?php
class OrganizationData
{
    var $db;
    function __construct(&$db)
    {
        $this->db = & $db;

    }
    //////////////////////////////
    // PUBLIC METHODS
    //////////////////////////////
    public function GetOrganizations($id = NULL)
    {
        $sql = $this->GetOrganizationsSQL($id);
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
    private function GetOrganizationsSQL($id = NULL)
    {
        $sql = "SELECT * 
				FROM dattbl_organization
				WHERE 1=1 ";
        $sql.= $id ? " AND OrgId = '$id' " : "";
        $sql.= "ORDER BY OrgName ASC";
        return $sql;

    }

}
?>

