<?php
    session_start();
?>

<html>
<head>
  <title>IPD: Cash Collection</title>
<!--  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
-->

<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
<script src="node_modules/jquery/dist/jquery.min.js"></script>


<!--
<script src="https://code.highcharts.com/highcharts.src.js"></script>
<script src="jquery.highchartTable.js" type="text/javascript"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharttable.org/master/jquery.highchartTable-min.js"></script>
-->
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
  <h6>BGH IPD Billing Headwise</h6>
<div class="container">
<form  class="form-inline" name="myform" action="ipd_daily_cash_coll_graph.php" method="POST"> <input type="hidden" name="check_submit" value="1" />     
  
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
            
    
   
        function do_graph($myeid, $myendt, $s)
        {
                
                print '<table class="highchart" data-graph-container-before="1" data-graph-type="spline" 
                        style="display:none" 
                        data-graph-height="600" data-graph-margin-left="50" data-graph-margin-right="50" 
                        data-graph-legend-disabled="0" 
                        data-graph-legend-layout="horizontal"
                        data-graph-subtitle-text="IPD DAILY CASH COLLECTION">';
                print '<thead>';
                print '<tr>';
                      print '<th>Date</th>';
                      print '<th>Collection</th>';
                print '</tr>';
                print '</thead>';
                print '<tbody>';

                while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) 
                        {   print '<tr>';                         
                            foreach ($row as $item) 
                            {        
                                                    
                                print '<td>'.($item?htmlentities($item):'&nbsp;').'</td>';                                                                
                            }
                                print '</tr>';
                            }
                print '</tbody>';
                print '</table>';
               
        }
    
        // Create connection to Oracle
        $c = oci_connect("WARD", "hpv185e", "10.143.55.53/BGHWARD"); 
        $query = "select rcpt_dt, sum(rcpt_amount) rcpt_amount
                  from ward_all_cash_receipts                  
                  where to_char(rcpt_dt,'YYYY-MM-DD') between :EIDBV and :EIDBV2 
                  group by rcpt_dt order by rcpt_dt";
    
    
        $s = oci_parse($c, $query);    
        $myeid = $stdate;
        oci_bind_by_name($s, ":EIDBV", $myeid);
    
        
        $myendt = $endate;
        oci_bind_by_name($s,":EIDBV2", $myendt);
 
       
    
        oci_execute($s);
        do_graph($myeid, $myendt, $s);
//        do_fetch($myeid, $myendt, $s);
        
        oci_close($c);

} 
else 
{
   
    
}
?> 


<script>
        $(document).ready(function() {
        $('table.highchart').highchartTable();
      });
</script>


<!--    
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>  
-->

<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/popper.js/dist/popper.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="highcharts/highcharts.src.js"></script>
<script src="highcharts/highcharts.js"></script>
<script src="highcharts/jquery.highchartTable.js"></script>


</body>
</html>