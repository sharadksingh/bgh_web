<?php
    session_start();
?>

<html>
<head>
  <title>Cat Iwse Admission </title>
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">


</head>
<body>


<?php
          
         $login_name = $_SESSION["login"];        
        if (!isset($_SESSION["loggedIn"]))
        {  
            header('Location:/login_bgh.php'); 
        }
        else
        {
            ;            
        }
?>
    
<nav class="navbar navbar-dark fixed-top bg-warning">
 <a class="navbar-brand" href="bgh_main.php"><img src="sail-logo.jpg" width="40" height="40" alt="BGH-MAIN"></a> 
  <h6>BGH IPD Admissions Data</h6>
<div class="container">
<form  class="form-inline" name="myform" action="adm_unit_wise.php" method="POST"> <input type="hidden" name="check_submit" value="1" />     
  
<div class="form-group">  
        <label for="stdate">Admission Start Date</label>  
        <input class="form-control mr-sm-2" type="date"   id="stdate" name="stdate" placeholder="fromDate" aria-label="stdate" value="<?php echo isset($_POST['stdate']) ? $_POST['stdate']:''; ?>">
    </div>     
         
         
    <div class="form-group">  
        <label for="endate">Admission To Date</label>  
        <input class="form-control mr-sm-2" type="date" id="endate" name="endate" placeholder="ToDate"   aria-label="todate" value="<?php echo isset($_POST['endate']) ? $_POST['endate']:''; ?>">
    </div>  
          
    <button class="btn btn-success my-2 my-sm-0" type="submit" name="submit">Get Data...</button>
</form>
</div>
</nav>
<br><br><br>



<?php
if (array_key_exists('check_submit', $_POST)) 
{
            $stdate =  $_POST['stdate'];
            $endate =  $_POST['endate'];
    
        function do_fetch($myeid, $myendt,  $s)
        {
//            date("d/m/Y", strtotime($str));
                print '<table class="table table-sm table-bordered table-striped table-dark w-auto table-hover">';            
                print '<thead class="thead-light">';
                print '<tr>'; 
                print '<td colspan="9">' . 'Unit Wise Admission From : ' . date("d-m-Y", strtotime($myeid)) .  '  To Date : ' . date("d-m-Y", strtotime($myendt)) . '</td>';
                print '</tr>';
                print '<tr>';
                print '<th scope="col">Unit</th>';
                print '<th scope="col">Total Patient</th>';            
                print '</tr>';
                print '</thead>';
            
/*
$s = oci_parse($c, "select postal_code from locations");
oci_execute($s);
while ($row = oci_fetch_array($s, OCI_ASSOC)) {
 echo $row["POSTAL_CODE"] . "<br>\n";
}
*/
//            cat_name, count(*) tot_count
            
//                        while ($row_1 = oci_fetch_array($scount, OCI_RETURN_NULLS+OCI_ASSOC)) {
//                        print '<b>' . $row_1["CAT_NAME"] . " =  " . $row_1["TOT_COUNT"] . " ; " . '<b>';
//                        }
                        
            
                        while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) 
                        {
                
                            print '<tr class="bg-primary">';
                            foreach ($row as $item) 
                            {                                
                                print '<td>'.($item?htmlentities($item):'&nbsp;').'</td>';
                                                                
                            }
                                print '</tr>';
                            }
                print '</table>';
        }
    
        // Create connection to Oracle
        $c = oci_connect("WARD", "hpv185e", "10.143.55.53/BGHWARD");
        // Use bind variable to improve resuability, 
        // and to remove SQL Injection attacks.
        $query = "select pat_admit_unit, count(*) tot_count from ward_admission_vw_grade 
        where  to_char(admdate,'YYYY-MM-DD') between :EIDBV and :EIDBV2 group by pat_admit_unit order by 2 desc";
    
//        $qcount = "select cat_name, count(*) tot_count from ward_admission_vw_grade 
//        where  to_char(admdate,'YYYY-MM-DD') between :EIDBV and :EIDBV2 group by cat_name";
    
        $s = oci_parse($c, $query);
//        $scount = oci_parse($c, $qcount);
    
        $myeid = $stdate;
        oci_bind_by_name($s, ":EIDBV", $myeid);
//        oci_bind_by_name($scount, ":EIDBV", $myeid);
    
        
        $myendt = $endate;
        oci_bind_by_name($s,":EIDBV2", $myendt);
//        oci_bind_by_name($scount, ":EIDBV2", $myeid);
    
        oci_execute($s);
//        oci_execute($scount);
    
    
//        while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) {
//            echo $row[0] . $row[1]. "<br>\n";
//              echo $row["HOSPNO"];
//        }
    
        do_fetch($myeid, $myendt,  $s);
    
        oci_close($c);

} 
else 
{
    
}
?> 
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/popper.js/dist/popper.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>