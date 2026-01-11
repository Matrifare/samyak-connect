<?php

/**
 * Secure Request Handler
 * Uses prepared statements to prevent SQL injection
 */
class Status
{
    private $_actionSuccess;
    private $_statusMessage;

    public function __construct()
    {

    }

    public function setActionSuccess($actionSuccess)
    {
        $this->_actionSuccess = $actionSuccess;
    }

    public function getActionSuccess()
    {
        return $this->_actionSuccess;
    }

    public function setStatusMessage($statusMessage)
    {
        $this->_statusMessage = $statusMessage;
    }

    public function getStatusMessage()
    {
        return $this->_statusMessage;
    }
}

function handle_post_request($action, $sql_statement, $DatabaseCo)
{
    $STATUS_MESSAGE = "";
    $statusObj = new Status();
    $SQL_STATEMENT = $sql_statement;
    switch ($action) {
        case 'REGISTER':
            if (($DatabaseCo->updateData($SQL_STATEMENT))) {
                $STATUS_MESSAGE = "A verification code has been sent to your email id.Please Enter verification code in below text box.";
                $statusObj->setActionSuccess(true);
                $statusObj->setStatusMessage($STATUS_MESSAGE);
            } else {
                $STATUS_MESSAGE = "There is a problem while adding record.";

                $statusObj->setActionSuccess(false);
                $statusObj->setStatusMessage($STATUS_MESSAGE);
            }
            break;

        case 'ADD':
            if (($DatabaseCo->updateData($SQL_STATEMENT))) {
                $STATUS_MESSAGE = "Record is added successfully.";
                $statusObj->setActionSuccess(true);
                $statusObj->setStatusMessage($STATUS_MESSAGE);
            } else {
                $STATUS_MESSAGE = "There is a problem while adding record.";

                $statusObj->setActionSuccess(false);
                $statusObj->setStatusMessage($STATUS_MESSAGE);
            }
            break;

        case 'UPDATE':
            if (($DatabaseCo->updateData($SQL_STATEMENT))) {
                $STATUS_MESSAGE = "Record is updated successfully.";
                $statusObj->setActionSuccess(true);
                $statusObj->setStatusMessage($STATUS_MESSAGE);
            } else {
                $STATUS_MESSAGE = "There is a problem while updating record.";
                $statusObj->setActionSuccess(false);
                $statusObj->setStatusMessage($STATUS_MESSAGE);
            }
            break;

        case 'DELETE':
            if (($DatabaseCo->updateData($SQL_STATEMENT))) {
                $STATUS_MESSAGE = "Record is deleted successfully.";
                $statusObj->setActionSuccess(true);
                $statusObj->setStatusMessage($STATUS_MESSAGE);
            } else {
                $STATUS_MESSAGE = "There is a problem while deleting record.";
                $statusObj->setActionSuccess(false);
                $statusObj->setStatusMessage($STATUS_MESSAGE);
            }
            break;

        case 'LOGIN':
            $DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($SQL_STATEMENT);

            if ($DatabaseCo->dbRow = mysqli_fetch_object($DatabaseCo->dbResult)) {
                $STATUS_MESSAGE = "Logged in successfully.";
                $statusObj->setActionSuccess(true);
                $statusObj->setStatusMessage($STATUS_MESSAGE);
            } else {
                $STATUS_MESSAGE = "User Name or Password does not match, Please try again!";
                $statusObj->setActionSuccess(false);
                $statusObj->setStatusMessage($STATUS_MESSAGE);
            }
            break;
        case 'FORGET':
            $DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($SQL_STATEMENT);

            if ($DatabaseCo->dbRow = mysqli_fetch_object($DatabaseCo->dbResult)) {
                $STATUS_MESSAGE = "Password Sent to your Email-ID successfully.";
                $statusObj->setActionSuccess(true);
                $statusObj->setStatusMessage($STATUS_MESSAGE);
            } else {
                $STATUS_MESSAGE = "Password is not Sent to your Email-ID, Please try again!";
                $statusObj->setActionSuccess(false);
                $statusObj->setStatusMessage($STATUS_MESSAGE);
            }
            break;
        case 'SEARCH':
            $DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($SQL_STATEMENT);
            if ($DatabaseCo->dbRow = mysqli_fetch_object($DatabaseCo->dbResult)) {
                $STATUS_MESSAGE = "Password Sent to your Email-ID successfully.";
                $statusObj->setActionSuccess(true);
                $statusObj->setStatusMessage($STATUS_MESSAGE);
            } else {
                $STATUS_MESSAGE = "Password is not Sent to your Email-ID, Please try again!";
                $statusObj->setActionSuccess(false);
                $statusObj->setStatusMessage($STATUS_MESSAGE);
            }
            break;
    }
    return $statusObj;
}

