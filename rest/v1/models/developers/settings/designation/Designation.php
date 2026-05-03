<?php

class Designation
{
    public $designation_aid;
    public $designation_is_active;
    public $designation_name;
    public $designation_category_id;
    public $designation_created;
    public $designation_updated;

    public $start;
    public $total;
    public $search;

    public $connection;
    public $lastInsertedId;

    public $tblDesignation;
    public $tblCategory;

    public function __construct($db)
    {
        $this->connection = $db;
        $this->tblDesignation = "settings_designation";
        $this->tblCategory = "settings_category";
    }

    public function create()
    {
        try {
            $sql = "insert into {$this->tblDesignation}";
            $sql .= " ( ";
            $sql .= " designation_is_active, ";
            $sql .= " designation_name, ";
            $sql .= " designation_category_id, ";
            $sql .= " designation_created, ";
            $sql .= " designation_updated ";
            $sql .= " ) values ( ";
            $sql .= " :designation_is_active, ";
            $sql .= " :designation_name, ";
            $sql .= " :designation_category_id, ";
            $sql .= " :designation_created, ";
            $sql .= " :designation_updated ";
            $sql .= " ) ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "designation_is_active" => $this->designation_is_active,
                "designation_name" => $this->designation_name,
                "designation_category_id" => $this->designation_category_id,
                "designation_created" => $this->designation_created,
                "designation_updated" => $this->designation_updated,
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
            $sql .= " d.*, ";
            $sql .= " c.category_name ";
            $sql .= " from {$this->tblDesignation} d ";
            $sql .= " left join {$this->tblCategory} c on c.category_aid = d.designation_category_id ";
            $sql .= " where true ";
            $sql .= $this->designation_is_active != "" ? " and d.designation_is_active = :designation_is_active " : "";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " d.designation_name like :designation_name " : " ";
            $sql .= $this->search != "" ? " or c.category_name like :category_name " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by d.designation_name asc, d.designation_aid desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                ...$this->designation_is_active != "" ? ["designation_is_active" => $this->designation_is_active] : [],
                ...$this->search != "" ? [
                    "designation_name" => "%{$this->search}%",
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
            $sql .= " d.*, ";
            $sql .= " c.category_name ";
            $sql .= " from {$this->tblDesignation} d ";
            $sql .= " left join {$this->tblCategory} c on c.category_aid = d.designation_category_id ";
            $sql .= " where true ";
            $sql .= $this->designation_is_active != "" ? " and d.designation_is_active = :designation_is_active " : "";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " d.designation_name like :designation_name " : " ";
            $sql .= $this->search != "" ? " or c.category_name like :category_name " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by d.designation_name asc, d.designation_aid desc ";
            $sql .= " limit :start, ";
            $sql .= " :total ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "start" => $this->start - 1,
                "total" => $this->total,
                ...$this->designation_is_active != "" ? ["designation_is_active" => $this->designation_is_active] : [],
                ...$this->search != "" ? [
                    "designation_name" => "%{$this->search}%",
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
            $sql = "update {$this->tblDesignation} set ";
            $sql .= "designation_name = :designation_name, ";
            $sql .= "designation_category_id = :designation_category_id, ";
            $sql .= "designation_updated = :designation_updated ";
            $sql .= "where designation_aid = :designation_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "designation_name" => $this->designation_name,
                "designation_category_id" => $this->designation_category_id,
                "designation_updated" => $this->designation_updated,
                "designation_aid" => $this->designation_aid,
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
            $sql = "update {$this->tblDesignation} set ";
            $sql .= "designation_is_active = :designation_is_active, ";
            $sql .= "designation_updated = :designation_updated ";
            $sql .= "where designation_aid = :designation_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "designation_is_active" => $this->designation_is_active,
                "designation_updated" => $this->designation_updated,
                "designation_aid" => $this->designation_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }

        return $query;
    }

    public function delete()
    {
        try {
            $sql = "delete from {$this->tblDesignation} ";
            $sql .= "where designation_aid = :designation_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "designation_aid" => $this->designation_aid,
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
            $sql .= "designation_name ";
            $sql .= "from {$this->tblDesignation} ";
            $sql .= "where designation_name = :designation_name ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "designation_name" => $this->designation_name,
            ]);
        } catch (PDOException $e) {
            returnError($e);
            $query = false;
        }
        return $query;
    }
}
