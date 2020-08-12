<?php
/*
  This Program displays the counterwise expiry, damage and breakage entry for a fiancual year
  Same program if selected ALL in the counter list displays the consolidated List
*/
    session_start();
?>

<html>
<head>
  <title>Bill: Billing Under Heads</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    

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
  <h6>BGH Ward Lab Test Report</h6>
<div class="container">
<form  class="form-inline" name="myform" action="wardlab_status_rep_01.php" method="POST"> <input type="hidden" name="check_submit" value="1" />     
  
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
    
                if (isset($_POST['stdate'])){$stdate    =  $_POST['stdate'];}
                if (isset($_POST['endate'])){$endate    =  $_POST['endate'];}
   
        function do_fetch($lab_type, $mystdate, $myendate, $s)            
            {
                print '<table class="table table-sm table-bordered table-striped table-dark w-auto table-hover">'; 
                print '<thead class="thead-light">';
                print '<tr>'; 
                if ($lab_type=='BBN') {
                    print '<td colspan="9">' . 'Status Report For Blood Bank : ' . date("d-m-Y", strtotime($mystdate)) .  ' and ' . date("d-m-Y", strtotime($myendate)) . '</td>';
                }
                elseif ($lab_type=='BCHM') {
                    print '<td colspan="9">' . 'Status Report  For BioChemistry : ' . date("d-m-Y", strtotime($mystdate)) .  ' and ' . date("d-m-Y", strtotime($myendate)) . '</td>';                
                }
                elseif ($lab_type=='PATH') {
                    print '<td colspan="9">' . 'Status Report  For Pathology : ' . date("d-m-Y", strtotime($mystdate)) .  ' and ' . date("d-m-Y", strtotime($myendate)) . '</td>';                
                }
                elseif ($lab_type=='ROUT') {
                    print '<td colspan="9">' . 'Status Report  For Urine Routine : ' . date("d-m-Y", strtotime($mystdate)) .  ' and ' . date("d-m-Y", strtotime($myendate)) . '</td>';                
                }
                elseif ($lab_type=='BACT') {
                    print '<td colspan="9">' . 'Status Report  For Bacteriology : ' . date("d-m-Y", strtotime($mystdate)) .  ' and ' . date("d-m-Y", strtotime($myendate)) . '</td>';                
                }

                print '</tr>';
                print '<tr>';
                print '<th scope="col">TestCode</th>';
                print '<th scope="col">TestName</th>';
                print '<th scope="col">Count</th>';
                print '</thead>';            

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
        $c = oci_connect("WARD", "hpv185e", "10.143.55.53/BGHWARD");
  
        // Variable for Holding the type of Lab
        $lab_type = 'BBN';
        // Blood bank Non Conformity Report    

        $query = "select a.test_code, b.test_desc, count(a.test_code) ctest_code 
                from wardlab.bgh_wardlab_01_vw a, wardlab.lab_blood_bank b 
                where to_char(a.sample_dt, 'YYYY-MM-DD')  between  :EIDBV and :EIDBV2 
                and a.lab_code='01' 
                and a.res_dt is not null 
                and a.test_code=b.test_code
                group by a.lab_code, a.test_code, b.test_desc
                order by a.test_code";
    
        $s = oci_parse($c, $query);
        $mystdate = $stdate;
        oci_bind_by_name($s, ":EIDBV", $mystdate);
        $myendate = $endate;
        oci_bind_by_name($s, ":EIDBV2", $myendate);    
        oci_execute($s); 
        do_fetch($lab_type, $mystdate, $myendate, $s);
        
// For BioChemistry
        $lab_type = 'BCHM';
        $query = "select a.test_code, b.test_desc, count(a.test_code) ctest_code 
        from wardlab.bgh_wardlab_02_vw a,  wardlab.lab_biochemistry b 
        where to_char(a.sample_dt, 'YYYY-MM-DD')  between  :EIDBV and :EIDBV2 
        and a.lab_code='02' 
        and a.res_dt is not null 
        and a.test_code=b.testno
        group by a.lab_code, a.test_code, b.test_desc
        order by a.test_code";


        $s = oci_parse($c, $query);

        $mystdate = $stdate;
        oci_bind_by_name($s, ":EIDBV", $mystdate);
        $myendate = $endate;
        oci_bind_by_name($s, ":EIDBV2", $myendate);    
        oci_execute($s); 
        do_fetch($lab_type, $mystdate, $myendate, $s);
               
        // For Pathology
        $lab_type = 'PATH';
        $query = "select a.test_code, b.test_desc, count(a.test_code) ctest_code 
        from wardlab.bgh_wardlab_03_vw a, wardlab.lab_pathology b  
        where to_char(a.sample_dt, 'YYYY-MM-DD')  between  :EIDBV and :EIDBV2 
        and a.lab_code='03' 
        and a.res_dt is not null 
        and a.test_code=b.code
        group by a.lab_code, a.test_code, b.test_desc
        order by a.test_code";

        $s = oci_parse($c, $query);

        $mystdate = $stdate;
        oci_bind_by_name($s, ":EIDBV", $mystdate);
        $myendate = $endate;
        oci_bind_by_name($s, ":EIDBV2", $myendate);    
        oci_execute($s); 
        do_fetch($lab_type, $mystdate, $myendate, $s);

        // For Urine Routine
        $lab_type = 'ROUT';

        $query = "select a.test_code, b.test_desc, count(a.test_code) ctest_code 
        from wardlab.bgh_wardlab_10_vw a, wardlab.lab_routine b  
        where to_char(a.sample_dt, 'YYYY-MM-DD')  between  :EIDBV and :EIDBV2 
        and a.lab_code='10' 
        and a.res_dt is not null 
        and a.test_code=b.test_code
        group by a.lab_code, a.test_code, b.test_desc
        order by a.test_code";

        $s = oci_parse($c, $query);
        $mystdate = $stdate;
        oci_bind_by_name($s, ":EIDBV", $mystdate);
        $myendate = $endate;
        oci_bind_by_name($s, ":EIDBV2", $myendate);    
        oci_execute($s); 
        do_fetch($lab_type, $mystdate, $myendate, $s);

        // For Bacteriology
        $lab_type = 'BACT';
        $query = "select a.test_code, b.bactest, count(a.test_code) ctest_code 
        from wardlab.bgh_wardlab_04_vw a, wardlab.lab_bacteriology b  
        where to_char(a.sample_dt, 'YYYY-MM-DD')  between  :EIDBV and :EIDBV2 
        and a.lab_code='04' 
        and a.res_dt is not null 
        and a.test_code=b.test_code
        group by a.lab_code, a.test_code, b.bactest
        order by a.test_code";

        $s = oci_parse($c, $query);

        $mystdate = $stdate;
        oci_bind_by_name($s, ":EIDBV", $mystdate);
        $myendate = $endate;
        oci_bind_by_name($s, ":EIDBV2", $myendate);    
        oci_execute($s); 
        do_fetch($lab_type, $mystdate, $myendate, $s);

        
        
// Close the connection        
        oci_close($c);

} 
else 
{
    
}
?> 
 
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>  
</body>
</html>