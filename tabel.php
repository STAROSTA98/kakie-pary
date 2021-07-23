<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" lang="ru">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">


</head>

<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-2 menu">
        </div>
        <div class="col-10">
            <div class="container">
                <h4 class="py-4">Формирование расписания</h4>
                <h6>Начальная дата:</h6>
                <input type="date" class="form-control" id="date" name="date" placeholder="Дата">

                <div class="contBtnTabel row justify-content-between">
                    <input type="button" id="createTabelBtn" class="col-2 btn btn-primary inline-block" value="Создать">

                </div>

                <div id="weekTabel" class="container-fluid">

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="js/bootstrap.bundle.js"></script>
<script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/jquery.cookie.js"></script>
<script src="js/main.js"></script>
<script src="js/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.js"></script>
</body>

</html>