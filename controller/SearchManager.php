<?php
                    $sel = ''; $word ='';
                    if(isset($_POST['submit']))
                    {
                        $sel = $_POST["sel"];
                        $word = $_POST["word"];
                        
                        if($sel == "search_date")
                        {
                            echo $sel,$word;
                            if(strlen($word) != 21)
                            {
                                echo '<script>alert("Wrong input"); location.href="Main.php";</script>';
                            }
                            
                            else
                                {
                                    for($i = 0; $i < length(workd); $i++)
                                    {
                                        if((charAt($word,i) < '0' || charAt($word,i) > '9') && (charAt(word, i) != '-' && charAt(word,i) != ','))
                                        {
                                            echo "<script>alert('Wrong input'); location.href='Main.php';</script>";
                                        }
                                    }
                                    $s_date = substring($word,0,10);
                                    $e_date = substring($word,11,21);
                                    echo ".$s_date. + ' '+ .$e_date.)";
                                    $sql = "select r.RoomID, r.room_title, r.hostID, r.cost, r.add1, r.add2, r.add3, r.add4, a.evaluation from room_info r, account a where a.ID = r.hostID order AND (s_date >= '$s_date' AND e_date <= '$e_date') by room_title";
                                }
                            
                        }   
                        else if($sel == "search_person")
                        {
                            for($i = 0; $i < strlen($word); $i++)
                            {
                                if($word{$i} < '0' || $word{$i} > '9')
                                {
                                    echo "<script>alert('Wrong input'); location.href='Main.php';</script>";
                                }
                            }
                            $sql = "select r.RoomID, r.room_title, r.hostID, r.cost, r.add1, r.add2, r.add3, r.add4, a.evaluation from room_info r, account a where a.ID = r.hostID AND (max_p >= '$word') order by room_title";
                        }
                        else if($sel == "search_location")
                        {
                            $sql = "select r.RoomID, r.room_title, r.hostID, r.cost, r.add1, r.add2, r.add3, r.add4, a.evaluation from room_info r, account a where a.ID = r.hostID AND (r.add1 like '%$word%' or r.add2 like '%$word%' or r.add3 like '%$word%' or r.add4 like '%$word%') order by room_title";
                        }	
                    }

                    if($sel == null || $word == null || $word == "")
                    {
                        $sql = "select r.RoomID, r.room_title, r.hostID, r.cost, r.add1, r.add2, r.add3, r.add4, a.evaluation from room_info r, account a where a.ID = r.hostID order by room_title";
                    }

                    $stmt = mysqli_stmt_init($conn);                        
                    if ($stmt = mysqli_prepare($conn, $sql)) 
                    {
                        // initialise connection
                        mysqli_stmt_execute($stmt);
                        // bind the results to their own variables
                       mysqli_stmt_bind_result($stmt, $rid, $title, $host, $price, $add1, $add2, $add3, $add4, $score);
                    }