<?php

function bind($string)
{
    return isset($string) ? "'" . $string . "'" : "NULL";
}

require_once "conn.php";

if (isset($_GET['filters'])) {
    $filters = json_decode($_GET['filters'], true);
    foreach ($filters as $key => $val) {
        if (in_array($key, ['ID', 'PatientID', 'DrugID', 'BedID', 'UserID', 'RobotID', 'RequestID', 'RFID', 'ActionID']))
            $whereCond .= " AND " . $key . " = '" . $val . "'";
        else
            $whereCond .= " AND " . $key . " LIKE '%" . $val . "%'";
    }
}

if ($result = db_query("UPDATE Patients SET Released = CURRENT_TIMESTAMP WHERE (1=1) $whereCond;")) {
    if ($result = db_query("SELECT * FROM fastmed_db.Patients WHERE (1=1) $whereCond"))
        gracefulExit(200, true, mysqli_fetch_assoc($result));
    else
        gracefulExit(400, false, "An error has occurred. Please try again!");
} else gracefulExit(400, false, "An error has occurred. Please try again!");