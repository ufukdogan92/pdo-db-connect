<?php
class postgresql extends PDO implements db{   
	public function __construct($host,$db, $user="", $passwd="") {
		$con = "pgsql:dbname=".$db.";host=".$host;
        
		$options = array( 
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", 
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		);
 
		try {
			PDO::__construct($con, $user, $passwd,$options); 
            
		} catch (PDOException $e) {
			$this->error = $e->getMessage();
            echo 'error: '.$this->error;
		}
	}
    
    public function cleanup($bind) {
		if(!is_array($bind)) {
			if(!empty($bind))
				$bind = array($bind);
			else
				$bind = array();
		}
		return $bind;
	}

    public function run($sql, $bind="") {
		$this->sql = trim($sql);
		$this->bind = $this->cleanup($bind);
		$this->error = "";

		try {
			$pdostmt = $this->prepare($this->sql);
			if($pdostmt->execute($this->bind) !== false) {
				if(preg_match("/^(" . implode("|", array("SELECT", "DESCRIBE", "PRAGMA")) . ") /i", $this->sql))
					return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
                elseif(preg_match("/^(" . implode("|", array("INSERT")) . ") /i", $this->sql))
                    return $this->lastInsertId();
                elseif(preg_match("/^(" . implode("|", array("DELETE", "UPDATE")) . ") /i", $this->sql))
                    return $pdostmt->rowCount();

			}	
		} catch (PDOException $e) {
			$this->error = $e->getMessage();
			$this->debug();
			return false;
		}
	}

	
	public function delete($table, $where, $bind="") {
		$sql = "DELETE FROM " . $table . " WHERE " . $where . ";";
        if($debug == 1)echo $sql;
        else return $this->run($sql, $bind);
	}

	public function insert($table, $info) {
		$fields = $this->filter($table, $info);
		$sql = "INSERT INTO " . $table . " (" . implode($fields, ", ") . ") VALUES (:" . implode($fields, ", :") . ");";
		$bind = array();
		foreach($fields as $field)
			$bind[":$field"] = $info[$field];

        return $this->run($sql, $bind);
	}

	

    public function select($table, $where="", $bind="", $fields="*") {
        $sql = "SELECT " . $fields . " FROM " . $table;
        if(!empty($where))
            $sql .= " WHERE " . $where;
        $sql .= ";";
        
        return $this->run($sql, $bind);
    }
 
	public function update($table, $info, $where, $bind="") {
		$fields = $this->filter($table, $info);
		$fieldSize = sizeof($fields);

		$sql = "UPDATE " . $table . " SET ";
		for($f = 0; $f < $fieldSize; ++$f) {
			if($f > 0)
				$sql .= ", ";
			$sql .= $fields[$f] . " = :update_" . $fields[$f]; 
		}
		$sql .= " WHERE " . $where . ";";

		$bind = $this->cleanup($bind);
		foreach($fields as $field)
			$bind[":update_$field"] = $info[$field];

        return $this->run($sql, $bind);
	}
}