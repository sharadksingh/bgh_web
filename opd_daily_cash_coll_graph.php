<?php
    session_start();
?>

<html>
<head>
  <title>OPD: Cash Collection</title>
  
<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
<script src="node_modules/jquery/dist/jquery.min.js"></script>

  
  
  
  <style>
  label,h6 {
        color:blue;
        text-align: left;
        margin-top: 5px;
        padding: 0px;
        font-weight: bold;
        font-style: normal;        
    }
</style>    
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
  <h6>BGH OPD Daily Cash Collection</h6>
<div class="container">
<form  class="form-inline" name="myform" action="opd_daily_cash_coll_graph.php" method="POST">
                <input type="hidden" name="check_submit" value="1" />
    <form class="form-inline">   
        <div class="form-group row">
            <label for="stdate" class="mr-sm-3 col-form-label">Cash Collection From Date</label> 
                <div class="mr-sm-3">
                    <input type="date" class="form-control" id="stdate" name="stdate" 
                    value="<?php echo isset($_POST['stdate']) ? $_POST['stdate']:''; ?>">
                </div>                       
            <label for="endate" class="mr-sm-3 col-form-label">Cash Collection To Date</label> 
                <div class="mr-sm-3">
                    <input type="date" class="form-control" id="endate" name="endate"
                    value="<?php echo isset($_POST['endate']) ? $_POST['endate']:''; ?>">
                </div>                                            
            <button type="submit" name="submit" class="btn btn-primary">Get Data.</button>                       
<!--
            <button type="button" onclick=<?php do_fetch();?> name="btngraph" class="btn btn-success">Show Graph.</button>                       
-->            

        </div>
    </form>            
  </form>
</div>  
</nav>

<br><br><br>

<?php    
global $gtotal;
$gtotal =0;    
function do_fetch()
{     
    
// Create connection to Oracle
        $c = oci_connect("WARD", "hpv185e", "10.143.55.53/BGHWARD"); 
        $query = "select visit_date, to_number(total) total 
                  from VIEW_CTR_101_DAILY_CASH_TOTAL
                  where to_char(visit_date,'YYYY-MM-DD') between '2020-06-01' and '2020-06-20' 
                  order by 1 asc";
        $s = oci_parse($c, $query);    
//        $myeid = $stdate;
//        oci_bind_by_name($s, ":EIDBV", $myeid);
//        $myendt = $endate;
//        oci_bind_by_name($s,":EIDBV2", $myendt);
        oci_execute($s);
//        do_graph($myeid, $myendt, $s);
//        do_fetch($myeid, $myendt, $s);        
        oci_close($c);
        print '<table class="table table-sm table-bordered table-striped table-dark w-auto table-hover">';            
        print '<thead class="thead-light">';
        print '<tr>'; 
//        print '<td colspan="9">' . 'Cash Collection From : ' . date("d-m-Y", strtotime($myeid)) .  '  To Date : ' . date("d-m-Y", strtotime($myendt)) . '</td>';
        print '</tr>';
        print '<tr>';
        print '<th scope="col">Date OF Visit</th>';
        print '<th scope="col">Total Collection (Rs.)</th>';
        print '</tr>';
        print '</thead>';
                  
                $x = 0;
                $gtotal = 0;
                
                while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) 
                {
                    $x = $x + 1;
                    $gtotal = $gtotal + $row["TOTAL"];
                    if ($x%2==0) {
                        print '<tr class="bg-primary">';}
                    else {
                        print '<tr class="bg-information">';}                                
                    
                    foreach ($row as $item) 
                    {                                
                        print '<td>'.($item?htmlentities($item):'&nbsp;').'</td>';
                                                        
                    }
                        print '</tr>';
                    }
        print '<tr>';
                print '<td>' . 'Total Collection (Rs.)' .  '</td>';
                print '<td align="right">' .  $gtotal .  '</td>';
        print '</tr>';   
    print '</table>';
        

        print '<br>';
}


 if (array_key_exists('check_submit', $_POST))
{
            $stdate =  $_POST['stdate'];
            $endate =  $_POST['endate'];
            
    
   
        function do_graph($myeid, $myendt, $s)
        {
                
                print '<table class="highchart" data-graph-container-before="1" data-graph-type="spline" 
                        style="display:none" 
                        data-graph-height="600" data-graph-margin-left="150" data-graph-margin-right="50" 
                        data-graph-legend-disabled="0" 
                        data-graph-legend-layout="horizontal"
                        data-graph-subtitle-text="OPD CASH COLLECTION">';
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
        $query = "select visit_date, to_number(total) total 
                  from VIEW_CTR_101_DAILY_CASH_TOTAL
                  where to_char(visit_date,'YYYY-MM-DD') between :EIDBV and :EIDBV2 
                  order by 1 asc";
    
    
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

 
<!-- 
<script>
function myFunction() {
    alert("Demo Alert");
    location.replace("opd_daily_cash_collgr01.html");
}  
</script>
-->

<script>
        $(document).ready(function() {
        $('table.highchart').highchartTable();
      });
</script>

<script>
function myFunction() 
{
    alert("Demo Alert");
//    do_fetch($myeid, $myendt, $s);
//    location.replace("opd_daily_cash_collgr01.html");
      document.write('<?php do_fetch();?>');
}  
</script>  
    
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/popper.js/dist/popper.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="../highcharts/highcharts.src.js"></script>
<script src="../highcharts/highcharts.js"></script>
<script src="../highcharts/jquery.highchartTable.js"></script>



</body>
</html>