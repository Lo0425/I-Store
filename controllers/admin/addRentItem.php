<?php
require_once '../connection.php';
require_once '../../views/layout2.php';
$itemName = $_POST['itemName'];
$category = $_POST['category'];
$description = $_POST['description'];
$price = $_POST['price'];
$short_description = explode(" ",$description);
$short_description_result = "";

$extensions = ['jpg','jpeg','svg','png','gif'];

$img_name = $_FILES['image']['name'];
$img_size = $_FILES['image']['size'];
$img_tmpname = $_FILES['image']['tmp_name'];

$img_type = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
$is_img = false;

$image_folder = '/public/'.time().'-'.$img_name;

if(in_array($img_type, $extensions)){
    $is_img = true;
}else{
    echo "Please upload an image";
}

if($itemName==""){
    echo "Please enter ItemName";
}


if($is_img && $img_size > 0 && count($short_description)<=10){

    $query = "INSERT INTO inventoryforrent (itemName, Category, description, image, price) VALUES ('$itemName','$category','$description','$image_folder','$price');";
   

} else if($is_img && $img_size > 0 && count($short_description)>10){
    for($i=0; $i<10; $i++){
        $short_description_result .= $short_description[$i]." ";
    }
    $query = "INSERT INTO inventoryforrent (itemName, Category, description, short_description, image, price) VALUES ('$itemName','$category','$description','$short_description_result','$image_folder','$price');";  

}

move_uploaded_file($img_tmpname, '../../public/'.time().'-'.$img_name);
mysqli_query($cn, $query);
mysqli_close($cn);

?>

<script>
Swal.fire({ icon: 'success',
title: 'Product added',
text: '',
}).then(okay => {
if (okay) {
    window.location.href = "/views/shop.php";
}
});

</script>