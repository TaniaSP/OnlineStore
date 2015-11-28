<?php include('/Model/conexion.php'); ?>
<?php include('/Model/cusers.php');?>
<?php include('/Model/cshirt.php');?>
<?php
	if (!isset($_GET['ajax'])) {
		include('/includes/headerStart.php');
		include('/includes/Header.php');
		include('/includes/NavBar.php');
	}
?>
<?php $conexion = new conexion("127.0.0.1", "root", "", "onlinestore"); ?>

<?php 
$rowindex= -1;
$deleteRow = -1;
$actual = 1;
$start = 0;
$pageNum = 0;
$itemsPerPage = 1;

$size = "";
$color = "";
$order	 = "";

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

if ($size == 'all')
	$size = "";
if ($color == 'all')
	$color = "";

function getShirts($conexion,$size, $color, $order, $start, $itemsPerPage, $actual)
{
	global $rowindex, $pagesQuant;
    $pagesQuant = shirt::totalShirts($conexion->ID);
    $pagesQuant = ceil($pagesQuant/$itemsPerPage);
    if ((($start/$itemsPerPage)+1) > $pagesQuant)
        $start = $pagesQuant;
    $shirts = shirt::shirtsWithFilters($conexion->ID,$size, $color, $order, $start, $itemsPerPage);
    ?>
    <div id="shirts-wrapper" name="wrapperPlayeras">
    <ul id="shirts-list" name="listaPlayeras">
        <?php
        foreach ($shirts as $row){
			echo "<li class='ShirtWrapper' name='ShirtWrapper'>";
                    echo "<a href='shirt.php?&shirt=$row->ID'>";
					echo "<div id='shirt' name='shirt'>";
                    echo "<div id='imageWrapper' name='imageWrapper'>";
                    echo "<img src='$row->Image' alt='$row->Description' width='200' height='200' />";
                    echo "</div>";
                    echo "<div class='shirt-description'>";
                    echo "<p><strong>".$row->Description."</strong></p>";
                    echo "<p>".$row->Price."</p>";
                    echo "<p><a link='#'>Add To Cart</a></p>";
                    echo "</div>";
					echo "</div>";
                    echo "</a>";
			echo "</li>";
			echo "</ul>";
    }
    echo "<div class='pagination'>";    
    if ($actual != 1)
    {
        echo "<input type='button' value='Start'  class='page' onclick=\"AjaxCall('buy','ajax=1&actual=1&start=$start&itemsPerPage=$itemsPerPage', 'shirts-contaier');\" />";
        $act2 = $actual-1;
        echo "<input type='button' value='&laquo;' class='page' onclick=\"AjaxCall('buy','ajax=1&actual=$act2&start=$start&itemsPerPage=$itemsPerPage', 'shirts-contaier');\" />";
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
        echo "<input type='button' class='page' value='End' onclick=\"AjaxCall('buy','ajax=1&start=$start&itemsPerPage=$itemsPerPage&actual=$pagesQuant', 'shirts-container');\" />";
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
		getShirts($conexion,$size,$color,$order, (($actual - 1)*$itemsPerPage), $itemsPerPage, $actual);
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
