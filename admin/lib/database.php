<?php
/*
	OXYLUS Development web framework
	copyright (c) 2002-2011 OXYLUS Development
		web:  www.oxylus-development.com
		mail: support@oxylus-development.com

	$Id: config.php,v 0.0.1 09/03/2003 20:38:15 Exp $
	database manipulation

	contact:
		www.oxylus.ro
		office@oxylus.ro

* database manipulation
*
* @library	Config
* @author	oxylus [OXYLUS.ro <devel@oxylus.ro>]
* @since	PHPBase 0.0.1
*/

// return types
define("DB_RT_ARRAY",0);		// return row as an assoc aray where fieldnames are keys
define("DB_RT_OBJECT",1);		// return row as an object where fieldnames are properties
define("DB_RT_SGLINE",2);
class CDatabase{
	/**
	* database type
	*
	* @var string
	*
	* @access private
	*/
	var $type;

	/**
	* database connection id
	*
	* @var resource
	*
	* @access private
	*/
	var $conn_id;

	/**
	* name of the current selected database
	*
	* @var string
	*
	* @access private
	*/
	var $current_db;

	/**
	* number of queries per session
	*
	* @var int
	*
	* @access private
	*/
	var $num_queries;

	/**
	* specifies if there were any modifications to the database [write queries]
	*
	* @var bool
	*
	* @access private
	*/
	var $modif = FALSE;

	/**
	* description
	*
	* @var type
	*
	* @access type
	*/
	var $cache;
	

	/**
	* initializes module and connects to the database
	*
	* @param array $connect_params connection parameters
	*
	* @return void
	*
	* @acces public
	*
	* @see Connect
	*/
	function CDatabase($connect_params = "") {
		$this->name = "database";

		$this->type = $type;

		if ($connect_params != "")
			$this->Connect($connect_params);

	}

	/**
	* connects to the database
	*
	* @param array $connect_params connection parameters
	*
	* @return void
	*
	* @access public
	*/
	function Connect($connect_params = "") {
		extract($connect_params);
		//resource mysql_connect ( [string server [, string username [, string password [, bool new_link !!! [, int client_flags ]]]]] )
		$this->conn_id = mysql_connect($server,$login,$password,TRUE) or die("CDatabase::Connect() error " . mysql_error($this->conn_id));

		if ($default != "")
			$this->SelectDB($default);
	}

	/**
	* closes the database connection
	*
	* @return void
	*
	* @access public
	*/
	function Close() {
		mysql_close($this->conn_id);
	}	
	
	/**
	* selects and sets the current database
	*
	* @param string $database
	*
	* @return void
	*
	* @access public
	*/
	function SelectDB($database) {
		mysql_select_db($database,$this->conn_id) or die("CDatabase::SelectDB() error");
		$this->current_db = $database;
	}
	
	/**
	* queries the database
	*
	* @param string $query	actual sql query
	*
	* @return resource or NULL
	*
	* @access public
	*/
	function Query($query,$db = "" , $die = true) {//debug($query);
		$this->num_queries++;
		$this->queries[] = $query;
		//$this->SelectDB($this->current_db);/

//		if ($_SERVER["REMOTE_ADDR"] == "172.20.100.3") {
//			echo "SQL: $query <br>";
///		}
		
		if ($db)
			$result = mysql_db_query($db ,$query,$this->conn_id);// or die(mysql_error());
		else
			$result = mysql_query($query,$this->conn_id) or die("\nDB ERROR:" . $query . mysql_error());

		if (in_array(substr($query,0,strpos($query," ")),array("INSERT", "UPDATE", "DELETE")))
			$this->modif = TRUE;

		return $result;
	}

	function FetchObject($result) {
		return mysql_fetch_object($result);
	}

	function FetchRow($result) {
		$data = mysql_fetch_row($result);
		if (is_array($data)) {
			foreach ($data as $key => $val)
				$data[$key] = stripslashes($val);
		}
		return $data;		

	}

	function FetchArray($result,$result_type = MYSQL_ASSOC) {
		$data = mysql_fetch_array($result,$result_type);
		if (is_array($data)) {
			foreach ($data as $key => $val)
				$data[$key] = stripslashes($val);
//			foreach ($data as $key => $val)
				//$data[$key] = utf8_decode(stripslashes($val));
				//$value = $this->utf8->strToUtf8(stripslashes($value) != addslashes($value) ? addslashes($value) : $value);
		}
		return $data;		
	}

