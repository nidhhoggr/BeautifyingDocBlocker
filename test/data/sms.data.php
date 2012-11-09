<?php
class SmsData extends BaseData
{
    function __construct($db)
    {
        $this->db = $db;
        $this->setTable("dtltbl_sms");

    }
    //////////////////////////////
    // PUBLIC METHODS
    //////////////////////////////
    public function InsertSms($notificationID, $phoneNumber, $message, $sent, $seq = NULL)
    {
        $sql = $this->InsertSmsSQL($notificationID, $phoneNumber, $message, $sent, $seq);
        $res = $this->db->dbQuery($sql);
        return $this->db->dbInsertId();

    }
    public function InsertMmsc($notificationID, $phoneNumber, $message, $media, $sent, $seq)
    {
        $sql = $this->InsertMmscSQL($notificationID, $phoneNumber, $message, $media, $sent, $seq);
        $res = $this->db->dbQuery($sql);
        return $this->db->dbInsertId();

    }
    public function getMmscSequence()
    {
        $seq = 0;
        $sql = $this->getMmscSequenceSQL();
        $res = $this->db->dbQuery($sql);
        if ($res) {
            $seq = $this->db->dbResult($res, 0, "COUNT");
            $this->db->dbFreeResult($res);

        }
        return $seq;

    }
    /**
     *
     *  @param Array $select_params
     *      Array fields an array of fields
     *      Array conditions is an array of conditions
     *      String order is a string to order by
     */
    public function findSms($fields = null, $conditions = null, $order = null)
    {
        $sql = $this->getSelectSql($fields, $conditions, $order);
        $res = $this->db->dbQuery($sql);
        return $this->db->returnResourceAsArray($res);

    }
    //////////////////////////////
    // PRIVATE METHODS
    //////////////////////////////
    private function InsertSmsSQL($notificationID, $phoneNumber, $message, $sent, $seq)
    {
        //		$sql = "INSERT INTO sms (notificationId, phoneNumber, message, sent, seq)
        //				VALUES ($notificationID, '$phoneNumber', '$message', '$sent', $seq)";
        $sql = "INSERT INTO dtltbl_sms (NotificationId, PhoneNumber, Message, Sent, Seq) 
				VALUES ($notificationID, '$phoneNumber', '$message', '$sent', $seq)";
        return $sql;

    }
    private function InsertMmscSQL($notificationID, $phoneNumber, $message, $media, $sent, $seq)
    {
        //		$sql = "INSERT INTO mmsc (notificationId, phoneNumber, message, media, sent, seq)
        //				VALUES ($notificationID, '$phoneNumber', '$message', '$media', '$sent', $seq)";
        $sql = "INSERT INTO dtltbl_mmsc (NotificationId, PhoneNumber, Message, BFile, Sent, seq) 
				VALUES ($notificationID, '$phoneNumber', '$message', '$media', '$sent', $seq)";
        return $sql;

    }
    private function getMmscSequenceSQL()
    {
        //		return "SELECT (IFNULL(MAX(SEQ),0)+1) AS COUNT FROM mmsc";
        return "SELECT (IFNULL(MAX(SEQ),0)+1) AS COUNT FROM dtltbl_mmsc";

    }
    //echo $sql; die;
    

}
?>


