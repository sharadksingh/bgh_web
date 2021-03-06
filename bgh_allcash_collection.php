<!DOCTYPE html>
<html>
  <head>
<!--  
<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="node_modules/datatables.net-bs4/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="node_modules/datatables.net-dt/css/jquery.dataTables.min.css">
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
-->

<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="DataTables/datatables.min.css" rel="stylesheet" type="text/css" />
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/popper.js/dist/popper.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="node_modules/datatables.net/js/jquery.dataTables.min.js"></script>


<style>
    body 
    {
        font: 90%/1.45em "Helvetica Neue", HelveticaNeue, Verdana, Arial, Helvetica, sans-serif;
        margin: 0;
        padding: 0;
        color: #333;
        background-color: #fff;
    }

    label,h6 {
        color:blue;
        text-align: left;
        margin-top: 5px;
        padding: 0px;
        font-weight: bold;
        font-style: normal;        
    }


</style>

    <meta charset=utf-8 />
    <title>BGH - All Cash Collection (IPD+OPD)</title>
  </head>
  <body>




<!--<div class="container"> -->

<nav class="navbar navbar-dark fixed-top bg-warning">
 <a class="navbar-brand" href="bgh_main.php"><img src="sail-logo.jpg" width="40" height="40" alt="BGH-MAIN"></a> 
  <h6>BGH All Cash Collection</h6>
<div class="container">
<form  class="form-inline" name="myform" action="bgh_allcash_collection.php" method="POST"> <input type="hidden" name="check_submit" value="1" />     
  
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
         
        function do_fetch($mystdate, $myendate, $s)
        {
            print '<table class="table table-hover table-striped table-bordered mydatatable" style="width:100%">'; 
      
            print '<thead>';           
            print '<tr>';
                print '<th scope="col">Year-Month</th>';
                print '<th scope="col">Total-Amount</th>';
            print '</tr>';
            print '</thead>';   

            print '<tfoot>';           
            print '<tr>';
                print '<th scope="col">Year-Month</th>';
                print '<th scope="col">Total-Amount</th>';
            print '</tr>';
            print '</tfoot>';   
            
            
            print '<tbody>';    
                        while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) 
                        {
                            print '<tr>';
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
        // Use bind variable to improve resuability, 
        // and to remove SQL Injection attacks.

//        $query = "select (hospno||'/'||hospyr) hospno, pat_name, pat_age,pat_sex gender, 
//                pfrom1, admdate, admtime, ent_nonent ent, medlegal,pat_local_add, pat_admit_unit, 
//                  pat_provdiag 
//                  from WARD_ADMISSION_VW 
//                  where to_char(admdate,'YYYY-MM-DD') between :EIDBV and :EIDBV1 order by hospno";

        $query = "select to_char(rcpt_dt,'YYYY-MM') , sum(rcpt_amount)  
                from BGH_ALL_CASH_RECEIPTS_VIEW
                where to_char(rcpt_dt,'YYYY-MM-DD') between :EIDBV and :EIDBV1
                group by to_char(rcpt_dt,'YYYY-MM')
                order by to_char(rcpt_dt,'YYYY-MM')";


        $s = oci_parse($c, $query);

        $mystdate = $stdate;
        oci_bind_by_name($s, ":EIDBV", $mystdate);

        $myendate = $endate;
        oci_bind_by_name($s, ":EIDBV1", $myendate);
// Execute the query
        oci_execute($s);
// fecth data
        do_fetch($mystdate, $myendate, $s);
//        do_fetch($s);
    

        // Close the Oracle connection
        oci_close($c);

} 
else 
{
    
}
?> 

<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="node_modules/datatables.net/js/jquery.dataTables.min.js"></script>



<script>
$(document).ready(function() {
    $('.mydatatable').DataTable( {
        "scrollY":        "500px",
        "scrollCollapse": true,
        "paging":         false
    } );
} );
</script>  



<!-- </div> -->   
</body>
</html>