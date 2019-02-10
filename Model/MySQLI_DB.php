<?php

class MySQLI_DB implements DbHandler {

    public $table;
    public $handler;

    public function __construct($table) {
        $this->table = $table;
        $this->connect();
    }

    public function connect() {
        $handler = mysqli_connect(__HOST__, __USER__, __PASS__, __DB__);

        if ($handler) {
            $this->handler = $handler;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_data($fields = array(), $start = 0) {
        if (empty($fields)) {
            $sql = "select * from $this->table";
        } else {
            $sql = "select ";
            foreach ($fields as $field) {
                $sql .= "$field,";
            }

            $sql .= " from $this->table ";
            $sql .= "LIMIT " . __RECORDS_PER_PAGE__;
            $sql .= " offset $start";
            $sql = str_replace(", from", " from", $sql);
        }

        $arr_result = $this->get_result($sql);
        $this->disconnect();
        return $arr_result;
    }

    public function disconnect() {
        if ($this->handler) {
            mysqli_close($this->handler);
        }
    }
    
    public function get_record_by_id($id, $primary_key) {
        $sql = "select * from $this->table where $primary_key = $id";

        $arr_result = $this->get_result($sql);
        $this->disconnect();
        return $arr_result;
    }
    
     public function check_userName($username) {
        $sql = "select id from $this->table where username = '".$username."'";
        $arr_result = $this->get_result($sql);
        $this->disconnect();
        echo $arr_result;
        if(sizeof($arr_result)>1){
            return FALSE;
        } else {
            return TRUE;
        }
        
    }

    
    
    
    
    public function get_user_id_by_userName($username) {
        $sql = "select id from $this->table where username = '".$username."'";
        echo "<h2>SQL : ==== $sql</h2>";
        $arr_result = $this->get_result($sql);
        $this->disconnect();
        echo $arr_result;
        print_r($arr_result);
        return $arr_result;
    }

    private function get_result($sql) {
//        if (__DEBUG_MODE__===1)
//        {
        //   echo $sql;
        $arr_result = [];
        $result_handler = mysqli_query($this->handler, $sql);
        //echo 'testtttt'.$result_handler;
        while ($row = mysqli_fetch_array($result_handler, MYSQLI_ASSOC)) {
            $arr_result [] = array_change_key_case($row);
        }


//        }
        return $arr_result;
    }

    public function check_login($username, $password) {
        $pass = hash('sha256', $password);
        //echo hash('sha256', $password);
        echo $password . "<br>";
        trim($pass);
        $sql = "SELECT * FROM  $this->table WHERE userName='{$username}' AND password='{$pass}' ";
        //echo $sql;

        $arr_result = $this->get_result($sql);
        $this->disconnect();
        return $arr_result;
    }

//    public function sign_up(){
//        
//      $sql = "SELECT * FROM $this->table WHERE userName=`$username` AND password=`$pass` ";
//      
//    }
//  that function ill be added in   Admin Class

    public function get_all_users($start = 0) {
        $arr_result = [];
        $sql = "select * from $this->table where is_admin = 0";
        $sql .= " ";
        $sql .= "LIMIT " . __RECORDS_PER_PAGE__;
        $sql .= " offset $start";

        $arr_result = $this->get_result($sql);
        $this->disconnect();
        return $arr_result;
    }

//    public function get_users_count() {
//
//        $sql = "select * from $this->table where is_admin = 0";
//        echo '<br>';
//        echo $sql;
//        echo '<br>';
//        $num_rows = 0;
//        $result = $this->get_result($sql);
//        $num_rows = mysqli_num_rows($result);
//        $this->disconnect();
//
//
//        return $num_rows;
//    }


    public function set_record($fields = array(), $values) {

        $sql = "insert into $this->table (";
        if (isset($fields) && !empty($fields)) {

            foreach ($fields as $col) {
                $sql .= "$col ,";
            }
            $sql .= ")";
            $sql = str_replace(",)", ")", $sql);
        } else {
            $sql .= "name,userName,password,job,img,cv,is_admin)";
        }
        $sql .= "values (";
        foreach ($values as $val) {
            $sql .= "$val,";
        }
        $sql .= ")";
        $sql = str_replace(",)", ")", $sql);
        //$result=$conn->query($sql);
        $result = mysqli_query($this->handler, $sql);
        return $result;
    }

    ///////////////////////////////////////////// update statement 

    public function update_record($CV = array(), $id) {
        
        $this->connect();
       
        
        print_r("cvvvvvvvvvvvvv = $CV");
        if ($CV != null) {
            $columns = '';
            $x = 1;
            foreach ($CV as $key => $value) {
                $columns .= "$key ='$value'";
                if ($x < count($CV)) {
                    $columns .= ",";
                }
                $x++;
            }

            $sql = "UPDATE $this->table SET $columns WHERE id = $id and is_admin=0";
           // $sql = str_replace("userName","username", $sql);
            echo $sql;
            $result = mysqli_query($this->handler, $sql);

            if ($result)
                return true;
            else
                return false;
        }
        return false;
    }
    
     public function insert_record( $CV = array()) {
        echo 'nnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn';
        print_r("cv = $CV");
       
        if ($CV != null) {
            
            $columns = '(';
            $values = '(';
            $x = 1;
            foreach ($CV as $key => $value) {
                $columns .= "$key ";
                $values .= "'$value '";
                if ($x < count($CV)) {
                    $columns .= ",";
                    $values .= ",";
                }
                $x++;
            } 
            $columns .=")";
            $values  .=")";
            
            
            $sql="insert into $this->table  $columns values $values";
            echo $sql;
            $result = mysqli_query($this->handler, $sql);
        
            echo 'insert function';
            
            if ($result)
                return true;
            else
                return false;
        }
        return false;
    }


}
