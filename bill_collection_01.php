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
  <h6>BGH IPD Bill Collection Report</h6>
<div class="container">
<form  class="form-inline" name="myform" action="bill_collection_01.php" method="POST"> <input type="hidden" name="check_submit" value="1" />     
  
    <div class="form-group">  
        <label for="stdate">Bill From Date</label>  
        <input class="form-control mr-sm-2" type="date"   id="stdate" name="stdate" placeholder="fromDate" aria-label="stdate" value="<?php echo isset($_POST['stdate']) ? $_POST['stdate']:''; ?>">
    </div>     
                  
    <div class="form-group">  
        <label for="endate">Bill To Date</label>  
        <input class="form-control mr-sm-2" type="date" id="endate" name="endate" placeholder="ToDate"   aria-label="todate" value="<?php echo isset($_POST['endate']) ? $_POST['endate']:''; ?>">
    </div>  
          
    <button class="btn btn-success my-2 my-sm-0" type="submit" name="submit">Get Data...</button>
</form>
</div>
</nav>
<br><br><br>

<?php
    
global $gtotal;
$gtotal =0;    
    
if (array_key_exists('check_submit', $_POST)) 
{
            $stdate =  $_POST['stdate'];
            $endate =  $_POST['endate'];
            
    
        function do_fetch($myeid, $myendt, $s)
        {
//            date("d/m/Y", strtotime($str));
             
                print '<table class="table table-sm table-bordered table-striped table-dark w-auto table-hover">';            
                print '<thead class="thead-light">';
                print '<tr>'; 
                print '<td colspan="9">' . 'Cash Collection (As Advance) From : ' . date("d-m-Y", strtotime($myeid)) .  '  To Date : ' . date("d-m-Y", strtotime($myendt)) . '</td>';
                print '</tr>';
                print '<tr>';
                print '<th scope="col">Pay Mode</th>';            
                print '<th scope="col">Total Amount (Rs.)</th>';
                print '</tr>';
                print '</thead>';
                          
                        $x = 0;
                        while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) 
                        {
                            $x = $x + $row["RCPT_AMOUNT"];
                            
                            print '<tr class="bg-primary">';
                            foreach ($row as $item) 
                            {                                
                                print '<td>'.($item?htmlentities($item):'&nbsp;').'</td>';
                                                                
                            }
                                print '</tr>';
                            }
                print '<tr>';
                        print '<td>' . 'Total Adv Receipt' .  '</td>';
                        print '<td>' .  $x .  '</td>';
                print '</tr>';   
                    $GLOBALS['gtotal'] = $GLOBALS['gtotal']  + $x;
            print '</table>';
                

                print '<br>';
        }
   
    function do_fetch_1($myeid, $myendt, $s)
        {
//            date("d/m/Y", strtotime($str));
                print '<table class="table table-sm table-bordered table-striped table-dark w-auto table-hover">';            
                print '<thead class="thead-light">';
                print '<tr>'; 
                print '<td colspan="9">' . 'Cash Collection (As Receipt) From : ' . date("d-m-Y", strtotime($myeid)) .  '  To Date : ' . date("d-m-Y", strtotime($myendt)) . '</td>';
                print '</tr>';
                print '<tr>';
                print '<th scope="col">Pay Mode</th>';            
                print '<th scope="col">Total Amount (Rs.)</th>';
                print '</tr>';
                print '</thead>';
                        
                        $x = 0;
            
                        while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) 
                        {
                            $x = $x + $row["RCPT_AMOUNT"];
                            
                            print '<tr class="bg-primary">';
                            foreach ($row as $item) 
                            {                                
                                print '<td>'.($item?htmlentities($item):'&nbsp;').'</td>';
                                                                
                            }
                                print '</tr>';
                            }
                
                print '<tr>';
                        print '<td>' . 'Total Cash Receipt' .  '</td>';
                        print '<td>' .  $x .  '</td>';
                print '</tr>';   
                        $GLOBALS['gtotal'] = $GLOBALS['gtotal'] + $x; 
                
                print '<tr>';
                        print '<td>' . 'Grand Total' .  '</td>';
                        print '<td>' .  $GLOBALS['gtotal'] .  '</td>';
                print '</tr>';   
        print '</table>';

        }
    
    
        // Create connection to Oracle
        $c = oci_connect("WARD", "hpv185e", "10.143.55.53/BGHWARD"); 
        $query = "select pay_mode, sum(rcpt_amount) rcpt_amount from adm_advance
                  where to_char(rcpt_dt,'YYYY-MM-DD') between :EIDBV and :EIDBV2
                  group by pay_mode order by 2 desc";
    
    
        $s = oci_parse($c, $query);    
        $myeid = $stdate;
        oci_bind_by_name($s, ":EIDBV", $myeid);
    
        
        $myendt = $endate;
        oci_bind_by_name($s,":EIDBV2", $myendt);
 
       
    
        oci_execute($s);
        do_fetch($myeid, $myendt, $s);
        oci_close($c);

    // Cash Receipt

       

    
        $c = oci_connect("WARD", "hpv185e", "10.143.55.53/BGHWARD"); 
        $query = "select pay_mode, sum(rcpt_total_amount) rcpt_amount from adm_cash_receipt
                  where to_char(rcpt_date,'YYYY-MM-DD') between :EIDBV and :EIDBV2
                  group by pay_mode order by 2 desc";
    
    
        $s = oci_parse($c, $query);    
        $myeid = $stdate;
        oci_bind_by_name($s, ":EIDBV", $myeid);
    
        
        $myendt = $endate;
        oci_bind_by_name($s,":EIDBV2", $myendt);
 
    
        oci_execute($s);
        do_fetch_1($myeid, $myendt, $s);

    
    
//    oci_close($c);

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