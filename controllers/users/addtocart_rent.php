<?php
require_once '../connection.php';
require_once '../../views/layout2.php';

session_start();
$productId = $_GET['productid'];
$id = $_SESSION['user_info']['id'];
$start_date = $_POST['date_to_rent'];
$end_date = $_POST['date_to_return'];

$query_rent = "SELECT * FROM inventoryforrent WHERE id = $productId;";
$result_rent = mysqli_query($cn, $query_rent);
$rents = mysqli_fetch_assoc($result_rent);

$query_calander = "INSERT INTO rent_item_calander (item_id, start_date, end_date, rentalId, status) VALUES ('$productId','$start_date','$end_date',$id,'Pending');";

mysqli_query($cn, $query_calander);

$query = "UPDATE inventoryforrent SET rentalId = '$id', startDate = '$start_date', endDate = '$end_date' WHERE id = $productId;";

// echo $productId;
mysqli_query($cn, $query);

mysqli_close($cn);
?>
<script>
Swal.fire({ icon: 'success',
          title: 'Payment Successful, inserted to pending list',
          text: 'Welcome to get your item in our centre on <?php echo $start_date?>',
          }).then(okay => {
          if (okay) {
              window.location.href = "/views/rental_shop.php";
          }
          });

</script>



