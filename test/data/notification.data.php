<?php
class NotificationData extends BaseData
{
    function __construct($db)
    {
        $this->db = $db;
        $this->setTable("dattbl_notifications");

    }
    //////////////////////////////
    // PUBLIC METHODS
    //////////////////////////////
    public function getNotificationsSms($id = NULL, $typeID = NULL)
    {
        $sql = $this->getNotificationsSmsSQL($id, $typeID);
        $res = $this->db->dbQuery($sql);
        $arr = $this->db->returnResourceAsArray($res);
        return $arr;

    }
    public function getNotificationType($internal = NULL)
    {
        $sql = $this->getNotificationTypeSQL($internal);
        $res = $this->db->dbQuery($sql);
        $arr = $this->db->returnResourceAsArray($res);
        return $arr;

    }
    public function insertNotification($typeId, $userId, $text, $zip, $radius, $internal = 0, $incidentNumber, $caseNumber, $alertID = 0)
    {
        global $alertsNotificationData;
        $sql = $this->insertNotificationSQL($typeId, $userId, $text, $zip, $radius, $internal, $alertID);
        $res = $this->db->dbQuery($sql);
        //get the notification id
        $notification_id = $this->db->dbInsertId();
        $insert_params = array(
            'alert_id' => NULL,
            'notification_id' => $notification_id,
            'incidentNumber' => $incidentNumber,
            'caseNumber' => $caseNumber
        );
        $sql = $alertsNotificationData->insertAlertsNotification($insert_params);
        $res = $this->db->dbQuery($sql);
        return $notification_id;

    }
    public function insertNotificationFile($notificationId, $filePath)
    {
        $sql = $this->insertNotificationFileSQL($notificationId, $filePath);
        $res = $this->db->dbQuery($sql);
        return $this->db->dbInsertId();

    }
    public function insertNotifiedUser($notificationId, $userID)
    {
        $sql = $this->insertNotifiedUserSQL($notificationId, $userID);
        $res = $this->db->dbQuery($sql);
        return $this->db->dbInsertId();

    }
    public function getNotificationTypeByID($id)
    {
        $sql = $this->getNotificationTypeByIDSQL($id);
        $res = $this->db->dbQuery($sql);
        $arr = $this->db->returnResourceAsArray($res);
        return $arr;

    }
    public function getNotifications($incidentNumber = NULL, $notificationDate = NULL, $phoneNumber = NULL, $lastName = NULL, $typeID = NULL)
    {
        $arr = null;
        $sql = $this->getNotificationsSQL($incidentNumber, $notificationDate, $phoneNumber, $lastName, $typeID);
        $res = $this->db->dbQuery($sql);
        $arr = $this->db->returnResourceAsArray($res);
        return $arr;

    }
    /**
     *
     *  @param Array $select_params
     *      Array fields an array of fields
     *      Array conditions is an array of conditions
     *      String order is a string to order by
     */
    public function findNotifications($fields = null, $conditions = null, $order = null)
    {
        $sql = $this->getSelectSql($fields, $conditions, $order);
        $res = $this->db->dbQuery($sql);
        return $this->db->returnResourceAsArray($res);

    }
    //////////////////////////////
    // PRIVATE METHODS
    //////////////////////////////
    public function getNotificationsSmsSQL($id = NULL, $typeID = NULL)
    {
        $sql = "SELECT n.*, an.incidentNumber, s.PhoneNumber, o.FirstName, o.LastName
				FROM dattbl_notifications n, dattbl_alerts_notification an, dtltbl_sms s, dattbl_orgusers o
				WHERE n.NotificationId = s.NotificationId
                                AND n.NotificationId = an.notification_id
				AND n.OrgUserId = o.OrgUserId";
        $sql.= $id ? " AND n.NotificationId = $id " : "";
        $sql.= $typeID ? " AND n.NotificationTypeId = $typeID " : "";
        $sql.= "ORDER BY n.NotificationDate DESC";
        return $sql;

    }
    private function getNotificationTypeSQL($internal = NULL)
    {
        $sql = "SELECT * FROM settbl_notificationtype
				WHERE 1=1 ";
        $sql.= $internal ? " AND Internal = $internal " : "";
        $sql.= "ORDER BY NotificationTypeDesc";
        return $sql;

    }
    private function insertNotificationSQL($typeId, $userId, $text, $zip, $radius, $internal = 0, $alertID = 0)
    {
        //		$sql = "INSERT INTO notifications (typeId, userId, text, zip, radius, internal)
        //				VALUES ($typeId, $userId, '$text', '$zip', $radius, $internal, $incidentNumber)";
        $sql = "INSERT INTO dattbl_notifications (NotificationTypeId, OrgUserId, NotificationText, NotificationZip, NotificationRadius, Internal, AlertId)
				VALUES ($typeId, $userId, '$text', '$zip', $radius, $internal, $alertID)";
        return $sql;

    }
    private function insertNotificationFileSQL($notificationId, $filePath)
    {
        //		$sql = "INSERT INTO notification_files (notificationId, filePath)
        //				VALUES ($notificationId, '$filePath')";
        $sql = "INSERT INTO dtltbl_notificationfiles (NotificationId, NotificationFilePath)
				VALUES ($notificationId, '$filePath')";
        return $sql;

    }
    private function insertNotifiedUserSQL($notificationId, $userID)
    {
        $sql = "INSERT INTO dtltbl_notification_users (NotificationId, NotifiedUserId)
				VALUES ($notificationId, $userID)";
        return $sql;

    }
    public function getNotificationTypeByIDSQL($id)
    {
        $sql = "SELECT * FROM settbl_notificationtype WHERE NotificationTypeId = $id ";
        return $sql;

    }
    public function getNotificationsSQL($incidentNumber = NULL, $notificationDate = NULL, $phoneNumber = NULL, $lastName = NULL, $typeID = NULL)
    {
        $sql = "SELECT n.*, s.PhoneNumber, o.FirstName, o.LastName
				FROM dattbl_notifications n, dtltbl_sms s, dattbl_orgusers o
				WHERE n.NotificationId = s.NotificationId 
				AND n.OrgUserId = o.OrgUserId";
        $sql.= $incidentNumber ? " AND n.IncidentNumber LIKE '$incidentNumber%' " : "";
        $sql.= $notificationDate ? " AND DATE_FORMAT(n.NotificationDate, '%Y-%m-%d') LIKE '$notificationDate%' " : "";
        $sql.= $phoneNumber ? " AND s.PhoneNumber LIKE '$phoneNumber%' " : "";
        $sql.= $lastName ? " AND o.LastName LIKE '$lastName%' " : "";
        $sql.= $typeID ? " AND n.NotificationTypeId = $typeID " : "";
        $sql.= "ORDER BY n.NotificationDate DESC";
        return $sql;
        // DATE_FORMAT(date_field, ‘%m %d, %Y, %l:%i%p’)
        

    }
    //echo $sql; die;
    

}
?>


