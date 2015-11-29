<?php
/*******
	ccart.php
	Class Cart
	-
	@ Tania Soto Pienda
******/
class Cart {
    public $Shirt;
    public $Price;
    public $Quantity;
    public $User;
    public $Image;
    public $Description;
    
    public function __construct ($description, $image, $shirt, $price, $quantity, $user){
        $this->Description = $description;
        $this->Image = $image;
        $this->Price = $price;
        $this->Shirt = $shirt;
        $this->Quantity = $quantity;
        $this->User = $user;
    }
    
    public static function getShoppingCart($user){
        $query = mysql_query("SELECT `Description`,`Image`,`shirts`.`ID` as 'Shirt', `Price`,`Quantity`,`cart`.`idUser` ".
                                "FROM `shirts`, `cart`, `users` WHERE `cart`.`idShirt` = `shirts`.`ID` AND `cart`.`idUser` = '$user'");
        $i = 0;
        $table = [];
        while($result = mysql_fetch_assoc($query)){
            $table[$i] = new Cart ($result['Description'], $result['Image'], $result['Shirt'], 
                                    $result['Price'], $result['Quantity'], $result['idUser']);
            $i++;
        }
        return $table;
    }
	
	public static function itemsCount($user) {
		$total = 0;
		$conexion = new mysqli('localhost', 'root', '', 'onlinestore');
		$query = $conexion->prepare("SELECT COUNT(*) AS 'Total' FROM cart WHERE `cart`.`idUser` = ?");
		$query->bind_param('s', $user);
		$query->execute();
		$query->bind_result($total);
		$query->fetch();
		$query->free_result();
		$conexion->close();
		return $total;
	}
	
    public static function AddShirt($user, $shirt, $quant)
    {
		echo "tania";
		$conexion = new mysqli('localhost', 'root', '', 'onlinestore');
		$query = $conexion->prepare("INSERT INTO `cart` (`idUser`, `idShirt`, `Quantity`) VALUES (?, ?, ?)");
		$query->bind_param('iii', $user, $shirt, $quant); 
		echo $user;
		echo $shirt;
		echo $quant;
		$query->execute();
		$query->fetch();
		$query->free_result();
		$conexion->close();
    }
    public function updateQuantity()
    {
        $query= mysql_query("UPDATE `cart` set Quantity='$this->Quantity' WHERE idUser='$this->User'",$this->Conexion);
    }
    public function removeShirt()
    {
        $query= mysql_query("DELETE FROM `cart` WHERE idUser='$this->User' AND Shirt='$this->Shirt'",$this->Conexion);
    }   
}
?>