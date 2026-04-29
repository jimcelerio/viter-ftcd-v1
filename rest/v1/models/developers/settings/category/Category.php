<?php

class Category
{
    public $category_aid;
    public $category_is_active;
    public $category_name;
    public $category_description;
    public $category_created;
    public $category_updated;

    public $start;
    public $total;
    public $search;

    public $connection;
    public $lastInsertedId;

    public $tblCategory;

    public function __construct($db)
    {
        $this->connection = $db;
        $this->tblCategory = "settings_category";
    }

    public function create()
    {
        try {
            $sql = "insert into {$this->tblCategory}";
            $sql .= " ( ";
            $sql .= " category_is_active, ";
            $sql .= " category_name, ";
            $sql .= " category_description, ";
            $sql .= " category_created, ";
            $sql .= " category_updated ";
            $sql .= " ) values ( ";
            $sql .= " :category_is_active, ";
            $sql .= " :category_name, ";
            $sql .= " :category_description, ";
            $sql .= " :category_created, ";
            $sql .= " :category_updated ";
            $sql .= " ) ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "category_is_active" => $this->category_is_active,
                "category_name" => $this->category_name,
                "category_description" => $this->category_description,
                "category_created" => $this->category_created,
                "category_updated" => $this->category_updated,
            ]);
            $this->lastInsertedId = $this->connection->lastInsertId();
        } catch (PDOException $e) {
            returnError($e);
            $query = false;
        }

        return $query;
    }

    public function readAll()
    {
        try {
            $sql = "select ";
            $sql .= " * ";
            $sql .= " from {$this->tblCategory} ";
            $sql .= " where true ";
            $sql .= $this->category_is_active != "" ? " and category_is_active = :category_is_active " : "";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " category_name like :category_name " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by category_name asc, category_aid desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                ...$this->category_is_active != "" ? ["category_is_active" => $this->category_is_active] : [],
                ...$this->search != "" ? [
                    "category_name" => "%{$this->search}%",
                ] : [],
            ]);
        } catch (PDOException $e) {
            $query = false;
        }

        return $query;
    }

    public function readLimit()
    {
        try {
            $sql = "select ";
            $sql .= " * ";
            $sql .= " from {$this->tblCategory} ";
            $sql .= " where true ";
            $sql .= $this->category_is_active != "" ? " and category_is_active = :category_is_active " : "";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " category_name like :category_name " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by category_name asc, category_aid desc ";
            $sql .= " limit :start, ";
            $sql .= " :total ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "start" => $this->start - 1,
                "total" => $this->total,
                ...$this->category_is_active != "" ? ["category_is_active" => $this->category_is_active] : [],
                ...$this->search != "" ? [
                    "category_name" => "%{$this->search}%",
                ] : [],
            ]);
        } catch (PDOException $e) {
            returnError($e);
            $query = false;
        }

        return $query;
    }

    public function update()
    {
        try {
            $sql = "update {$this->tblCategory} set ";
            $sql .= "category_name = :category_name, ";
            $sql .= "category_description = :category_description, ";
            $sql .= "category_updated = :category_updated ";
            $sql .= "where category_aid = :category_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "category_name" => $this->category_name,
                "category_description" => $this->category_description,
                "category_updated" => $this->category_updated,
                "category_aid" => $this->category_aid,
            ]);
        } catch (PDOException $e) {
            returnError($e);
            $query = false;
        }

        return $query;
    }

    public function active()
    {
        try {
            $sql = "update {$this->tblCategory} set ";
            $sql .= "category_is_active = :category_is_active, ";
            $sql .= "category_updated = :category_updated ";
            $sql .= "where category_aid = :category_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "category_is_active" => $this->category_is_active,
                "category_updated" => $this->category_updated,
                "category_aid" => $this->category_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }

        return $query;
    }

    public function delete()
    {
        try {
            $sql = "delete from {$this->tblCategory} ";
            $sql .= "where category_aid = :category_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "category_aid" => $this->category_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }

        return $query;
    }

    public function checkName()
    {
        try {
            $sql = "select ";
            $sql .= "category_name ";
            $sql .= "from {$this->tblCategory} ";
            $sql .= "where category_name = :category_name ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "category_name" => $this->category_name,
            ]);
        } catch (PDOException $e) {
            returnError($e);
            $query = false;
        }
        return $query;
    }
}
