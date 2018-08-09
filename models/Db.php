<?php  
	interface Db{
		 
		public function run($sql, $bind);
		public function cleanup($bind);
		public function delete($table, $where, $bind);
		public function insert($table, $info);
		public function select($table, $where, $bind, $fields); 

	}