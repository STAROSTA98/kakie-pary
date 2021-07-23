<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" lang="ru">
    <link rel="stylesheet" href="css/reset.css">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-2 menu">
        </div>
        <div class="col-10">
            <h4 class="namePage" data-qry="printPlan">Учебный план</h4>
            <div class="container-fluid">
                <div class="row">
                    <nav class="groups navbar navbar-expand-lg border">
                        <ul class="navbar-nav navGroup dataPrint">

                    </nav>
                    <div id="spinner">

                    </div>
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
        </div>
    </div>
</div>


    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>

    
</body>

</html>