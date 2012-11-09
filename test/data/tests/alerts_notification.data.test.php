<?php
include (dirname(__FILE__) . "/../../../inc/common/bootstrap.php");
require_once (PATH_INCLUDES_DATA . '/alerts_notification.data.php');
$tester = new AlertsNotificationData($db);
echo "<pre>";
$insert_params = array(
    'alert_id' => 2,
    'notification_id' => 3,
    'incidentNumber' => '201248575',
    'caseNumber' => '2012-38498'
);
$tester->insertAlertsNotification($insert_params);
$select_params = array(
    'fields' => array(
        "*"
    ) ,
    'conditions' => null,
    'order' => null
);
print_r($tester->findAlertsNotification($select_params));
$lastInsertedId = $db->dbInsertId();
$update_params = array(
    'id' => $lastInsertedId,
    'alert_id' => 2,
    'notification_id' => 3,
    'incidentNumber' => '201348575',
    'caseNumber' => '2013-38498'
);
$tester->updateAlertsNotification($update_params);
print_r($tester->findAlertsNotification($select_params));
$tester->deleteAlertsNotification($lastInsertedId);
var_dump($smsData->findSms(null, array(
    "NotificationId = 1422"
)));
$tester->createReferenceByPhoneNumber(1422);
echo "</pre>";

