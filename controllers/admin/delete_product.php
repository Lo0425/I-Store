<?php
require_once '../connection.php';
require_once '../../views/layout2.php';
$id = $_GET['id'];

$query = "DELETE FROM inventoryforsale WHERE id=$id;";
mysqli_query($cn,$query);
mysqli_close($cn);


?>

<script>
Swal.fire({ icon: 'success',
title: 'Product deleted',
text: '',
}).then(okay => {
if (okay) {
    window.location.href = "/views/shop.php";
}
});

</script>