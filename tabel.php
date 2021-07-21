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

</body>

</html>