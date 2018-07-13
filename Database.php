<?php


class Database
{

	private static $_instance = null;
	private $_connection;

	private function __construct()
	{
		$this->connect();
	}

	/**
	 * Used to connect to mysql using PDO.
	 */
	public function connect()
	{
		try {
			$this->_connection = new PDO('mysql:host=127.0.0.1;dbname=php_530', 'root', 'secret');
			$this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	/**
	 * Follows single pattern to connect the db.
	 * @return Database|null
	 */
	public static function instantiate()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new Database();
		}
		return self::$_instance;
	}


	public function insert(string $tableName, array $columnValues)
	{
		$columns = implode(',', array_keys($columnValues));

		$query = "INSERT INTO {$tableName}({$columns}) VALUES (?";
		for ($i = 1; $i < count($columnValues); $i++) {
			$query .= ',?';
		}
		$query .= ')';


		$stmt = $this->_connection->prepare($query);
		try {
			if ($stmt->execute(array_values($columnValues)))
				return $this->_connection->lastInsertId();
			else
				throw new Exception('Could not insert');

		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}


	public function update(string $tableName, array $columnValues)
	{
		$query = "UPDATE {$tableName} SET ";
		$query .= implode('=?, ', array_keys($columnValues));
		$query .= '=?';
		return $this;

	}

	public function where(array $criteria)
	{

	}

	public
	function delete()
	{

	}

	public
	function select()
	{

	}

	public
	function count()
	{

	}
}

$obj = Database::instantiate();
//echo $obj->insert('users', [
//	'name' => 'shyam',
//	'email' => 'shyam@gmail.com',
//	'pass' => password_hash('secret', PASSWORD_DEFAULT),
//	'gender' => 'male',
//	'lang' => 'nepali,chinese',
//	'about' => 'hello this is shyam'
//]);

$obj->update('users', ['gender' => 'female', 'name' => 'sita', 'email' => 'sita@gmail.com'])->where(['id' => 14]);