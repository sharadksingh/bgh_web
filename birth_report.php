<!DOCTYPE html>
<html>
  <head>
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
</style>

    <meta charset=utf-8 />
    <title>Birth Report for a Period (Labour Room Stats)</title>
  </head>
  <body>

<!-- Nav Bar for position at the top of page-->  
<nav class="navbar navbar-dark fixed-top bg-warning " style="height:50px; position: absolute;">
 <a class="navbar-brand" href="bgh_main.php"><img src="sail-logo.jpg" width="40" height="40" alt="BGH-MAIN"></a> 
  <h6>BGH Stats-Mortality</h6>
<div class="container">
<form  class="form-inline" name="myform" action="birth_report.php" method="POST"> <input type="hidden" name="check_submit" value="1" />     
  
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
</nav>
<br><br><br>


<?php
if (array_key_exists('check_submit', $_POST)) 
{
  if (isset($_POST['stdate'])){$stdate    =  $_POST['stdate'];}
  if (isset($_POST['endate'])){$endate    =  $_POST['endate'];}
         
        function do_fetch($mystdate, $myendate, $s)
        {
            //Fetch the results in an associative array
            //print '<p>$myeid is ' . $myeid . '</p>';
            //print '<p>Data Showing For the Date:' . $myeid . '</p>';
            // <table class="table table-dark">
            // print '<table class="table table-sm table-bordered table-striped table-dark w-auto"  border="1">';
            
//            print '<table id="example" class="display" style="width:100%">';
//            print '<table id="example" class="table table-striped table-bordered" style="width:100%">';  

//            print '<table id="example" class="display wrap table-bordered" width="100%">';          
            print '<table class="table table-striped  table-bordered mydatatable" style="width:100%">'; 

//            print '<tr>'; 
//              print '<td  colspan="9">' . 'Admission Data From : ' . date('d-m-Y', strtotime($mystdate)) . ' To '. date('d-m-Y', strtotime($myendate)) .  '</td>';
//            print '</tr>';  

            print '<thead>';           
            print '<tr>';
                print '<th scope="col">YNo</th>';
                print '<th scope="col">HospNo</th>';
                print '<th scope="col">Mother</th>';
                print '<th scope="col">Age</th>';            
                print '<th scope="col">AdmDate</th>';
                print '<th scope="col">DelyDate</th>';
                print '<th scope="col">Weeks</th>';                        
                print '<th scope="col">Cat</th>';
                print '<th scope="col">Unit</th>';
                print '<th scope="col">Baby</th>';
            print '</tr>';
            print '</thead>';   

            print '<tfoot>';           
            print '<tr>';
            print '<th scope="col">YNo</th>';
            print '<th scope="col">HospNo</th>';
            print '<th scope="col">Mother</th>';
            print '<th scope="col">Age</th>';            
            print '<th scope="col">AdmDate</th>';
            print '<th scope="col">DelyDate</th>';
            print '<th scope="col">Weeks</th>';
            print '<th scope="col">Category</th>';  
            print '<th scope="col">Unit</th>';  
            print '<th scope="col">Baby</th>';  


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

        $query = "select a.yearly_no, (a.hospno||'/'||a.hospyr) hospno, 
              a.patient_name mother_name, a.pat_age mother_age, 
              a.adm_date, a.dely_date, a.preg_in_week,  b.name cat_name,  a.unit,
              (a.BABY1_GENDER)||'-'||(a.BABY2_GENDER)||(a.BABY3_GENDER)||(a.BABY4_GENDER) Baby              
              from 
              BIRTH_STATS_YEARLY_DETAIL_VW a , wardbill_catedic b
              where to_char(a.dely_date,'YYYY-MM-DD') between :EIDBV and :EIDBV1 and
              a.category=b.code";
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


<!--
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
-->

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