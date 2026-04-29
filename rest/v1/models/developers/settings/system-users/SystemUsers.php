<?php

class SystemUsers
{
    public $system_users_aid;
    public $system_users_is_active;
    public $system_users_first_name;
    public $system_users_last_name;
    public $system_users_email;
    public $system_users_role_id;
    public $system_users_created;
    public $system_users_updated;

    public $start;
    public $total;
    public $search;

    public $connection;
    public $lastInsertedId;

    public $tblSystemUsers;
    public $tblRoles;

    public function __construct($db)
    {
        $this->connection = $db;
        $this->tblSystemUsers = "settings_system_users";
        $this->tblRoles = "settings_roles";
    }

    public function create()
    {
        try {
            $sql = "insert into {$this->tblSystemUsers}";
            $sql .= " ( ";
            $sql .= " system_users_is_active, ";
            $sql .= " system_users_first_name, ";
            $sql .= " system_users_last_name, ";
            $sql .= " system_users_email, ";
            $sql .= " system_users_role_id, ";
            $sql .= " system_users_created, ";
            $sql .= " system_users_updated ";
            $sql .= " ) values ( ";
            $sql .= " :system_users_is_active, ";
            $sql .= " :system_users_first_name, ";
            $sql .= " :system_users_last_name, ";
            $sql .= " :system_users_email, ";
            $sql .= " :system_users_role_id, ";
            $sql .= " :system_users_created, ";
            $sql .= " :system_users_updated ";
            $sql .= " ) ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "system_users_is_active" => $this->system_users_is_active,
                "system_users_first_name" => $this->system_users_first_name,
                "system_users_last_name" => $this->system_users_last_name,
                "system_users_email" => $this->system_users_email,
                "system_users_role_id" => $this->system_users_role_id,
                "system_users_created" => $this->system_users_created,
                "system_users_updated" => $this->system_users_updated,
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
            $sql .= " su.*, ";
            $sql .= " r.role_name ";
            $sql .= " from {$this->tblSystemUsers} su ";
            $sql .= " left join {$this->tblRoles} r on r.role_aid = su.system_users_role_id ";
            $sql .= " where true ";
            $sql .= $this->system_users_is_active != "" ? " and su.system_users_is_active = :system_users_is_active " : "";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " su.system_users_first_name like :system_users_first_name " : " ";
            $sql .= $this->search != "" ? " or su.system_users_last_name like :system_users_last_name " : " ";
            $sql .= $this->search != "" ? " or su.system_users_email like :system_users_email " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by su.system_users_first_name asc, su.system_users_aid desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                ...$this->system_users_is_active != "" ? ["system_users_is_active" => $this->system_users_is_active] : [],
                ...$this->search != "" ? [
                    "system_users_first_name" => "%{$this->search}%",
                    "system_users_last_name" => "%{$this->search}%",
                    "system_users_email" => "%{$this->search}%",
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
            $sql .= " su.*, ";
            $sql .= " r.role_name ";
            $sql .= " from {$this->tblSystemUsers} su ";
            $sql .= " left join {$this->tblRoles} r on r.role_aid = su.system_users_role_id ";
            $sql .= " where true ";
            $sql .= $this->system_users_is_active != "" ? " and su.system_users_is_active = :system_users_is_active " : "";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " su.system_users_first_name like :system_users_first_name " : " ";
            $sql .= $this->search != "" ? " or su.system_users_last_name like :system_users_last_name " : " ";
            $sql .= $this->search != "" ? " or su.system_users_email like :system_users_email " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by su.system_users_first_name asc, su.system_users_aid desc ";
            $sql .= " limit :start, ";
            $sql .= " :total ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "start" => $this->start - 1,
                "total" => $this->total,
                ...$this->system_users_is_active != "" ? ["system_users_is_active" => $this->system_users_is_active] : [],
                ...$this->search != "" ? [
                    "system_users_first_name" => "%{$this->search}%",
                    "system_users_last_name" => "%{$this->search}%",
                    "system_users_email" => "%{$this->search}%",
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
            $sql = "update {$this->tblSystemUsers} set ";
            $sql .= "system_users_first_name = :system_users_first_name, ";
            $sql .= "system_users_last_name = :system_users_last_name, ";
            $sql .= "system_users_email = :system_users_email, ";
            $sql .= "system_users_role_id = :system_users_role_id, ";
            $sql .= "system_users_updated = :system_users_updated ";
            $sql .= "where system_users_aid = :system_users_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "system_users_first_name" => $this->system_users_first_name,
                "system_users_last_name" => $this->system_users_last_name,
                "system_users_email" => $this->system_users_email,
                "system_users_role_id" => $this->system_users_role_id,
                "system_users_updated" => $this->system_users_updated,
                "system_users_aid" => $this->system_users_aid,
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
            $sql = "update {$this->tblSystemUsers} set ";
            $sql .= "system_users_is_active = :system_users_is_active, ";
            $sql .= "system_users_updated = :system_users_updated ";
            $sql .= "where system_users_aid = :system_users_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "system_users_is_active" => $this->system_users_is_active,
                "system_users_updated" => $this->system_users_updated,
                "system_users_aid" => $this->system_users_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }

        return $query;
    }

    public function delete()
    {
        try {
            $sql = "delete from {$this->tblSystemUsers} ";
            $sql .= "where system_users_aid = :system_users_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "system_users_aid" => $this->system_users_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }

        return $query;
    }

    public function checkEmail()
    {
        try {
            $sql = "select ";
            $sql .= "system_users_email ";
            $sql .= "from {$this->tblSystemUsers} ";
            $sql .= "where system_users_email = :system_users_email ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "system_users_email" => $this->system_users_email,
            ]);
        } catch (PDOException $e) {
            returnError($e);
            $query = false;
        }
        return $query;
    }
}
