<?php
	include_once("config.php");
	session_start();
	

    $locationsql=mysqli_query($conn,"SELECT * FROM category");
    $output="";
    if(mysqli_num_rows($locationsql) > 0){
        $output.='  <center><div class="row" style="position:relative;>
                        <div class="col-sm-offset-2 col-md-9 text-center">';
        
        
        while($row = mysqli_fetch_array($locationsql)) 
        {
            if($row['category_code']!= "MAC" and $row['category_code']!= "CPU" and $row['category_code']!= "LAP" and $row['category_code']!= "SRV"){
                $code = $row['category_code'];
                $sql = mysqli_query($conn,"SELECT * FROM components where componentid like '$code%' and status = 2");
                $idsql = mysqli_query($conn,"SELECT count(*) as count FROM components where componentid like '$code%' and status = 2");
                $lab = mysqli_fetch_assoc($idsql);
                if(mysqli_num_rows($sql)>0)
                {
                    $output.='
                            <table class="table table-condensed" border="1">
                            <caption><center><h4 class="text-center"><b>'.$row['category'].' not working count : '.$lab['count'].' </b></h4></center></caption>
                                <tr>
                                <th>Component ID</th>
                                <th>Description</th>
                                <th>Problem Description</th>
                                </tr>';
                    while($labsys = mysqli_fetch_assoc($sql))
                    {
                        $output .='<tr>
                            <td>'.$labsys['componentid'].'</td>
                            <td>'.$labsys['brand'].','.$labsys['type'].','.$labsys['description'].'</td>
                            <td>'.$labsys['problem_description'].'</td>
                            </tr>';
                    }

                    $output .='</table> <br><br><br>';
                }
                else{
                    // $output.='<caption><center><h4 class="text-center"><b>'.$row['category'].' working fine.</b></h4></center></caption>
                    // <br><br><br>';
                }

            }else{
                $code = $row['category_code'];
                $sql=mysqli_query($conn,"SELECT * FROM cpu where cpu_id like '$code%' and status = 2");
                $idsql = mysqli_query($conn,"SELECT count(*) as count FROM cpu where cpu_id like '$code%' and status = 2");
                $lab = mysqli_fetch_assoc($idsql);
                if(mysqli_num_rows($sql)>0)
                {
                    
                    $output.=' 
                            <table class="table table-condensed" border="1">
                            <caption><center><h4 class="text-center"><b>'.$row['category'].' not working count : '.$lab['count'].' </b></h4></center></caption>
                                <tr>
                                <th>Component ID</th>
                                <th>Description</th>
                                <th>Problem Description</th>
                                </tr>';
                    while($labsys=mysqli_fetch_assoc($sql))
                    {
                        $output .='<tr>
                            <td>'.$labsys['cpu_id'].'</td>
                            <td>'.$labsys['RAM'].','.$labsys['processor_series'].','.$labsys['storage'].','.$labsys['description'].'</td>
                            <td>'.$labsys['problem_description'].'</td>
                            </tr>';
                    }	

                    $output .='</table> <br><br><br>';

                }
                else{
                    // $output.='<caption><center><h4 class="text-center"><b>'.$row['category'].' working fine.</b></h4></center></caption>
                    // <br><br><br>';
                }
               
            }

        }
        //$sql6 = mysqli_query($conn,"INSERT INTO log(user_id,id,description,purpose) VALUES({$_SESSION['unique_id']},'NA','NA','Generated a report for not working components and systems.')");

    }
    else{
        echo '<div class="alert alert-info">
        <strong>Category sql failure</strong> 
        </div>';
    }
    $output .='</div></center>';
    echo $output;
	
?>