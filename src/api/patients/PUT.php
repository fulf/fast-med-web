<?php

function bind($string)
{
    return isset($string) ? "'" . $string . "'" : "NULL";
}

require_once "conn.php";

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['CNP']) || !isset($data['FirstName']) || !isset($data['LastName']) || !isset($data['Age']) || !isset($data['Address']) || !isset($data['Hositalized']) || !isset($data['Released']) || !isset($data['Diagnosis']) || !isset($data['BedID']))
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

foreach ($data as $key => $val) {
    if(in_array($key, ['ID', 'CNP', 'FirstName', 'LastName', 'Age', 'Address', 'Hospitalized', 'Released', 'Diagnosis', 'BedID']))
        $updateCond .=  ", ".$key." = ".bind($val);
    else
        gracefulExit(400, false, "Request data malformed.");
}

if ($result = db_query("UPDATE Patients SET ID=ID $updateCond WHERE (1=1) $whereCond;")) {
    if ($result = db_query("SELECT * FROM fastmed_db.Patients WHERE (1=1) $whereCond"))
        gracefulExit(200, true, mysqli_fetch_assoc($result));
    else
        gracefulExit(400, false, "An error has occurred. Please try again!");
} else gracefulExit(400, false, "An error has occurred. Please try again!");