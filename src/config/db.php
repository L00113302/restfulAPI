<?php
    class db{
        // properties
        private $dbhost = 'myproject.chxpcxm6f4vv.eu-west-1.rds.amazonaws.com';
        private $dbuser = 'm4rkglenn';
        private $dbpass = '211230mG';
        private $dbname = 'myProject';

        // connect to bb
        public function connect(){
            $mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname";
            $dbconnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
            $dbconnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbconnection;
        }
    }