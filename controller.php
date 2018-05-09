<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

require 'config.php';
require 'model.php';

$db = new PDO('mysql:host='.DATABASE_HOST.';dbname='.DATABASE_NAME.';charset=utf8mb4', DATABASE_USER, DATABASE_PASSWORD);

$person = new person($db);

if (filter_input(INPUT_POST, 'method', FILTER_SANITIZE_STRING) == 'set') {
    $id = filter_input(INPUT_POST, 'modosit', FILTER_SANITIZE_STRING);
    if ($id == '0') {
        $person->insert();
    } else {
        $person->update($id);
    }
}

if (filter_input(INPUT_POST, 'method', FILTER_SANITIZE_STRING) == 'list') {
    $order = filter_input(INPUT_POST, 'order', FILTER_SANITIZE_STRING);
    $filter = filter_input(INPUT_POST, 'filter', FILTER_SANITIZE_STRING);
    
    if (!$order){ $order = 'name';}
    
    foreach ($person->gets($order, $filter) as $row) {
        $rows .= '<tr><td>' . $row->name . '</td><td>' . $row->phone . '</td><td>' . $row->email . '</td><td>' . $row->birthday . '</td><td><span onclick="szerkeszt('.$row->id.');">szerkeszt</span></td></tr>';
    }
    
    echo $rows;
}

if (filter_input(INPUT_POST, 'method', FILTER_SANITIZE_STRING) == 'edit') {
    
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    echo json_encode($person->get($id));

}