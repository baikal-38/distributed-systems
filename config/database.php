<?php

class Database
{
    private $host = "localhost";
    private $db_name = "api_db";
    private $username = "rest_api_test";
    private $password = "sYnTv2QxyD2dVc3Q";
    public $conn;
    
    
    public function getConnection()
    {
        $this->conn = null;
        
        
	if (!$handle = fopen(__DIR__.'/current_ip_db.txt', 'r'))
        {
                error_log('Не могу открыть файл '.__DIR__.'/current_ip_db.txt');
                echo 'Отсутствует конфигурационный файл с параметрами подключения.';
        }
        else
        {
                $this->host = fread($handle, filesize(__DIR__.'/current_ip_db.txt'));
                fclose($handle);
        }
        
        
        try
        {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            //$this->conn = new PDO("mysqli:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }
        catch (PDOException $exception)
        {
            echo "Ошибка подключения: " . $exception->getMessage();
        }

        return $this->conn;
    }
    
    /*
    public function select($query = "" , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query , $params );
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);				
            $stmt->close();
            return $result;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }
    private function executeStatement($query = "" , $params = [])
    {
        try {
            $stmt = $this->connection->prepare( $query );
            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
            if( $params ) {
                $stmt->bind_param($params[0], $params[1]);
            }
            $stmt->execute();
            return $stmt;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }	
    }
    */
}