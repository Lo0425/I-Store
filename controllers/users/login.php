<?php
require_once '../connection.php';
require_once '../../views/layout2.php';
$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM user WHERE username='$username';";
$user = mysqli_fetch_assoc(mysqli_query($cn,$query));

if($user && password_verify($password, $user['password'])){
    session_start();
    $_SESSION['user_info'] = $user;
    mysqli_close($cn);
    // header('Location: /');
    ?>
    <script>
    Swal.fire({ icon: 'success',
              title: 'Welcome to I-STORE !',
              text: '',
              }).then(okay => {
              if (okay) {
                  window.location.href = "/views/shop.php";
              }
              });

  </script>
  <?php
}else{
    ?>
    <script>
      Swal.fire({ icon: 'error',
                title: 'Oops...',
                text: 'Wrong Credentials !',
                }).then(okay => {
                if (okay) {
                    window.location.href = "/index.php";
                }
                });

    </script>

    
<?php
}
?>