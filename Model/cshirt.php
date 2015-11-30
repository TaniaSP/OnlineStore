<?php
/*******
	cshirt.php
	Class Shirt
	Basic shirt properties and fetch methods
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
    
	# Search a shirt by the shirt ID
    public static function ShirtSearch($shirtID){
		try {
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
		catch (Exeption $e){
			echo $e->errorMessage();
		}
    }  
	
	# Fetch an array of the shirts with the given filters
    public static function shirtsWithFilters($size, $color, $order, $start, $quant){
		try {
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
		catch (Exeption $e){
			echo $e->errorMessage();
		}		
    }
    
    # Get the total count of shirts in the database
    public static function totalShirts(){
		try {
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
		catch (Exeption $e){
			echo $e->errorMessage();
		}
    }
}
?>
 
 
 

