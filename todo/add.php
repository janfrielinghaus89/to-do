<?php

if (empty($_POST['name'])) {
    $error = "Kein Name angegeben";
} elseif (empty($_POST['desc'])) {
    $error = "Keine Beschreibung angegeben";
}

if (file_exists('todos.json')) {
    $final_data = fileWriteAppend();
    if (file_put_contents('todos.json', $final_data)) {
        $message = "To-Do erfolgreich hinzugefügt.\nSie werden weitergeleitet.";
    }
} else {
    $final_data = fileCreateWrite();
    if (file_put_contents('todos.json', $final_data)) {
        $message = "To-Do Datei und To-Do wurden erfolgreich angelegt.\nSie werden weitergeleitet.";
    }
}

// Funktion zum Hinzufügen von To-Do's
function fileWriteAppend() {
    // Lade die aktuellen Daten aus der JSON-Datei
    $current_data = file_get_contents('todos.json');
    $array_data = json_decode($current_data, true);
    $extra = array(
        'id' => getNewId($array_data),
        'name' => $_POST['name'],
        'desc' => $_POST['desc'],
        'date' => date("d.m.Y"),
        'creator' => $_POST['creator']
    );
    $array_data[] = $extra;
    $final_data = json_encode($array_data);
    return $final_data;
}

// Funktion zum Erstellen einer Datei plus Hinzufügen von erstem To-Do
function fileCreateWrite() {
    // Öffne bzw. erstelle Datei
    $file = fopen("todos.json", "w");
    $array_data = array();
    $extra = array(
        'id' => getNewId($array_data),
        'name' => $_POST['name'],
        'desc' => $_POST['desc'],
        'date' => date("d.m.Y"),
        'creator' => $_POST['creator']
    );

    $array_data[] = $extra;
    $final_data = json_encode($array_data);
    fclose($file);
    return $final_data;
}

// Funktion zum Zuweisen einer neuen ID
function getNewId($arrays) {
    $highestId = 0;

    foreach ($arrays as $item) {
        $id = intval($item['id']);
        if ($id > $highestId) {
            $highestId = $id;
        }
    }

    $newId = ++$highestId;

    return $newId;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do Verwaltung</title>
    <link rel="stylesheet" href="../style/styles.css">
    <!-- Weiterleitung auf Startseite -->
    <meta http-equiv="refresh" content="3;URL='../index.html'" />

</head>
<body>
    <p class="message">
    <?php
                if(isset($message))
                {
                    echo $message;                   
                }
                else
                    echo $message;
    ?>
    </p>
</body>
</html>
