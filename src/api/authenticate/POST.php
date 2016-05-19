<?php

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data["username"]) || !isset($data["password"])) {
    gracefulExit(400, false, "Request data malformed.");
}
else
{
    $username = $data['username'];
    $password = $data['password'];
}

require_once "conn.php";

if($result = db_query("SELECT * FROM fastmed_db.Users WHERE Username = '$username';")) {
    if(mysqli_num_rows($result)==1)
    {
        $rs = mysqli_fetch_assoc($result);
        if(password_verify($password, $rs["Password"]))
        {
            unset($rs["Password"]);
            $_SESSION['login'] = 'ok';
            gracefulExit(200, true, $rs);
        }
    }
    mysqli_free_result($result);
}
gracefulExit(401, false, "Invalid username or password.");