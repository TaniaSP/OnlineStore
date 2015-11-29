<?php
/*******
cusers.php
	Class Users
	Basic user properties and methods
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
    
    public function ShirtReport(){
        $consulta = mysql_query("SELECT clave, descripcion, marca, marcas.clave as claveMarca, color, precio, imagen FROM playeras, marcas where playera.marca = marcas.clave;", $conexion);
        $valores=[];
        $i=0;
        $html = "<table style='font-family:Calibri;'><tr><th>Id Playera</th>".
                "<th>Nombre</th>".
                "<th>Idd Marca</th>".
                "<th>Marca</th>".
                "<th>Color</th>".
                "<th>Precio</th>".
                "<th>Imagen</th></tr>";
        while ($resultado = mysql_fetch_assoc($consulta))
        {
            $html.="<tr><td>".$resultado['clave']."</td><td>"
                            .$resultado['descripcion']."</td><td>"
                            .$resultado['marca']."</td><td>"
                            .$resultado['claveMarca']."</td><td>"
                            .$resultado['color']."</td><td>"
                            .$resultado['precio']."</td><td>"
                            .$resultado['imagen']."</td></tr>";
        }
        include('mpdf57/mpdf.php');
        $html .= "</table>";
        $mpdf=new mPDF();
        $mpdf->allow_charset_conversion=true;  // Set by default to TRUE
        $mpdf->charset_in='iso-8859-1';
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
        
    public function SearchUser()
    {
		$conexion = new mysqli('localhost', 'root', '', 'onlinestore');
		$query = $conexion->prepare("SELECT `ID`, `Name`, `LastName`, `Email`, `Password`, `Type` FROM `users` WHERE ID = ?");
		$query->bind_param('s', $this->ID);
		$query->execute();
		$query->bind_result($this->ID, $this->Name, $this->LastName, $this->Email, $this->Password, $this->Type);
		$query->fetch();
		$query->free_result();
		$conexion->close();
    }
	
    public function SearchUserByEmail()
    {
		$conexion = new mysqli('localhost', 'root', '', 'onlinestore');
		$query = $conexion->prepare("SELECT `ID`, `Name`, `LastName`, `Email`, `Password`, `Type` FROM `users` WHERE Email = ?");
		$query->bind_param('s', $this->Email);
		$query->execute();
		$query->bind_result($this->ID, $this->Name, $this->LastName, $this->Email, $this->Password, $this->Type);
		$query->fetch();
		$query->free_result();
		$conexion->close();
    }
    
    public function isAdmin()
    {
        if ($this->Type == "Admin")
            return true;
        else
            return false;
    }
    
    public function Access($page){
        $query = mysql_query("SELECT * FROM access, users WHERE Access.Type = users.Type and users.Name = '$this->Name' and access.Type='$this->Type' and Access.Page ='$page';", $Conexion);
                                
        if ($result = mysql_fetch_assoc($query))
        {
            return $result['Type'];
        }
        else
        {
            return false;
        }

    }
    
    public static function AllUsers($type){
        if ($type == 0) $type = "Admin"; else $type="Client";
		
        $consulta = mysql_query("SELECT * FROM users WHERE Type = '$type';", $Conexion);
        $i = 0;
        $table = [];
        while($result = mysql_fetch_assoc($consulta)){
            $table[$i] = new User($result['ID'], $result['Name'], $result['LastName'], $result['Email'], $result['Password'], $result['Type']);
            $i++;
        }
        return $table;
    }
    
    public function InsertUser(){	
		
        if ($this->Type==0) $this->Type = "Admin"; else $this->Type="Client";
		
		$this->Password = md5($this->Name.$this->Password."%#M=");
        $result =mysql_query("INSERT INTO `Users` (`ID`, `Name`,`LastName`, `Email`, `Password`, `Type`) VALUES ('$this->ID', '$this->Name','$this->LastName','$this->Email','$this->Password','$this->Type');", $Conexion);
        if (!$result)
            die("<div id='result-popup'>Error".mysql_error()."<br /> <input type='button' value='Ok' onclick=\"this.parentNode.style.display = 'none'\"; /></div>");
        else
            echo "<div id='result-popup'>Data Saved<input type='button' value='OK' onclick=\"this.parentNode.style.display = 'none'\"; /></div>";
    }
	
    public function Edit(){	
        if ($this->Type==0) $this->Type = "Admin"; else $this->Type="Client";
        $this->Password = md5($this->Name.$this->Password."%#M=");
        $result = mysql_query("UPDATE `Users` SET `Name` = '$this->Name', `LastName` = '$this->LastName', `Type` = '$this->Type' WHERE `ID` = '$this->ID' AND `Email` = '$this->Email';", $Conexion);
        if (!$result)
            die("<div id='result-popup'>Error".mysql_error()."<br /> <input type='button' value='OK' onclick=\"this.parentNode.style.display = 'none'\"; /></div>");
        else
            echo "<div id='result-popup'>Data Saved <input type='button' value='OK' onclick=\"this.parentNode.style.display = 'none'\"; /></div>";
    }
	
    public function Delete(){	
        $result = mysql_query("DELETE FROM `usuario` WHERE idusuario = '$this->idusuario';", $conexion );
        if (!$result)
            die("<div id='result-popup' >Error".mysql_error()."<br /> <input type='button' value='OK' onclick=\"this.parentNode.style.display = 'none'\"; /></div>");
        else
            echo "<div id='result-popup' >Data deleted  <input type='button' value='OK' onclick=\"this.parentNode.style.display = 'none'\"; /></div>";
    }
}
?>