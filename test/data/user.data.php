<?php
class UserData
{
    var $db;
    function __construct(&$db)
    {
        $this->db = & $db;

    }
    //////////////////////////////
    // PUBLIC METHODS
    //////////////////////////////
    public function GetInternalUsers($id = NULL, $orderBy = NULL)
    {
        $sql = $this->GetInternalUsersSQL($id, $orderBy);
        $res = $this->db->dbQuery($sql);
        if ($res) {
            while ($row = $this->db->dbFetchAssoc($res)) $arr[] = $row;
            $this->db->dbFreeResult($res);

        }
        return $arr;

    }
    public function GetInternalUser($id)
    {
        $sql = $this->GetInternalUserSQL($id);
        $res = $this->db->dbQuery($sql);
        if ($res) {
            while ($row = $this->db->dbFetchAssoc($res)) $arr[] = $row;
            $this->db->dbFreeResult($res);

        }
        return $arr;

    }
    public function GetInternalUserEmails($userList, $deviceTypeID = NULL)
    {
        $sql = $this->GetInternalUserEmailsSQL($userList, $deviceTypeID);
        $res = $this->db->dbQuery($sql);
        if ($res) {
            while ($row = $this->db->dbFetchAssoc($res)) $arr[] = $row;
            $this->db->dbFreeResult($res);

        }
        return $arr;

    }
    public function GetInternalUserPhone($userList, $deviceTypeID = NULL)
    {
        $sql = $this->GetInternalUserPhoneSQL($userList);
        $res = $this->db->dbQuery($sql);
        if ($res) {
            while ($row = $this->db->dbFetchAssoc($res)) $arr[] = $row;
            $this->db->dbFreeResult($res);

        }
        return $arr;

    }
    public function getAllUserEmails($userList, $zipCodes, $notificationTypeID)
    {
        $sql = $this->getAllUserEmailsSQL($userList, $zipCodes, $notificationTypeID);
        $res = $this->db->dbQuery($sql);
        if ($res) {
            while ($row = $this->db->dbFetchAssoc($res)) $arr[] = $row;
            $this->db->dbFreeResult($res);

        }
        return $arr;

    }
    public function getAllUserPhone($userList, $zipCodes, $notificationTypeID)
    {
        $sql = $this->getAllUserPhoneSQL($userList, $zipCodes, $notificationTypeID);
        $res = $this->db->dbQuery($sql);
        if ($res) {
            while ($row = $this->db->dbFetchAssoc($res)) $arr[] = $row;
            $this->db->dbFreeResult($res);

        }
        return $arr;

    }
    public function GetInternalUserTypes()
    {
        $sql = $this->GetInternalUserTypesSQL();
        $res = $this->db->dbQuery($sql);
        if ($res) {
            while ($row = $this->db->dbFetchAssoc($res)) $arr[] = $row;
            $this->db->dbFreeResult($res);

        }
        return $arr;

    }
    public function InsertUser($userName, $password, $firstName, $lastName, $primaryEmail, $adminID, $orgID, $userTypeID, $magIncOnly)
    {
        $sql = $this->InsertUserSQL($userName, $password, $firstName, $lastName, $primaryEmail, $adminID, $orgID, $userTypeID, $magIncOnly);
        $res = $this->db->dbQuery($sql);
        return $this->db->dbInsertId();

    }
    public function InsertUserPhone($id, $phone, $phoneType)
    {
        $sql = $this->InsertUserPhoneSQL($id, $phone, $phoneType);
        $res = $this->db->dbQuery($sql);
        return $this->db->dbInsertId();

    }
    public function UpdateUser($id, $firstName, $lastName, $primaryEmail, $adminID, $userTypeID)
    {
        $sql = $this->updateUserSQL($id, $firstName, $lastName, $primaryEmail, $adminID, $userTypeID);
        $res = $this->db->dbQuery($sql);
        return $this->db->dbInsertId();

    }
    public function UpdateUserPhone($id, $phone, $phoneType)
    {
        $sql = $this->updateUserPhoneSQL($id, $phone, $phoneType);
        $res = $this->db->dbQuery($sql);
        return $this->db->dbInsertId();

    }
    public function DeleteUserAlertType($id)
    {
        $sql = $this->DeleteUserAlertTypeSQL($id);
        return $this->db->dbQuery($sql);

    }
    public function InsertUserAlertType($id, $typeID, $adminID)
    {
        $sql = $this->InsertUserAlertTypeSQL($id, $typeID, $adminID);
        $res = $this->db->dbQuery($sql);
        return $this->db->dbInsertId();

    }
    public function DoesUsernameExist($username)
    {
        $sql = $this->DoesUsernameExistSQL($username);
        $res = $this->db->dbQuery($sql);
        return $this->db->dbNumRows($res);

    }
    public function DoesEmailExist($email)
    {
        $sql = $this->DoesEmailExistSQL($email);
        $res = $this->db->dbQuery($sql);
        return $this->db->dbNumRows($res);

    }
    public function DoesPhoneExist($phone)
    {
        $sql = $this->DoesPhoneExistSQL($phone);
        $res = $this->db->dbQuery($sql);
        return $this->db->dbNumRows($res);

    }
    //////////////////////////////
    // PRIVATE METHODS
    //////////////////////////////
    private function GetInternalUsersSQL($id, $orderBy = NULL)
    {
        $sql = "SELECT *  
				FROM dattbl_orgusers u     
				WHERE 1=1";
        $sql.= $id ? " AND u.id = $id " : "";
        $sql.= $orderBy ? " ORDER BY $orderBy " : "";
        return $sql;

    }
    private function GetInternalUserSQL($id)
    {
        //		$sql = "SELECT DISTINCT U.LastName,
        //					U.FirstName,
        //					U.PrimaryEmailAddress,
        //					PH1.PhoneNumber,
        //					PH2.PhoneNumber AS CellPhone,
        //					U.OrgUserTypeId,
        //					(SELECT DeviceTypeId
        //						FROM dtltbl_orguserdevicetypes
        //						WHERE OrgUserId = '".$id."'
        //						AND DeviceTypeId = 1) AS DeviceTypeId_1,
        //					(SELECT DeviceTypeId
        //						FROM dtltbl_orguserdevicetypes
        //						WHERE OrgUserId = '".$id."'
        //						AND DeviceTypeId = 2) AS DeviceTypeId_2
        //				FROM
        //					dattbl_orgusers U,
        //					dtltbl_orguserphonenumber PH1,
        //					dtltbl_orguserphonenumber PH2
        //				WHERE U.OrgUserId  = PH1.OrgUserId
        //					AND U.OrgUserId  = PH2.OrgUserId
        //					AND PH2.PhoneNumberTypeID = 3
        //					AND PH1.PhoneNumberTypeID = 1
        //					AND U.OrgUserId  = '".$id."'";
        $sql = "SELECT DISTINCT 
					U.LastName, 
					U.FirstName, 
					U.PrimaryEmailAddress,
					PH2.PhoneNumber AS CellPhone,
					U.OrgUserTypeId,
					(SELECT DeviceTypeId
						FROM dtltbl_orguserdevicetypes
						WHERE OrgUserId = '" . $id . "'
						AND DeviceTypeId = 1) AS DeviceTypeId_1,
					(SELECT DeviceTypeId
						FROM dtltbl_orguserdevicetypes
						WHERE OrgUserId = '" . $id . "'
						AND DeviceTypeId = 2) AS DeviceTypeId_2 
				FROM 
					dattbl_orgusers U,
					dtltbl_orguserphonenumber PH2
				WHERE U.OrgUserId  = PH2.OrgUserId
					AND PH2.PhoneNumberTypeID = 3
					AND U.OrgUserId  = '" . $id . "'";
        return $sql;

    }
    private function GetInternalUserEmailsSQL($userList, $deviceTypeID = NULL)
    {
        $sql = "SELECT distinct u.PrimaryEmailAddress  
				FROM dattbl_orgusers u, dtltbl_orguserdevicetypes t     
				WHERE u.OrgUserId = t.OrgUserId    
				AND u.OrgUserId IN ($userList)";
        $sql.= $deviceTypeID ? " AND t.DeviceTypeId = $deviceTypeID " : "";
        return $sql;

    }
    private function GetInternalUserPhoneSQL($userList, $deviceTypeID = NULL)
    {
        $sql = "SELECT DISTINCT REPLACE(p.PhoneNumber,'-','') AS cellNumber 
				FROM dtltbl_orguserphonenumber p 
				INNER JOIN dtltbl_orguserdevicetypes t ON t.OrgUserId = p.OrgUserId 
				WHERE p.OrgUserId IN ($userList) 
				AND p.PhoneNumberTypeId = 3";
        $sql.= $deviceTypeID ? " AND t.DeviceTypeId = $deviceTypeID " : "";
        return $sql;

    }
    private function getAllUserEmailsSQL($userList, $zipCodes, $notificationTypeID)
    {
        $sql = "SELECT DISTINCT x.PrimaryEmailAddress, x.SecondaryEmailAddress, x.iPhoneEmailAddress
				FROM 
				(
					SELECT u.PrimaryEmailAddress, u.SecondaryEmailAddress, u.iPhoneEmailAddress
					FROM dattbl_Users u
					INNER JOIN dtltbl_useraddress a ON u.UserId = a.UserId
					INNER JOIN dtltbl_userdevicetypes d ON u.UserId = d.UserId
					INNER JOIN dtltbl_userselectednotifications n ON u.UserID = n.UserId
					WHERE ZipCode in ($zipCodes)
					AND d.DeviceTypeID = 2
					AND NotificationTypeId = $notificationTypeID
				UNION
					SELECT DISTINCT o.PrimaryEmailAddress ,o.SecondaryEmailAddress, o.iPhoneEmailAddress
					FROM dattbl_orgusers o, dtltbl_orguserdevicetypes d
					WHERE o.OrgUserId = d.userList
					AND d.DeviceTypeId = 2
					AND o.OrgUserId IN ($userList)
				) x ";
        return $sql;

    }
    private function getAllUserPhoneSQL($userList, $zipCodes, $notificationTypeID)
    {
        $sql = "SELECT x.cellnumber
				FROM 
				(
					SELECT DISTINCT REPLACE(Ph.PhoneNumber,'-','') AS cellnumber
					FROM 
						settbl_carriers c,
						dtltbl_userphonenumber p,
						dtltbl_userdevicetypes d,
						dtltbl_useraddress a,
						dtltbl_userselectednotifications n
					WHERE c.CarrierId = p.CarrierId
						AND d.UserId = p. UserId
						AND d.UserId = a.UserId
						AND d.UserId = n.UserId
						AND a.ZipCode in ($zipCodes)
						AND d.DeviceTypeId = 1
						AND c.MMSToModem = 'Y'
						AND n.NotificationTypeId = $notificationTypeID
				UNION
					SELECT DISTINCT REPLACE(p.PhoneNumber,'-','') AS cellnumber
					FROM 
						settbl_carriers c,
						dtltbl_orguserphonenumber p,
						dtltbl_orguserdevicetypes d
					WHERE c.CarrierId = p.CarrierId
						AND d.OrgUserId = p.OrgUserId
						AND d.DeviceTypeId = 1
						AND c.MMSToModem = 'Y'
						AND p.OrgUserId IN ($userList)
				) x ";
        return $sql;

    }
    private function GetInternalUserTypesSQL()
    {
        return "SELECT * FROM settbl_orgusertype 
				WHERE OrgUserTypeId != 1
				ORDER BY OrgUserTypeDesc";

    }
    public function InsertUserSQL($userName, $password, $firstName, $lastName, $primaryEmail, $adminID, $orgID, $userTypeID, $magIncOnly)
    {
        $sql = "INSERT INTO dattbl_orgusers (
					UserName, Password, FirstName, LastName,
					PrimaryEmailAddress, CreatedDate, MaintenanceDate,
					MaintenanceUserId, OrgId, OrgUserTypeId, MagIncOnly
				  )
				  VALUES (
					'$userName', '$password', '$firstName', '$lastName',
					'$primaryEmail', NOW(), NOW(),
					'$adminID', '$orgID', '$userTypeID', '$magIncOnly'
				  )";
        return $sql;

    }
    public function InsertUserPhoneSQL($id, $phone, $phoneType)
    {
        $sql = "INSERT INTO dtltbl_orguserphonenumber (
					  OrgUserId, PhoneNumber, PhoneNumberTypeId, PrimaryPhone
					)
					VALUES (
					  $id, '$phone', $phoneType, 0
					)";
        return $sql;

    }
    public function UpdateUserSQL($id, $firstName, $lastName, $primaryEmail, $adminID, $userTypeID)
    {
        $sql = "UPDATE dattbl_orgusers
				SET FirstName = '$firstName',
				LastName = '$lastName',
				PrimaryEmailAddress = '$primaryEmail',
				MaintenanceDate = NOW(),
				MaintenanceUserId = $adminID,
				OrgUserTypeId  = $userTypeID
				WHERE OrgUserId = $id";
        return $sql;

    }
    public function UpdateUserPhoneSQL($id, $phone, $phoneType)
    {
        $sql = "UPDATE dtltbl_orguserphonenumber
				SET PhoneNumber = '$phone', CarrierId = null
				WHERE OrgUserId = $id
				AND PhoneNumberTypeId = $phoneType";
        return $sql;

    }
    public function DeleteUserAlertTypeSQL($id)
    {
        return "DELETE FROM dtltbl_orguserdevicetypes WHERE OrgUserId = $id";

    }
    private function InsertUserAlertTypeSQL($id, $typeID, $adminID)
    {
        $sql = "INSERT INTO dtltbl_orguserdevicetypes 
				(OrgUserId, DeviceTypeId, CreatedDate, ModifiedDate, ModificationUser)
				VALUES 
				($id, $typeID, NOW(), NOW(), $adminID)";
        return $sql;

    }
    public function DoesUsernameExistSQL($username)
    {
        return "SELECT Username FROM dattbl_orgusers 
				WHERE Username = '$username'";

    }
    public function DoesEmailExistSQL($email)
    {
        return "SELECT PrimaryEmailAddress FROM dattbl_orgusers 
				WHERE PrimaryEmailAddress = '$email'";

    }
    public function DoesPhoneExistSQL($phone)
    {
        return "SELECT PhoneNumber FROM dtltbl_orguserphonenumber 
				WHERE PhoneNumber = '$phone'";

    }
    //echo $sql; die;
    

}
?>

