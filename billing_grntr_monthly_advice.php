<!DOCTYPE html>
<html>
  <head>
<!--
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
-->

<link   rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
<script src="node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<link   rel="stylesheet" href="DataTables/dataTables.css" rel="stylesheet" type="text/css" />


<style>
    body 
    {
    font: 90%/1.45em "Helvetica Neue", HelveticaNeue, Verdana, Arial, Helvetica, sans-serif;
    margin: 0;
    padding: 0;
    color: #333;
    background-color: #fff;
    }

    <div class="datatable-wide">
        <table ...>
        </table>
    </div>
 
    div.datatable-wide {
        padding-left:  0;
        padding-right: 0;
    }
</style>

    <meta charset=utf-8 />
    <title>IPD: Monthly Cenus : DepartmentWise Ocuupancy</title>
    </head>
    <body>

<!-- Nav Bar for position at the top of page-->  
<nav class="navbar navbar-dark fixed-top bg-warning">
 <a class="navbar-brand" href="bgh_main.php"><img src="sail-logo.jpg" width="40" height="40" alt="BGH-MAIN"></a> 
 <div class="container">

  <h6>BGH IPD Billing Guarantor Monthly Recovery Advice</h6>

        <form  class="form-inline" name="myform" action="billing_grntr_monthly_advice.php" method="POST"> <input type="hidden" name="check_submit" value="1" />       
            <select name="rep_year" id="rep_year">
                <?php 
                    $conn = oci_connect("bgh", "hpv185e", "10.143.100.36/BGH6");
                    $sql = 'select rep_year_code, rep_year_value from rep_year';
                    $stid = oci_parse($conn, $sql);
                    oci_execute($stid);
                    while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC))
                    {
                        echo $row['REP_YEAR_CODE']; 
                        echo "<option value=" . $row['REP_YEAR_CODE'] . ">" . $row['REP_YEAR_VALUE'] . "</option>";
                    }
                ?>
            </select>
            <button class="btn btn-success my-2 my-sm-0" type="submit" name="submit">Get Data...</button>
        </form>
</div>        
</nav>
<br><br><br>


<?php
if (array_key_exists('check_submit', $_POST)) 
{
    if (isset($_POST['rep_year'])){$repyear=$_POST['rep_year'];}
         
        function do_fetch( $s, $repyear)
        {
            print '<div class="datatable-wide">';
            print '<table class="table table-striped  table-bordered mydatatable" style="width:100%">'; 
            print '<thead>';        
            print '<tr>';               
              
                print '<th scope="col">Year</th>';               
                print '<th scope="col">Jan</th>';
                print '<th scope="col">Feb</th>';            
                print '<th scope="col">Mar</th>';
                print '<th scope="col">Apr</th>';
                print '<th scope="col">May</th>';
                print '<th scope="col">Jun</th>';            
                print '<th scope="col">Jul</th>';
                print '<th scope="col">Aug</th>';
                print '<th scope="col">Sep</th>';            
                print '<th scope="col">Oct</th>';            
                print '<th scope="col">Nov</th>';            
                print '<th scope="col">Dec</th>';    
                print '<th scope="col">Total</th>';    
            print '</tr>';
            print '</thead>';   
            print '<tfoot>';           
            print '<tr>';
            print '<th scope="col">Year</th>';
            print '<th scope="col">Jan</th>';
            print '<th scope="col">Feb</th>';            
            print '<th scope="col">Mar</th>';
            print '<th scope="col">Apr</th>';
            print '<th scope="col">May</th>';
            print '<th scope="col">Jun</th>';            
            print '<th scope="col">Jul</th>';
            print '<th scope="col">Aug</th>';
            print '<th scope="col">Sep</th>';            
            print '<th scope="col">Oct</th>';            
            print '<th scope="col">Nov</th>';            
            print '<th scope="col">Dec</th>';    
            print '<th scope="col">Total</th>';    

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

                print '<tbody>';
                print '</table>';
                print '</div>';
                
        
        
            }
        
        // Create connection to Oracle
        $c = oci_connect("ward", "hpv185e", "10.143.55.53/BGHWARD");

        $query = "select 
        to_number(year) year, jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec,
        nvl(jan,0)+nvl(feb,0)+nvl(mar,0)+ nvl(apr,0)+nvl(may,0)+nvl(jun,0)+ nvl(jul,0)+ nvl(aug,0)+nvl(sep,0)+nvl(oct,0)+nvl(nov,0)+nvl(dec,0) year_total
        from GUARANTORS_RECOVERY_ADVICE order by to_number(year) desc";
        $s = oci_parse($c, $query);

        $myrepyear = $repyear;
//        oci_bind_by_name($s, ":EIDBV", $myrepyear);

//        $myendate = $endate;
//        oci_bind_by_name($s, ":EIDBV1", $myendate);
// Execute the query
        oci_execute($s);
// fecth data
//        do_fetch($mystdate, $myendate, $s);
        do_fetch($s, $repyear);
    

        // Close the Oracle connection
        oci_close($c);

} 
else 
{
    
}
?> 
<!--
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>  
-->

<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/popper.js/dist/popper.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="DataTables/dataTables.js"></script>
<script src="DataTables/bootstrap4.min.js"></script>


<!-- Working Fine Option 1  
<script>
        $(document).ready( function () {
        $('.mydatatable').DataTable();
    });
</script>
-->


<script>
/*
        $(document).ready( function () {
        $('.mydatatable').DataTable({
            order:[[3, 'desc']],
            pagingType: 'full_numbers',
            "scrollY": "300px",
            "scrollX": true,
            "scrollCollapse": true,
            "paging": true,
            "fixedColumns":   true
        });        
    });
*/
$(document).ready(function(){  
        $('.mydatatable').DataTable({
            "scrollY": "500",
            "scrollX": true,
            "scrollCollapse": true,
            "paging": false
        });
});

</script>


</body>
</html>