	function NumRows($result) {
		return mysql_num_rows($result);
	}

	function AffectedRows() {
		return mysql_affected_rows($this->conn_id);
	}

	function InsertID() {
		return mysql_insert_id($this->conn_id);
	}

	function NumQueries() {
		return $this->num_queries;
	}

	function QFetchObject($query) {
		return $this->FetchObject($this->Query($query));
	}

	function QFetchRow($query) {
		$data = $this->FetchRow($this->Query($query));
		if (is_array($data)) {
			foreach ($data as $key => $val)
				$data[$key] = stripslashes($val);
		}
		return $data;		
	}

	function QFetchArray($query) {
		$data = $this->FetchArray($this->Query($query));

		return $data;		
	}

	/**
	* returns the number of rows from a table based on a certain [optional]
	* where clause
	*
	* @param string $table			table in which to count rows
	* @param string $where_clause	optional where clause [see sql WHERE clause]
	*
	* @return int row count
	*
	* @access public
	*/
	function RowCount($table,$where_clause = "",$what="") {
		$what = $what != "" ? $what : "*" ;
		$result = $this->FetchRow($this->Query("SELECT COUNT({$what}) FROM $table $where_clause;"));
		return $result[0];
	}

	/**
	* fetch an array w/ rows from the database
	*
	* @param resource $result	sql query result
	* @param int $return_type	row return type [can be DB_RT_ARRAY or DB_RT_OBJECT]
	* @param string $key		key the returned array by a certain row field [defaults to ""]
	*
	* @return array with rows or NULL if none fetched
	*
	* @access public
	*/
	function FetchRowArray($result,$return_type = DB_RT_ARRAY,$key = "") {
		$ret_val = array();
		$i = 0;

		// dont panic. its just ternary operators in action :]
		while ($row = (($return_type == DB_RT_ARRAY) ? $this->FetchArray($result) : $this->FetchObject($result)))
			$ret_val[(($key == "") ? $i++ : (($return_type == DB_RT_ARRAY) ? $row["$key"] : $row->$key))] = $row;


		// see if any rows were fetched and return accordingly
		return (count($ret_val) != 0) ? $ret_val : NULL;
	}

	/**
	* FetchRowArray wrapper
	*
	* @param string $query	sql query to send to FetchRowArray
	* @param int $return_type
	* @param string $key
	*
	* @return array
	*
	* @access public
	*
	* @see CDatabase::FetchRowArray
	*/
	function QFetchRowArray($query,$return_type = DB_RT_ARRAY,$key = "") {
		
		if ($return_type == DB_RT_SGLINE) {
			$return_type = 0;
			$change = 1;
		}
		
		$data = $this->FetchRowArray($this->Query($query),$return_type,$key);

		if (($change == 1) && is_array($data)) {
			//okay, lets play
			foreach ($data as $k => $val) {
				$data[$k] = $val[key($val)];
			}
		}		

		return $data;
	}

	/**
	* returns an array w/ the tables fields
	*
	* @param $table database table from which to get rows
	*
	* @return array
	*
	* @access public
	*/
	function GetTableFields($table , $simple = TRUE ) {

		//check if the cache exists
		
		if (is_array($this->cache["fields"][$table])) {
			if ($simple)
				return $this->cache["fields"][$table]["fields"];
			else
				return $this->cache["fields"][$table];
		}
		
		$fields = $this->QFetchRowArray("SHOW FIELDS FROM $table");

		$ret_val = array();
		$ret_type = array();

		foreach ($fields as $field) {

			//remove the field sizes
			if (stristr($field["Type"] , "(")) {
				$field["Type"] = substr($field["Type"] , 0,strpos($field["Type"] ,"("));
			}
			

			$ret_val[$field["Field"]] = $field["Field"];
			$ret_type[$field["Field"]] = $field["Type"];


			if ($field["Extra"] == "auto_increment") {
				$extra["auto"] = $field["Field"];
			}
			
		}

		//save the cache
		$this->cache["fields"][$table] = array(
						"fields" => $ret_val,
						"type" => $ret_type
					);

		if ($simple == TRUE )
			return $ret_val;
		else 
			return array(
					"fields" => $ret_val,
					"type" => $ret_type,
					"extra" => $extra
					);
		

		
	}

