<?php
class AlertData
{
    var $db;
    function __construct(&$db)
    {
        $this->db = & $db;

    }
    //////////////////////////////
    // PUBLIC METHODS
    //////////////////////////////
    public function getAlert($id = NULL)
    {
        $sql = $this->getAlertSQL($id);
        $res = $this->db->dbQuery($sql);
        $arr = $this->db->returnResourceAsArray($res);
        return $arr;

    }
    public function getAlertsByStatus($status)
    {
        $sql = $this->getAlertsByStatusSQL($status);
        $res = $this->db->dbQuery($sql);
        $arr = $this->db->returnResourceAsArray($res);
        return $arr;

    }
    public function getMediaForAlert($id = NULL)
    {
        $sql = $this->getMediaForAlertSQL($id);
        $res = $this->db->dbQuery($sql);
        $arr = NULL;
        if ($res) {
            $arr = $this->db->dbFetchAssoc($res);
            $this->db->dbFreeResult($res);

        }
        return !$arr ? NULL : $arr;

    }
    public function updateAlertStatus($id, $userID, $status = NULL, $note = NULL)
    {
        $sql = $this->updateAlertStatusSQL($id, $userID, $status, $note);
        $res = $this->db->dbQuery($sql);

    }
    public function GetAlertMethod($id = NULL)
    {
        $sql = $this->GetAlertMethodSQL($id);
        $res = $this->db->dbQuery($sql);
        $arr = $this->db->returnResourceAsArray($res);
        return $arr;

    }
    //	public function getAlerts($created=NULL, $smsFrom=NULL, $smsSenderName=NULL, $alertStatus=NULL)
    //	{
    //		$arr = null;
    //
    //		$sql = $this->getAlertsSQL($created, $smsFrom, $smsSenderName, $alertStatus);
    //		$res = $this->db->dbQuery($sql);
    //
    //		if($res){
    //			while($row = $this->db->dbFetchAssoc($res))$arr[] = $row;
    //			$this->db->dbFreeResult($res);
    //		}
    //
    //		return $arr;
    //	}
    public function getAlerts($createdFrom = NULL, $createdTo = NULL, $smsFrom = NULL, $smsSenderName = NULL, $alertStatus = NULL)
    {
        $arr = null;
        $sql = $this->getAlertsSQL($createdFrom, $createdTo, $smsFrom, $smsSenderName, $alertStatus);
        $res = $this->db->dbQuery($sql);
        $arr = $this->db->returnResourceAsArray($res);
        return $arr;

    }
    public function UpdateAlertViewed($id)
    {
        $sql = $this->UpdateAlertViewedSQL($id);
        $res = $this->db->dbQuery($sql);
        return $this->db->dbInsertId();

    }
    public function NewAlertViewedCount($viewed = 0)
    {
        $rows = 0;
        $sql = $this->NewAlertViewedSQL($viewed);
        $res = $this->db->dbQuery($sql);
        if ($res) {
            $rows = $this->db->dbNumRows($res);
            $this->db->dbFreeResult($res);

        }
        return $rows;

    }
    public function getAlertIdByPhoneNumber($phonenumber)
    {
        $this->getAlertIdByPhoneNumberSQL($phoneNumber);
        $res = $this->db->dbQuery($sql);
        $arr = $this->db->returnResourceAsArray($res);
        return $arr;

    }
    //////////////////////////////
    // PRIVATE METHODS
    //////////////////////////////
    //get the most recent alert_id by the phone number by joining several different tables
    private function getAlertIdByPhoneNumberSQL($phoneNumber)
    {
        $sql = "
                SELECT a.id FROM alerts a, dtltbl_sms s, dattbl_notifications n
                WHERE n.NotificationId = s.NotificationId AND a.smsFrom LIKE '%$phoneNumber'
                AND s.PhoneNumber = '$phoneNumber' ORDER BY a.id DESC";
        return $sql;

    }
    private function getAlertSQL($id = NULL)
    {
        $sql = "SELECT *
				FROM alerts a INNER JOIN settbl_notificationtype n
				ON a.TypeId = n.NotificationTypeId
				WHERE 1=1 ";
        $sql.= $id ? " AND a.id = $id " : "";
        $sql.= " ORDER BY id DESC";
        return $sql;

    }
    private function getAlertsByStatusSQL($status)
    {
        $sql = "SELECT a.id as id, a.created, a.smsFrom, n.NotificationTypeDesc, a.media, a.viewed, an.incidentNumber, an.caseNumber   
				FROM alerts a 
                                INNER JOIN settbl_notificationtype n 
				ON a.TypeId = n.NotificationTypeId
                                LEFT JOIN dattbl_alerts_notification an 
                                ON a.id = an.alert_id
				WHERE a.status = '$status'
				ORDER BY a.id DESC";
        return $sql;

    }
    private function getMediaForAlertSQL($id = NULL)
    {
        $sql = "SELECT media FROM alerts
				WHERE 1=1 ";
        $sql.= $id ? " AND id = $id " : "";
        return $sql;

    }
    private function updateAlertStatusSQL($id, $userID, $status = NULL, $note = NULL)
    {
        $sql = "UPDATE alerts 
				SET status = '$status', 
				modifiedDate = NOW()";
        $sql.= $userID ? ", modifiedBy = '$userID' " : "";
        $sql.= $note ? ", note = '$note' " : "";
        $sql.= "WHERE id = $id";
        return $sql;

    }
    private function GetAlertMethodSQL($id = NULL)
    {
        $sql = "SELECT * 
				FROM settbl_devicetype
				WHERE 1=1 ";
        $sql.= $id ? " AND a.id = $id " : "";
        return $sql;

    }
    private function getAlertsSQL($created = NULL, $smsFrom = NULL, $smsSenderName = NULL, $alertStatus = NULL)
    {
        $sql = "SELECT *
				FROM alerts a INNER JOIN settbl_notificationtype n 
				ON a.TypeId = n.NotificationTypeId ";
        $sql.= $created ? " AND a.created LIKE '%$created%' " : "";
        $sql.= $smsFrom ? " AND a.smsFrom LIKE '%$smsFrom%' " : "";
        $sql.= $smsSenderName ? " AND a.smsSenderName LIKE '%$smsSenderName%' " : "";
        $sql.= $alertStatus ? " AND a.status = '$alertStatus' " : "";
        $sql.= "ORDER BY a.id DESC";
        return $sql;

    }
    private function UpdateAlertViewedSQL($id)
    {
        return "UPDATE alerts SET viewed = 1 WHERE id = $id";

    }
    private function NewAlertViewedSQL($viewed = 0)
    {
        return "SELECT * FROM alerts WHERE status = 'N' AND viewed = $viewed";

    }
    //	private function getAlertsSQL($createdFrom=NULL, $createdTo=NULL, $smsFrom=NULL, $smsSenderName=NULL, $alertStatus=NULL){
    //
    //		$sql = "SELECT *
    //				FROM alerts a INNER JOIN settbl_notificationtype n
    //				ON a.TypeId = n.NotificationTypeId ";
    //
    //		if ($createdFrom && $createdTo) {
    //			$sql .= " AND a.created BETWEEN '$createdFrom' AND '$createdTo' ";
    //		}
    //		elseif ($createdFrom) {
    //			$sql .= " AND a.created LIKE '%$createdFrom%' ";
    //		}
    //		elseif ($createdTo) {
    //			$sql .= " AND a.created LIKE '%$createdTo%' ";
    //		}
    //
    //		$sql .= $smsFrom ? " AND a.smsFrom LIKE '%$smsFrom%' " : "";
    //		$sql .= $smsSenderName ? " AND a.smsSenderName LIKE '%$smsSenderName%' " : "";
    //		$sql .= $alertStatus ? " AND a.status = '$alertStatus' " : "";
    //
    //		$sql .= "ORDER BY a.id DESC";
    //
    //		return $sql;
    //	}
    //echo $sql; die;
    

}
//INSERT INTO alerts
//( typeId , created , msgID , smsTo , smsBody , smsFrom , smsResult , smsSentTo , userID , smsSenderName , media , status , note , modifiedBy , modifiedDate )
//VALUES
//(5,'09/16/2012 08:26:38', 'CE19028B19F6F4A5852579FC0007EEC3','+14079999999','','+14075555555','ALL','+14076666666','3FB7D9E3BAC240D7852579E500480958','peggy','../attach/media/20120511232735006_0120120511_202844.jpg','N','auto update record',122,'2012-09-16');

?>


