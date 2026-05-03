<?php

class Donors
{
    public $donor_aid;
    public $donor_is_active;
    public $donor_name;
    public $donor_email;
    public $donor_contact;
    public $donor_address;
    public $donor_city;
    public $donor_state;
    public $donor_country;
    public $donor_zip;
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
            $sql .= " donor_name, ";
            $sql .= " donor_email, ";
            $sql .= " donor_contact, ";
            $sql .= " donor_address, ";
            $sql .= " donor_city, ";
            $sql .= " donor_state, ";
            $sql .= " donor_country, ";
            $sql .= " donor_zip, ";
            $sql .= " donor_created, ";
            $sql .= " donor_updated ";
            $sql .= " ) values ( ";
            $sql .= " :donor_is_active, ";
            $sql .= " :donor_name, ";
            $sql .= " :donor_email, ";
            $sql .= " :donor_contact, ";
            $sql .= " :donor_address, ";
            $sql .= " :donor_city, ";
            $sql .= " :donor_state, ";
            $sql .= " :donor_country, ";
            $sql .= " :donor_zip, ";
            $sql .= " :donor_created, ";
            $sql .= " :donor_updated ";
            $sql .= " ) ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "donor_is_active" => $this->donor_is_active,
                "donor_name" => $this->donor_name,
                "donor_email" => $this->donor_email,
                "donor_contact" => $this->donor_contact,
                "donor_address" => $this->donor_address,
                "donor_city" => $this->donor_city,
                "donor_state" => $this->donor_state,
                "donor_country" => $this->donor_country,
                "donor_zip" => $this->donor_zip,
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
            $sql .= $this->search != "" ? " donor_name like :donor_name " : " ";
            $sql .= $this->search != "" ? " or donor_email like :donor_email " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by donor_name asc, donor_aid desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                ...$this->donor_is_active != "" ? ["donor_is_active" => $this->donor_is_active] : [],
                ...$this->search != "" ? [
                    "donor_name" => "%{$this->search}%",
                    "donor_email" => "%{$this->search}%",
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
            $sql .= $this->search != "" ? " donor_name like :donor_name " : " ";
            $sql .= $this->search != "" ? " or donor_email like :donor_email " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by donor_name asc, donor_aid desc ";
            $sql .= " limit :start, ";
            $sql .= " :total ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "start" => $this->start - 1,
                "total" => $this->total,
                ...$this->donor_is_active != "" ? ["donor_is_active" => $this->donor_is_active] : [],
                ...$this->search != "" ? [
                    "donor_name" => "%{$this->search}%",
                    "donor_email" => "%{$this->search}%",
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
            $sql .= "donor_is_active = :donor_is_active, ";
            $sql .= "donor_name = :donor_name, ";
            $sql .= "donor_email = :donor_email, ";
            $sql .= "donor_contact = :donor_contact, ";
            $sql .= "donor_address = :donor_address, ";
            $sql .= "donor_city = :donor_city, ";
            $sql .= "donor_state = :donor_state, ";
            $sql .= "donor_country = :donor_country, ";
            $sql .= "donor_zip = :donor_zip, ";
            $sql .= "donor_updated = :donor_updated ";
            $sql .= "where donor_aid = :donor_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "donor_is_active" => $this->donor_is_active,
                "donor_name" => $this->donor_name,
                "donor_email" => $this->donor_email,
                "donor_contact" => $this->donor_contact,
                "donor_address" => $this->donor_address,
                "donor_city" => $this->donor_city,
                "donor_state" => $this->donor_state,
                "donor_country" => $this->donor_country,
                "donor_zip" => $this->donor_zip,
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
            $sql .= "donor_name ";
            $sql .= "from {$this->tblDonors} ";
            $sql .= "where donor_name = :donor_name ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "donor_name" => $this->donor_name,
            ]);
        } catch (PDOException $e) {
            returnError($e);
            $query = false;
        }
        return $query;
    }
}
