<?php
class ZipcodeData
{
    private $db;
    public function __construct(&$db)
    {
        $this->db = & $db;

    }
    //////////////////////////////
    // PUBLIC METHODS
    //////////////////////////////
    public function getGeographicCoordinatesForZipcode($zipcode)
    {
        $sql = $this->getGeographicCoordinatesForZipcodeSQL($zipcode);
        $res = $this->db->dbQuery($sql);
        if ($res) {
            while ($row = $this->db->dbFetchAssoc($res)) $arr[] = $row;
            $this->db->dbFreeResult($res);

        }
        return $arr[0];

    }
    public function getZipcodes($coordinates, $rowOffset = 0, $numberOfRows = NULL)
    {
        $sql = $this->getZipcodesSQL($coordinates, $rowOffset, $numberOfRows);
        $res = $this->db->dbQuery($sql);
        if ($res) {
            while ($row = $this->db->dbFetchAssoc($res)) $arr[] = $row;
            $this->db->dbFreeResult($res);

        }
        return $arr;

    }
    public function getZipcodes_OLD($coordinates, $orderBy = NULL, $rowOffset = 0, $numberOfRows = NULL)
    {
        $sql = $this->getZipcodesSQL_OLD($coordinates, $orderBy, $rowOffset, $numberOfRows);
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
    private function getGeographicCoordinatesForZipcodeSQL($zipcode)
    {
        return "SELECT latitude, longitude 
				FROM dattbl_zipdata 
				WHERE zipcode = '$zipcode' 
				AND PrimaryRecord = 'P'";

    }
    private function getZipcodesSQL($coordinates, $rowOffset = 0, $numberOfRows = NULL)
    {
        $sql = "SELECT ZipCode, State, City, AreaCode FROM dattbl_zipdata 
				WHERE PrimaryRecord = 'P' 
				AND ((latitude BETWEEN {$coordinates['minLatitude']} AND {$coordinates['maxLatitude']})
				AND	(longitude BETWEEN {$coordinates['minLongitude']} AND {$coordinates['maxLongitude']}))
				OR (latitude = {$coordinates['latitude']} AND longitude = {$coordinates['longitude']})";
        $sql.= $numberOfRows ? " LIMIT $rowOffset, $numberOfRows" : "";
        return $sql;

    }
    private function getZipcodesSQL_OLD($coordinates, $orderBy = NULL, $rowOffset = 0, $numberOfRows = NULL)
    {
        $sql = "SELECT DISTINCT country_code, postal_code, place_name AS city, admin_code1 AS state, latitude, longitude
				FROM zipcodes
				WHERE 
					((latitude BETWEEN {$coordinates['minLatitude']} AND {$coordinates['maxLatitude']})
				AND	(longitude BETWEEN {$coordinates['minLongitude']} AND {$coordinates['maxLongitude']}))
				OR (latitude = {$coordinates['latitude']} AND longitude = {$coordinates['longitude']})";
        $sql.= $orderBy ? "ORDER BY $orderBy " : 'ORDER BY postal_code';
        $sql.= $numberOfRows ? " LIMIT $rowOffset, $numberOfRows" : "";
        return $sql;

    }

} // end ZipcodeData
// echo '<br>'.$sql.'<br>'; die;

?>

