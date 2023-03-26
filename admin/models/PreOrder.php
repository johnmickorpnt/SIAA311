<?php
class PreOrder
{
    private $conn;
    private $table = "pre_ordered";

    private $id;
    private $userId;
    private $dishId;
    private $quantity;
    private $created_at;
    private $updated_at;

    function __construct($db)
    {
        $this->conn = $db;
    }

    function fetchAll()
    {
        $query = "SELECT * FROM `{$this->table}`";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        if ($results && $stmt->rowCount() > 0) {
            $preOrders = array();
            while ($row = $stmt->fetch()) {
                $preOrder = array(
                    "id" => $row->id,
                    "userId" => $row->userId,
                    "dishId" => $row->dishId,
                    "quantity" => $row->quantity,
                    "created_at" => $row->created_at,
                    "updated_at" => $row->updated_at
                );
                array_push($preOrders, $preOrder);
            }
            return $preOrders;
        } else return false;
    }

    function fetch($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = {$id}";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        if ($results && $stmt->rowCount() > 0) {
            while ($row = $stmt->fetch()) {
                $preOrder = array(
                    "id" => $row->id,
                    "userId" => $row->userId,
                    "dishId" => $row->dishId,
                    "reservationId" => $row->reservationId,
                    "quantity" => $row->quantity,
                    "created_at" => $row->created_at,
                    "updated_at" => $row->updated_at
                );
                $this->setId($row->id);
                $this->setUserId($row->userId);
                $this->setDishId($row->dishId);
                $this->setQuantity($row->quantity);
                $this->setCreated_at($row->created_at);
                $this->setUpdated_at($row->updated_at);
            }
            return $preOrder;
        } else return false;
    }

    // function verifyTables()
    // {
    //     $query = "SELECT * FROM reservations WHERE id = {$this->getReservationId()}";
    //     $stmt = $this->conn->prepare($query);
    //     $results = $stmt->execute();

    //     if ($results && $stmt->rowCount() <= 0) return false;

    //     $query = "SELECT * FROM users WHERE id = {$this->getUserId()}";
    //     $stmt = $this->conn->prepare($query);
    //     $results = $stmt->execute();

    //     if ($results && $stmt->rowCount() <= 0) return false;

    //     $query = "SELECT * FROM dishes WHERE id = {$this->getDishId()}";
    //     $stmt = $this->conn->prepare($query);
    //     $results = $stmt->execute();

    //     if ($results && $stmt->rowCount() <= 0) return false;
    //     else return true;
    // }

    function save()
    {
        $this->setUpdated_at(date("Y-m-d H:i:s"));
        $query = $this->getId() !== null ? "UPDATE {$this->table} SET 
        `userId` = '{$this->getUserId()}', 
        `dishId` = '{$this->getDishId()}', 
        `quantity` = '{$this->getQuantity()}', 
        `updated_at` = '{$this->getUpdated_at()}'
        WHERE id = {$this->getId()}" : "INSERT INTO {$this->table} (id, userId, dishId, quantity, created_at, updated_at) 
        VALUES(NULL, '{$this->getUserId()}', '{$this->getDishId()}', '{$this->getQuantity()}', NOW(), NOW());";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        return $results;
    }

    function delete()
    {
        $query = "DELETE FROM {$this->table} WHERE id = '{$this->getId()}'";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        return $results;
    }
    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of dishId
     */
    public function getDishId()
    {
        return $this->dishId;
    }

    /**
     * Set the value of dishId
     *
     * @return  self
     */
    public function setDishId($dishId)
    {
        $this->dishId = $dishId;

        return $this;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
