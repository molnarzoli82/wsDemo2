<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

require 'config.php';
require 'model.php';

$db = new PDO('mysql:host='.DATABASE_HOST.';dbname='.DATABASE_NAME.';charset=utf8mb4', DATABASE_USER, DATABASE_PASSWORD);

if (filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING)) {
    $person = new person($db);
    $id = filter_input(INPUT_POST, 'modosit', FILTER_SANITIZE_STRING);
    if ($id == '0') {
        $person->insert();
    } else {
        $person->update($id);
    }
}

if (filter_input(INPUT_GET, 'method', FILTER_SANITIZE_STRING) == 'list') {
    
    $order = filter_input(INPUT_GET, 'order', FILTER_SANITIZE_STRING);
    $filter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_STRING);
    
    if (!$order){ $order = 'name';}
    
    $person = new person($db);

    
    foreach ($person->gets($order, $filter) as $row) {
        $rows .= '<tr><td>' . $row->name . '</td><td>' . $row->phone . '</td><td>' . $row->email . '</td><td>' . $row->birthday . '</td><td><span onclick="szerkeszt('.$row->id.');">szerkeszt</span></td></tr>';
    }

    echo '
    <table>
        <thead>
            <tr><th id="nameTh">Név</th><th id="phoneTh">Telefon</th><th id="emailTh">Email</th><th id="birthTh">Születési idő</th><th></th></tr>
        </thead>
        <tbody>
        ' . $rows . '
        </tbody>
    </table>';
}

if (filter_input(INPUT_GET, 'method', FILTER_SANITIZE_STRING) == 'edit') {
    
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    $person = new person($db);
    echo json_encode($person->get($id));

}