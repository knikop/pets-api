<?php

namespace Vanier\Api\Models;

class RecordModel extends BaseModel
{
    private $table_name = "record";

    public function __construct(){
        parent::__construct();
    }

    public function getRecordByDate($date_type)
    {
        $sql = "SELECT r.* FROM  $this->table_name AS r WHERE r.entry_id IN
        (SELECT entry_id FROM entry AS e WHERE e.date_type = :date_type)";

        $filters_value[":date_type"] = $date_type;
        //return $this->run($sql, $filters_value)->fetch();
        return $this->paginate($sql, $filters_value);
    }

    public function getAll(array $filters = []) {
        $query_values = [];

        $sql = "SELECT r.*
                FROM $this->table_name AS r
                WHERE 1";

        // address filter
        if (isset($filters["address"])) {
            $sql .= " AND r.address LIKE :address";
            $query_values[":address"] = $filters["address"]."%";
        }

        // city filter
        if (isset($filters["city"])) {
            $sql .= " AND r.city LIKE :city";
            $query_values[":city"] = $filters["city"]."%";
        }

        // state filter
        if (isset($filters["state"])) {
            $sql .= " AND r.state LIKE :state";
            $query_values[":state"] = $filters["state"]."%";
        }

        // postal_code filter
        if (isset($filters["postal_code"])) {
            $sql .= " AND r.postal_code LIKE :postal_code";
            $query_values[":postal_code"] = $filters["postal_code"]."%";
        }
        
        //return $this->run($sql, $query_values)->fetchAll();
        return $this->paginate($sql, $query_values);
    }
}
