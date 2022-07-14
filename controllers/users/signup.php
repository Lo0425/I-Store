<?php
require_once '../connection.php';
require_once '../../views/layout2.php';

$username = $_POST['username'];
$address = $_POST['address'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$phonenumber = $_POST['phoneNumber'];
$errors = 0;

if(strlen($username)<8 && strlen($password)<8 && $password != $password2){
    ?>
    <script>
      Swal.fire({ icon: 'error',
                title: 'Oops...',
                text: 'Username should be atleast 8 characters, Password should be at least 8 characters, and Password should be match!',
                }).then(okay => {
                if (okay) {
                    window.location.href = "/views/signup.php";
                }
                });

    </script>

    <br>
    <?php
    $errors++;
}else if(strlen($username)<8 && strlen($password)<8){
    ?>
    <script>
    Swal.fire({ icon: 'error',
              title: 'Oops...',
              text: 'Username and Password should be at least 8 characters !',
              }).then(okay => {
              if (okay) {
                  window.location.href = "/views/signup.php";
              }
              });

  </script>
    <?php
    $errors++;
}
    else if(strlen($username)<8){
    ?>
    <script>
    Swal.fire({ icon: 'error',
              title: 'Oops...',
              text: 'Username should be at least 8 characters !',
              }).then(okay => {
              if (okay) {
                  window.location.href = "/views/signup.php";
              }
              });

  </script>

    <br>
    <?php
    $errors++;
} else if(strlen($password)<8){
    ?>
    <script>
    Swal.fire({ icon: 'error',
              title: 'Oops...',
              text: 'Password should be at least 8 characters !',
              }).then(okay => {
              if (okay) {
                  window.location.href = "/views/signup.php";
              }
              });

  </script>

    <br>
    <?php
    $errors++;
} else if($password != $password2){
    ?>
    <script>
    Swal.fire({ icon: 'error',
              title: 'Oops...',
              text: 'Password should be match !',
              }).then(okay => {
              if (okay) {
                  window.location.href = "/views/signup.php";
              }
              });

  </script>

    <br>
    <?php
    $errors++;
}

if($username){
    $query = "SELECT username FROM user WHERE username='$username';";
    $result = mysqli_fetch_assoc(mysqli_query($cn, $query));

    if($result){
        ?>
        <script>
        Swal.fire({ icon: 'error',
            title: 'Oops...',
            text: 'Username is already taken !',
            }).then(okay => {
            if (okay) {
                window.location.href = "/views/signup.php";
            }
            });
        </script>
        <?php
        $errors++;
        mysqli_close($cn);
    }
}

if($errors == 0){
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO user (username, password, address,PhoneNumber) VALUES ('$username','$password','$address','$phonenumber');";

    mysqli_query($cn, $query);
    mysqli_close($cn);
    ?>
    <script>
    Swal.fire({ icon: 'success',
        title: 'Account successfully created',
        text: '',
        }).then(okay => {
        if (okay) {
            window.location.href = "/views/login.php";
        }
        });
    </script>
<?php
}

?>