function getSelectForCountry($selected, $arg)
{
    if ($selected == $arg)
        echo "SELECTED=SELECTED";
    else
        echo "";
}

function getRowCount($sqlForCount, $DatabaseCo)
{
    $rowCount = 0;

    $DatabaseCo->dbResult = $DatabaseCo->getSelectQueryResult($sqlForCount);

    while ($DatabaseCo->dbRow = mysqli_fetch_array($DatabaseCo->dbResult)) {
        $rowCount = $DatabaseCo->dbRow[0];
    }
    return $rowCount;

}

function getWhereClauseForStatus($status)
{
    $where = "";
    switch ($status) {
        case 'approved':
            $where = " WHERE STATUS='APPROVED'";
            break;

        case 'unapproved':
            $where = " WHERE STATUS='UNAPPROVED'";
            break;

        case 'all':
            $where = "";
            break;
        default:
            $where = "";

    }
    return $where;
}


function getWhereClauseForVideo($status)
{
    $where = "";
    switch ($status) {
        case 'approved':
            $where = " WHERE video_approval='APPROVED'  AND (video!='' OR video_url!='')";
            break;
        case 'unapproved':
            $where = " WHERE video_approval='UNAPPROVED'  AND (video!='' OR video_url!='')";
            break;
        case 'all':
            $where = " WHERE (video!='' OR video_url!='')";
            break;
        default:
            $where = "";
    }
    return $where;

}

/**
 *  Given a file, i.e. /css/base.css, replaces it with a string containing the
 *  file's mtime, i.e. /css/base.1221534296.css.
 *
 * @param $file  The file to be loaded.  Must be an absolute path (i.e.
 *                starting with slash).
 * @return Datetime of updated time
 */
function auto_version($file)
{
    return $file . "?v=" . filemtime($file);
}

