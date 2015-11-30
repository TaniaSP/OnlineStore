<?php 
#the user can view the available shirts to buy here, also the user can add a shirt to the shopping cart and filter the data.
?>

<?php include('/Includes/mainIncludes.php'); ?>

<?php
if (!isset($_GET['ajax'])) {
	include('/includes/headerStart.php');
	include('/includes/Header.php');
	include('/includes/NavBar.php');
}
else {
	session_start();
}


$actual = 1;
$start = 0;
$pageNum = 0;
$itemsPerPage = 4;
$user = "";
$size = "";
$color = "";
$order	 = "";

# get the filters from an Ajax call
if (isset($_GET['color']))
	$color = $_GET['color'];
if (isset($_GET['size']))
	$size = $_GET['size'];
if (isset($_GET['order']))
	$order = $_GET['order'];
if (isset($_GET['start']))
	$start = $_GET['start'];
if (isset($_GET['actual']))
	$actual = $_GET['actual'];
if (isset($_GET['itemsPerPage']))
	$itemsPerPage = $_GET['itemsPerPage'];

# ask if there is a user in a session
if(isset($_SESSION['myuser'])) {
	$user = $_SESSION['myuser']; 
}

if ($size == 'all')
	$size = "";
if ($color == 'all')
	$color = "";

# add a shirt to the shopping cart
if (isset($_GET['addtocart'])) {
	$userID = $_GET['user'];
	$shirtQuant =  $_GET['quant'];
	$shirtID =  $_GET['shirt'];
	Cart::AddShirt($userID, $shirtID, $shirtQuant);
}

# this function gets all the shirts with the provided filters
function getShirts($size, $color, $order, $start, $itemsPerPage, $actual)
{
	global $pagesQuant;
    $pagesQuant = shirt::totalShirts();
    $pagesQuant = ceil($pagesQuant/$itemsPerPage);
    if ((($start/$itemsPerPage)+1) > $pagesQuant)
        $start = $pagesQuant;
    $shirts = shirt::shirtsWithFilters($size, $color, $order, $start, $itemsPerPage);
    ?>
    <div id="shirts-wrapper">
    <ul id="shirts-list">
        <?php
        foreach ($shirts as $row){
			echo "<li class='ShirtWrapper' name='ShirtWrapper'>";
                    echo "<a href='shirt.php?shirtID=$row->ID'>";
					echo "<div id='shirt' name='shirt'>";
                    echo "<div id='imageWrapper' name='imageWrapper'>";
                    echo "<img src='$row->Image' alt='$row->Description' width='200' height='200' />";
                    echo "</div>";
                    echo "<div class='shirt-description'>";
                    echo "<p><strong>".$row->Description."</strong></p>";
                    echo "<p>".$row->Price."</p>";
                    echo "</a>";
                    echo "<p><input type='number' name='shirt$row->ID' id='shirt$row->ID' value='1' />";
					if(isset($_SESSION['myuser'])) {
						$user = $_SESSION['myuser']; 
						echo "<a href='#' onclick=\"AjaxCall('buy','ajax=1&addtocart=1&shirt=$row->ID&user=$user->ID&quant='+shirt$row->ID.value, 'shirts-container');\" >Add To Cart</a></p>";
					}
					else
						echo "<a href='/login.php' >Add To Cart</a></p>";
                    echo "</div>";
					echo "</div>";
			echo "</li>";
    }
	echo "</ul>";
    echo "<div class='pagination'>";    
    if ($actual != 1)
    {
        echo "<input type='button' value='First'  class='page' onclick=\"AjaxCall('buy','ajax=1&actual=1&start=$start&itemsPerPage=$itemsPerPage', 'shirts-container');\" />";
        $act2 = $actual-1;
        echo "<input type='button' value='&laquo;' class='page' onclick=\"AjaxCall('buy','ajax=1&actual=$act2&start=$start&itemsPerPage=$itemsPerPage', 'shirts-container');\" />";
    }
    if ($actual > 2){
        $actual--;
        $actual--;
        echo '<span class="page">...</span>';
        echo "<input type='button' class='page' value=$actual onclick=\"AjaxCall('buy','ajax=1&start=$start&itemsPerPage=$itemsPerPage&actual='+this.value, 'shirts-container');\" />"; 
        $actual++;
        $actual++;
    }
    if($actual > 1){
        $actual--;
        echo "<input type='button' class='page' value=$actual onclick=\"AjaxCall('buy','ajax=1&start=$start&itemsPerPage=$itemsPerPage&actual='+this.value, 'shirts-container');\" />";
        $actual++;  
    }
    echo "<span class='page active' >".$actual."</span>";
    $act2 = $actual + 1;
    if ($actual < $pagesQuant){
        $actual++;
        if ($actual< $pagesQuant){
            echo "<input type='button' class='page' value=$actual onclick=\"AjaxCall('buy','ajax=1&start=$start&itemsPerPage=$itemsPerPage&actual='+this.value, 'shirts-container');\" />";
            $actual++;  
            echo "<input type='button' class='page' value=$actual onclick=\"AjaxCall('buy','ajax=1&start=$start&itemsPerPage=$itemsPerPage&actual='+this.value, 'shirts-container');\" />";
            echo '<span class="page">...</span>';
        }
        else{
            echo "<input type='button' class='page' value=$actual onclick=\"AjaxCall('buy','ajax=1&start=$start&itemsPerPage=$itemsPerPage&actual='+this.value, 'shirts-container');\" />";
        }
        echo "<input type='button' class='page' value='&raquo;' onclick=\"AjaxCall('buy','ajax=1&start=$start&itemsPerPage=$itemsPerPage&actual=$act2', 'shirts-container');\" />";
        echo "<input type='button' class='page' value='Last' onclick=\"AjaxCall('buy','ajax=1&start=$start&itemsPerPage=$itemsPerPage&actual=$pagesQuant', 'shirts-container');\" />";
    }
    echo "</div>";
    ?>
    </div>
    <?php
}    
?>

