<?php

function bind($string)
{
    return isset($string) ? "'" . $string . "'" : "NULL";
}

require_once "conn.php";

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['RobotID']))
    gracefulExit(400, false, "Request data malformed.");

if (isset($_GET['filters'])) {
    $filters = json_decode($_GET['filters'], true);
    foreach ($filters as $key => $val) {
        if (in_array($key, ['ID', 'PatientID', 'DrugID', 'BedID', 'UserID', 'RobotID', 'RequestID', 'RFID', 'ActionID']))
            $whereCond .= " AND " . $key . " = '" . $val . "'";
        else
            $whereCond .= " AND " . $key . " LIKE '%" . $val . "%'";
    }
}

if ($result = db_query("UPDATE Requests SET Acknowledged = " . bind("Canceled") . " WHERE (1=1) $whereCond;")) {
    if ($result = db_query("SELECT * FROM fastmed_db.Requests WHERE (1=1) $whereCond"))
        gracefulExit(200, true, mysqli_fetch_assoc($result));
    else
        gracefulExit(400, false, "An error has occurred. Please try again!");
} else gracefulExit(400, false, "An error has occurred. Please try again!");