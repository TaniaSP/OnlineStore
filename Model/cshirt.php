<?php
/*******
	cshirt.php
	Class Shirt
	Basic shirt properties and methods
	@ Tania Soto Pienda
******/
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
        $this->Image = $image;
    }
    
    public static function AllShirts ($conexion, $start, $count){
        $query = mysql_query("SELECT `ID`,`Description`,`Price`,`Brand`,`Quantity`,`Size`,`Color`,`Image` ".
                                "FROM `shirt` WHERE LIMIT $start, $count", $conexion);
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
	
	
    public static function shirtsWithFilters($conexion, $size, $color, $order, $start, $quant){
        $sqlOrder = "";
        $query = "";
        if ($order == "desc")
            $sqlOrder = " ORDER BY Price desc";
        else
            $sqlOrder = " ORDER BY Price asc";
        if ($size != "" && $color != "")
        {
            $query = "SELECT `ID`,`Description`,`Price`,`Brand`,`Quantity`,`Size`,`Color`,`Image` ".
                                "FROM `shirts` WHERE Size = '$size' and Color = '$color' and Quantity > 0 $sqlOrder LIMIT $start, $quant;";
        }
        else if ($size != "")
        {
            $query = "SELECT `ID`,`Description`,`Price`,`Brand`,`Quantity`,`Size`,`Color`,`Image` ".
                                "FROM `shirts` WHERE Size = '$size' and Quantity > 0 $sqlOrder LIMIT $start, $quant;";
        }
        else if ($color != "")
        {
            $query = "SELECT `ID`,`Description`,`Price`,`Brand`,`Quantity`,`Size`,`Color`,`Image` ".
                                "FROM `shirts` WHERE Color = '$color' and Quantity > 0 $sqlOrder LIMIT $start, $quant;";
        }
        else{
            $query = "SELECT `ID`,`Description`,`Price`,`Brand`,`Quantity`,`Size`,`Color`,`Image` ".
                                "FROM `shirts` WHERE Quantity > 0 $sqlOrder LIMIT $start, $quant;";
        }
        $i = 0;
        $table = [];
        $query  = mysql_query($query, $conexion);
        while($result = mysql_fetch_assoc($query)){
            $table[$i] = new Shirt($conexion, $result['ID'], $result['Description'], $result['Price'], 
                                    $result['Brand'], $result['Quantity'],
                                    $result['Size'],$result['Color'],$result['Image']);
            $i++;
        }
        return $table;
    }
    
        
    public static function totalShirts($conexion){
        $query = mysql_query("SELECT COUNT(*) AS 'Total' FROM shirts;", $conexion);
        $total = 0;
        while($result = mysql_fetch_assoc($query)){
            $total = $result['Total'];
        }
        return $total;
    }
	
    
    public function Insert(){	
        $resultado = mysql_query("INSERT INTO `shirts` (`Description`,`Price`,`Department`,`Brand`,
                                                        `Quantity`,`Size`,`Color`,`Image`) ".
                                "VALUES ('$this->Description','$this->Price', '$this->Brand',
                                       '$this->Quantity', '$this->Size', '$this->Color', '$this->Image');", $this->Conexion);
        if (!$resultado)
            die("Error ".mysql_error());
        else
            echo "Data Saved";
    }
    public function Edit(){	
        $resultado = mysql_query("UPDATE `shirts` SET `Description` = '$this->Description',".
                                "`Price` = '$this->Price',`Brand` = '$this->Brand',".
                                "`Quantity` = '$this->Quantity',`Size` = '$this->Size',`Color` = '$this->Color',".
                                "`Image` = '$this->Image' where ID = '$this->ID';", $this->Conexion);
        if (!$resultado)
            die("Error ".mysql_error());
        else
            echo "Data Saved";
    }
    public function Delete(){	
        $resultado = mysql_query("DELETE FROM `shirts` WHERE ID = '$this->ID';", $this->Conexion );
        if (!$resultado)
            die("Error ".mysql_error());
        else
            echo "Data Deleted";
    }
}
?>
 
 
 

