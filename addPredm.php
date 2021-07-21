<?php
    include "database.php";

    
    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" lang="ru">
    <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/jquery-ui.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/bootstrap.css">
    <title>Предметы</title>
</head>
<body>
    <h4 class="py-4">Предметы</h4>
    <div class="d-flex justify-content-end">
        <button id="openAddPredm" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Добавить</button>
    </div>

    <form id="content">
        <div class="form-group container-fluids">
            <div class="row">
                <div class="col">
                    <p>Поиск</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <input class="" type="text" id="textAdd">
                </div>
            </div>
        </div>
    </form>


<!-- модальное окно изменения данных -->
    <div class="modal fade" id="myModalUpdPredm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-1">
                    Предмет
                    <button class="btn-close closePredm" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form class="addPrepUpd" method="post">
                        <div class="mb-3">
                            <label>Название </label>
                            <br><input type="text" class="form-control" id="titleUpd"></input>
                        </div>
                    </form>

                </div>
                <div class="modal-footer py-1">
                    <button type="submit" class="btn btn-primary" id="updPredmBtn">Изменить</button>
                    <button class="btn btn-secondary closePredm" data-bs-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
<!-- модальное окно добавления данных -->
    <div class="modal fade" id="myModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-1">
                    Предмет
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body py-2">
                    <form class="addPredm">
                        <div class="my-2">
                            <label class="required">Название</label>
                            <br><input type="text" class="form-control" id="title"></input>
                        </div>
                        
                        <div class="my-2">
                            <label>Преподаватель</label> 
                            <br><input type="text" class="form-control ui-widget" id="prep2"></input>
                        </div>
                    </form>
                </div>
                <div class="modal-footer py-1">
                    <button type="submit" class="btn btn-primary" id="addPredmBtn">Добавить</button>
                    <button class = "btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                </div>    
            </div>  
        </div>         
    </div>
    <div class="container-fluids">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Название</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="tablePredm">
                <?php
                $ip = "localhost";
                $name = "root";
                $pass = "";
                $db = "u1393764_default";
            
                $link = mysqli_connect($ip, $name, $pass, $db);
            
                $link->set_charset('UTF8');
            
                $link != true ? print("Error") : TRUE;
                
                 $sql = 'select * from predmet';
                 $result = mysqli_query($link, $sql);
                 while ($row = mysqli_fetch_assoc($result)){
                     echo '<tr>';
                     echo '<th>'.$row['title'].'</th>';
                     echo '<td><button type="button" class="'.$row['ID'].'" data-bs-toggle="modal"
                     data-bs-target="#myModalUpdPredm" value="Редактировать">Редактировать</button> 
                     <button type="button" class="'.$row['ID'].'" value="Удалить">Удалить</button></td>'; 
     
                     echo '</tr>';  
                 }
                 $qryType = "";
                ?>
            </tbody>
        </table>
    </div>
        

    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
        <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/main.js"></script>
        <script src="js/jquery.maskedinput.min.js"></script>
</body>
</html>
