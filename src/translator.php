<?php
function t($s)
{
    $_DICTIONARY = array(
        "ro" => array(
            "Login" => "Conectare",
            "Wrong username or password" => "Nume de utilizator sau parolă greșită",
            "Logged in successfully" => "Autentificat cu success",
            "Username" => "Nume de utilizator",
            "Username cannot be empty" => "Numele de utilizator nu poate rămâne necompletat",
            "Password" => "Parola",
            "Password cannot be empty" => "Parola nu poate rămâne necompletată",
            "Password recovery" => "Recuperare parolă",
            "Run Fixtures" => "Generează date",
            "Dashboard" => "Panoul de control",
            "Fast-Med Dashboard" => "Panoul de control Fast-Med",
            "First Name" => "Prenume",
            "Last Name" => "Nume",
            "Age" => "Vârstă",
            "Add Patient" => "Adaugă pacient",
            "Diagnostic" => "Diagnostic",
            "Actions" => "Acțiuni",
            "Undiagnosed" => "Nediagnosticat",
            "Log Out" => "Deconectare",
            "Page" => "Pagina",
            "per page" => "pe pagină",
            "Add patient" => "Adaugă pacient",
            "Address" => "Adresă",
            "Assign bed" => "Asignează pat",
            "Add" => "Adaugă",
            "Viewing patient" => "Vizualizare pacient",
            "Unreleased" => "Internat",
            "years old" => "ani",
            "Editing patient" => "Editare pacient",
            "Send drug" => "Trimite medicament",
            "Viewing history" => "Vizualizare istoric",
            "Drug" => "Medicament",
            "Date" => "Data",
            "Status" => "Stare",
            "Adding patient" => "Adăugare pacient",
            "Diagnosis" => "Diagnostic"
        )
    );
    session_start();
    if (isset($_DICTIONARY[$_SESSION['language']]) && isset($_DICTIONARY[$_SESSION['language']][$s]))
        echo $_DICTIONARY[$_SESSION['language']][$s];
    else echo $s;
}

?>