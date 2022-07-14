<?php 

require_once '../connection.php';
require_once '../../views/layout2.php';
session_start();
$id = $_GET['id'];
$itemName = mysqli_real_escape_string($cn, $_POST['itemName']);
$description = mysqli_real_escape_string($cn, $_POST['description']);
$price = mysqli_real_escape_string($cn, $_POST['price']);
$qty = mysqli_real_escape_string($cn, $_POST['qty']);

if(isset($_POST['shirt_size'])){
    $size = mysqli_real_escape_string($cn, $_POST['shirt_size']);
}


$query_sale_item = "SELECT * FROM inventoryforsale WHERE id=$id;";
$sale_item = mysqli_fetch_assoc(mysqli_query($cn,$query_sale_item));
$short_description = explode(" ",$description);
$short_description_result = "";

if(count($short_description)<=10){
    if(!isset($_POST['shirt_size'])){
        $query = "UPDATE inventoryforsale SET itemName = '$itemName', description='$description', short_description = '', price = '$price' ,Quantity = '$qty' WHERE id=$id;";
    }else{
        $change_size = $_POST['shirt_size'];
        $query = "UPDATE inventoryforsale SET itemName = '$itemName', description='$description', short_description = '', price = '$price' ,Quantity = '$qty',size='$change_size' WHERE id=$id;";
    }
}else{
    for($i=0; $i<10; $i++){
        $short_description_result .= $short_description[$i]." ";
    }

    if(!isset($_POST['SHIRT_SIZE'])){
        $query="UPDATE inventoryforsale SET itemName = '$itemName', description = '$description', short_description = '$short_description_result', price = '$price' ,Quantity = '$qty' WHERE id = $id;";
    }else{
        $change_size = $_POST['shirt_size'];
        $query="UPDATE inventoryforsale SET itemName = '$itemName', description = '$description', short_description = '$short_description_result', price = '$price' ,Quantity = '$qty',size='$change_size' WHERE id = $id;";
    }
}


mysqli_query($cn, $query);
mysqli_close($cn);
?>

<script>
Swal.fire({ icon: 'success',
title: 'Product edited',
text: '',
}).then(okay => {
if (okay) {
    window.location.href = "/views/shop.php";
}
});

</script>
