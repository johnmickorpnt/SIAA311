<?php
class Dish
{
    private $conn;
    private $table = "dishes";

    private $id;
    private $name;
    private $category;
    private $price;
    private $description;
    private $image;
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
            $dishes = array();
            while ($row = $stmt->fetch()) {
                $dish = array(
                    "id" => $row->id,
                    "name" => $row->name,
                    "category" => $row->category,
                    "price" => $row->price,
                    "description" => $row->description,
                    "image" => $row->image,
                    "created_at" => $row->created_at,
                    "updated_at" => $row->updated_at
                );
                array_push($dishes, $dish);
            }
            return $dishes;
        } else return false;
    }

    function fetch($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = {$id}";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        if ($results && $stmt->rowCount() > 0) {
            $dish = array();
            while ($row = $stmt->fetch()) {
                $dish = array(
                    "id" => $row->id,
                    "name" => $row->name,
                    "category" => $row->category,
                    "price" => $row->price,
                    "description" => $row->description,
                    "image" => $row->image,
                    "created_at" => $row->created_at,
                    "updated_at" => $row->updated_at
                );
                $this->set_id($row->id);
                $this->set_name($row->name);
                $this->set_category($row->category);
                $this->set_price($row->price);
                $this->set_description($row->description);
                $this->set_image($row->image);
                $this->set_created_at($row->created_at);
                $this->set_updated_at($row->updated_at);
            }
            return $dish;
        } else return false;
    }

    function fetchCategories()
    {
        $query = "SELECT * FROM `dish-category`";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        $categories = array();
        if ($results && $stmt->rowCount() > 0) {
            $category = array();
            while ($row = $stmt->fetch()) {
                $category = array(
                    "id" => $row->id,
                    "category-name" => $row->categoryName,
                );
                array_push($categories, $category);
            }
            return $categories;
        } else return false;
    }

    function save()
    {
        $this->set_updated_at(date("Y-m-d H:i:s"));
        $categories = array();
        foreach ($this->fetchCategories() as $key => $val)
            array_push($categories, $val["id"]);
        if (!in_array($this->get_category(), $categories))
            return false;
        $query = $this->get_id() !== null ? "UPDATE {$this->table} SET 
        `name` = '{$this->get_name()}', 
        `category` = '{$this->get_category()}', 
        `price` = '{$this->get_price()}', 
        `description` = '{$this->get_description()}', 
        `image` = '{$this->get_image()}',
        `updated_at` = '{$this->get_updated_at()}'
        WHERE id = {$this->get_id()}" : 
        "INSERT INTO {$this->table} (id, name, category, price, description, image)
        VALUES (NULL, '{$this->get_name()}', '{$this->get_category()}', 
        '{$this->get_price()}', '{$this->get_description()}', '{$this->get_image()}')";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        return $results;
    }

    function delete()
    {
        $query = "DELETE FROM {$this->table} WHERE id = '{$this->get_id()}'";
        $stmt = $this->conn->prepare($query);
        $results = $stmt->execute();
        return $results;
    }
    
    public function get_id()
    {
        return $this->id;
    }

    public function get_name()
    {
        return $this->name;
    }

    public function get_category()
    {
        return $this->category;
    }

    public function get_price()
    {
        return $this->price;
    }

    public function get_description()
    {
        return $this->description;
    }

    public function get_image()
    {
        return $this->image;
    }

    public function get_updated_at()
    {
        return $this->updated_at;
    }

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }

    public function set_category($category)
    {
        $this->category = $category;
    }

    public function set_price($price)
    {
        $this->price = $price;
    }

    public function set_description($description)
    {
        $this->description = $description;
    }

    public function set_image($image)
    {
        $this->image = $image;
    }

    public function set_created_at($created_at)
    {
        $this->created_at = $created_at;
    }

    public function set_updated_at($updated_at)
    {
        $this->updated_at = $updated_at;
    }
}
