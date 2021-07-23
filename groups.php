<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" lang="ru">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">

</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-2 menu">
        </div>
        <div class="col-10">
            <h4 class="py-4 namePage" data-qry="printGroups">Группы</h4>
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Добавить</button>
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
                        <th scope="col">Староста</th>
                        <th scope="col">Номер старосты</th>
                        <th scope="col">Деление на подгруппы</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody id="tableGroup" class="dataPrint">

                    </tbody>
                </table>
                <div id="spinner">

                </div>
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
                <button class="btn-close closeGroup" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body py-2">
                    <form class="addPredm">
                        <div class="my-2">
                            <label>Номер <br></label>
                            <input type="text" class="form-control" id="ID"></input>
                        </div>
                        <div class="my-2">
                            <label>Староста</label> 
                            <br><input type="text" class="form-control ui-widget" id="starosta"></input>
                        </div>
                        <div class="my-2">
                            <label>Номер старосты</label> 
                            <br><input type="text" class="form-control ui-widget" id="phoneStar"></input>
                        </div>
                        <div class="my-2">
                            
                            <input class="form-check-input" type="checkbox" value="" id="subGroups" checked></input>
                            <label class="form-check-label" for="subGroups">Деление на подгруппы</label> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer py-1">
                    <button type="submit" class="btn btn-primary" id="addGroupBtn">Добавить</button>
                    <button class = "btn btn-secondary closeGroup" data-bs-dismiss="modal">Отмена</button>
                </div>    
            </div>  
        </div>         
    </div>



<!-- модальное окно изменения данных -->
    <div class="modal fade" id="myModalUpdPredm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-1">
                    Предмет
                    <button class="btn-close closeGroup" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                <form class="addPredm">
                        <div class="my-2">
                            <label>Номер <br></label>
                            <input type="text" class="form-control" id="IDUpd"></input>
                        </div>
                        <div class="my-2">
                            <label>Староста</label> 
                            <br><input type="text" class="form-control ui-widget" id="starostaUpd"></input>
                        </div>
                        <div class="my-2">
                            <label>Номер старосты</label> 
                            <br><input type="text" class="form-control ui-widget" id="phoneStarUpd"></input>
                        </div>
                        <div class="my-2">
                            
                            <input class="form-check-input" type="checkbox" value="" id="subGroupsUpd" checked></input>
                            <label class="form-check-label" for="subGroupsUpd">Деление на подгруппы</label> 
                        </div>
                    </form>

                </div>
                <div class="modal-footer py-1">
                    <button type="submit" class="btn btn-primary" id="updGroupBtn">Изменить</button>
                    <button class="btn btn-secondary closeGroup" data-bs-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div> 
        


    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>
