<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" lang="ru">
    <link rel="stylesheet" href="css/reset.css">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <h4 class="sssaaw">Учебный план</h4>
    <div class="container-fluid">
        <div class="row">
            <nav class="groups navbar navbar-expand-lg border">
                <ul class="navbar-nav navGroup">
                    <?php
                            $ip = "localhost";
                            $name = "root";
                            $pass = "";
                            $db = "u1393764_default";

                            $link = mysqli_connect($ip, $name, $pass, $db);

                            $link->set_charset('UTF8');

                            $link != true ? print("Error") : TRUE;

                            $sql = "SELECT * FROM groups";

                            $result = mysqli_query($link, $sql);

                            while ($row = mysqli_fetch_assoc($result)){
                                echo '<li class="nav-link rounded sqlGroup">'.$row['ID'].'</li>';
                            }
                        ?>
            </nav>
        </div>
        <div class="row ">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Предмет</th>
                        <th scope="col">Год</th>
                        <th scope="col">Семестр</th>
                        <th scope="col">Лекции</th>
                    </tr>
                </thead>
                <tbody class="groupPlan">


                </tbody>
                

            </table>

        </div>
        <div class="d-flex justify-content-end edtPlan">
            
        </div>
        <div class="d-flex justify-content-end">
            <button id="addPlan" class="btn btn-primary">Добавить</button>
        </div>
    </div>

    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>

    
</body>

</html>