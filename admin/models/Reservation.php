<?php
class Reservation
{
    private $conn;
    private $table = "reservations";

    private $id;
    private $date;
    private $startTime;
    private $endTime;
    private $user;
    private $tblId;
    private $status;
    private $created_at;
    private $updated_at;

    function __construct($db)
    {
        $this->conn = $db;
    }

    function fetchAll()
    {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        if ($results && $stmt->rowCount() > 0) {
            $reservations = array();
            while ($row = $stmt->fetch()) {
                $reservation = array(
                    "id" => $row->id,
                    "date" => $row->date,
                    "startTime" => $row->startTime,
                    "endTime" => $row->endTime,
                    "user" => $row->user,
                    "tableId" => $row->tableId,
                    "status" => $row->status,
                    "created_at" => $row->created_at,
                    "updated_at" => $row->updated_at
                );
                array_push($reservations, $reservation);
            }
            return $reservations;
        } else return false;
    }

    function fetch($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = {$id}";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        if ($results && $stmt->rowCount() > 0) {
            while ($row = $stmt->fetch()) {
                $reservation = array(
                    "id" => $row->id,
                    "date" => $row->date,
                    "startTime" => $row->startTime,
                    "endTime" => $row->endTime,
                    "user" => $row->user,
                    "tableId" => $row->tableId,
                    "status" => $row->status,
                    "created_at" => $row->created_at,
                    "updated_at" => $row->updated_at
                );
                $this->set_id($row->id);
                $this->set_date($row->date);
                $this->set_startTime($row->startTime);
                $this->set_endTime($row->endTime);
                $this->set_user($row->user);
                $this->set_tblId($row->tableId);
                $this->set_status($row->status);
                $this->set_created_at($row->created_at);
                $this->set_updated_at($row->updated_at);
            }
            return $reservation;
        } else return false;
    }


    function fetch_by_status($status)
    {
        $query = "SELECT * FROM {$this->table} WHERE status = '{$status}'";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        if ($results && $stmt->rowCount() > 0) {
            $reservations = array();
            while ($row = $stmt->fetch()) {
                $reservation = array(
                    "id" => $row->id,
                    "date" => $row->date,
                    "startTime" => $row->startTime,
                    "endTime" => $row->endTime,
                    "user" => $row->user,
                    "tableId" => $row->tableId,
                    "status" => $row->status,
                    "created_at" => $row->created_at,
                    "updated_at" => $row->updated_at
                );
                array_push($reservations, $reservation);
            }
            return $reservations;
        } else return false;
    }

    public function is_available()
    {
        $interval = \DateTime::createFromFormat('Y-m-d H:i:s', $this->get_endTime())
            ->diff(\DateTime::createFromFormat('Y-m-d H:i:s', $this->get_startTime()));
        if ($interval->h < 2) return false;

        $query = "SELECT * FROM {$this->table}  WHERE date = '{$this->get_date()}' 
        AND '{$this->get_startTime()}' < endTime AND tableId = '{$this->get_tblId()}' 
        AND id <> '{$this->get_id()}'";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        if ($results && $stmt->rowCount() <= 0)  return true;
        else return false;
    }

    public function save($db)
    {
        include("User.php");
        $this->set_updated_at(date("Y-m-d H:i:s"));
        $status = array("0", "1", "2", "3", "4");
        $user = new User($db);

        if (!in_array($this->get_status(), $status)) {
            return false;
        }

        if (!$user->fetch($this->get_user())) {
            return false;
        }

        $query = "UPDATE {$this->table} SET 
        `date` = '{$this->get_date()}', 
        `startTime` = '{$this->get_startTime()}', 
        `endTime` = '{$this->get_endTime()}', 
        `user` = '{$this->get_user()}', 
        `tableId` = '{$this->get_tblId()}',
        `status` = '{$this->get_status()}',
        `updated_at` = '{$this->get_updated_at()}'
        WHERE id = {$this->get_id()}";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        return $results;
    }

    public function new()
    {
        $query = "INSERT INTO {$this->table} (id, date, startTime, endTime, user, tableId, created_at, updated_at) 
            VALUES(NULL, '{$this->get_date()}', '{$this->get_startTime()}', 
            '{$this->get_endTime()}', '{$this->get_user()}', '{$this->get_tblId()}', NOW(), NOW());";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        return $results;
    }

    public function get_tables()
    {
        $query = "SELECT * FROM tables";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        if ($results && $stmt->rowCount() > 0) {
            $tables = array();
            while ($row = $stmt->fetch()) {
                $table = array(
                    "id" => $row->id,
                    "tbl_type" => $row->tbl_type,
                    "seats" => $row->seats,
                    "pax" => $row->pax,
                );
                array_push($tables, $table);
            }
            return $tables;
        } else return false;
    }

    function delete()
    {
        $query = "DELETE FROM {$this->table} WHERE id = '{$this->get_id()}'";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        return $results;
    }

    public function fetch_user()
    {
        $query = "SELECT * FROM users WHERE id = {$this->get_user()}";
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
            return $user;
        } else return false;
    }

    /**
     * Get the value of id
     */
    public function get_id()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function set_id($id)
    {
        $this->id = $id;
    }

    /**
     * Get the value of date
     */
    public function get_date()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */
    public function set_date($date)
    {
        $this->date = $date;
    }

    /**
     * Get the value of startTime
     */
    public function get_startTime()
    {
        return $this->startTime;
    }

    /**
     * Set the value of startTime
     *
     * @return  self
     */
    public function set_startTime($startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * Get the value of endTime
     */
    public function get_endTime()
    {
        return $this->endTime;
    }

    /**
     * Set the value of endTime
     *
     * @return  self
     */
    public function set_endTime($endTime)
    {
        $this->endTime = $endTime;
    }

    /**
     * Get the value of user
     */
    public function get_user()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */
    public function set_user($user)
    {
        $this->user = $user;
    }

    /**
     * Get the value of tblId
     */
    public function get_tblId()
    {
        return $this->tblId;
    }

    /**
     * Set the value of tblId
     *
     * @return  self
     */
    public function set_tblId($tblId)
    {
        $this->tblId = $tblId;
    }

    /**
     * Get the value of status
     */
    public function get_status()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function set_status($status)
    {
        $this->status = $status;
    }

    /**
     * Get the value of created_at
     */
    public function get_created_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */
    public function set_created_at($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * Get the value of updated_at
     */
    public function get_updated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */
    public function set_updated_at($updated_at)
    {
        $this->updated_at = $updated_at;
    }
}
