<?php
                $ip = "localhost";
                $name = "root";
                $pass = "";
                $db = "u1393764_default";
            
                $link = mysqli_connect($ip, $name, $pass, $db);
            
                $link->set_charset('UTF8');
            
                $link != true ? print("Error") : TRUE;

                $qryType = $_POST['qry'];
                
                switch ($qryType) {
                // выборка групп
                    case 'selGroups':
                        $sql = "SELECT * FROM `groups`";
                        $result = mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_assoc($result)){
                            $groupArr[] = $row['ID'];
                        }    

                        $sql = "SELECT * FROM `plan`";
                        $result = mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_assoc($result)){
                            $planIDArr[] = $row['ID'];
                            $planGroupsArr[] = $row['groups'];
                            $planYearArr[] = $row['year'];
                            $planPredmetArr[] = $row['predmet'];
                            $planSemestrArr[] = $row['semestr'];
                            $planLekciiArr[] = $row['lekcii'];
                        }    
                        
                        $sql = "SELECT * FROM `prepod`";
                        $result = mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_assoc($result)){
                            $prepodID[] = $row['ID'];
                        }   
                        
                        $arr['IDGroups'] = $groupArr;
                        $arr['planIDArr'] =  $planIDArr;
                        $arr['planGroupsArr'] =  $planGroupsArr;
                        $arr['planYearArr'] =  $planYearArr;
                        $arr['planPredmetArr'] =  $planPredmetArr;
                        $arr['planSemestrArr'] =  $planSemestrArr;
                        $arr['planLekciiArr'] =  $planLekciiArr;
                        $arr['prepodID'] = $prepodID;
                        echo json_encode($arr);
                        $qryType = "";        
                        break;
                    case 'addTabel':
                    // отправка данных о предмете на страницу расписания
                        $dateT = "'".$_POST['dateT']."'";
                        $timeT = "'".$_POST['timeT']."'";
                        $groupT = $_POST['groupT'];
                        $predmetT = $_POST['predmetT'];
                        $kabVal = "'".$_POST['kabVal']."'";
                        $prepod = $_POST['prepod'];
                        $sql = "INSERT INTO tabel(`date`, `time`, groups, predmet, prepod, kabinet) 
                                VALUES($dateT, $timeT, $groupT, $predmetT, $prepod, $kabVal)";
                        $result = mysqli_query($link, $sql);

                        $sql = "SELECT * FROM plan WHERE groups = $groupT AND predmet = $predmetT";
                        $result = mysqli_query($link, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $count = $row['lekcii'];
                        $count = $count - 1;

                        $sql = "UPDATE plan SET lekcii = $count WHERE groups = $groupT AND predmet = $predmetT";
                        $result = mysqli_query($link, $sql);


                        break;
                }
                
                
?>