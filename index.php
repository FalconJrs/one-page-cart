<?php
session_start();
$connect = mysqli_connect("localhost", "root", "-QY^HX_+9wARyLzt", "test2");

if(isset($_POST["add_to_cart"]))
{
	if(isset($_SESSION["shopping_cart"]))
	{
		$item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
		if(!in_array($_GET["id"], $item_array_id))
		{
			$count = count($_SESSION["shopping_cart"]);
			$item_array = array(
				'item_id'			=>	$_GET["id"],
				'item_name'			=>	$_POST["hidden_name"],
				'item_price'		=>	$_POST["hidden_price"],
				'item_quantity'		=>	$_POST["quantity"]
			);
			$_SESSION["shopping_cart"][$count] = $item_array;
		}
		else
		{
			echo '<script>alert("Item Already Added")</script>';
		}
	}
	else
	{
		$item_array = array(
			'item_id'			=>	$_GET["id"],
			'item_name'			=>	$_POST["hidden_name"],
			'item_price'		=>	$_POST["hidden_price"],
			'item_quantity'		=>	$_POST["quantity"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
	}
}

if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if($values["item_id"] == $_GET["id"])
			{
				unset($_SESSION["shopping_cart"][$keys]);
				echo '<script>alert("Item Removed")</script>';
				echo '<script>window.location="index.php"</script>';
			}
		}
	}
}

?>


<!DOCTYPE html>
<html>
	<head>
		<title>FalconJrs Cart</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>

		<center> <h3> FalconJrs One page cart (join line then order) </h3>
		<div class="container" >
			<br />
			<br />


			<?php
				$query = "SELECT * FROM tbl_product2 ORDER BY id ASC";
				$result = mysqli_query($connect, $query);
				if(mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_array($result))
					{
				?>
			<div class="col-md-4">
				<form method="post" action="index.php?action=add&id=<?php echo $row["id"]; ?>">
					<div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
						<img src="images/<?php echo $row["image"]; ?>" class="img-responsive" /><br />

						<h4 class="text-info"><?php echo $row["name"]; ?></h4>

						<h4 class="text-danger">$ <?php echo $row["price"]; ?></h4>

						<input type="text" name="quantity" value="1" class="form-control" />

						<input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />

						<input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />

						<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />

					</div>
				</form>
			</div>
			<?php
					}
				}
			?>
			<div style="clear:both"></div>
			<br />
			<h3>Order Details</h3>
			<div class="table-responsive">
				<form action="services/send_line_service.php" method="post" id="form-order">
				<table class="table table-bordered">
					<tr>
						<th width="40%">Item Name</th>
						<th width="10%">Quantity</th>
						<th width="20%">Price</th>
						<th width="15%">Total</th>
						<th width="5%">Action</th>
					</tr>
					<?php
					if(!empty($_SESSION["shopping_cart"]))
					{
						$total = 0;
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
					?>
					<tr>
						<td><?php echo $values["item_name"]; ?>
							<input type="hidden" name="item_name[]" value="<?php echo $values["item_name"]; ?>" >
						</td>
						<td><?php echo $values["item_quantity"]; ?></td>
							<input type="hidden" name="item_quantity[]" value="<?php echo $values["item_quantity"]; ?>" >
						<td>$ <?php echo $values["item_price"]; ?></td>
							<input type="hidden" name="item_price[]" value="<?php echo $values["item_price"]; ?>" >
						<td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
						<td><a href="index.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
							<input type="hidden" name="message[]" value="มีลูกค้าสั่ง <?php echo $values["item_name"]; ?> จำนวน <?php echo $values["item_quantity"]; ?> ชิ้น ราคาชิ้นละ <?php echo $values["item_price"]; ?> $ " >
					</tr>
					<?php
							$total = $total + ($values["item_quantity"] * $values["item_price"]);
						}
					?>
					<tr>
						<td colspan="3" align="right">Total</td>
						<td align="right">$ <?php echo number_format($total, 2); ?>
							<input type="hidden" name="item_total" value="<?php echo number_format($total, 2); ?>" >
						</td>
						<td></td>
					</tr>
					<?php
					}
					?>

				</table>
			</form>
			</div>
		</div>
	</div>
	<br />
	<div style="text-align:center;padding-bottom:10px;margin-top:5px">
	<center>


	<a href="https://line.me/R/ti/g/XBxPiCTuLk" target="_blank"> <h2> Click This Link First -> Join Line Group for take Line Notify </h2> </a>
	<a href="https://line.me/R/ti/g/XBxPiCTuLk" target="_blank"> <h2> กดปุ่ม หรือ แอด QR Code เพื่อเข้าไลน์ จำลองเป็น แม่ค้า เพื่อรับ Message ว่ามีลูกค้าสั่งสินค้า ได้เลย </h2> </a>
	<img src="line.jpg" > <br>


		<a href="https://line.me/R/ti/g/XBxPiCTuLk" target="_blank">
			<button type="button" class="btn btn-secondary btn-block" style="background-color:#233268;color:white;max-width:80% "> <h4 style="text-align:center;font-size:16px;font-weight:bold;font-family:Kanit,sans-serif;">>>>> ONLY Test USER <<<<<  คลิกเข้าไลน์ก่อนน้า
			</h4> </button> </a>
			<br>

			<a href="http://34.87.108.181/web-test2/">
		 		<button type="submit" href="http://34.87.108.181/web-test2/" form="form-order" value="submit" class="btn btn-secondary btn-block" style="background-color:#233268;color:white; max-width:200px"> <h4 style="text-align:center;font-size:16px;font-weight:bold;font-family:Kanit,sans-serif;">สั่งซื้อสินค้า
			</h4> </button>
		</a>
	</form>
	</center>
	</div>


	</body>
</html>

<?php
//If you have use Older PHP Version, Please Uncomment this function for removing error

/*function array_column($array, $column_name)
{
	$output = array();
	foreach($array as $keys => $values)
	{
		$output[] = $values[$column_name];
	}
	return $output;
}*/
?>