	function GetTableField($table , $_field) {

		$fields = $this->QFetchRowArray("SHOW FIELDS FROM `$table`");

		$ret_val = array();

		foreach ($fields as $field)
			if ($field["Field"] == $_field) {
				return $field;
			}
	}


	/**
	* fetches a row from a table based on a certain id using the SELECT SQL query
	*
	* @param string $table		table in which to perform select
	* @param int $id			row id to fetch
	* @param string $fields		comma separated list of row fields to fetch [defaults to `*' all]
	* @param int $return_type	row return type DB_RT_ARRAY|DB_RT_OBJECT [defaults to DB_RT_ARRAY]
	*
	* @return array w/ the fetched data or NULL if id not found
	*
	* @access public
	*/
	function QuerySelectByID($table,$id,$fields = "*",$return_type = DB_RT_ARRAY) {
		// build query
		$query = "SELECT $fields FROM `$table` WHERE `id` = '$id'";

		// fetch row
		return ($return_type == DB_RT_ARRAY) ? $this->QFetchArray($query) : $this->QFetchObject($query);
	}

	/**
	* complex fetch row array w/ WHERE/LIMIT/ORDER SQL clauses and page modifier
	*
	* @param string $table			table to fetch rows from
	* @param string $fields			comma separated list of row fields to fetch
	* @param string $where_clause	SQL WHERE clause [use empty to ignore]
	* @param int $start				limit start
	* @param int $count				number of rows to fetch
	* @param bool $pm				page modifier. if set to TRUE [default] $start becomes the page
	* @param string $order_by		field[s] to order the result by [defaults to void]
	* @param string $order_dir		order direction. can be ASC or DESC [defaults to ASC]
	* @param int $return_type		row return type [DB_RT_ARRAY(default)|DB_RT_OBJECT]
	*
	* @return array w/ fetched rows or NULL
	*
	* @access public
	*/
	function QuerySelectLimit($table,$fields,$where_clause,$start,$count,$pm = TRUE,$order_by = "",$order_dir = "ASC",$return_type = DB_RT_ARRAY) {
		// check if $count is empty just to be safe
		$count = ($count == "") ? 0 : $count;

		// recompute $start if page modifier set
		$_start = ($pm == TRUE) ? ((($start == 0) ? 1 : $start) * $count - $count) : $start;

		// setup order clause
		$order_clause = ($order_by != "") ? "ORDER BY $order_by " . (in_array($order_dir,array("ASC","DESC")) ? "$order_dir " : "") : "";

		// setup where clause
		$where_clause = ($where_clause != "") ? "WHERE $where_clause " : "";

		// limit clause
		$limit_clause = ($start >= 0) ? "LIMIT $_start,$count" : "";
		
		// build query
		$query = "SELECT $fields FROM `$table` {$where_clause}{$order_clause}{$limit_clause}";

		// fetch rows
		return $this->QFetchRowArray($query,$return_type);
	}

	/**
	* builds and performes a SQL INSERT query based on the user data
	*
	* @param string $table	table in which to perform insert
	* @param array $fields	associative array w/ the row fields to be inserted
	*
	* @return void
	*
	* @access public
	*/
	function QueryInsert($table,$fields,$string = false) {
		// first get the tables fields
		$table_fields = $this->GetTableFields($table , false);

		$sql_fields = $this->__prepareFields($table_fields, $fields , TRUE , $all);

		if (is_array($sql_fields["names"])) {

			$sql = "INSERT INTO $table ". 
					"(" . implode("," , $sql_fields["names"]) . ") " . 
					"VALUES( " . implode("," , $sql_fields["values"]) . ");\n";

			if ($string)
				return $string;
			else {
				$this->Query($sql);
				return $this->InsertID();
			}			
		}
	}

	/**
	* builds and performs a SQL UPDATE query based on the user data
	*
	* @param string $table			table in which to perform update
	* @param array $fields			associative array w/ the fields to be updated
	* @param string $where_clause	update where clause [see SQL WHERE clause]
	* @param boolean $fillall		update even the fields which arent in the $fields array
	*
	* @return void
	*
	* @access public
	*/
	function QueryUpdate($table,$fields,$where_clause = null, $all = false) {
		// first get the tables fields
		$table_fields = $this->GetTableFields($table , false);

		$sql_fields = $this->__prepareFields($table_fields, $fields , false, $all);

		if (is_array($sql_fields["names"])) {

			//if the where clause doesnt exist the update based on the autoincrement fields
			if ($where_clause == null) {
				$where_clause = "`" . $table["extra"]["auto"] . "`=" . (int) $fields[$table["extra"]["auto"]] . "";
			}			

			$sql = "UPDATE $table SET ". 
					"" . implode("," , $sql_fields["pairs"]) . " " . 
					"WHERE ($where_clause)";

			if ($string)
				return $string;
			else {
				$this->Query($sql);
			}			
		}
	}

