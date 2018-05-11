<?php

session_start();

class Db {

    private static $instance = NULL;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            self::$instance = new PDO('mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME . ';port=' . DATABASE_PORT . ';charset='.DATABASE_CHARSET, DATABASE_USER, DATABASE_PASSWORD, $pdo_options);
        }
        return self::$instance;
    }

}

interface personInterface {

    public function get($id);

    public function gets($order, $filter);

    public function set();

    public function insert();

    public function update($id);
}

class person implements personInterface {

    public function get($id) {

        $db = Db::getInstance();
        $sth = $db->prepare("SELECT * FROM urlap WHERE id = ?");
        $sth->execute(array($id));
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $data[0];
    }

    public function gets($order, $filter) {

        if ($order == $_SESSION['order']) {
            if ($_SESSION['direction'] == 'ASC') {
                $direction = 'DESC';
            } else {
                $direction = 'ASC';
            }
            $orderString = $order . ' ' . $direction;
        } else {
            $direction = 'ASC';
            $orderString = $order . ' ' . $direction;
        }

        $_SESSION['direction'] = $direction;
        $_SESSION['order'] = $order;

        if ($filter) {
            $szuresQuery = "WHERE name LIKE '%" . $filter . "%'";
        }

        $filter = '%' . $filter . '%';
        $db = Db::getInstance();
        $sth = $db->prepare("SELECT * FROM urlap WHERE name LIKE :filter ORDER BY " . $orderString);
        $sth->bindParam(':filter', $filter, PDO::PARAM_STR);
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function set() {
        $this->post['nev'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $this->post['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $this->post['telefon'] = filter_input(INPUT_POST, 'telefon', FILTER_SANITIZE_STRING);
        $this->post['szuletesidatum'] = filter_input(INPUT_POST, 'szuletesiDatum', FILTER_SANITIZE_STRING);
        $this->post['jogositvany'] = filter_input(INPUT_POST, 'jogositvany', FILTER_SANITIZE_STRING);
        $this->post['hobbiKerekpar'] = filter_input(INPUT_POST, 'hobbiKerekpar', FILTER_SANITIZE_STRING);
        $this->post['hobbiTurazas'] = filter_input(INPUT_POST, 'hobbiTurazas', FILTER_SANITIZE_STRING);
        $this->post['hobbiHegymaszas'] = filter_input(INPUT_POST, 'hobbiHegymaszas', FILTER_SANITIZE_STRING);
        $this->post['hobbiProgramozas'] = filter_input(INPUT_POST, 'hobbiProgramozas', FILTER_SANITIZE_STRING);
        $this->post['hobbiEgyeb'] = filter_input(INPUT_POST, 'hobbiEgyeb', FILTER_SANITIZE_STRING);

        ($this->post['hobbiKerekpar'] == 'on' ? $this->post['hobbiKerekpar'] = 1 : $this->post['hobbiKerekpar'] = 0);
        ($this->post['hobbiTurazas'] == 'on' ? $this->post['hobbiTurazas'] = 1 : $this->post['hobbiTurazas'] = 0);
        ($this->post['hobbiHegymaszas'] == 'on' ? $this->post['hobbiHegymaszas'] = 1 : $this->post['hobbiHegymaszas'] = 0);
        ($this->post['hobbiProgramozas'] == 'on' ? $this->post['hobbiProgramozas'] = 1 : $this->post['hobbiProgramozas'] = 0);
        ($this->post['hobbiEgyeb'] == 'on' ? $this->post['hobbiEgyeb'] = 1 : $this->post['hobbiEgyeb'] = 0);
    }

    public function insert() {
        $this->set();

        $db = Db::getInstance();
        $statement = $db->prepare("INSERT INTO `urlap` 
                    (`name`, `email`, `phone`, `birthday`, `drivingLicence`, 
                     `hobbiKerekpar`, `hobbiTurazas`, `hobbiHegymaszas`, `hobbiProgramozas`, `hobbiEgyeb`) 
                     VALUES 
                    (:nev, :email, :telefon, :szuletesidatum, :jogositvany, :hobbiKerekpar, :hobbiTurazas, :hobbiHegymaszas, 
                    :hobbiProgramozas, :hobbiEgyeb);");

        $statement->execute($this->post);
    }

    public function update($id) {
        $this->set();

        $db = Db::getInstance();
        $statement = $db->prepare("UPDATE `urlap` SET name=:nev, email=:email, phone=:telefon, birthday=:szuletesidatum, drivingLicence=:jogositvany, 
                     hobbiKerekpar=:hobbiKerekpar, hobbiTurazas=:hobbiTurazas, hobbiHegymaszas=:hobbiHegymaszas, hobbiProgramozas=:hobbiProgramozas, hobbiEgyeb=:hobbiEgyeb WHERE id = $id;");

        $statement->execute($this->post);
    }

}