<?php 
if (!isset($_GET['ajax'])) {
?>
<div class="content">
	<h1>Buy Shirts</h1>
	<div class="filters">
<?php echo "<select name='size1' id='size1' class='combobox' onchange=\"AjaxCall('buy','showTable=1&ajax=1&itemsPerPage=$itemsPerPage&actual=$actual&start=$start&size='+size1.value+'&color='+color.value+'&order='+order.value,'shirts-container')\" >";  ?>
			<option value="all">Size</option>
			<option value="S">S</option>
			<option value="M">M</option>
			<option value="L">L</option>
			<option value="XL">XL</option>
		</select>
<?php echo "<select name='color' id='color' class='combobox' onchange=\"AjaxCall('buy','showTable=1&ajax=1&itemsPerPage=$itemsPerPage&actual=$actual&start=$start&size='+size1.value+'&color='+color.value+'&order='+order.value,'shirts-container')\" >";  ?>
			<option value="all">Color</option>
			<option value="red">red</option>
			<option value="blue">blue</option>
			<option value="black">black</option>
			<option value="white">white</option>
		</select>
<?php echo "<select name='order' id='order' class='combobox' onchange=\"AjaxCall('buy','showTable=1&ajax=1&itemsPerPage=$itemsPerPage&actual=$actual&start=$start&size='+size1.value+'&color='+color.value+'&order='+order.value,'shirts-container')\" >";  ?>
			<option value="asc">Price $$ &gt; $$</option>
			<option value="desc">Price $$ &lt; $$</option>
		</select>
	</div>
<?php } ?>
	<div id="shirts-container">
	<?php 
		getShirts($size,$color,$order, (($actual - 1)*$itemsPerPage), $itemsPerPage, $actual);
	?>
	</div>
<?php 
if (!isset($_GET['ajax'])) {
	echo "</div>";

	include ('/includes/Footer.php'); 
}
?>

</body>
</html>
