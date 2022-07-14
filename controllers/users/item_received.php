<?php
require_once '../connection.php';
require_once '../../views/layout2.php';

session_start();
$id = $_GET['id'];
$user_id = $_SESSION['user_info']['id'];

$query = "UPDATE order_detail SET status = 'Received'  WHERE id=$id;";
mysqli_query($cn,$query);

$query_read = "SELECT * FROM cart_items;";
$read_result = mysqli_query($cn,$query_read);
$read = mysqli_fetch_all($read_result, MYSQLI_ASSOC);

if(count($read)==0){
    $delete_query = "DELETE FROM cart WHERE user_id=$user_id;";
    mysqli_query($cn,$delete_query);
}

mysqli_close($cn);

?>
<script>
Swal.fire({ icon: 'success',
    title: 'Item Received',
    text: 'Status Updated',
    }).then(okay => {
    if (okay) {
        window.location.href = "/views/purchase_history.php";
    }
    });

</script>


?>