function r_print($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function photo_exists($photoName)
{
    $url = "https://www.samyakmatrimony.com/photos/" . trim($photoName);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($code == 200) {
        $status = true;
    } else {
        $status = false;
    }
    curl_close($ch);
    return $status;
}

function getPhotoForEmail($photo, $gender)
{
    if (!empty($photo) && photo_exists($photo)) {
        $photo = "https://www.samyakmatrimony.com/photos/watermark?image=" . trim($photo) . "&watermark=watermark.png";
    } else {
        if ($gender == 'Groom') {
            $photo = "https://www.samyakmatrimony.com/img/default-photo/male-200.png";
        } else {
            $photo = "https://www.samyakmatrimony.com/img/default-photo/female-200.png";
        }
    }
    return $photo;
}

/**
 * Reactivate Express Interests using prepared statements
 */
function reActivateExpressInterests($DatabaseCo, $matriId)
{
    // Sanitize matriId
    $matriId = preg_replace('/[^a-zA-Z0-9_-]/', '', $matriId);
    
    // Receiver Interests - Accept
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE expressinterest SET receiver_response='Accept' WHERE ei_receiver = ? AND receiver_response = 'SuspendedAccept'");
    $stmt->bind_param("s", $matriId);
    $result['receiver_accept'] = $stmt->execute();
    $stmt->close();

    // Receiver Interests - Reject
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE expressinterest SET receiver_response='Reject' WHERE ei_receiver = ? AND receiver_response = 'SuspendedReject'");
    $stmt->bind_param("s", $matriId);
    $result['receiver_reject'] = $stmt->execute();
    $stmt->close();

    // Receiver Interests - Hold
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE expressinterest SET receiver_response='Hold' WHERE ei_receiver = ? AND receiver_response = 'SuspendedHold'");
    $stmt->bind_param("s", $matriId);
    $result['receiver_hold'] = $stmt->execute();
    $stmt->close();

    // Receiver Interests - Pending
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE expressinterest SET receiver_response='Pending' WHERE ei_receiver = ? AND receiver_response = 'SuspendedPending'");
    $stmt->bind_param("s", $matriId);
    $result['receiver_pending'] = $stmt->execute();
    $stmt->close();

    // Sender Interests - Accept
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE expressinterest SET receiver_response='Accept' WHERE ei_sender = ? AND receiver_response = 'SuspendedAccept'");
    $stmt->bind_param("s", $matriId);
    $result['sender_accept'] = $stmt->execute();
    $stmt->close();

    // Sender Interests - Reject
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE expressinterest SET receiver_response='Reject' WHERE ei_sender = ? AND receiver_response = 'SuspendedReject'");
    $stmt->bind_param("s", $matriId);
    $result['sender_reject'] = $stmt->execute();
    $stmt->close();

    // Sender Interests - Hold
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE expressinterest SET receiver_response='Hold' WHERE ei_sender = ? AND receiver_response = 'SuspendedHold'");
    $stmt->bind_param("s", $matriId);
    $result['sender_hold'] = $stmt->execute();
    $stmt->close();

    // Sender Interests - Pending
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE expressinterest SET receiver_response='Pending' WHERE ei_sender = ? AND receiver_response = 'SuspendedPending'");
    $stmt->bind_param("s", $matriId);
    $result['sender_pending'] = $stmt->execute();
    $stmt->close();

    return true;
}

/**
 * Deactivate Express Interests using prepared statements
 */
function deActivateExpressInterests($DatabaseCo, $matriId)
{
    // Sanitize matriId
    $matriId = preg_replace('/[^a-zA-Z0-9_-]/', '', $matriId);
    
    // Receiver Interests - Accept
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE expressinterest SET receiver_response='SuspendedAccept' WHERE ei_receiver = ? AND receiver_response = 'Accept'");
    $stmt->bind_param("s", $matriId);
    $result['receiver_accept'] = $stmt->execute();
    $stmt->close();

    // Receiver Interests - Reject
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE expressinterest SET receiver_response='SuspendedReject' WHERE ei_receiver = ? AND receiver_response = 'Reject'");
    $stmt->bind_param("s", $matriId);
    $result['receiver_reject'] = $stmt->execute();
    $stmt->close();

    // Receiver Interests - Hold
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE expressinterest SET receiver_response='SuspendedHold' WHERE ei_receiver = ? AND receiver_response = 'Hold'");
    $stmt->bind_param("s", $matriId);
    $result['receiver_hold'] = $stmt->execute();
    $stmt->close();

    // Receiver Interests - Pending
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE expressinterest SET receiver_response='SuspendedPending' WHERE ei_receiver = ? AND receiver_response = 'Pending'");
    $stmt->bind_param("s", $matriId);
    $result['receiver_pending'] = $stmt->execute();
    $stmt->close();

    // Sender Interests - Accept
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE expressinterest SET receiver_response='SuspendedAccept' WHERE ei_sender = ? AND receiver_response = 'Accept'");
    $stmt->bind_param("s", $matriId);
    $result['sender_accept'] = $stmt->execute();
    $stmt->close();

    // Sender Interests - Reject
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE expressinterest SET receiver_response='SuspendedReject' WHERE ei_sender = ? AND receiver_response = 'Reject'");
    $stmt->bind_param("s", $matriId);
    $result['sender_reject'] = $stmt->execute();
    $stmt->close();

    // Sender Interests - Hold
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE expressinterest SET receiver_response='SuspendedHold' WHERE ei_sender = ? AND receiver_response = 'Hold'");
    $stmt->bind_param("s", $matriId);
    $result['sender_hold'] = $stmt->execute();
    $stmt->close();

    // Sender Interests - Pending
    $stmt = $DatabaseCo->dbLink->prepare("UPDATE expressinterest SET receiver_response='SuspendedPending' WHERE ei_sender = ? AND receiver_response = 'Pending'");
    $stmt->bind_param("s", $matriId);
    $result['sender_pending'] = $stmt->execute();
    $stmt->close();

    return true;
}

// to Sanitize database inputs for security purpose  starts //
function cleanInput($input)
{
    $search = array(
        '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
        '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
        '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
        '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
    );
    $output = preg_replace($search, '', $input);
    return $output;
}

function sanitize($input)
{
    if (is_array($input)) {
        foreach ($input as $var => $val) {
            $output[$var] = sanitize($val);
        }
    } else {
        $input = htmlspecialchars($input);
        $input = cleanInput($input);
        $output = $input;
    }
    return $output;
}

// to Sanitize database inputs for security purpose  ends //
