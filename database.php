<?php

    class database{
       
 		public $host= DB_HOST;
 		public $username= DB_USER;
 		public $password= DB_PASS;
 		public $db_name= DB_NAME;


        public $link;
        public $error;


        public function __construct(){
            $this->connect();
        }

        public function connect(){
           $this->link=new mysqli($this->host,$this->username,$this->password,$this->db_name);

            if(!$this->link){
                $this->error="connection failed".$this->link->connect_error;
            }
        }

        public function select($query){
            	$result=$this->link->query($query) or die($this->link->error._LINE_);

			if($result->num_rows>0){
				return $result;
			}
			else{
				return false;
			}
        }
		public function row_no($query){
            	$result=$this->link->query($query) or die($this->link->error._LINE_);

			if($result->num_rows>0){
				return $result->num_rows;
			}
			else{
				return 0;
			}
        }

        public function insert($query){
			$insert_row=$this->link->query($query) or die($this->link->error._LINE_);

			//valid insert

			if($insert_row){
				header("location: log_add.php?msg=".'You are registered now');
				exit();
			}
			else{
				die('Error: ('.$this->link->errno.')'.$this->link->error);
			}

		}
		public function insert1($query){
			$insert_row=$this->link->query($query) or die($this->link->error._LINE_);

			//valid insert

			if($insert_row){
				//header("location: log_add.php?msg=".'You are registered now');
				//exit();
			}
			else{
				die('Error: ('.$this->link->errno.')'.$this->link->error);
			}

		}
		public function update($query){
			$update_row=$this->link->query($query) or die($this->link->error._LINE_);

			//valid insert

			if($update_row){
				header("location: profile.php?msg=".urlencode('Record updated'));
				exit();
			}
			else{
				die('Error: ('.$this->link->errno.')'.$this->link->error);
			}

		}
        
    }


?>