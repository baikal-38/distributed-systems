<?php

class userRights
{
    private $conn;
    private $table_name = 'tt_user_rights';
    
    public $id;
    public $message;
    public $path;
    public $user_id;

    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

    
    function create()
    {
        $query = 'INSERT INTO '. $this->table_name.' (`user_id`,`message`,`path`,`created`) VALUES (?, "message N...", "c:\", "'.date('Y-m-d H:i:s').'")';
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->user_id);
        
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
        $query = 'SELECT * FROM '.$this->table_name.' WHERE `user_id`=? ORDER BY `id`';
        //error_log($query.'    '.$this->user_id);
        $stmt = $this->conn->prepare($query);
        
        $stmt->bind_param("s", $this->user_id);
        
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