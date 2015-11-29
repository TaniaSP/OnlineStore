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

	public function __construct ($id, $description, $price, $brand, $quantity, $size, $color, $image){
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
    
    public static function ShirtSearch($shirtID){
		$conexion = new mysqli('localhost', 'root', '', 'onlinestore');
 		$query = $conexion->prepare("SELECT `ID`,`Description`,`Price`,`Brand`,`Quantity`,`Size`,`Color`,`Image` FROM `Shirts` Where ID = ?");
		$query->bind_param('i', $shirtID);
		$shirt = new Shirt("","","","","","","", "");
		$query->execute();
		$query->bind_result($shirt->ID,$shirt->Description, $shirt->Price, $shirt->Brand,$shirt->Quantity, $shirt->Size, $shirt->Color, $shirt->Image);
		$query->fetch();
		$query->free_result();
		$conexion->close();
        return $shirt; 
    }  
	
	
    public static function shirtsWithFilters($size, $color, $order, $start, $quant){
		$conexion = new mysqli('localhost', 'root', '', 'onlinestore');
        $sqlOrder = "";
        $query = "";
        if ($order == "desc")
            $sqlOrder = " ORDER BY Price desc";
        else
            $sqlOrder = " ORDER BY Price asc";
		
        if ($size != "" && $color != "")
        {
            $query = $conexion->prepare("SELECT `ID`,`Description`,`Price`,`Brand`,`Quantity`,`Size`,`Color`,`Image` ".
                                "FROM `shirts` WHERE Size = ? and Color = ? and Quantity > 0 $sqlOrder LIMIT ?, ?;");
			$query->bind_param('ssss', $size, $color, $start, $quant);
        }
        else if ($size != "")
        {
            $query = $conexion->prepare("SELECT `ID`,`Description`,`Price`,`Brand`,`Quantity`,`Size`,`Color`,`Image` ".
                                "FROM `shirts` WHERE Size = ? and Quantity > 0 $sqlOrder LIMIT ?, ?;");
			$query->bind_param('sss', $size, $start, $quant);
        }
        else if ($color != "")
        {
            $query = $conexion->prepare("SELECT `ID`,`Description`,`Price`,`Brand`,`Quantity`,`Size`,`Color`,`Image` ".
                                "FROM `shirts` WHERE Color = ? and Quantity > 0 $sqlOrder LIMIT ?, ?;");
			$query->bind_param('sss', $color, $start, $quant);
        }
        else{
            $query = $conexion->prepare("SELECT `ID`,`Description`,`Price`,`Brand`,`Quantity`,`Size`,`Color`,`Image` ".
                                "FROM `shirts` WHERE Quantity > 0 $sqlOrder LIMIT ?, ?;");
			$query->bind_param('ss', $start, $quant);
        }
		$query->execute();
		$query->bind_result($id, $description, $price, $brand, $quantity, $size, $color, $image);
		$id = $description = $price =$brand = $quantity = $size = $color = $image = "";
        $i = 0;
        $table = [];
		while ($query->fetch()){
			$table[$i] = new Shirt($id, $description, $price, $brand, $quantity, $size, $color, $image);
            $i++;
		}

        return $table;
		
		$query->free_result();
		$conexion->close();
    }
    
        
    public static function totalShirts(){
        $total = 0;
		$conexion = new mysqli('localhost', 'root', '', 'onlinestore');
		$query = $conexion->prepare("SELECT COUNT(*) AS 'Total' FROM shirts;");
		$query->execute();
		$query->bind_result($total);
		$query->fetch();
		$query->free_result();
		$conexion->close();
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
 
 
 

