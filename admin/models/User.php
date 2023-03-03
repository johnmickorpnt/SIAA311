<?php
class User
{
    private $conn;
    private $table = "users";
    private $id;
    private $firstname;
    private $lastname;
    private $email;
    private $number;
    private $created_at;
    private $updated_at;
    private $password;

    function __construct($db)
    {
        $this->conn = $db;
    }

    function fetchAll($limit)
    {
        $limitQ = isset($limit) ? "LIMIT $limit" : "";
        $query = "SELECT * FROM {$this->table} $limitQ";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        if ($results && $stmt->rowCount() > 0) {
            $users = array();
            while ($row = $stmt->fetch()) {
                $user = array(
                    "id" => $row->id,
                    "firstname" => $row->firstname,
                    "lastname" => $row->lastname,
                    "email" => $row->email,
                    "password" => $row->password,
                    "number" => $row->number,
                    "created_at" => $row->created_at,
                    "updated_at" => $row->updated_at
                );

                array_push($users, $user);
            }
            return $users;
        } else return false;
    }

    function fetch($id)
    {
        $qId = $this->get_id() !== null ? $this->get_id() : $id;
        $query = "SELECT * FROM {$this->table} WHERE id = {$qId}";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        if ($results && $stmt->rowCount() > 0) {
            $user = array();
            while ($row = $stmt->fetch()) {
                $user = array(
                    "id" => $row->id,
                    "firstname" => $row->firstname,
                    "lastname" => $row->lastname,
                    "email" => $row->email,
                    "password" => $row->password,
                    "number" => $row->number,
                    "created_at" => $row->created_at,
                    "updated_at" => $row->updated_at
                );
            }
            $this->set_firstname($user["firstname"]);
            $this->set_lastname($user["firstname"]);
            $this->set_email($user["email"]);
            $this->set_password($user["password"]);
            $this->set_number($user["number"]);

            return $user;
        } else return false;
    }

    function is_email_not_unique($email)
    {
        $query = "SELECT * FROM {$this->table} WHERE `id` <> '{$this->get_id()}' AND `email` = '{$email}'";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();

        if ($stmt->rowCount() > 0) return true;
        else return false;
    }

    function save()
    {
        $this->set_updated_at(date("Y-m-d H:i:s"));
        $query = "UPDATE {$this->table} SET 
        `firstname` = '{$this->get_firstname()}', 
        `lastname` = '{$this->get_lastname()}', 
        `email` = '{$this->get_email()}', 
        `number` = '{$this->get_number()}', 
        `updated_at` = '{$this->get_updated_at()}'
        WHERE id = {$this->get_id()}";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        return $results;
    }

    function new()
    {
        $query = "INSERT INTO {$this->table} (id, firstname, lastname, email, password, number, created_at, updated_at) 
        VALUES(NULL, '{$this->get_firstname()}', '{$this->get_lastname()}', 
        '{$this->get_email()}', '{$this->get_password()}', '{$this->get_number()}', NOW(), NOW());";

        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        return $results;
    }

    function delete()
    {
        $query = "DELETE FROM users WHERE id = '{$this->get_id()}'";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        return $results;
    }


    function set_id($id)
    {
        $this->id = $id;
    }

    function get_id()
    {
        return $this->id;
    }

    function get_firstname()
    {
        return $this->firstname;
    }

    function get_password()
    {
        return $this->password;
    }

    function get_lastname()
    {
        return $this->lastname;
    }

    function get_email()
    {
        return $this->email;
    }

    function get_number()
    {
        return $this->number;
    }

    function get_created_at()
    {
        return $this->created_at;
    }

    function get_updated_at()
    {
        return $this->updated_at;
    }

    function set_password($password)
    {
        $this->password = $password;
    }

    function set_firstname($firstname)
    {
        $this->firstname = $firstname;
    }

    function set_lastname($lastname)
    {
        $this->lastname = $lastname;
    }

    function set_email($email)
    {
        $this->email = $email;
    }

    function set_number($number)
    {
        $this->number = $number;
    }

    function set_created_at($created_at)
    {
        $this->created_at = $created_at;
    }

    function set_updated_at($updated_at)
    {
        $this->updated_at = $updated_at;
    }
}
