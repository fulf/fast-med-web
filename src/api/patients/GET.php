<?php
require_once "conn.php";

$limit = isset($_GET['limit']) ? $_GET['limit'] : 50;
$page = $limit * ((isset($_GET['page']) ? $_GET['page'] : 1) - 1 );

$orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'ID';
$orderDir = isset($_GET['orderDir']) ? $_GET['orderDir'] : 'Asc';

unset($_GET['limit']);
unset($_GET['page']);
unset($_GET['orderBy']);
unset($_GET['orderDir']);

if(count($_GET) > 0) {
    $whereCond = "AND ";
    foreach ($_GET as $key => $val)
        $whereCond .= $key . " LIKE '%" . $val . "%'";
}

if($result = db_query("SELECT COUNT(*) FROM fastmed_db.Patients WHERE (1=1) $whereCond ORDER BY $orderBy $orderDir")) {
    $arr["total"] = mysqli_fetch_array($result)[0];
}

if($result = db_query("SELECT * FROM fastmed_db.Patients WHERE (1=1) $whereCond ORDER BY $orderBy $orderDir LIMIT $limit OFFSET $page ;")) {
    while($rs = mysqli_fetch_assoc($result))
        $arr["records"][] = $rs;
    gracefulExit(200, true, $arr);
}
gracefulExit(400, false, "An error has occured. Please try again!");