	/**
	* builds and performs a SQL UPDATE query based on the user data
	*
	* @param string $table	table in which to perform update
	* @param array $fields	associative array w/ the fields to be updated
	*
	* @return void
	*
	* @access public
	*/
	function QueryUpdateByID($table,$fields , $all = false) {
		$this->QueryUpdate($table,$fields, null, $all);	
	}

	function QueryDelete($table , $fields , $force = false) {
		$table_fields = $this->GetTableFields($table , false);

		$sql = "";

		//check if its a list of fields with conditions
		if (is_array($fields)) {
			$sql_fields = $this->__prepareFields($table_fields, $fields , false, $all);

			$sql = "DELETE FROM {$table} " . 
				   "WHERE " . implode(" AND " , $sql_fields["pairs"]);
		} else {

			//check if its numeric
			if ((int)$fields) {
				//i supose tha its the extra field, 
				$sql = "DELETE FROM {$table} " . 
					   "WHERE `" . $table_fields["extra"]["auto"] . "`=" . (int)$fields . ";";

			} else {

				if ($fields) {
					// i'll suppose this is the condition, warning if no fields then the entire table will get deleted
					$sql = "DELETE FROM {$table} " . 
							"WHERE $fields";
				} else{
					//if forced
					if ($force === true) {
						$sql = "DELETE FROM {$table} ";
					}					
				}				
			}
		}
		
		//check if the sql exists and then execute
		if ($sql) {
			$this->Query($sql);
		}				
	}
	


	function GetTables() {
		
		//check if the table list was cached
		$tables = is_array($this->cache["tables"]) ? $this->cache["tables"] : $this->QFetchRowArray("SHOW TABLES FROM {$this->current_db}");

		if (is_array($tables)) {
			foreach ($tables as $key => $val) {
				$_tables[] = $val[key($val)];
			}			
		}
		return $_tables;
	}

	/**
	* description
	*
	* @param
	*
	* @return
	*
	* @access
	*/
	function TableExists($table) {
		return in_array($table , $this->GetTables());
	}
	


	/* INTERNAL FUNCTIONS */

	function __prepareFields($table , $fields , $extra = TRUE , $all = false) {

		if (is_array($table["fields"])) {
			foreach ($table["fields"] as $key => $val) {

				//reset the current fields values
				$field = null;

				//check if the key exits
				if (isset($fields[$key])) {

					switch ($table["type"][$key]) {
						case "int":
							$field = (int)$fields[$key];
						break;

						case "float":
							$field = (float)$fields[$key];
						break;

						default:
							$field = $fields[$key];
							//check for add / strip slashes
							if (stripslashes($field) != addslashes($field)) {
								$field = addslashes($field);
							}							

							$field = "'" . $field . "'";
						break;
					}

					//add to the table
					$pairs[$key] = "`$key` = " . $field . "";					
					$names[$key] = $key;
					$values[$key] = $field;
				} else {

#!!! WARNING here i need to check whats the default value for this field

					//check if all the fields needs to be filled in
					if ($all === true) {
						switch ($table["type"][$key]) {
							case "int":
								$field = (int)$fields[$key];
							break;

							case "float":
								$field = (float)$fields[$key];
							break;

							default:
								$field = "'" . $field . "'";
							break;
						}

						$pairs[$key] = "`$key` = " . $field . "";					
						$names[$key] = $key;
						$values[$key] = $field;

					}
					
				}
			}

			//check if i should remove the extra from the pairs
			if (!$extra ) {
				unset($pairs[$table["extra"]["auto"]]);
				unset($names[$table["extra"]["auto"]]);
			}			

			return array(
				"names" => $names,
				"values" => $values,
				"pairs" => $pairs
			);
		}

		return $pairs;
	}
}


/*

History

v0.1
	Added QueryDelete
	Rewrite QueryInsert,QueryUpdate and QueryUpdateByID

v0.0.1
	Core functionality

*/

?>