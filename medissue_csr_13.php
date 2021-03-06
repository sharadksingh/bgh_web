<?php
/*
  This Program take scare of the Medicine Issued from Counter 20 for CSR Sarwa Swasthya Kendra
*/
    session_start();
?>

<html>
<head>
  <title>Medicne Issued For CSR: Medical Camps </title>
  
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
    
<!-- Nav Bar for position at the top of page-->  
<nav class="navbar navbar-dark fixed-top bg-warning">
 <a class="navbar-brand" href="bgh_main.php"><img src="sail-logo.jpg" width="40" height="40" alt="BGH-MAIN"></a> 
  <h6>Medicine Issue To CSR-13</h6>
<div class="container">
<form  class="form-inline" name="myform" action="medissue_csr_13.php" method="POST"> <input type="hidden" name="check_submit" value="1" />     
  
<div class="form-group">  
        <label for="stdate">From Date</label>  
        <input class="form-control mr-sm-2" type="date"   id="stdate" name="stdate" placeholder="fromDate" aria-label="stdate" value="<?php echo isset($_POST['stdate']) ? $_POST['stdate']:''; ?>">
    </div>     
         
         
    <div class="form-group">  
        <label for="endate">To Date</label>  
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
    
        function do_fetch($myeid, $myendt,  $s, $scount)            
            {
                print '<table class="table table-sm table-bordered table-striped table-dark w-auto table-hover">';            
                print '<thead class="thead-light">';
                print '<tr>'; 
                print '<td colspan="9">' . 'Medicine Issued From Date : ' . $myeid .  '  To Date : ' . $myendt . '</td>';
                print '</tr>';
                print '<tr>';
                print '<th scope="col">Cat No</th>';
                print '<th scope="col">Med Name</th>';
                print '<th scope="col">Total Issue (Qty)</th>';
                print '<th scope="col">Total Value (Rs.)</th>';   
                print '</tr>';
                print '</thead>';
            
// print the total value of the medicine issued to the CSR Counter  
                print '<tr>';
                while ($row_1 = oci_fetch_array($scount, OCI_RETURN_NULLS+OCI_ASSOC)) 
                {            
                    print '<b>' . 'Total Value of Medicine Issued to CSR HC-5 is Rs.: ' . $row_1["TOT_VALUE"] . '</b>';
                    
                }                        
                print '</tr>';

// Print the data in Table            
                        while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) 
                        {                            
                            print '<tr>';

                            foreach ($row as $item) 
                            { 
                                
                                print '<td>'.($item?htmlentities($item):'&nbsp;').'</td>';
                                                                
                            }
                                print '</tr>';
                            }
                print '</table>';
        }
    
    
        // Create connection to Oracle
        $c = oci_connect("BGH", "hpv185e", "10.143.100.36/BGH6");
        // Use bind variable to improve resuability, 
        // and to remove SQL Injection attacks.
    
        $query = "select old_cat_no, med_desc, sum(issue_qty) tot_issue, sum(tot_rate) tot_value 
        from BGH_MED_STOCK_ISSUE_VW 
        where ctrno = '20' and to_char(issue_dt,'YYYY-MM-DD') between :EIDBV and :EIDBV2 
        group by  old_cat_no, med_desc order by med_desc";
    
        $qcount = "select sum(tot_rate) TOT_VALUE from BGH_MED_STOCK_ISSUE_VW 
        where  ctrno = '20' and to_char(issue_dt,'YYYY-MM-DD') between :EIDBV and :EIDBV2";
    
        $s = oci_parse($c, $query);
        $scount = oci_parse($c, $qcount);
    
        $myeid = $stdate;
        oci_bind_by_name($s, ":EIDBV", $myeid);
        oci_bind_by_name($scount, ":EIDBV", $myeid);
    
        
        $myendt = $endate;
        oci_bind_by_name($s, ":EIDBV2", $myendt);
        oci_bind_by_name($scount, ":EIDBV2", $myendt);
    
        oci_execute($s);
        oci_execute($scount);
    
/*   
        while ($row_1 = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) {
            echo $row_1[0] . $row_1[1]. "<br>\n";
              echo $row_1["tot_value"];
        }
*/        
    
        do_fetch($myeid, $myendt,  $s, $scount);
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