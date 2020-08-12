<?php
    session_start();
?>

<html>
<head>
  <title>Cat Iwse Admission </title>
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
  <h6>BGH IPD Report for Casualty</h6>
<div class="container">
<form  class="form-inline" name="myform" action="adm_cas_report_adm.php" method="POST"> <input type="hidden" name="check_submit" value="1" />     
  
    <div class="form-group">        
                <label for="repyear">IPD Admissions from Casualty for the Year :</label>
                <select class="form-control mr-sm-2" type="text"  id="repyear" name="repyear">
                    <option value="2020">2020</option>
                    <option value="2019">2019</option>
                    <option value="2018">2018</option>
                    <option value="2017">2017</option>
                    <option value="2016">2016</option>
                </select>
    </div>    



    <button class="btn btn-success my-2 my-sm-0" type="submit" name="submit">Get Data...</button>
</form>
</div>
</nav>
<br><br><br>

<?php
if (array_key_exists('check_submit', $_POST)) 
{
        $repyear =  $_POST['repyear'];

        // Create connection to Oracle
        $c = oci_connect("WARD", "hpv185e", "10.143.55.53/BGHWARD");
        // Query for the admissions from casualty
        $query = "select count(*) tot_count 
                  from ward_admission_vw 
                  where pfrom1='C' and ent_nonent=:BTYPE and  
                  to_char(admdate, 'MON')=:BMONTH       and 
                  to_char(admdate, 'YYYY')=:REPYEAR";    
        $s = oci_parse($c, $query);    
        oci_bind_by_name($s,   ":REPYEAR",   $repyear);     

        // Query for the admissions from OPD
        $opd_query = "select count(*) tot_count 
                  from ward_admission_vw 
                  where pfrom1='O' and ent_nonent=:BTYPE and  
                  to_char(admdate, 'MON')=:BMONTH       and 
                  to_char(admdate, 'YYYY')=:REPYEAR";    
        $opds = oci_parse($c, $opd_query);    
        oci_bind_by_name($opds,   ":REPYEAR",   $repyear);     



        $month_array = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
        $type_array  = ["Y", "N", "P"];
// print the First Row as the months        
        print '<table class="table table-sm table-bordered table-striped table-dark w-auto table-hover">';            
        print '<thead class="thead-light">';
        print '<td colspan="9">' . 'IPD Admissions from Casualty for the Year : ' . $repyear . '</td>';
        print '<tr>';
        print '<th scope="col"> Month=====> </th>';
            foreach ($month_array as $month => $value)
            {               
                print '<th scope="col">'.($value?htmlentities($value):'&nbsp;').'</th>';
            }
        print '</tr>';
        print '</thead>';
           
        foreach ($type_array as $ttype => $tvalue) 
        
        {
            print '<tr>'; 
            if ($tvalue=='Y'){
                print '<td>' . 'ENTITLED' . '</td>'; 
            }
            elseif ($tvalue=='N') {
                print '<td>' . 'NOT-ENTITLED' . '</td>'; 
            }
            elseif ($tvalue=='P') {
                print '<td>' . 'AYUSHMAN' . '</td>'; 
            }
            
            oci_bind_by_name($s,   ":BTYPE",   $tvalue);     


            foreach ($month_array as $month => $mvalue) 
            {
                oci_bind_by_name($s,   ":BMONTH",   $mvalue);   
                oci_define_by_name($s, 'TOT_COUNT', $tot_count);     
                oci_execute($s);

                while (oci_fetch($s)) 
                {
                   print '<td>' . $tot_count . '</td>';
                }            
             
            }
           
            print '</tr>';  

           
        }
        print '</table>';

print '<br>';
print '<br>';
print '<br>';

// Print for the OPD

print '<table class="table table-sm table-bordered table-striped table-dark w-auto table-hover">';            
print '<thead class="thead-light">';
print '<td colspan="9">' . 'IPD Admissions from OPD for the Year : ' . $repyear . '</td>';
print '<tr>';
print '<th scope="col"> Month=====> </th>';
    foreach ($month_array as $month => $value)
    {               
        print '<th scope="col">'.($value?htmlentities($value):'&nbsp;').'</th>';
    }
print '</tr>';
print '</thead>';
   
foreach ($type_array as $ttype => $tvalue) 

{
    print '<tr>'; 
    if ($tvalue=='Y'){
        print '<td>' . 'ENTITLED' . '</td>'; 
    }
    elseif ($tvalue=='N') {
        print '<td>' . 'NOT-ENTITLED' . '</td>'; 
    }
    elseif ($tvalue=='P') {
        print '<td>' . 'AYUSHMAN' . '</td>'; 
    }
    
    oci_bind_by_name($opds,   ":BTYPE",   $tvalue);     


    foreach ($month_array as $month => $mvalue) 
    {
        oci_bind_by_name($opds,   ":BMONTH",   $mvalue);   
        oci_define_by_name($opds, 'TOT_COUNT', $tot_count);     
        oci_execute($opds);

        while (oci_fetch($opds)) 
        {
           print '<td>' . $tot_count . '</td>';
        }            
     
    }
   
    print '</tr>';  

   
}
print '</table>';





// Close Connection
        oci_close($c);
}
?> 
 
  
    
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>  

</div> 
</body>
</html>