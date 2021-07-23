<?php

//подключение к БД
$ip = "localhost";
$name = "root";
$pass = "";
$db = "u1393764_default";

$link = mysqli_connect($ip, $name, $pass, $db);

$link->set_charset('UTF8');

$link != true ? print("Error") : TRUE;

$qryType = $_POST['qry'];

if (!$qryType) {
    $qryType = $_GET['qry'];
}

switch ($qryType) {
    // выборка предметов на один день по группе и дате
    case 'selTabelGroupDate':
        $groups = "'" . $_POST['id'] . "'";
        $dates = "'" . $_POST['dates'] . "'";
        $sql = "SELECT * FROM `tabel` WHERE groups = $groups and `date` = $dates ";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $predmArr[] = $row['predmet'];
            $prepodArr[] = $row['prepod'];
            $kabinetArr[] = $row['kabinet'];
        }
        $arr['predmet'] = $predmArr;
        $arr['prepod'] = $prepodArr;
        $arr['kabinet'] = $kabinetArr;
        echo json_encode($arr);
        break;
    case 'selTabelGroup':
        // выборка дат для распсиания
        $groups = "'" . $_POST['id'] . "'";
        $sql = "SELECT * FROM `tabel` WHERE groups = $groups GROUP BY `date` ORDER BY `date`";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $arr[] = $row['date'];
        }
        echo json_encode($arr);
        break;
    case 'selGroup':
        // выборка групп
        $sql = "SELECT ID FROM groups";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $arr[] = $row['ID'];
        }
        echo json_encode($arr);
        $qryType = "";
        break;
    case 'addPrep':
        // добавление преподавателя
        $fio = "'" . $_POST['fio'] . "'";
        $phone = "'" . $_POST['phone'] . "'";
        $sql = "INSERT INTO prepod(fio, phone) values($fio,$phone)";
        $result = mysqli_query($link, $sql);
        $predm = "'" . $_POST['predm'] . "'";
        if (!$predm) {
        } else {
            $idPrep = mysqli_insert_id($link);
            $sql = "INSERT INTO fixed_predmet(prepod, predmet) values($idPrep,$predm)";
            $result = mysqli_query($link, $sql);
        }
        $qryType = "";
        break;
    case "addPredm":
        // добавление предмета
        $predmet = "'" . $_POST['title'] . "'";
        $sql = "INSERT INTO predmet(title) values($predmet)";
        $result = mysqli_query($link, $sql);
        $prep = "'" . $_POST['prep'] . "'";
        if (!$prep) {
        } else {
            $idPredm = mysqli_insert_id($link);
            $sql = "INSERT INTO fixed_predmet(prepod, predmet) values($prep,$idPredm)";
            $result = mysqli_query($link, $sql);
        }
        $qryType = "";
        break;
    case "selPredm":
        // выборка предметов
        $sql = "SELECT * FROM `predmet`";
        $result = mysqli_query($link, $sql);
        $resArray = array();
        $idArray = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $resArray[] = $row['title'];
            $idArray[] = $row['ID'];
        }
        $arr['title'] = $resArray;
        $arr['ID'] = $idArray;
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        $qryType = "";
        break;
    case "selPrep":
        // выборка преподавателей
        $sql = "SELECT * FROM `prepod`";
        $result = mysqli_query($link, $sql);
        $resArray = array();
        $idArray = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $resArray[] = $row['FIO'];
            $idArray[] = $row['ID'];
        }
        $arr['FIO'] = $resArray;
        $arr['ID'] = $idArray;
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        $qryType = "";
        break;
    case "delPrep":
        //удаление преподавателя
        $id = $_POST['id'];
        $sql = "DELETE FROM prepod WHERE id=$id";
        $result = mysqli_query($link, $sql);
        break;
    case "delPredm":
        // удаление предмета
        $id = $_POST['id'];
        $sql = "DELETE FROM predmet WHERE id=$id";
        $result = mysqli_query($link, $sql);
        break;
    case "delGroup":
        // удаление группы
        $id = $_POST['id'];
        $sql = "DELETE FROM groups WHERE id=$id";
        $result = mysqli_query($link, $sql);
        break;
    case "delKab":
        // удаление кабинета
        $id = $_POST['id'];
        $sql = "DELETE FROM kabinet WHERE id=$id";
        $result = mysqli_query($link, $sql);
        break;
    case "updSelPrep":
        // формирование списка преподавателей
        $prep = $_GET['id'];
        $sql = "SELECT * FROM prepod WHERE ID = $prep";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $arr['ID'] = $row['ID'];
            $arr['FIO'] = $row['FIO'];
            $arr['phone'] = $row['phone'];
        }
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        $qryType = "";
        break;
    case "updPrep":
        // редактирвоание данных преподавателя
        $id = $_POST['id'];
        $fio = "'" . $_POST['fio'] . "'";
        $phone = "'" . $_POST['phone'] . "'";
        $sql = "UPDATE prepod SET FIO = $fio, phone = $phone WHERE ID = $id";
        $result = mysqli_query($link, $sql);
        break;
    case "delFixPredm":
        // удаление закреплённого предмета за преподавателем
        $fix = $_POST['idFix'];
        $sql = "DELETE FROM fixed_predmet WHERE ID = $fix";
        $result = mysqli_query($link, $sql);
        $qryType = "";
        break;
    case "updSelPredm":
        // формирование списка предметов
        $id = $_GET['id'];
        $sql = "SELECT * FROM `predmet` WHERE ID = $id";
        $result = mysqli_query($link, $sql);
        $resArray = array();
        $idArray = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $arr['title'] = $row['title'];
            $arr['ID'] = $row['ID'];
        }
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        $qryType = "";
        break;
    case "updSelKab":
        // формирование списка кабинетов
        $id = $_GET['id'];
        $sql = "SELECT * FROM `kabinet` WHERE ID = $id";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $arr['ID'] = $row['ID'];
        }
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        $qryType = "";
        break;
    case "updSelGroup":
        // формирование списка групп
        $id = $_GET['id'];
        $sql = "SELECT * FROM `groups` WHERE ID = $id";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $arr['ID'] = $row['ID'];
            $arr['starosta'] = $row['starosta'];
            $arr['phoneStar'] = $row['phone_star'];
            $arr['subGroups'] = $row['sub_groups'];
        }
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        $qryType = "";
        break;
    case "updKab":
        // обновление данных кабинета
        $id = "'" . $_POST['id'] . "'";
        $newId = "'" . $_POST['newId'] . "'";
        $sql = "UPDATE kabinet SET ID = $newId WHERE ID = $id";
        $result = mysqli_query($link, $sql);
        $qryType = "";
        break;
    case "updGroup":
        // обновление данных группы
        $id = $_POST['id'];
        $starosta = "'" . $_POST['starosta'] . "'";
        $phone_star = "'" . $_POST['phoneStar'] . "'";
        $sub = $_POST['sub'];
        $sql = "UPDATE groups SET ID = $id, starosta = $starosta, phone_star = $phone_star, sub_groups = $sub WHERE ID = $id";
        $result = mysqli_query($link, $sql);
        $qryType = "";
        break;
    case "updPredm":
        // обновление данных предмета
        $id = $_POST['id'];
        $title = "'" . $_POST['title'] . "'";
        $sql = "UPDATE predmet SET title = $title WHERE ID = $id";
        $result = mysqli_query($link, $sql);
        $qryType = "";
        break;
    case "addFixPredm":
        // закрепление предмета за преподавателем
        $prep = $_POST['idPrep'];
        $predm = $_POST['idFix'];
        $sql = "INSERT INTO fixed_predmet (prepod, predmet) values($prep, $predm)";
        $result = mysqli_query($link, $sql);
        $qryType = "";
        break;
    case "addFixKab":
        // закрепление премета за кабинетом
        $kab = "'" . $_POST['idKab'] . "'";
        $predm = $_POST['idPredm'];
        $sql = "INSERT INTO fixed_kabinet(kabinet, predmet) values($kab, $predm)";
        $result = mysqli_query($link, $sql);
        $qryType = "";
        break;
    case "addFixKab":
        // закрепление премета за кабинетом
        $kab = $_POST['idKab'];
        $predm = $_POST['idPredm'];
        $sql = "INSERT INTO fixed_kabinet (kabinet, predmet) values($kab, $predm)";
        $result = mysqli_query($link, $sql);
        $qryType = "";
        break;
    case "prepAsPredm":
        // генерация спсика закреплённых предметов в модальном окне преподавателя
        $id = $_GET['id'];
        $sql = "SELECT prepod.FIO, prepod.phone, predmet.title, fixed_predmet.prepod, fixed_predmet.predmet, fixed_predmet.ID
            FROM prepod INNER JOIN (predmet INNER JOIN fixed_predmet ON predmet.ID = fixed_predmet.predmet) ON prepod.ID = fixed_predmet.prepod
            WHERE fixed_predmet.prepod=$id";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $arr['html'][] = '<div><li class="list-group-item listEdit">' . $row['title'] . ' </li><svg  id="' . $row['ID'] . '" width="2em" height="2em" viewBox="0 0 16 16" class="minusPredm" cursor="pointer" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                <path fill-rule="evenodd" d="M5.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                </svg></div>';
        }
        foreach ($arr['html'] as $value) {
            echo $value;
        }
        break;
    case "kabAsPredm":
        // генерация спсика закреплённых предметов в модальном окне кабинета
        $id = "'" . $_GET['id'] . "'";
        $sql = "SELECT fixed_kabinet.ID, fixed_kabinet.kabinet, fixed_kabinet.predmet, predmet.title
            FROM kabinet INNER JOIN (predmet INNER JOIN fixed_kabinet ON predmet.ID = fixed_kabinet.predmet) ON kabinet.ID = fixed_kabinet.kabinet
            WHERE fixed_kabinet.kabinet = $id";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div><li class="list-group-item listEdit">' . $row['title'] . ' </li><svg  id="' . $row['ID'] . '" width="2em" height="2em" viewBox="0 0 16 16" class="minusPredm" cursor="pointer" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                <path fill-rule="evenodd" d="M5.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                </svg></div>';
        }
        // foreach ($arr['html'] as $value) {
        //     echo $value;
        // }
        break;
    case "selKabPredm":
        // выборка предметов по кабинетам
        $id = $_POST['id'];
        $sql = "SELECT fixed_kabinet.ID, fixed_kabinet.kabinet, fixed_kabinet.predmet, predmet.title
            FROM kabinet INNER JOIN (predmet INNER JOIN fixed_kabinet ON predmet.ID = fixed_kabinet.predmet) ON kabinet.ID = fixed_kabinet.kabinet
            WHERE fixed_kabinet.predmet = $id";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $arr['kab'] = $row['kabinet'];
            $arr['predm'] = $row['title'];
        }

        $sql = "";

        $sql = "SELECT prepod.FIO, prepod.phone, predmet.title, fixed_predmet.prepod, fixed_predmet.predmet, fixed_predmet.ID
            FROM prepod INNER JOIN (predmet INNER JOIN fixed_predmet ON predmet.ID = fixed_predmet.predmet) ON prepod.ID = fixed_predmet.prepod
            WHERE fixed_predmet.predmet=$id";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $arr['prepod'] = $row['prepod'];
            $arr['FIO'] = $row['FIO'];
        }

        echo json_encode($arr);

    case "addGroup":
        // добавление группы
        $data = $_POST['data'];

        $sql = "INSERT INTO groups VALUES (";
        foreach ($data as $item){
            intval($item) ? $sql .= $item."," : $sql .= "'".$item."',";
        }

        $sql[strlen($sql) - 1] = ')';
        echo var_dump($sql);

        $id = $data['ID'];
        $starosta = "'" . $data['starosta'] . "'";
        $phone_star = "'" . $data['phoneStar'] . "'";
        $sub_groups = $data['subGroups'];
        //$sql = "INSERT INTO groups VALUES ($id, $starosta, $phone_star, $sub_groups)";
        $result = mysqli_query($link, $sql);
        $qryType = "";
        break;
    case "addKab":
        // добавление предмета
        $id = $_POST['id'];
        $sql = "INSERT INTO kabinet VALUES ($id)";
        $result = mysqli_query($link, $sql);
        $idPredm = "'" . $_POST['predm'] . "'";
        $sql = "INSERT INTO fixed_kabinet(kabinet, predmet) VALUES ($id, $idPredm)";
        $result = mysqli_query($link, $sql);
        $qryType = "";
        break;
    case "selPlan":
        // выборка учебного плана по группе
        $group = $_GET['group'];
        $sql = "SELECT predmet.title, plan.ID, plan.year, plan.predmet, plan.semestr, 
            plan.lekcii, plan.groups FROM predmet INNER JOIN plan ON predmet.ID = plan.predmet
            WHERE plan.groups = $group";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<th><input id="' . $row['ID'] . '"class="inpGroup titlePlan list-group-item form-control" type="text" value="' . $row['title'] . '"></th>';
            echo '<td><input id="' . $row['ID'] . '" class="inpGroup yearPlan list-group-item form-control" type="text" value="' . $row['year'] . '"></td>';
            echo '<td><input id="' . $row['ID'] . '" class="inpGroup semestrPlan list-group-item form-control" type="text" value="' . $row['semestr'] . '"></td>';
            echo '<td><input id="' . $row['ID'] . '" class="inpGroup lekciiPlan list-group-item form-control" type="text" value="' . $row['lekcii'] . '"></td>';
            echo '</tr>';
        }
        break;
    case "updPlan":
        // обновление данных учебного плана
        $val = $_POST['val'];
        $type = $_POST['type'];
        $id = $_POST['idPlan'];
        $sql = "UPDATE plan SET $type = $val WHERE ID = $id";
        $result = mysqli_query($link, $sql);
        break;
    case "addPlan":
        // добавление нового предмета учебному плану
        $predm = $_POST['predm'];
        $year = $_POST['year'];
        $sem = $_POST['sem'];
        $lekcii = $_POST['lekcii'];
        $groups = $_POST['groups'];
        $sql = "INSERT INTO plan(groups, `year`, predmet, semestr, lekcii) VALUES($groups, $year, $predm, $sem, $lekcii)";
        $result = mysqli_query($link, $sql);
        var_dump($result);
        break;
    case "addTabel":
        // добавление пункта в расписание
        $timeTabel = $_POST['timeTabel'];
        $groupsTabel = $_POST['timeTabel'];
        $date = $_POST['timeTabel'];
        $predmetTabel = $_POST['timeTabel'];
        break;
    case 'printPrep':
        $sql = 'select * from prepod';
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<th>' . $row['FIO'] . '</th>';
            echo '<td>' . $row['phone'] . '</td>';
            echo '<td><button type="button" class="' . $row['ID'] . '" data-bs-toggle="modal"
                     data-bs-target="#myModalUpd" value="Редактировать">Редактировать</button> 
                     <button type="button" class="' . $row['ID'] . '" value="Удалить">Удалить</button></td>';

            echo '</tr>';
        }
        break;
    case 'printDisc':
        $sql = 'select * from predmet';
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<th>' . $row['title'] . '</th>';
            echo '<td><button type="button" class="' . $row['ID'] . '" data-bs-toggle="modal"
                     data-bs-target="#myModalUpdPredm" value="Редактировать">Редактировать</button> 
                     <button type="button" class="' . $row['ID'] . '" value="Удалить">Удалить</button></td>';

            echo '</tr>';
        }
        break;
    case 'printGroups':
        $sql = 'select * from groups';
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)){
            echo '<tr>';
            echo '<th>'.$row['ID'].'</th>';
            echo '<td>'.$row['starosta'].'</td>';
            echo '<td>'.$row['phone_star'].'</td>';
            echo '<td>'.$row['sub_groups'].'</td>';
            echo '<td><button type="button" class="'.$row['ID'].'" data-bs-toggle="modal"
                     data-bs-target="#myModalUpdPredm" value="Редактировать">Редактировать</button> 
                     <button type="button" class="'.$row['ID'].'" value="Удалить">Удалить</button></td>';

            echo '</tr>';
        }
        break;
    case 'printPlan':
        $sql = "SELECT * FROM groups";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)){
            echo '<li class="nav-link rounded sqlGroup">'.$row['ID'].'</li>';
        }
        break;
    case 'printKab':
        $sql = 'select * from kabinet';
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)){
            echo '<tr>';
            echo '<th>'.$row['ID'].'</th>';
            echo '<td><button type="button" class="'.$row['ID'].'" data-bs-toggle="modal"
                     data-bs-target="#myModalUpdKab" value="Редактировать">Редактировать</button> 
                     <button type="button" class="'.$row['ID'].'" value="Удалить">Удалить</button></td>';

            echo '</tr>';
        }
        break;
    case 'editPass':
        // смена пароля пользователя
        $loggin = $_POST['loggin'];
        $oldPass = $_POST['oldPass'];
        $oldPass = md5($oldPass);
        $newPass = $_POST['newPass'];
        $newPassRetype = $_POST['newPassRetype'];

        $sql = "SELECT * FROM users WHERE userlog = '$loggin' AND pass = '$oldPass'";
        $result = mysqli_query($link, $sql);

        if ($result == false) {
            echo 'Неверно введены данные';
        } else {
            if ($newPass === $newPassRetype) {
                $newPass = md5($newPass);
                $sql = "UPDATE users SET pass = '$newPass' WHERE userlog = '$loggin'";
                $result = mysqli_query($link, $sql);
                echo 'Пароль успешно изменён';
            }

        }
}
?>

