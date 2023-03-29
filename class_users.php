<?php

class Users
{
    private $conn;
    private $table_name = 'tt_users';
    
    public $id;
    public $name;
    public $login;
    public $pass;

    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

    
    function create()
    {
        $query = 'INSERT INTO '. $this->table_name.' (`name`,`login`,`pass`,`created`) VALUES ("new_user","","","'.date('Y-m-d H:i:s').'")';
        $stmt = $this->conn->prepare($query);
        
        // выполняем запрос
        if ($stmt->execute())
        {
            return mysqli_insert_id($this->conn);
        }
        return false;
    }
    function update()
    {
        $query = 'UPDATE '.$this->table_name.' SET name=?, login=?, pass=?, modified=? WHERE `id`=?';
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bind_param("sssss", $this->name, $this->login, $this->pass, $this->modified, $this->id);
        
        if ($stmt->execute())   return true;
        
        return false;
    }
    function read()
    {
        $query = 'SELECT * FROM '.$this->table_name.' ORDER BY `id`';
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->execute();
        
        return $stmt->get_result();
    }
    function readOne()
    {
        $query = 'SELECT * FROM '.$this->table_name.' WHERE `id`='.$this->id.' ORDER BY `id`';
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->execute();
        
        return $stmt->get_result();
    }
    function delete()
    {
        $query = 'DELETE FROM '.$this->table_name.' WHERE `id`='.$this->id.'';
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->execute();
        
        return $stmt->affected_rows;
    }
}