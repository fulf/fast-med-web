<?php
require_once "conn.php";

$limit = isset($_GET['limit']) ? $_GET['limit'] : 50;
$page = $limit * ((isset($_GET['page']) ? $_GET['page'] : 1) - 1);

$orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'ID';
$orderDir = isset($_GET['orderDir']) ? $_GET['orderDir'] : 'Asc';

if (isset($_GET['filters'])) {
    $filters = json_decode($_GET['filters'], true);
    foreach ($filters as $key => $val) {
        if (in_array($key, ['ID', 'PatientID', 'DrugID', 'BedID', 'UserID', 'RobotID', 'RequestID', 'RFID', 'ActionID']))
            $whereCond .= " AND " . $key . " = '" . $val . "'";
        else
            $whereCond .= " AND " . $key . " LIKE '%" . $val . "%'";
    }
}

if ($result = db_query("SELECT COUNT(*) FROM fastmed_db.Beds WHERE (1=1) $whereCond ORDER BY $orderBy $orderDir")) {
    $arr["total"] = mysqli_fetch_array($result)[0];
}

if ($result = db_query("SELECT * FROM fastmed_db.Beds WHERE (1=1) $whereCond ORDER BY $orderBy $orderDir LIMIT $limit OFFSET $page ;")) {
    while ($rs = mysqli_fetch_assoc($result))
        $arr["records"][] = $rs;
    gracefulExit(200, true, $arr);
}
gracefulExit(400, false, "An error has occurred. Please try again!");