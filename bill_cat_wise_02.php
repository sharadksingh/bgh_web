<?php
    session_start();
?>

<html>
<head>
  <title>Bill: Category Wise</title>
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
  <h6>BGH IPD Billing Category Wise</h6>
<div class="container">
<form  class="form-inline" name="myform" action="bill_cat_wise_02.php" method="POST"> <input type="hidden" name="check_submit" value="1" />     
  
    <div class="form-group">  
        <label for="stdate">Bill From Date</label>  
        <input class="form-control mr-sm-2" type="date"   id="stdate" name="stdate" placeholder="fromDate" aria-label="stdate" value="<?php echo isset($_POST['stdate']) ? $_POST['stdate']:''; ?>">
    </div>     
                  
    <div class="form-group">  
        <label for="endate">Bill To Date</label>  
        <input class="form-control mr-sm-2" type="date" id="endate" name="endate" placeholder="ToDate"   aria-label="todate" value="<?php echo isset($_POST['endate']) ? $_POST['endate']:''; ?>">
    </div>  


    <div class="form-group">     
    <label for="group">Group</label>
          <div class="mr-sm-3">
          <select id="group" name="group" class="form-control">
          <option value="<?php echo isset($_POST['group']) ? $_POST['group']:'A'; ?>">
              <?php echo isset($_POST['group']) ? $_POST['group']:'A'; ?>
          </option>       
          
           <?php          
                $c = oci_connect("WARD", "hpv185e", "10.143.55.53/BGHWARD");
                $sql = "select distinct catg from wardbill_catedic order by 1";  
                $stid = oci_parse($c, $sql);  
                $success = oci_execute($stid);
                while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)){
                    print '<option> ' . $row["CATG"] . '</option>';
                }  
                    oci_close($c);  
            ?>                    
      </select>
      </div>
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
            $group  =  $_POST['group'];
    
    
        function do_fetch($myeid, $myendt, $mygroup, $s)
        {
//            date("d/m/Y", strtotime($str));
                print '<table class="table table-sm table-bordered table-striped table-dark w-auto table-hover">';            
                print '<thead class="thead-light">';
                print '<tr>'; 
                print '<td colspan="9">' . 'Billing party Wise From : ' . $mygroup . '  ' . date("d-m-Y", strtotime($myeid)) .  '  To Date : ' . date("d-m-Y", strtotime($myendt)) . '</td>';
                print '</tr>';
                print '<tr>';
                print '<th scope="col">Group-Name</th>';            
                print '<th scope="col">Category-Name</th>';
                print '<th scope="col">Total Bill (Rs.)</th>';            
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
    
        $query = "select hospcg, name party_name, sum(bill_grand_total) total_bill from view_wardbill_rgstrpat_01
                  where to_char(hbilldt,'YYYY-MM-DD') between :EIDBV and :EIDBV2 and hospcg=:EIDBV3
                  group by hospcg, name 
                  order by hospcg, name desc";
    
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
 
        $myendt = $endate;
        oci_bind_by_name($s,":EIDBV2", $myendt);

        $mygroup = $group;
        oci_bind_by_name($s,":EIDBV3", $mygroup);

    
        oci_execute($s);
//        oci_execute($scount);
    
    
//        while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) {
//            echo $row[0] . $row[1]. "<br>\n";
//              echo $row["HOSPNO"];
//        }
    
        do_fetch($myeid, $myendt, $mygroup,   $s);
    
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