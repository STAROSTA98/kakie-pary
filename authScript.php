<?php
        $ip = "localhost";
        $name = "root";
        $pass = "";
        $db = "u1393764_default";

        $link = mysqli_connect($ip, $name, $pass, $db);

        $link->set_charset('UTF8');

        $link != true ? print("Error") : TRUE;
        

        $userlog = $_POST['login'];
        $pass = $_POST['pass'];

        if (!$userlog and !$pass) {

        } else {
            $pass = md5($pass);
            $sql = "SELECT * FROM users WHERE userlog = '$userlog' AND pass='$pass'";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                header('Location: ../admin.html');
                exit();
            } else {
                echo '<label for="exampleInputPassword1" class="form-label" >Неверный логин или пароль</label>';
            }
        }

    ?>