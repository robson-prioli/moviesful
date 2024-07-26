<?php


class Read extends Conn
{
    private $conn;
    private $read;
    private $result;

    public function __construct()
    {
        $this->conn = $this->getInstance()->getConnection();
    }

    public function getResult(){
        return $this->result;
    }


    private function prepareAndExecute($query, $params = [])
    {
        try {
            $this->read = $this->conn->prepare($query);
            foreach ($params as $key => $value) {
                $this->read->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
            }
            $this->read->execute();
        } catch (PDOException $e) {
            die('Query failed: ' . $e->getMessage());
        }
    }

    public function fullQuery($query, $params = [])
    {
        $this->prepareAndExecute($query, $params);
        $this->result = $this->read->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readBy($table, $conditions = [], $fields = '*')
    {
        $query = "SELECT $fields FROM $table";
        $params = [];
        if (!empty($conditions)) {
            $query .= " WHERE " . $this->buildConditions($conditions, $params);
        }
        $this->prepareAndExecute($query, $params);
        $this->result = $this->read->fetchAll(PDO::FETCH_ASSOC);
    }

    private function buildConditions($conditions, &$params)
    {
        $conditionStr = [];
        foreach ($conditions as $key => $value) {
            $conditionStr[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        return implode(' AND ', $conditionStr);
    }
}
