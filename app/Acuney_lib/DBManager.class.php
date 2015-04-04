<?php

namespace Acuney\Lib;

class DBManager
{
	private static $db = null;
	public static $lastError = '';
	public static $checkmode = false;

	/*
	* @param {string} host
	* @param {string} user
	* @param {string} pass
	* @param {string} database
	* @param {string} type
	* @param {string} charset
	*/
	public function __construct($host, $user, $pass, $database, $type = 'mysql', $charset = 'utf8')
	{
		if ( self::$db == null )
		{
			self::$db = new \PDO($type . ':host=' . $host . ';dbname=' . $database . ';charset=' . $charset, $user, $pass);
		}
	}

	/*
	* @param {boolean} state
	*/
	public function setDebugMode($state)
	{
		if ( $state )
		{
			self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->setCheckMode(true);
		}
		else
		{
			self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT);
			$this->setCheckMode(false);
		}
	}

	/*
	* @param {bool} state
	*/
	public function setCheckMode($state)
	{
		self::$checkmode = true;
	}

	public static function availableDrivers()
	{
		return \PDO::getAvailableDrivers();
	}

	/*
	* @param {string} columns
	* @param {string} table
	*/
	public function pluck($column, $table)
	{	
		if ( self::$checkmode && !$this->tableExists($table) )
		{
			self::$lastError = 'Table(' . $table . ') doesn\'t exist in function Acuney\Lib\DBManager::pluck()';
			return false;
		}

		$columns =  explode(',', rtrim(str_replace(' ', '', $column), ','));

		$data = '';

		foreach($columns as $c)
		{
			if ( self::$checkmode && $c != '*' && !$this->columnExists($c, $table) )
			{
				self::$lastError = 'Column(' . $c . ') doesn\'t exist in function Acuney\Lib\DBManager::pluck()';
				return false;
			}

			if ( $column == '*' )
			{
				$data = '*';
			}
			elseif ( !isset($columns[array_search($c,$columns) + 1]) )
			{
				$data .= '`' . $c . '`';
			}
			else
			{
				$data .= '`' . $c . '`,';
			}
		}

		$stmt = self::$db->prepare("
			SELECT " . $data . "
			FROM " . $table
		);
			
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_OBJ);
	}

	/*
	* @param {string} table
	*/
	public function tableExists($table)
	{
		$stmt = self::$db->prepare('SHOW TABLES LIKE :tablename');
		$stmt->bindParam(':tablename', $table);
		$stmt->execute();

		if ( $stmt->rowCount() > 0 )
		{
			return true;
		}
	}

	/*
	* @param {string} column
	* @param {string} table
	*/
	public function columnExists($column, $table)
	{
		if ( self::$checkmode && !$this->tableExists($table) )
		{
			self::$lastError = 'Table(' . $table . ') doesn\'t exist in function Acuney\Lib\DBManager::columnExists()';
			return false;
		}
					
		$stmt = self::$db->prepare('SHOW COLUMNS FROM ' . $table . ' LIKE :column');
		$stmt->bindParam(':column', $column);
		$stmt->execute();


		if ( count ( $stmt->fetchAll() ) > 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/*
	* @param {string} table
	* @param {string} setcolumn
	* @param {string} setvalue
	* @param {array} where
 	*/
	public function update($table, $setcolumn, $setvalue, $where = array())
	{
		if ( self::$checkmode && !$this->columnExists($setcolumn, $table) )
		{
			self::$lastError = 'Column(' . $column . ') doesn\'t exist in function Acuney\Lib\DBManager::update()';
			return false;
		}

		if ( $where == array() )
		{
			self::$db->query("
				UPDATE " . $table . "
				SET " . $setcolumn . "=" . self::$db->quote($setvalue)
			);
		}
		else
		{
			self::$db->query("
				UPDATE " . $table . "
				SET " . $setcolumn . "=" . self::$db->quote($setvalue) . "
				WHERE " . key($where) . "=" . self::$db->quote(end($where))
			);
		}
	}

	public function add($columns = array(), $table)
	{
		if ( self::$checkmode && !$this->tableExists($table) )
		{
			self::$lastError = 'Table(' . $table . ') doesn\'t exist in function Acuney\Lib\DBManager::add()';
			return false;
		}

		if ( $columns == array() )
		{
			self::$lastError = '$columns is an empty array in function Acuney\Lib\DBManager::add()';
			return false;
		}

		$data = '';
		$values = '';
		foreach($columns as $k => $c)
		{	
			if ( self::$lastError && !$this->columnExists(array_search($c, $columns)))
			{
				self::$lastError = 'Column(' . $k. ') doesn\'t exist in function Acuney\Lib\DBManager::add()';
				return false;
			}

			end($columns);

			if ( prev($columns) != $c )
			{
				$data .= array_search($c, $columns);
				$values .= '\'' . $c . '\'';
			}
			else
			{
				$data .= array_search($c, $columns) . ',';
				$values .= '\'' . $c . '\',';
			}

		}

		self::$db->query("
			INSERT INTO " . $table . "(" . $data . ")
			VALUES(" . $values . ")
		");
	}

	public function delete($table, $where = array())
	{
		if ( self::$checkmode && !$this->tableExists($table) )
		{
			self::$lastError = 'Table(' . $table . ') doesn\'t exist in function Acuney\Lib\DBManager::delete()';
			return false;
		}

		if ( $where == array() )
		{
			self::$db->query(
				"DELETE FROM " . $table
			);
		}
		else
		{
			$column = key($where);
			$value = end($where);

			if ( self::$checkmode && !$this->columnExists($column, $table) )
			{
				self::$lastError = 'Column(' . $column . ') doesn\'t exist in function Acuney\Lib\DBManager::add()';
				return false;
			}

			var_dump(self::$db->query(
				"DELETE FROM `" . $table .
				"` WHERE " . $column . "=" . self::$db->quote($value)
			));
		}
	}

	public function closeConnection()
	{
		self::$db = null;
	}
}