<?php
/*
  This Program displays the counterwise expiry, damage and breakage entry for a fiancual year
  Same program if selected ALL in the counter list displays the consolidated List
*/
    session_start();
?>

<html>
<head>
  <title>Bill: BSL Guarantor List for Administration</title>
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

     
<!-- Nav Bar for position at the top of page-->  
<div class="container">
<nav class="navbar navbar-dark fixed-top" style="background-color: bisque; height:50px; position: absolute;">
<form  class="form-inline" name="myform" action="grnt_list_for_admin.php" method="POST"> <input type="hidden" name="check_submit" value="1" />     
  
<div class="form-group">  
        <label for="stdate">From Admission  Date </label>  
        <input class="form-control mr-sm-2" type="date"   id="stdate" name="stdate" placeholder="fromDate" aria-label="stdate" value="<?php echo isset($_POST['stdate']) ? $_POST['stdate']:''; ?>">
    </div>
     
         
    <div class="form-group">  
        <label for="enddt">To Admission Date </label>  
        <input class="form-control mr-sm-2" type="date" id="endate" name="endate" placeholder="ToDate"   aria-label="todate" value="<?php echo isset($_POST['endate']) ? $_POST['endate']:''; ?>">
    </div>  
          
    <button class="btn btn-success my-2 my-sm-0" type="submit" name="submit">Get Data...</button>
</form>
</nav>
</div>    
<!-- Nav Bar for position at the top of page-->      


<br><br><br>

<?php
if (array_key_exists('check_submit', $_POST)) 
{
    
                if (isset($_POST['stdate'])){$stdate    =  $_POST['stdate'];}
                if (isset($_POST['endate'])){$endate    =  $_POST['endate'];}
   
        function do_fetch($mystdate, $myendate,  $s)            
            {
                print '<table class="table table-sm table-bordered table-striped table-dark w-auto table-hover">'; 
                print '<thead class="thead-light">';
                print '<tr>'; 
                print '<td colspan="9">' . 'BSL Guarantor List between Adm Date  : ' . date("d-m-Y", strtotime($mystdate)) .  ' and ' . date("d-m-Y", strtotime($myendate)) . '</td>';
                print '</tr>';
                print '<tr>';
                print '<th scope="col">StaffNo</th>';
                print '<th scope="col">EmpName</th>';
                print '<th scope="col">Section</th>';
                print '<th scope="col">Ret. Date</th>';
                print '<th scope="col">HospNo</th>';            
                print '<th scope="col">PatName</th>';            

                print '</thead>';            

               
// Print the data in Table            
                       while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) 
                        {                            
                            print '<tr>';

                            foreach ($row as $item) 
                            { 
//                                if ($row["NAME"]) {
                                    print '<td>'.($item?htmlentities($item):'&nbsp;').'</td>';
//                                }
//                                else{
//                                    print '<td text-align: right>'.($item?htmlentities($item):'&nbsp;').'</td>';
//                                }
                                
                                                                
                            }
                                print '</tr>';
                            }
                print '</table>';
        }
    
    
        // Create connection to Oracle
        $c = oci_connect("WARD", "hpv185e", "10.143.55.53/BGHWARD");
        // Use bind variable to improve resuability, 
        // and to remove SQL Injection attacks.

        
//        b.deptt, 
        
  
    
        $query = "select 
                    a.staffno, 
                    (b.ffname||' '||b.lname) emp_name,
                    d.section,
                    nvl(b.sep_dt, b.ret_dt) ret_dt,
                    (a.hospno||'/'||a.hospyear) hospno,
                    c.pat_name 
                    from adm_edpgrt    a,
                    emp_master         b,
                    ward_admission_vw  c,
                    emp_dep_code       d 
                    where 
                        to_char(a.admdate,'YYYY-MM-DD') between :EIDBV and :EIDBV2 and
                        a.staffno = b.stno and
                        b.deptt   = d.deptt  and
                        a.hospno  = c.hospno and
                        a.hospyear= c.hospyr
                    order by a.staffno";
    

        $s = oci_parse($c, $query);
    
        $mystdate = $stdate;
        oci_bind_by_name($s, ":EIDBV", $mystdate);
        $myendate = $endate;
        oci_bind_by_name($s, ":EIDBV2", $myendate);    
        oci_execute($s);

 
    
        do_fetch($mystdate, $myendate, $s);
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