<?php		
class Shirt
{
    public $ID;
    public $Description;
    public $Price;
    public $Brand;
    public $Quantity;
    public $Size;
    public $Color;
    public $Image;

	public function __construct ($conexion, $id, $description, $price,$brand, $quantity, $size, $color, $image){
        $this->Conexion = $conexion;
        $this->ID = $id;
        $this->Description= $description;
        $this->Price = $price;
        $this->Brand = $brand;
        $this->Quantity = $quantity;
        $this->Size= $size;
        $this->Color = $color;
        $this->Image = $imagen;
    }
    
    
    public static function AllShirts ($conexion, $start, $count){
        $query = mysql_query("SELECT `ID`,`Description`,`Price`,`Brand`,`Quantity`,`Size`,`Color`,`Image` ".
                                "FROM `Shirt` WHERE LIMIT $start, $count", $conexion);
        $i = 0;
        $table = [];
        while($result = mysql_fetch_assoc($query)){
            $table[$i] = new Shirt($conexion, $result['ID'], $result['Description'], $result['Price'], 
									$result['Brand'], $result['Quantity'],
                                    $result['Size'], $result['Color'],$result['Image']);
            $i++;
        }
        return $table;
    }
    
    public function ShirtSearch($conexion){
        $query = mysql_query("SELECT `Description`,`Price`,`Department`,`Brand`,`Quantity`,`Size`,`Color`,`Image` ".
                                "FROM `Shirts` Where ID = '$this->ID'", $conexion);
        $shirt = "";
        if($result = mysql_fetch_assoc($query)){
            $shirt = new Shirt($conexion, $result['ID'], $result['Description'], $result['Price'], 
                                    $result['Brand'], $result['Quantity'],
                                    $result['Size'],$result['Color'],$result['Image']);
        }
        return $shirt;
    }  
	
	
    public static function filtroPlayeras($conexion, $departamento, $talla, $color, $orden, $desde, $cant){
        $sqlOrden = "";
        $consulta = "";
        if ($orden == "desc")
            $sqlOrden = " order by precio desc";
        else
            $sqlOrden = " order by precio asc";
        if ($talla != "" && $color != "")
        {
            $consulta = "SELECT `clave`,`descripcion`,`precio`,`departamento`,`marca`,`existencia`,`talla`,`color`,`imagen` ".
                                "FROM `playeras` where departamento = '$departamento' and talla = '$talla' and color = '$color' and existencia > 0 $sqlOrden limit $desde, $cant;";
        }
        else if ($talla != "")
        {
            $consulta = "SELECT `clave`,`descripcion`,`precio`,`departamento`,`marca`,`existencia`,`talla`,`color`,`imagen` ".
                                "FROM `playeras` where departamento = '$departamento' and talla = '$talla' and existencia > 0 $sqlOrden limit $desde, $cant;";
        }
        else if ($color != "")
        {
            $consulta = "SELECT `clave`,`descripcion`,`precio`,`departamento`,`marca`,`existencia`,`talla`,`color`,`imagen` ".
                                "FROM `playeras` where departamento = '$departamento' and color = '$color' and existencia > 0 $sqlOrden limit $desde, $cant;";
        }
        else{
            $consulta = "SELECT `clave`,`descripcion`,`precio`,`departamento`,`marca`,`existencia`,`talla`,`color`,`imagen` ".
                                "FROM `playeras` where departamento = '$departamento' and existencia > 0 $sqlOrden limit $desde, $cant;";
        }
        $i = 0;
        $tabla = [];
        $consulta  = mysql_query($consulta, $conexion);
        while($registro = mysql_fetch_assoc($consulta)){
            $tabla[$i] = new playera($conexion, $registro['clave'], $registro['descripcion'], $registro['precio'], 
                                    $registro['departamento'], $registro['marca'], $registro['existencia'],
                                    $registro['talla'],$registro['color'],$registro['imagen']);
            $i++;
        }
        return $tabla;
    }
    
        
    public static function TotalShirts($conexion){
        $query = mysql_query("SELECT COUNT(*) as Total FROM Shirts;", $conexion);
        $total = 0;
        $table = [];
        while($result = mysql_fetch_assoc($query)){
            $total = $table['Total'];
        }
        return $total;
    }        
    
    public function Insert(){	
        $resultado = mysql_query("INSERT INTO `Shirts` (`Description`,`Price`,`Department`,`Brand`,
                                                        `Quantity`,`Size`,`Color`,`Image`) ".
                                "VALUES ('$this->Description','$this->Price', '$this->Brand',
                                       '$this->Quantity', '$this->Size', '$this->Color', '$this->Image');", $this->Conexion);
        if (!$resultado)
            die("Error ".mysql_error());
        else
            echo "Data Saved";
    }
    public function Edit(){	
        $resultado = mysql_query("UPDATE `Shirt` SET `Description` = '$this->Description',".
                                "`Price` = '$this->Price',`Brand` = '$this->Brand',".
                                "`Quantity` = '$this->Quantity',`Size` = '$this->Size',`Color` = '$this->Color',".
                                "`Image` = '$this->Image' where ID = '$this->ID';", $this->Conexion);
        if (!$resultado)
            die("Error ".mysql_error());
        else
            echo "Data Saved";
    }
    public function Delete(){	
        $resultado = mysql_query("DELETE FROM `Shirt` WHERE ID = '$this->ID';", $this->Conexion );
        if (!$resultado)
            die("Error ".mysql_error());
        else
            echo "Data Deleted";
    }
}
?>
 
 
 

