$(document).ready(function () {

    let qryType = "";

    let tabelArr = { 'group': [], 'day': [] };
    let timesArr = ['8.00-9-35', '9.45-11.20', '12.00-13.35', '14.15-15.50', '16.00-17-35', '17.45-19.20'];
    let weekDays = [];
    let groupArr = [];

    //инициация процесса генерации расписания

    $('body').on('click', '#createTabelBtn', function () {

        $('#weekTabel').html('');

        // основные массивы учебного плана

        tabelArr = { 'group': [], 'day': [] };
        let dicsArr = { 'planGroupsArr': [], 'planIDArr': [], 'planYearArr': [], 'planPredmetArr': [], 'planSemestrArr': [], 'planLekciiArr': [] };
        let maxDayArr = [];
        groupArr = [];
        let prepodArr = [];
        let daysArr = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
        let allsArr = [];
        let global = [];
        weekDays = [];

        function formatDate(date) {

            var dd = date.getDate();
            if (dd < 10) dd = '0' + dd;

            var mm = date.getMonth() + 1;
            if (mm < 10) mm = '0' + mm;

            var yy = date.getFullYear() % 100;
            if (yy < 10) yy = '0' + yy;

            return dd + '.' + mm + '.' + yy;
        }

        Date.prototype.addDays = function (days) {
            var date = new Date(this.valueOf());
            date.setDate(date.getDate() + days);
            return date;
        }
        

        let fistDay = $('#date').val();
        let date = new Date(fistDay);

        for (let i = 0; i < 7; i++) {
            if (date.getDay() == 0) {
                date = date.addDays(1);
            }
            weekDays.push(formatDate(date));
            date = date.addDays(1);
        }

        if(weekDays[1] == 'NaN.NaN.NaN'){
            alert('Не выбрана дата');   
            fail;
        }


        let count;

        qryType = 'selGroups';

        $.post('tabelScript.php', { qry: qryType }, (data) => {
            global = jQuery.parseJSON(data);
            groupArr = global['IDGroups'];
            prepodArr = global['prepodID'];


            const norma = 4;
            // создание пустого шаблона расписания
            for (let i = 0; i < groupArr.length; i++) {

                let timeTmp = [];

                for (let j = 0; j < timesArr.length; j++) {
                    timeTmp.push('');
                }

                let dayTmp = []

                for (let j = 0; j < daysArr.length; j++) {
                    let ar = timeTmp.slice()
                    dayTmp.push(ar);
                }

                tabelArr['day'].push(dayTmp);
                tabelArr['group'].push(groupArr[i]);

            }

            //формирвоание и предварительный вывод расписания

            for (let i = 0; i < groupArr.length; i++) {
                for (let j = 0; j < global['planIDArr'].length; j++) {
                    if (global['planGroupsArr'][j] == groupArr[i]) {
                        dicsArr['planGroupsArr'].push(global['planGroupsArr'][j]);
                        dicsArr['planIDArr'].push(global['planIDArr'][j]);
                        dicsArr['planYearArr'].push(global['planYearArr'][j]);
                        dicsArr['planPredmetArr'].push(global['planPredmetArr'][j]);
                        dicsArr['planSemestrArr'].push(Number(global['planSemestrArr'][j]));
                        dicsArr['planLekciiArr'].push(global['planLekciiArr'][j]);
                    }

                }

                let max = dicsArr['planIDArr'].length;
                let s = '';
                s = `<table class="table border">
                <thead>
                    <tr>
                    <th class="border" scope="col">ГРУППА</th>`;

                for (let i = 0; i < daysArr.length; i++) {
                    s = s + ' <th class="border" scope="col">' + daysArr[i] + '<br>' + weekDays[i] + '</th>';
                }

                s = s + '</tr> </thead>';

                for (let j = 0; j < daysArr.length; j++) {
                    let k = 4;
                    for (let l = 0; l < timesArr.length; l++) {
                        if (k > 0) {
                            let disc = tabelArr['day'][tabelArr['group'].indexOf(groupArr[i])][j][l];
                            if (disc == '') {
                                let rand = Math.floor(Math.random() * (max));
                                if (dicsArr['planLekciiArr'][rand] > 0) {
                                    disc = dicsArr['planPredmetArr'][rand];
                                    tabelArr['day'][tabelArr['group'].indexOf(groupArr[i])][j][l] = disc;
                                    dicsArr['planLekciiArr'][rand]--;
                                }
                            }
                            k--;
                        }
                    }
                }

                s = s + `<tbody> 
                <tr id="` + groupArr[i] + `">
                    <td class="fs-3 mb-0 pb-0">` + groupArr[i] + `</td> </tr>`;

                $('#weekTabel').append(s);
 
                for (let j = 0; j < daysArr.length; j++) {
                    let idGr = '#' + groupArr[i];
                    $(idGr).append(`<td class="border m-0 p-0">
                                        <table class="table m-0 p-0">
                                            <tbody id="` + daysArr[j] + groupArr[i] + `">
                                            </tbody>
                                        </table>
                                    </td>`)

                    let idDay = '#' + daysArr[j] + groupArr[i];

                    let k = 4;
                    for (let l = 0; l < timesArr.length; l++) {
                        if (k > 0) {
                            if (disc != '') {
                                let predmetTabel = tabelArr['day'][tabelArr['group'].indexOf(groupArr[i])][j][l];


                                qryType = 'selKabPredm';

                                $.post('database.php', { id: predmetTabel, qry: qryType }, function (data) {
                                    arrD = jQuery.parseJSON(data);
                                    let discVal = arrD['predm'];
                                    let kabVal = arrD['kab'];
                                    let fio = arrD['FIO'];

                                    let ss = `<tr><td class="border">` + timesArr[l] + `</td>
                                   <td class="border">` + discVal + `</td>
                                   <td class="border">` + fio + `</td>
                                   <td class="border">` + kabVal + `</td> </tr>`;
                                    $(idDay).append(ss);
   
                                })

                            }
                            k--;
                        }
                    }
                }

                dicsArr = { 'planGroupsArr': [], 'planIDArr': [], 'planYearArr': [], 'planPredmetArr': [], 'planSemestrArr': [], 'planLekciiArr': [] };
            }

        });
        
        $(this).val('Изменить');

        $('#accept').remove();

        $('.contBtnTabel').append('<input type="button" id="accept" class="col-3 btn btn-primary inline-block" value="Выгрузить расписание"></input>');;

    });


    // запись готового распиания в базу данных
    $('body').on('click', '#accept', function () {


        for (let i = 0; i < tabelArr['day'].length; i++) {
            for (let j = 0; j < tabelArr['day'][i].length; j++) {
                let k = 4;
                for (let l = 0; l < tabelArr['day'][i][j][l].length; l++) {
                    if (k > 0) {
                        let disc = tabelArr['day'][i][j][l];
                        if (disc != '') {

                            let dateT = weekDays[j];
                            let timeT = timesArr[l];
                            let groupT = groupArr[i];
                            let predmetT = disc;

                            qryType = 'selKabPredm';

                            $.post('database.php', { id: disc, qry: qryType }, function (data) {
                                arrD = jQuery.parseJSON(data);
                                let kabVal = arrD['kab'];
                                let prepod = arrD['prepod'];

                                qryType = "addTabel";
                            

                                $.post('tabelScript.php', {dateT: dateT, timeT: timeT, groupT: groupT, predmetT: predmetT, kabVal: kabVal, prepod: prepod, qry: qryType }, function (date) {
                                    

                                });

                            })

                            
                        }
                        
                    }
                    k--;
                }
            }
        }
        alert('Расписание успешно сформирвоано и выгружено в общий доступ');
        $('#rasp').trigger('click');
    });


    // ajax загрузка страниц в правую панель
    // function loadDoc(url) {
    //     let xhttp = new XMLHttpRequest();
    //     xhttp.onreadystatechange = function () {
    //         if (this.readyState == 4 && this.status == 200) {
    //             document.querySelector('#menu').innerHTML = this.responseText;
    //         }
    //     }
    //     xhttp.open("GET", url, true);
    //     xhttp.send();
    //     console.log(url)
    // }

    $.ajax('menu.html', {
        success: (respone)=>{
            $('.menu').append(respone);
        }
    })


    let namePage = $('.namePage').attr('data-qry');

    function preload(qryType){
        $('#spinner').append(`<div class="d-flex justify-content-center"><img src="img/spinner.svg" ></div>`)
        $.post('database.php', {qry: qryType}, (data)=>{
            $('#spinner').remove()
            $('.dataPrint').append(data)
        })
    }

    preload(namePage);

    //добавление группы

    $('body').on('click', '#addGroupBtn', function () {

        qryType = "addGroup";

        let idGroup = $('#ID').val();
        let star = $('#starosta').val();
        let phoneStar = $('#phoneStar').val();
        let subGroup;
        if ($('#subGroups').is(':checked')) {
            subGroup = 1;
        } else { subGroup = 0 }

        $.ajax({
            method: "POST",
            url: "database.php",
            data: { id: idGroup, star: star, phone: phoneStar, sub: subGroup, qry: qryType }
        })
            .done(function () {
                alert('Новая группа создана');
            });

    });




    let arr;

    let tmp;
    $('#phone').mask("+7(999)-999-99-99");

    function sPredm(sel) {
        qryType = "selPredm";

        $.get("database.php", { qry: qryType }, function (data) {

            arr = data;
            if (!arr) {

            } else {
                arr = data;



                $(sel).autocomplete({
                    source: arr["title"]
                });


            }
        }, "json");
    }

    // автозаполнение предметов
    $('body').on('click', '#openAddPrep', function () {
        sPredm('#predmet')
    });

    // автозаполнение преподавателей
    function sPrep(sel) {
        qryType = "selPrep";

        $.get("database.php", { qry: qryType }, function (data) {

            arr = data;

            if (!arr) {

            } else {
                $(sel).autocomplete({
                    source: arr["FIO"]
                });
            }
        }, "json");
    }

    // автозаполнение преметов в кабинетах
    $('body').on('click', '#openAddKab', function () {
        sPredm('#listPredmKab');
    });


    $('body').on('click', '#openAddPredm', function () {
        sPrep('#prep2');

    });


    // удаление и редактирование преподавателя

    let idFix = [];

    $('body').on('click', '.minusPredm', function (e) {

        idFix.push($(e.target).attr('id'));
        $(e.target).parent('li').hide();
    });

    $('body').on('click', '#tablePrep', function (e) {

        let act = $(e.target).attr('value');

        if (act == 'Удалить') {
            let id = $(e.target).attr('class');

            qryType = 'delPrep';

            $.ajax({
                method: "POST",
                url: "database.php",
                data: { id: id, qry: qryType }
            })
                .done(function () {

                });

            alert('Удалено');
            $('#prep').trigger('click');

        } else if (act == 'Редактировать') {

            qryType = "updSelPrep";

            let id = $(e.target).attr('class');
            tmp = id;

            $.get('database.php', { id: id, qry: qryType }, function (data) {

                let arr = jQuery.parseJSON(data);
                $('#fioUpd').val(arr['FIO']);
                $('#phoneUpd').val(arr['phone']);
            });

            qryType = "prepAsPredm";

            id = $(e.target).attr('class');

            $.get('database.php', { id: id, qry: qryType }, function (data) {
                $('#listPredm').html(data);
            });

        }

    });



    // редактирование или удаление группы
    $('body').on('click', '#tableGroup', function (e) {

        let act = $(e.target).attr('value');


        if (act == 'Удалить') {
            let id = $(e.target).attr('class');

            qryType = 'delGroup';

            $.ajax({
                method: "POST",
                url: "database.php",
                data: { id: id, qry: qryType }
            })
                .done(function () {

                });

            alert('Удалено');
            $('#groups').trigger('click');

        } else if (act == 'Редактировать') {

            qryType = "updSelGroup";

            let id = $(e.target).attr('class');
            tmp = id;

            $.get('database.php', { id: id, qry: qryType }, function (data) {
                let arr = jQuery.parseJSON(data);
                $('#IDUpd').val(arr['ID']);
                $('#starostaUpd').val(arr['starosta']);
                $('#phoneStarUpd').val(arr['phoneStar']);
                arr['subGroups'] == 1 ? $('#subGroupsUpd').prop('checked', true) : $('#subGroupsUpd').prop('checked', false);

            });

        }

    });

    // редактирвоание или удаление кабинета
    $('body').on('click', '#tableKab', function (e) {

        let act = $(e.target).attr('value');


        if (act == 'Удалить') {
            let id = $(e.target).attr('class');

            qryType = 'delKab';

            $.ajax({
                method: "POST",
                url: "database.php",
                data: { id: id, qry: qryType }
            })
                .done(function () {

                });

            alert('Удалено');
            $('#kabinet').trigger('click');

        } else if (act == 'Редактировать') {

            let id = $(e.target).attr('class');
            tmp = id;

            let tmpPredm = [];

            //добавление предмета кабинету
            $('body').on('click', '#addPredmPlusKab', function () {
                $('.editKabPredm').remove();
                $('#listPredmUpd').append('<input type="text" class=" list-group-item form-control editKabPredm">');

                qryType = "selPredm";

                $.get('database.php', { qry: qryType }, function (data) {

                    arr = data;

                    $('.editPredm').autocomplete({
                        source: arr["title"]
                    });
                }, "json");

                sPredm('.editKabPredm');

            });



            qryType = 'kabAsPredm';

            $.get('database.php', { id: id, qry: qryType }, function (data) {
                $('#listPredmUpd').html(data);
            });



            qryType = "updSelKab";

            $.get('database.php', { id: id, qry: qryType }, function (data) {
                let arr = jQuery.parseJSON(data);
                $('#IDUpdKab').val(arr['ID']);

            });



        }

    });

    // изменение кабинета
    $('body').on('click', '#updKabBtn', function () {


        qryType = 'updKab';

        let id = tmp;
        let newId = $('#IDUpdKab').val();

        $.ajax({
            method: "POST",
            url: "database.php",
            data: { id: id, newId: newId, qry: qryType }
        })
            .done(function () {
                alert('Данные успешно изменены');
            });


        qryType = 'addFixKab';

        tmpPredm = [];

        $('ul').children('.editKabPredm').each(function () {
            tmpPredm.push($(this).val());
        });

        tmpPredm.forEach((e) => {

            let idPredm = arr['title'].indexOf(e);
            let idFixPredm = arr['ID'][idPredm];

            $.ajax({
                method: "POST",
                url: "database.php",
                data: { idKab: id, idPredm: idFixPredm, qry: qryType }
            })
                .done(function () {

                });

        });
    });

    //удаление и редактирование предмета
    $('body').on('click', '#tablePredm', function (e) {

        let act = $(e.target).attr('value');

        if (act == 'Удалить') {
            let id = $(e.target).attr('class');

            qryType = 'delPredm';

            $.ajax({
                method: "POST",
                url: "database.php",
                data: { id: id, qry: qryType }
            })
                .done(function () {

                });

            alert('Удалено');
            $('#disc').trigger('click');

        } else if (act == 'Редактировать') {

            qryType = "updSelPredm";

            let id = $(e.target).attr('class');
            tmp = id;

            $.get('database.php', { id: id, qry: qryType }, function (data) {

                let arr = jQuery.parseJSON(data);
                $('#titleUpd').val(arr['title']);

            });

        }

    });

    //изменение преподавателя
    $('body').on('click', '#updPrepBtn', function () {
        qryType = 'updPrep';

        let id = tmp;
        let fio = $('#fioUpd').val();
        let phone = $('#phoneUpd').val();

        $.ajax({
            method: "POST",
            url: "database.php",
            data: { id: id, fio: fio, phone: phone, qry: qryType }
        })
            .done(function () {

            });

        qryType = 'delFixPredm';

        idFix.forEach((e) => {

            $.ajax({
                method: "POST",
                url: "database.php",
                data: { idFix: e, qry: qryType }
            })
                .done(function () {

                });
        });

        // добавление предмета преподавателю

        qryType = 'addFixPredm';

        $('ul').children('.editPredm').each(function () {
            tmpPredm.push($(this).val());
        });

        tmpPredm.forEach((e) => {
            let idPredm = arr['title'].indexOf(e);
            let idFixPredm = arr['ID'][idPredm];

            $.ajax({
                method: "POST",
                url: "database.php",
                data: { idPrep: id, idFix: idFixPredm, qry: qryType }
            })
                .done(function () {

                });

        });
        alert("Данные успешно изменены");
    });

    let tmpPredm = [];

    $('body').on('click', '#addPredmPlus', function () {
        $('#listPredm').append('<input type="text" class=" list-group-item form-control editPredm">');

        qryType = "selPredm";

        $.get('database.php', { qry: qryType }, function (data) {

            arr = data;

            $('.editPredm').autocomplete({
                source: arr["title"]
            });
        }, "json");

    });

    //изменение предмета
    $('body').on('click', '#updPredmBtn', function () {
        qryType = 'updPredm';

        let id = tmp;
        let title = $('#titleUpd').val();

        $.ajax({
            method: "POST",
            url: "database.php",
            data: { id: id, title: title, qry: qryType }
        })
            .done(function () {
                alert('Данные успешно изменены');
            });
    });



    // добавление кабинета
    $('body').on('click', '#addKabBtn', function () {
        qryType = 'addKab';

        let id = $('#IDKab').val();
        let predm = $('#listPredm').val();

        let tPredm = arr['title'].indexOf(predm);
        let idPredm = arr['ID'][tPredm];

        if (!predm) {
            if (!id) {
                alert('Данные не заполнены');
            } else {
                $.ajax({
                    method: "POST",
                    url: "database.php",
                    data: { id: id, qry: qryType }
                })
                    .done(function () {
                        alert('Данные загружены без указания предмета');
                    });

                $('.addKab').trigger('reset');
            }
        } else {
            if (!id) {
                alert('Данные не заполнены');
            } else {
                $.ajax({
                    method: "POST",
                    url: "database.php",
                    data: { id: id, predm: idPredm, qry: qryType }
                })
                    .done(function () {
                        alert('Данные успешно загружены');

                    });

                $('.addKab').trigger('reset');
            }
        }
    });


    //изменение группы
    $('body').on('click', '#updGroupBtn', function () {
        qryType = 'updGroup';

        let id = tmp;
        let starosta = $('#starostaUpd').val();
        let phoneStar = $('#phoneStarUpd').val();
        let sub;
        $('#subGroupsUpd').is(':checked') ? sub = 1 : sub = 0;



        $.ajax({
            method: "POST",
            url: "database.php",
            data: { id: id, starosta: starosta, phoneStar: phoneStar, sub: sub, qry: qryType }
        })
            .done(function () {
                alert('Данные успешно изменены');
            });
    });


    $('form').submit((e) => {

        e.preventDefault();
    });


    $('body').on('click', '.closeKab', function () {
        $('#kabinet').trigger('click');
    });

    $('body').on('click', '.closePrep', function () {
        $('#prep').trigger('click');
    });

    $('body').on('click', '.closePredm', function () {
        $('#disc').trigger('click');
    });

    $('body').on('click', '.closeGroup', function () {
        $('#groups').trigger('click');
    });

    // добавление преподавателя
    $('body').on('click', '#addPrepBtn', function () {

        qryType = "addPrep";

        let prepVal = $('#fio').val();
        let phoneVal = $('#phone').val();

        let predmVal = $('#predmet').val();
        let id = arr['title'].indexOf(predmVal);
        predmVal = arr['ID'][id];

        if (!predmVal) {
            if (!prepVal || !phoneVal) {
                alert('Данные не заполнены');
            } else {
                $.ajax({
                    method: "POST",
                    url: "database.php",
                    data: { fio: prepVal, phone: phoneVal, qry: qryType }
                })
                    .done(function () {
                        alert('Данные загружены без указания предмета');

                    });

                $('.addPrep').trigger('reset');
            }
        } else {
            if (!prepVal || !phoneVal) {
                alert('Данные не заполнены');
            } else {
                $.ajax({
                    method: "POST",
                    url: "database.php",
                    data: { fio: prepVal, phone: phoneVal, predm: predmVal, qry: qryType }
                })
                    .done(function () {
                        alert('Данные успешно загружены');

                    });

                $('.addPrep').trigger('reset');
            }
        }

    });

    //добавление предмета
    $('body').on('click', '#addPredmBtn', function () {

        qryType = "addPredm";

        let titleVal = $('#title').val();

        let prepVal = $('#prep2').val();
        let id = arr['FIO'].indexOf(prepVal);
        prepVal = arr['ID'][id];


        if (!prepVal) {
            if (!titleVal) {
                alert('Данные не заполнены');
            } else {
                $.ajax({
                    method: "POST",
                    url: "database.php",
                    data: { title: titleVal, qry: qryType }
                })
                    .done(function () {
                        alert('Данные загружены без указания преподавателя');
                    });

                $('.addPredm').trigger('reset');
            }
        } else {
            if (!titleVal) {
                alert('Данные не заполнены');
            } else {
                $.ajax({
                    method: "POST",
                    url: "database.php",
                    data: { title: titleVal, prep: prepVal, qry: qryType }
                })
                    .done(function () {
                        alert('Данные успешно загружены');
                    });

                $('.addPredm').trigger('reset');
            }
        }

    });

    //УЧЕБНЫЙ ПЛАН

    let arrPlan;

    //загрузка плана

    let sqlGroupId;

    $('body').on('click', '.sqlGroup', function (e) {

        $('.btnPlan').remove();
        qryType = 'selPlan';
        let idGroup = $(e.target).text();

        sqlGroupId = idGroup;

        $.get('database.php', { group: idGroup, qry: qryType }, function (data) {
            $('.groupPlan').html(data);
        });

        sPredm('.titlePlan');

    });

    function clickPlan(id) {
        qryType = 'selPlan';

        $.get('database.php', { group: id, qry: qryType }, function (data) {
            $('.groupPlan').html(data);
        });
    }

    // создания строки для ввода нового предметя для учебного плана

    $('body').on('click', '#addPlan', function () {
        if (!isNaN(sqlGroupId)) {
            $('.btnPlan').remove();
            $('.groupPlan').append('<tr class="rowGroupPlan"> <th><input id="planPredmEdt" class="addGroupPlan titlePlan list-group-item form-control" type="text"></th> <td><input id="planYear" class="addGroupPlan yearPlan list-group-item form-control" type="text"></td> <td><input id="planSem" class="addGroupPlan titlePlan list-group-item form-control" type="text"></td> <td><input id="planLekcii" class="addGroupPlan titlePlan list-group-item form-control" type="text"></td> </tr>)');
            $('.edtPlan').append('<button id="closeInpPlan" class="btnPlan btn btn-primary me-2 mb-2">Отмена</button><button id="addRowPlan" class="btnPlan btn btn-primary mb-2">Сохранить</button>');
            sPredm('#planPredmEdt');
        }
    });

    //отмена добаления предмета учебному плану
    $('body').on('click', '#closeInpPlan', function () {
        $('.btnPlan').remove();
        $('.rowGroupPlan').remove();

    });


    //добавление нового предмета в учебный план
    $('body').on('click', '#addRowPlan', function () {

        let predm = $('#planPredmEdt').val();
        let year = $('#planYear').val();
        let sem = $('#planSem').val();
        let lekcii = $('#planLekcii').val();

        let idPredmPlan;

        if (!predm || !year || !sem || !lekcii) {
            alert('Не заполнены все данные');
        } else {

            qryType = 'selPredm';

            $.post('database.php', { qry: qryType }, function (data) {

                arrPredm = jQuery.parseJSON(data);

                let tmpId = arrPredm['title'].indexOf(predm);

                idPredmPlan = arrPredm['ID'][tmpId];
                qryType = 'addPlan';

                $.post('database.php', { groups: sqlGroupId, predm: idPredmPlan, year: year, sem: sem, lekcii: lekcii, qry: qryType }, function () {

                });
                $('.btnPlan').remove();
                $('.rowGroupPlan').remove();

                clickPlan(sqlGroupId);
            });

        }

    });


    let idPlan;
    $('body').on('click', '.inpGroup', (e) => {
        idPlan = $(e.target).attr('id');
    });


    // внесение изменений в учебный план
    $('body').change('.inpGroup', (e) => {

        qryType = 'updPlan';

        let cl = $(e.target).attr('class');


        if (cl.indexOf('titlePlan') !== -1) {
            let val = $(e.target).val();
            let predmId = arr['title'].indexOf(val);
            val = arr['ID'][predmId];
            let type = 'predmet';
            $.post('database.php', { idPlan: idPlan, val: val, type: type, qry: qryType }, () => {
            });
        } else if (cl.indexOf('yearPlan') !== -1) {
            let val = $(e.target).val();
            let type = 'year';
            $.post('database.php', { idPlan: idPlan, val: val, type: type, qry: qryType }, () => {
            });
        } else if (cl.indexOf('semestrPlan') !== -1) {
            let val = $(e.target).val();
            let type = 'semestr';
            $.post('database.php', { idPlan: idPlan, val: val, type: type, qry: qryType }, () => {
            });
        } else if (cl.indexOf('lekciiPlan') !== -1) {
            let val = $(e.target).val();
            let type = 'lelcii';
            $.post('database.php', { idPlan: idPlan, val: val, type: type, qry: qryType }, () => {
            });
        }

    });

    // смена пароля пользователя
    $('body').on('click', '#changePassBtn', function(){
        qryType = 'editPass';
        let loggin = $('#loggin').val();
        let oldPass = $('#oldPass').val();
        let newPass = $('#newPass').val();
        let newPassRetype = $('#newPassRetype').val();
        $.post('database.php', {loggin: loggin, oldPass: oldPass, newPass: newPass, newPassRetype: newPassRetype, qry: qryType},function (data) {  
            alert(data);    
        })
    });

});