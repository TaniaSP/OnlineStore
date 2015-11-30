<?php
/*******
	ccart.php
	Class Cart
	This class functios as the user "shopping cart" of those items selected to buy.
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
    
	# Get the total count of items in the shopping cart
	public static function itemsCount($user) {
		try {
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
		catch (Exeption $e){
			echo $e->errorMessage();
		}
	}
	
	# Add a shirt to the shopping cart
    public static function AddShirt($user, $shirt, $quant)
    {
		try {
			$conexion = new mysqli('localhost', 'root', '', 'onlinestore');
			$query = $conexion->prepare("INSERT INTO `cart` (`idUser`, `idShirt`, `Quantity`) VALUES (?, ?, ?)");
			$query->bind_param('iii', $user, $shirt, $quant); 
			$query->execute();
			$query->fetch();
			$query->free_result();
			$conexion->close();
		}
		catch (Exeption $e){
			echo $e->errorMessage();
		}
    }
}
?>