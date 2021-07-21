<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" lang="ru">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/reset.css">
    
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">

    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<body>
    <!-- расписание для открытия студентами -->
    <div class="container">
        <div class="row justify-content-around addTabel">
           
        </div>
    </div>
    <script>
           $(document).ready(function() {
                
            // вывод списка групп
                let qryType = 'selGroup';

                $.post('database.php', {qry: qryType}, function(data) {
                    let groups = jQuery.parseJSON(data); 
                    
                    groups.forEach(e => {
                        $('.addTabel').append('<div id="' + e + '" class="col-xs-12 col-sm-6 col-md-2 btn btn-secondary text-center m-1 groupBtn">' + e + '</div>');    
                    });

                });
                let id;

                // открытия списка дат при выборе группы

                $('body').on('click', '.groupBtn', function(e){

                    id = $(e.target).attr('id');
                    $('body').html('');

                    qryType = 'selTabelGroup';

                    $('body').html(`<div class="container">
                                        <div class="row list-group addTabel">

                                        </div>
                                    </div>`);

                    $.post('database.php', {id: id, qry: qryType}, function(data){
                        let dates = jQuery.parseJSON(data);  
                        dates.forEach(e => {
                            $('.addTabel').append('<p href="#" id="' + e + '" class="dateClick list-group-item list-group-item-action m-1 text-center">' + e + '</p>');
                        });
                    })

                });
                let timesArr = ['8.00-9-35', '9.45-11.20', '12.00-13.35', '14.15-15.50', '16.00-17-35', '17.45-19.20'];


                //открытие расписания на выбранный день

                $('body').on('click', '.dateClick', function(){

                    $('body').html('');

                    let s = '';

                    s = s + `<table class="table table-striped">
                                <thead>
                                    <tr> <th colspan="4"> Группа ` + id + `</th> </tr>
                                    <tr> <th colspan="4">` + $(this).attr('id') + `</th> </tr>
                                <thead> <tbody id="bodyTabel"> </tbody>`;

                    $('body').append(s);

                    qryType = 'selTabelGroupDate';

                    let dates = $(this).attr('id');

                    $.post('database.php', {id: id, dates: dates, qry: qryType}, function(data) {
                        let par = jQuery.parseJSON(data); 
                        

                        s = '';

                            for(let i = 0; i < par['predmet'].length; i++){
                                qryType = 'selKabPredm';

                                $.post('database.php', {id: par['predmet'][i], qry: qryType}, function(data) {
                                    let fix = jQuery.parseJSON(data);
                                    console.log(fix);

                                    $('#bodyTabel').append(`<tr >
                                        <td class="border">` + timesArr[i] + `</td>
                                        <td class="border">` + fix['predm'] + `</td>
                                        <td class="border">` + fix['FIO'] + `</td>
                                        <td class="border">` + par['kabinet'][i] + `</td>
                                    </tr>`);
                                    
                                })

                            }
  
                    })
                });

            });
        </script>
        
</body>
</html>