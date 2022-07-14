<?php 

require_once '../connection.php';
require_once '../../views/layout2.php';
session_start();
$id = $_GET['id'];
$itemName = mysqli_real_escape_string($cn, $_POST['itemName']);
$description = mysqli_real_escape_string($cn, $_POST['description']);
$price = mysqli_real_escape_string($cn, $_POST['price']);


$query_rent_item = "SELECT * FROM inventoryforrent WHERE id=$id;";
$rent_item = mysqli_fetch_assoc(mysqli_query($cn,$query_rent_item));
$short_description = explode(" ",$description);
$short_description_result = "";

if(count($short_description)<=10){
        $query = "UPDATE inventoryforrent SET itemName = '$itemName', description='$description', short_description = '', price = '$price' WHERE id=$id;";
    
}else{
    for($i=0; $i<10; $i++){
        $short_description_result .= $short_description[$i]." ";
    }

    $query="UPDATE inventoryforrent SET itemName = '$itemName', description = '$description', short_description = '$short_description_result', price = '$price' WHERE id = $id;";
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
    window.location.href = "/views/rental_shop.php";
}
});

</script>
