<?php

class Donors
{
    public $donor_aid;
    public $donor_is_active;
    public $donor_first_name;
    public $donor_last_name;
    public $donor_birth_date;
    public $donor_age;
    public $donor_residency_status;
    public $donor_donation;
    public $donor_created;
    public $donor_updated;

    public $start;
    public $total;
    public $search;

    public $connection;
    public $lastInsertedId;

    public $tblDonors;

    public function __construct($db)
    {
        $this->connection = $db;
        $this->tblDonors = "donors";
    }

    public function create()
    {
        try {
            $sql = "insert into {$this->tblDonors}";
            $sql .= " ( ";
            $sql .= " donor_is_active, ";
            $sql .= " donor_first_name, ";
            $sql .= " donor_last_name, ";
            $sql .= " donor_birth_date, ";
            $sql .= " donor_age, ";
            $sql .= " donor_residency_status, ";
            $sql .= " donor_donation, ";
            $sql .= " donor_created, ";
            $sql .= " donor_updated ";
            $sql .= " ) values ( ";
            $sql .= " :donor_is_active, ";
            $sql .= " :donor_first_name, ";
            $sql .= " :donor_last_name, ";
            $sql .= " :donor_birth_date, ";
            $sql .= " :donor_age, ";
            $sql .= " :donor_residency_status, ";
            $sql .= " :donor_donation, ";
            $sql .= " :donor_created, ";
            $sql .= " :donor_updated ";
            $sql .= " ) ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "donor_is_active" => $this->donor_is_active,
                "donor_first_name" => $this->donor_first_name,
                "donor_last_name" => $this->donor_last_name,
                "donor_birth_date" => $this->donor_birth_date,
                "donor_age" => $this->donor_age,
                "donor_residency_status" => $this->donor_residency_status,
                "donor_donation" => $this->donor_donation,
                "donor_created" => $this->donor_created,
                "donor_updated" => $this->donor_updated,
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
            $sql .= " from {$this->tblDonors} ";
            $sql .= " where true ";
            $sql .= $this->donor_is_active != "" ? " and donor_is_active = :donor_is_active " : "";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " donor_first_name like :donor_first_name " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by donor_first_name asc, donor_aid desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                ...$this->donor_is_active != "" ? ["donor_is_active" => $this->donor_is_active] : [],
                ...$this->search != "" ? [
                    "donor_first_name" => "%{$this->search}%",
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
            $sql .= " from {$this->tblDonors} ";
            $sql .= " where true ";
            $sql .= $this->donor_is_active != "" ? " and donor_is_active = :donor_is_active " : "";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " donor_first_name like :donor_first_name " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by donor_first_name asc, donor_aid desc ";
            $sql .= " limit :start, ";
            $sql .= " :total ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "start" => $this->start - 1,
                "total" => $this->total,
                ...$this->donor_is_active != "" ? ["donor_is_active" => $this->donor_is_active] : [],
                ...$this->search != "" ? [
                    "donor_first_name" => "%{$this->search}%",
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
            $sql = "update {$this->tblDonors} set ";
            $sql .= "donor_first_name = :donor_first_name, ";
            $sql .= "donor_updated = :donor_updated ";
            $sql .= "where donor_aid = :donor_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "donor_first_name" => $this->donor_first_name,
                "donor_updated" => $this->donor_updated,
                "donor_aid" => $this->donor_aid,
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
            $sql = "update {$this->tblDonors} set ";
            $sql .= "donor_is_active = :donor_is_active, ";
            $sql .= "donor_updated = :donor_updated ";
            $sql .= "where donor_aid = :donor_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "donor_is_active" => $this->donor_is_active,
                "donor_updated" => $this->donor_updated,
                "donor_aid" => $this->donor_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }

        return $query;
    }

    public function delete()
    {
        try {
            $sql = "delete from {$this->tblDonors} ";
            $sql .= "where donor_aid = :donor_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "donor_aid" => $this->donor_aid,
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
            $sql .= "donor_first_name ";
            $sql .= "from {$this->tblDonors} ";
            $sql .= "where donor_first_name = :donor_first_name ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "donor_first_name" => $this->donor_first_name,
            ]);
        } catch (PDOException $e) {
            returnError($e);
            $query = false;
        }
        return $query;
    }
}
