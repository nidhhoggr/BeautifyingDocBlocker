<?php
require_once (PATH_INCLUDES_DATA . '/basedata.php');
class AlertsNotificationData extends BaseData
{
    public function __construct($db)
    {
        $this->db = $db;
        $this->setTable("dattbl_alerts_notification");

    }
    /**
     *
     *  PUBLIC METHODS
     *
     */
    public function findAlertsNotification($select_params)
    {
        $sql = $this->findAlertsNotificationSQL($select_params);
        $res = $this->db->dbQuery($sql);
        return $this->db->returnResourceAsArray($res);

    }
    public function insertAlertsNotification($insert_params)
    {
        $sql = $this->insertAlertsNotificationSQL($insert_params);
        return $this->db->dbQuery($sql);

    }
    public function updateAlertsNotification($update_params)
    {
        $sql = $this->updateAlertsNotificationSQL($update_params);
        return $this->db->dbQuery($sql);

    }
    public function deleteAlertsNotification($id)
    {
        $sql = $this->deleteAlertsNotificationSQL($id);
        return $this->db->dbQuery($sql);

    }
    /**
     * @param notification_id integer te id of the notification id
     * @return void
     *
     * this function is used to create an alert notification reference from the notification_id
     * which retrieves the phonenumber from the sms table and finds the related alert
     * the alert_id is obtained and the reference is created
     *
     */
    public function createReferenceByPhoneNumber($notification_id)
    {
        global $smsData, $alertData;
        $smsRecord = $smsData->findSms(null, array(
            "NotificationId = $notification_id"
        ));
        $phoneNumber = $smsRecord[0]["PhoneNumber"];
        $alertIds = $alertData->getAlertIdByPhoneNumber($phoneNumber);
        $alert_id = $alertIds[0]['id'];
        $this->setIdentifier('notification_id');
        $update_params = array(
            'notification_id' => $notification_id,
            'alert_id' => $alert_id
        );
        $this->updateAlertsNotification($update_params);

    }
    /**
     *
     *  PRIVATE METHODS
     *
     */
    private function findAlertsNotificationSQL($params)
    {
        extract($params);
        return $this->getSelectSql($fields, $conditions, $order);

    }
    private function insertAlertsNotificationSQL($insert_params)
    {
        return $this->getInsertSql($insert_params);

    }
    private function updateAlertsNotificationSQL($update_params)
    {
        return $this->getUpdateSql($update_params);

    }
    private function deleteAlertsNotificationSQL($id)
    {
        return $this->getDeleteSql($id);

    }
    private function findReferenceByAlert()
    {

    }

}

