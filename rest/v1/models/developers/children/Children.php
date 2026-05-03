<?php

class Children
{
    public $children_aid;
    public $children_is_active;
    public $children_name;
    public $children_birth_date;
    public $children_story;
    public $children_age;
    public $children_residency;
    public $children_donation_limit;
    public $children_created;
    public $children_updated;

    public $start;
    public $total;
    public $search;

    public $connection;
    public $lastInsertedId;

    public $tblChildren;

    public function __construct($db)
    {
        $this->connection = $db;
        $this->tblChildren = "children";
    }

    public function create()
    {
        try {
            $sql = "insert into {$this->tblChildren}";
            $sql .= " ( ";
            $sql .= " children_is_active, ";
            $sql .= " children_name, ";
            $sql .= " children_birth_date, ";
            $sql .= " children_story, ";
            $sql .= " children_age, ";
            $sql .= " children_residency, ";
            $sql .= " children_donation_limit, ";
            $sql .= " children_created, ";
            $sql .= " children_updated ";
            $sql .= " ) values ( ";
            $sql .= " :children_is_active, ";
            $sql .= " :children_name, ";
            $sql .= " :children_birth_date, ";
            $sql .= " :children_story, ";
            $sql .= " :children_age, ";
            $sql .= " :children_residency, ";
            $sql .= " :children_donation_limit, ";
            $sql .= " :children_created, ";
            $sql .= " :children_updated ";
            $sql .= " ) ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "children_is_active" => $this->children_is_active,
                "children_name" => $this->children_name,
                "children_birth_date" => $this->children_birth_date,
                "children_story" => $this->children_story,
                "children_age" => $this->children_age,
                "children_residency" => $this->children_residency,
                "children_donation_limit" => $this->children_donation_limit,
                "children_created" => $this->children_created,
                "children_updated" => $this->children_updated,
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
            $sql = "select * from {$this->tblChildren} where true ";
            $sql .= $this->children_is_active != "" ? " and children_is_active = :children_is_active " : "";
            $sql .= $this->search != "" ? " and ( children_name like :children_name ) " : " ";
            $sql .= " order by children_name asc, children_aid desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                ...$this->children_is_active != "" ? ["children_is_active" => $this->children_is_active] : [],
                ...$this->search != "" ? ["children_name" => "%{$this->search}%"] : [],
            ]);
        } catch (PDOException $e) {
            $query = false;
        }

        return $query;
    }

    public function readLimit()
    {
        try {
            $sql = "select * from {$this->tblChildren} where true ";
            $sql .= $this->children_is_active != "" ? " and children_is_active = :children_is_active " : "";
            $sql .= $this->search != "" ? " and ( children_name like :children_name ) " : " ";
            $sql .= " order by children_name asc, children_aid desc ";
            $sql .= " limit :start, :total ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "start" => $this->start - 1,
                "total" => $this->total,
                ...$this->children_is_active != "" ? ["children_is_active" => $this->children_is_active] : [],
                ...$this->search != "" ? ["children_name" => "%{$this->search}%"] : [],
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
            $sql = "update {$this->tblChildren} set ";
            $sql .= "children_name = :children_name, ";
            $sql .= "children_birth_date = :children_birth_date, ";
            $sql .= "children_story = :children_story, ";
            $sql .= "children_age = :children_age, ";
            $sql .= "children_residency = :children_residency, ";
            $sql .= "children_donation_limit = :children_donation_limit, ";
            $sql .= "children_updated = :children_updated ";
            $sql .= "where children_aid = :children_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "children_name" => $this->children_name,
                "children_birth_date" => $this->children_birth_date,
                "children_story" => $this->children_story,
                "children_age" => $this->children_age,
                "children_residency" => $this->children_residency,
                "children_donation_limit" => $this->children_donation_limit,
                "children_updated" => $this->children_updated,
                "children_aid" => $this->children_aid,
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
            $sql = "update {$this->tblChildren} set ";
            $sql .= "children_is_active = :children_is_active, ";
            $sql .= "children_updated = :children_updated ";
            $sql .= "where children_aid = :children_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "children_is_active" => $this->children_is_active,
                "children_updated" => $this->children_updated,
                "children_aid" => $this->children_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }

        return $query;
    }

    public function delete()
    {
        try {
            $sql = "delete from {$this->tblChildren} where children_aid = :children_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "children_aid" => $this->children_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }

        return $query;
    }

    public function checkName()
    {
        try {
            $sql = "select children_name from {$this->tblChildren} where children_name = :children_name ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "children_name" => $this->children_name,
            ]);
        } catch (PDOException $e) {
            returnError($e);
            $query = false;
        }
        return $query;
    }
}
