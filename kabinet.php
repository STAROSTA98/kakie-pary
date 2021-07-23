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
            <h4 class="py-4 namePage" data-qry="printKab">Аудитории</h4>
            <div class="d-flex justify-content-end">
                <button id="openAddKab" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Добавить</button>
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

            <div class="container-fluids">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Номер</th>

                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody id="tableKab" class="dataPrint">

                    </tbody>
                </table>
                <div id="spinner">

                </div>
            </div>
        </div>
    </div>
</div>

<!-- модальное окно изменения данных -->
<div class="modal fade" id="myModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-1">
                    Аудитории
                <button class="btn-close closeKab" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body py-2">
                    <form class="addKab">
                        <div class="my-2">
                            <label class="required">Номер</label>
                            <br><input type="text" class="form-control" id="IDKab"></input>
                        </div>
                        <div class="my-2">
                            <label>Предмет<br></label>
                            <input type="text" class="form-control" id="listPredmKab"></input>
                        </div>
                    </form>
                </div>
                <div class="modal-footer py-1">
                    <button type="submit" class="btn btn-primary" id="addKabBtn">Добавить</button>
                    <button class = "btn btn-secondary closeKab" data-bs-dismiss="modal">Отмена</button>
                </div>    
            </div>  
        </div>         
    </div>


<!-- модальное окно добавления данных -->
    <div class="modal fade" id="myModalUpdKab" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-1">
                Аудитории
                    <button class="btn-close closeKab" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                <form class="addPredm">
                        <div class="my-2">
                            <label>Номер <br></label>
                            <input type="text" class="form-control" id="IDUpdKab"></input>
                        </div>
                        <div class="mb-3">
                    
                            <label>Предметы</label>
                            <svg cursor="pointer" id="addPredmPlusKab" width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-file-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                            <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                            <ul class="list-group" id="listPredmUpd">

                            </ul>
                    </div>
                    </form>

                </div>
                <div class="modal-footer py-1">
                    <button type="submit" class="btn btn-primary" id="updKabBtn">Изменить</button>
                    <button class="btn btn-secondary closeKab" data-bs-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>
