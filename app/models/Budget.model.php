<?php


class Budget extends Project
{
    public function getJobsBudget($sector)
    {
        try {
            $query = "SELECT `jobs`.`id`, `sectors`.`sector_name`,`jobs`.`direct`, `jobs`.`indirect`, `jobs`.`induced`, `jobs`.`total`, `jobs`.`budget_per_total_jobs` FROM `jobs`JOIN `sectors` WHERE `sectors`.`id` = `jobs`.`sector_id` AND `sectors`.`sector_name` = :sector";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([
                ':sector' => $sector
            ]);
            $data = $stmt->fetchAll();
            return $data;
        } catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function getAllJobsBudget()
    {
        try {
            $query = "SELECT `jobs`.`id`, `sectors`.`sector_name`,`jobs`.`direct`, `jobs`.`indirect`, `jobs`.`induced`, `jobs`.`total`, `jobs`.`budget_per_total_jobs` FROM `jobs`JOIN `sectors` WHERE `sectors`.`id` = `jobs`.`sector_id`";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        } catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function getBudget($sector, $date)
    {
        try {
            $query = "SELECT * FROM `budget` JOIN `sectors` WHERE `budget`.`sector` = `sectors`.`id` AND `sectors`.`sector_name` = ? AND `budget`.`year` = ?";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([
                $sector,
                $date
            ]);
            $data = $stmt->fetchAll();
            return $data;
        } catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

    public function getPastBudget($sector, $date)
    {
        try {
            $query = "SELECT * FROM `budget` JOIN `sectors` WHERE `budget`.`sector` = `sectors`.`id` AND `sectors`.`sector_name` = ? AND `budget`.`year` != ?";
            $stmt = $this->connect()->prepare($query);
            $stmt->execute([
                $sector,
                $date
            ]);
            $data = $stmt->fetchAll();
            return $data;
        } catch(PDOException $e){
            return "error=Failed! <br>" . $e->getMessage();
        }
    }

}