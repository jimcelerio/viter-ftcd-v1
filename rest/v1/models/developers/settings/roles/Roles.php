<?php

class Roles
{
    public $role_aid;
    public $role_is_active;
    public $role_name;
    public $role_description;
    public $role_created;
    public $role_updated;

    public $start;
    public $total;
    public $search;

    public $connection;
    public $lastInsertedId;

    public $tblRoles;

    public function __construct($db)
    {
        $this->connection = $db;
        $this->tblRoles = "settings_roles";
    }

    public function create()
    {
        try {
            $sql = "insert into {$this->tblRoles}";
            $sql .= " ( ";
            $sql .= " role_is_active, ";
            $sql .= " role_name, ";
            $sql .= " role_description, ";
            $sql .= " role_created, ";
            $sql .= " role_updated ";
            $sql .= " ) values ( ";
            $sql .= " :role_is_active, ";
            $sql .= " :role_name, ";
            $sql .= " :role_description, ";
            $sql .= " :role_created, ";
            $sql .= " :role_updated ";
            $sql .= " ) ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "role_is_active" => $this->role_is_active,
                "role_name" => $this->role_name,
                "role_description" => $this->role_description,
                "role_created" => $this->role_created,
                "role_updated" => $this->role_updated,
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
            $sql .= " from {$this->tblRoles} ";
            $sql .= " where true ";
            $sql .= $this->role_is_active != "" ? " and role_is_active = :role_is_active " : "";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " role_name like :role_name " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by role_name asc, role_aid desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                ...$this->role_is_active != "" ? ["role_is_active" => $this->role_is_active] : [],
                ...$this->search != "" ? [
                    "role_name" => "%{$this->search}%",
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
            $sql .= " from {$this->tblRoles} ";
            $sql .= " where true ";
            $sql .= $this->role_is_active != "" ? " and role_is_active = :role_is_active " : "";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " role_name like :role_name " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by role_name asc, role_aid desc ";
            $sql .= " limit :start, ";
            $sql .= " :total ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "start" => $this->start - 1,
                "total" => $this->total,
                ...$this->role_is_active != "" ? ["role_is_active" => $this->role_is_active] : [],
                ...$this->search != "" ? [
                    "role_name" => "%{$this->search}%",
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
            $sql = "update {$this->tblRoles} set ";
            $sql .= "role_name = :role_name, ";
            $sql .= "role_description = :role_description, ";
            $sql .= "role_updated = :role_updated ";
            $sql .= "where role_aid = :role_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "role_name" => $this->role_name,
                "role_description" => $this->role_description,
                "role_updated" => $this->role_updated,
                "role_aid" => $this->role_aid,
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
            $sql = "update {$this->tblRoles} set ";
            $sql .= "role_is_active = :role_is_active, ";
            $sql .= "role_updated = :role_updated ";
            $sql .= "where role_aid = :role_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "role_is_active" => $this->role_is_active,
                "role_updated" => $this->role_updated,
                "role_aid" => $this->role_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }

        return $query;
    }

    public function delete()
    {
        try {
            $sql = "delete from {$this->tblRoles} ";
            $sql .= "where role_aid = :role_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "role_aid" => $this->role_aid,
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
            $sql .= "role_name ";
            $sql .= "from {$this->tblRoles} ";
            $sql .= "where role_name = :role_name ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "role_name" => $this->role_name,
            ]);
        } catch (PDOException $e) {
            returnError($e);
            $query = false;
        }
        return $query;
    }
}
