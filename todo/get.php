<?php

if (file_exists('todos.json')) {
    $filename = 'todos.json';
    $data = file_get_contents($filename);
    $todos = json_decode($data);

    $message = "<h3 class='text-success'>To-Do Liste</h3>";
} else {
    $message = "<h3 class='text-success'>Keine To-Do's gefunden!</h3>";
}

function deleteEntry($idToDelete) {
    // Lade die aktuellen Daten aus der JSON-Datei
    $current_data = file_get_contents('todos.json');
    $array_data = json_decode($current_data, true);

    // Finde die gesuchte ID
    foreach ($array_data as $key => $entry) {
        if ($entry['id'] == $idToDelete) {
            unset($array_data[$key]);
            break; // Stoppe sobald gelöscht
        }
    }

    $final_data = json_encode(array_values($array_data));

    file_put_contents('todos.json', $final_data);

    return $final_data;
}

// Überprüfe, ob das Formular zum Löschen eines Eintrags gesendet wurde
if(isset($_POST['id'])) {
    // Rufe die Funktion zum Löschen des Eintrags auf
    $idToDelete = $_POST['id'];
    $deletedData = deleteEntry($idToDelete);
    $message = "<h3 class='text-success'>Eintrag erfolgreich gelöscht!</h3>";

    // Leite die Seite nach dem Löschen automatisch neu, um die Änderungen anzuzeigen
    echo "<meta http-equiv='refresh' content='2'>"; // Seite nach 2 Sekunden neu laden
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do Verwaltung</title>
    <link rel="stylesheet" href="../style/styles.css">
</head>
<body>
    <?php
    if(isset($message)) {
        echo $message;
    ?>
    <table>
        <tbody>
            <tr>
                <th>ID</th>
                <th>Bezeichnung</th>
                <th>Beschreibung</th>
                <th>Angelegt am</th>
                <th>Angelegt von</th>
            </tr>
            <?php foreach ($todos as $todo) { ?>
            <tr>
                <td> <?= $todo->id; ?> </td>
                <td> <?= $todo->name; ?> </td>
                <td> <?= $todo->desc; ?> </td>
                <td> <?= $todo->date; ?> </td>
                <td> <?= $todo->creator; ?> </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <p>
        <!-- Formular zum Löschen eines Eintrags -->
        <form action="" method="post">
            <label for="id">ID des zu löschenden Eintrags: </label><br>
            <input type="text" id="id" name="id" required>
            <input type="submit" value="Eintrag löschen">
        </form>
    </p>
    <?php } else { echo $message; } ?>
</body>
</html>
