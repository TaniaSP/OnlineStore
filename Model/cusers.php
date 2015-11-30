<?php
/*******
cusers.php
	Class Users
	Basic properties of a user and fetch info methods.
	@ Tania Soto Pienda
******/
class User {
    public $ID;
    public $Name;
    public $LastName;
    public $Email;
    public $Password;
    public $Type;

    public function __construct ($id, $name, $lastName, $email, $password, $type){
        $this->ID = $id;
        $this->Name = $name;
        $this->LastName = $lastName;
        $this->Email = $email;
        $this->Password = $password;
        $this->Type = $type;
    }
    
	# Serch an user by ID number
    public function SearchUser()
    {
		try {
			$conexion = new mysqli('localhost', 'root', '', 'onlinestore');
			$query = $conexion->prepare("SELECT `ID`, `Name`, `LastName`, `Email`, `Password`, `Type` FROM `users` WHERE ID = ?");
			$query->bind_param('s', $this->ID);
			$query->execute();
			$query->bind_result($this->ID, $this->Name, $this->LastName, $this->Email, $this->Password, $this->Type);
			$query->fetch();
			$query->free_result();
			$conexion->close();
		}
		catch (Exeption $e){
			echo $e->errorMessage();
		}
    }
	
	# Serch an user by email
    public function SearchUserByEmail()
    {
		try {
			$conexion = new mysqli('localhost', 'root', '', 'onlinestore');
			$query = $conexion->prepare("SELECT `ID`, `Name`, `LastName`, `Email`, `Password`, `Type` FROM `users` WHERE Email = ?");
			$query->bind_param('s', $this->Email);
			$query->execute();
			$query->bind_result($this->ID, $this->Name, $this->LastName, $this->Email, $this->Password, $this->Type);
			$query->fetch();
			$query->free_result();
			$conexion->close();
		}
		catch (Exeption $e){
			echo $e->errorMessage();
		}
    }
    
	# Asks if instance is an admin or not
    public function isAdmin()
    {
        if ($this->Type == 0)
            return true;
        else
            return false;
    }
}
?>