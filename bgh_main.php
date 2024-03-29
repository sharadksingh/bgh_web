<?php
// Start the session
session_start();
?>

<html>
    <head>

    <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS and internal CSS -->        
        <link rel="stylesheet"    href="bgh_main_style.css">
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
        

        <!--
        <link rel="stylesheet"    href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        -->
        <link rel="stylesheet" href="node_modules/fas-web/css/all.min.css">
        <link rel="icon" type="image/png" href="sail-logo.jpg"/>

        <style>    
            .dropdown-menu
            {    
              color: #fff;
              background-color: #ffbf4c;
              border-color: #fff;
            }
            .dropdown .dropdown-menu a:hover
            {    
              color: #fff;
              background-color: #b91773;
              border-color: #fff;
            }

            .dropdown-submenu 
            {
            position: relative;
            }

            .dropdown-submenu a::after 
            {
              transform: rotate(-90deg);
              position: absolute;
              right: 6px;
              top: .8em;
            }

            .dropdown-submenu .dropdown-menu 
            {
              top: 0;
              left: 100%;
              margin-left: .1rem;
              margin-right: .1rem;
            }
            .navbar-brand {
              display: inline-block;
              padding-top: .3125rem;
              padding-bottom: .3125rem;
              margin-right: 0rem;
              font-size: 1.25rem;
              line-height: inherit;
              white-space: nowrap;
            }

            .container-fluid-nav div{
            display: flex;
            justify-content: space-around;
            }
            .circular--square {
            border-radius: 50%;
            }

            .circular--landscape {
            display: inline-block;
            position: relative;
            width: 200px;
            height: 200px;
            overflow: hidden;
            border-radius: 50%;
          }

          .circular--landscape img {
          width: auto;
          height: 100%;
          margin-left: -50px;
          }            



        </style>
        <title> Bokaro General Hospital, Bokaro</title>
    </head>
    <body>
      <!-- Checking the Session Variable for Login from the login page -->      
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
<!-- <div class="container"> -->
<div class="container-fluid-nav">
<h5 style="color:blue;text-align:center; background-color: orange">Bokaro General Hospital Information System (Internal)</h5>
<!--
<nav style="color:blue;text-align : center" class="navbar navbar-expand-lg navbar-dark bg-warning">
-->
<!--  <span class="navbar-text" style="color:blue;text-align:center">Bokaro General Hospital</span> -->
      
</nav> 
</div>


    <!-- NAVBAR FROM BOOTSTRAP -->
    <!-- class="navbar navbar-dark bg-primary" -->
    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light"> -->
        <nav class="navbar  sticky-top navbar-expand-lg navbar-dark bg-primary justified"> 
        <a class="navbar-brand" href="#"><img src="bgh_logo.jpg" width="30" height="30" class="d-inline-block align-top" alt="SAIL"></a>               
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        


        <div class="collapse navbar-collapse" id="navbarNavDropdown">            
          <ul class="navbar-nav">
            <li class="nav-item dropdown active">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                OPD
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="opd_status_01.php">OPD Dashboard</a>
                <a class="dropdown-item" href="opd_status_02.php">Daily OPD Stats</a>
                <a class="dropdown-item" href="opd_daily_status_gr01.html">Daily OPD Stats Graph</a>
                <a class="dropdown-item" href="#">Department Wise OPD Visit</a>
                <a class="dropdown-item" href="#">Entitled OPD Visits</a>                
                <a class="dropdown-item" href="#">Non-Entitled OPD Visits</a>
                <a class="dropdown-item" href="#">Gender Wise OPD Visits</a>
                <a class="dropdown-item" href="opd_pat_seen_01.php">Doctor Wise Patient Seen</a>
                <a class="dropdown-item" href="#">Third Party OP Billing</a>
                <a class="dropdown-item" href="#">OP Billing of Mediclaim</a>
                <a class="dropdown-item" href="#">Inv. Billing of Mediclaim</a>
                <a class="dropdown-item" href="opd_daily_cash_coll_01.php">Daily OPD Cash Collection</a>
                <a class="dropdown-item" href="opd_daily_cash_coll_graph.php">Daily OPD Cash Collection Graph</a>
              </div>
            </li>

            <li class="nav-item dropdown active">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                IPD/WARD
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="inv_index.php">Admissions Dashboard</a>
                <a class="dropdown-item" href="adm_all_admissions.php">All Admissions Searhable</a>
                <a class="dropdown-item" href="get_adm_date.php">All Admissions</a>
                <a class="dropdown-item" href="get_adm_employee.php">ON-Roll Employee IPD</a>
                <a class="dropdown-item" href="adm_cat_wise.php">Category Wise Admission</a>
                <a class="dropdown-item" href="adm_unit_wise.php">Unit Wise Admission</a>
                <a class="dropdown-item" href="adm_source_wise.php">Source Wise Admission</a>
                <a class="dropdown-item" href="adm_diag_wise.php">Diagnosis Wise Admission</a>
                <a class="dropdown-item" href="adm_census_data.php">Census Daily Data</a>                
                <a class="dropdown-item" href="adm_wrkacdt_case.php">Work Accident Cases</a>
                <a class="dropdown-item" href="adm_ml_case.php">Medico Legal Cases</a>
                <a class="dropdown-item" href="adm_genderwise_adm.php">Gender Wise Admissions</a>
                <a class="dropdown-item" href="adm_cas_report_adm.php">Admission Report for Casualty</a>
                <a class="dropdown-item" href="adm_unit_master.php">Unit Master</a>
                <a class="dropdown-item" href="#">Entitled/Non-Entitled Admissions</a>
                <a class="dropdown-item" href="adm_google_chart.php">Yearly Admissions Chart</a>


              </div>
            </li>
            
            <li class="nav-item dropdown active">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Billing</a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">Billing Dashboard</a>
                <a class="dropdown-item" href="bill_cat_wise.php">Category Wise Billing</a>
                <a class="dropdown-item" href="bill_cat_wise_01.php">Group Wise Billing</a>
                <a class="dropdown-item" href="bill_cat_wise_02.php">Group/Cat Wise Billing</a>
                <a class="dropdown-item" href="bill_cat_wise_03.php">Third Party Billing</a>
                <a class="dropdown-item" href="billing_ccat_claims.php">Third Party Claims/Receipt</a>               
                <a class="dropdown-item" href="bill_collection_01.php">IPD Cash Collection</a>
                <a class="dropdown-item" href="bill_refund_01.php">IPD Refunds</a>
                <a class="dropdown-item" href="bill_refund_02.php">Misc. Refunds</a>                                
                <a class="dropdown-item" href="grntr_admtobill_status.php">Guarantor Adm To Bill</a>
                <a class="dropdown-item" href="bill_grntr_pending_01.php">Guarantor Bill Pending</a>
                <a class="dropdown-item" href="wardbill_recovery_statement_01.php">Guarantor Recovery Statement</a>
                <a class="dropdown-item" href="wardbill_headwise_billing_01.php">Bills Under Different Heads</a>                                               
                <a class="dropdown-item" href="bill_rate_master.php">IPD Charges</a>     
                <a class="dropdown-item" href="ipd_daily_cash_coll_graph.php">IPD Daily Cash Coll. Graph</a> 
                <a class="dropdown-item" href="billing_grntr_monthly_advice.php">Grntr</a> 
                <a class="dropdown-item" href="bgh_allcash_collection.php">Monthly Cash Collection</a> 
                <a class="dropdown-item" href="bgh_allpos_collection.php">Monthly POS Collection</a> 


                <div class="dropdown-submenu">
                  <a class="dropdown-item dropdown-toggle" href="#">Mediclaim</a>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="mediclaim_tpa_processing.php">Mediclaim TPA Processing Status</a></li>
                    <li><a class="dropdown-item" href="#">Mediclaim Receipt FYr Wise</a></li>
                    <li><a class="dropdown-item" href="mediclaim_admtobill_status.php">Mediclaim Adm To Bill Status</a></li>
                    <li><a class="dropdown-item" href="#">Mediclaim Option-2</a></li>
                </div>

              </div>
            </li>

            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  BloodBank
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="bbank_donor_rep_01.php">Blood Donor For a Period</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
            
              <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Pharmacy
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Pharmacy DashBoard</a>
                  <a class="dropdown-item" href="pharma_med_master.php">OPD Med Master</a>
                  <a class="dropdown-item" href="pharma_med_master_wms.php">WMS Med Master</a>
                  <a class="dropdown-item" href="pharma_allctr_stock.php">All Counter Stock</a>
                  <a class="dropdown-item" href="pharma_substore_stock.php">SubStore Stock</a>
                  <a class="dropdown-item" href="pharma_wms_stock.php">WMS-Store Stock</a>  
                  <a class="dropdown-item" href="pharma_current_stock_combined.php">Combined Medicine Stock</a>  
                  <a class="dropdown-item" href="pharma_na_order.php">LP-OPD-NA Medicines</a>
                  <a class="dropdown-item" href="pharma_opdnl_order.php">LP-OPD-NL Medicines</a>
                  <a class="dropdown-item" href="pharma_wardna_order.php">LP-WARD-NA Medicines</a>
                  <a class="dropdown-item" href="pharma_nl_order.php">LP-WARD-NL Medicines</a>
                  <a class="dropdown-item" href="pharma_expiry_01.php">Pharma Expired Drug (Counter)</a>
                  <a class="dropdown-item" href="pharma_expiry_02.php">Pharma Expired Drug (All)</a> 
                  <a class="dropdown-item" href="pharma_med_dist_01.php">OPD-Medicine Distribution Trend</a>  
                  <a class="dropdown-item" href="pharma_na_trend.php">OPD-NA-Medicine Distribution Trend</a> 
                  <a class="dropdown-item" href="pharma_nl_trend.php">OPD-NL-Medicine Distribution Trend</a>
                  <a class="dropdown-item" href="#">WARD-Medicine Distribution Trend</a>  
                  <a class="dropdown-item" href="ward_na_trend.php">WARD-NA-Medicine Distribution Trend</a> 
                  <a class="dropdown-item" href="ward_nl_trend.php">WARD-NL-Medicine Distribution Trend</a>
                </div>
              </li>  

              <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  ISO
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="iso_adm_death_01.php">ISO Admission/Mortality Data</a>
                </div>
              </li>  

              <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Statistics
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="https://apex.oracle.com/pls/apex/sharadk/r/ward-admission-vw-2019/login?session=102603820669007
">Stats Cloud System</a>
                  <a class="dropdown-item" href="stat_mortality_01.php">Mortality Data</a>
                  <a class="dropdown-item" href="stat_mortality_02.php">Mortality DepartmentWise</a>                 
                  <a class="dropdown-item" href="labour_room_br_01.php">Birth Report Summary</a>
                  <a class="dropdown-item" href="birth_report.php">Birth Report Detail</a>
                  <a class="dropdown-item" href="stat_adm_census_monthly.php">Census Daily Data</a>
                </div>
              </li>

              <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Radiology
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Radiology DashBoard</a>
                  <a class="dropdown-item" href="radiology_report_02.php">Radiology Report</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>

              <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Investigation
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="opd_lab_trend.php">OPD-LAB Test Trends</a>
                  <a class="dropdown-item" href="ipd_lab_trend.php">IPD-LAB Test Trends</a>

                  <a class="dropdown-item" href="wardlab_status_rep_01.php">WardLab Tests Report</a>
                  <a class="dropdown-item" href="wardlab_non_conformity_01.php">WardLab Non Conformity Report</a>
                  <a class="dropdown-item" href="wardlab_inv_fy_wise.php">FY Year Wise Ward Lab Summary</a>
                </div>
              </li>

              <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Misc Reports
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="list_doctor_01.php">List of Doctor's</a>
                  <a class="dropdown-item" href="list_bgh_or_employees.php">List of BGH Staff</a>
                  <a class="dropdown-item" href="misc_party_wise_entitled_01.php">Party Wise Entitled Patient</a>
                  <a class="dropdown-item" href="grnt_list_for_admin.php">BSL Guarantor for Admin</a>
                  <a class="dropdown-item" href="medissue_csr_13.php">CSR-Medicine Issued to Medical Camps</a>
                  <a class="dropdown-item" href="medissue_csr_20.php">CSR-Medicine Issued to SSK(HC-5)</a>
                  <a class="dropdown-item" href="misc_bgh_mid_employee_01.php">View Details of Entitled Person</a>
                  <a class="dropdown-item" href="misc_bgh_covid_report.php">View Covid Report(BGH)</a>
                  <a class="dropdown-item" href="covid_trans.php">Covid Intimation</a>
                  <a class="dropdown-item" href="https://sadarhospitalbokaro.com">Sadar Hospital Covid Reporting</a>



                </div>
              </li>

              <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  PMJAY
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="https://hospitals.pmjay.gov.in/">About PMJAY</a>
                  <a class="dropdown-item" href="pmjay_adm_01.php">PMJAY Admissions</a>
                  <a class="dropdown-item" href="pmjay_claims_manual_01.php">PMJAY Claims and Receipt</a>  
                  <a class="dropdown-item" href="https://pmjay.gov.in/">National Health Mission(NHA)</a>  
                  <a class="dropdown-item" href="https://pmjay.qcin.org/faq-page">PMJAY-FAQ</a> 
                  <a class="dropdown-item" href="https://nabh.co/">NABH</a> 
                </div>
              </li>
              
              <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  PACS
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="http://10.143.55.35">Pacs System (Local)</a>
                  <a class="dropdown-item" href="http://122.252.255.248/User_Login.asp">Pacs System (Internet)</a>
                  <a class="dropdown-item" href="#">About PACS System</a>
                  <a class="dropdown-item" href="#">Work Order PACS</a>
                  <a class="dropdown-item" href="#">AMC PACS</a>                  
                </div>
              </li>

              <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  BGH-MIS
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">BGH-MIS-Server-1</a>
                  <a class="dropdown-item" href="#">BGH-MIS-Server-2</a>
                </div>
              </li>
             
              <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Links
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="http://bokarosteel.com">BokaroSteel.com</a>
                  <a class="dropdown-item" href="https://email.sail.in">E-Mail</a>
                  <a class="dropdown-item" href="http://10.143.2.143:8024/Forms/LogIn.aspx">Attendance System</a>
                  <a class="dropdown-item" href="sail.co.in">SAIL Corporate Web Site</a>
                  <a class="dropdown-item" href="india.gov.in">Govt. of India</a>
                  <a class="dropdown-item" href="steel.gov.in">Steel Ministry</a>
                  <a class="dropdown-item" href="who.int/classifications/ied/en/">WHO ICD Codification</a>
                  <a class="dropdown-item" href="www.mohfw.gov.in">Ministry of Health </a>
                  <a class="dropdown-item" href="https://mor.nlm.nih.gov/RxNav/">RxNav </a>
                  <a class="dropdown-item" href="https://openi.nlm.nih.gov/">BioMedical Serach Engine</a>
                  <a class="dropdown-item" href="file_upload.php">File Upload </a>
                  <a class="dropdown-item" href="file_upload_1.php">File Upload New </a>
                  <a class="dropdown-item" href="https://bspapp.sail-bhilaisteel.com/cprs/cprs_login.htm">Check PaySlip</a>
                </div>
              </li>

              <li class="nav-item active">
                <a class="nav-link" href="bgh_complaints.html">Complaints <span class="sr-only">(current)</span></a>
              </li>  
              <li class="nav-item active">
                <a class="nav-link" href="bgh_com_escalation.html"><i class="fa fa-phone"></i><span class="sr-only">(current)</span></a>
              </li>

              <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">(current)</span>
                <?php echo $_SESSION["login"]; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Profile</a>
                  <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
              </li>
          </ul>
        </div>
      </nav>


<!-- Caraousel Entry has to be done Here  -->
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="bgh_2.jpg" height="300px"  class="d-block w-100" alt="...">
      </div>

<!-- may be uncommented later
      <div class="carousel-item">
        <img src="bgh_3.jpg" height="350px" class="d-block w-100" alt="...">
      </div>
    </div>
-->    

    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>     
<!-- Caraousel Entry is upto Here         -->

<!-- CARD LAYOUT FROM THE BOOTSTRAP GOES HERE -->

<!--Carousel Wrapper-->
<div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">

  <!--Controls-->
  <div class="controls-top">
    <a class="btn-floating" href="#multi-item-example" data-slide="prev"><i class="fas fa-chevron-left"></i></a>
    <a class="btn-floating" href="#multi-item-example" data-slide="next"><i
        class="fas fa-chevron-right"></i></a>
  </div>
  <!--/.Controls-->

  <!--Indicators-->
  <ol class="carousel-indicators">
    <li data-target="#multi-item-example" data-slide-to="0" class="active"></li>
    <li data-target="#multi-item-example" data-slide-to="1"></li>
    
  </ol>
  <!--/.Indicators-->

  <!--Slides-->
  <div class="carousel-inner" role="listbox">

    <!--First slide-->
    <div class="carousel-item active">

      <div class="col-md-3" style="float:left">
       <div class="card mb-2">
          <img class="card-img-top"
            src="bgh_bg.jpg" alt="Card image cap">
          <div class="card-body">
<!--      <h4 class="card-title">Covid-19</h4> -->
            <p class="card-text"></p>
            <a class="btn btn-primary">Covid-19</a>
          </div>
        </div>
      </div>

      <div class="col-md-3" style="float:left">
       <div class="card mb-2">
          <img class="card-img-top"
            src="bgh_bg.jpg" alt="Card image cap">
          <div class="card-body">
<!--      <h4 class="card-title">Covid-19</h4> -->
            <p class="card-text"></p>
            <a class="btn btn-primary">Covid-19</a>
          </div>
        </div>
      </div>

      <div class="col-md-3" style="float:left">
       <div class="card mb-2">
          <img class="card-img-top"
            src="bgh_bg.jpg" alt="Card image cap">
          <div class="card-body">
<!--      <h4 class="card-title">Covid-19</h4> -->
            <p class="card-text"></p>
            <a class="btn btn-primary">Covid-19</a>
          </div>
        </div>
      </div>
      
      <div class="col-md-3" style="float:left">
       <div class="card mb-2">
          <img class="card-img-top"
            src="bgh_bg.jpg" alt="Card image cap">
          <div class="card-body">
<!--      <h4 class="card-title">Covid-19</h4> -->
            <p class="card-text"></p>
            <a class="btn btn-primary">Covid-19</a>
          </div>
        </div>
      </div>

    </div>
    <!--/.First slide-->

    <!--Second slide-->
    <div class="carousel-item">

    <div class="col-md-3" style="float:left">
       <div class="card mb-2">
          <img class="card-img-top"
            src="bgh_bg.jpg" alt="Card image cap">
          <div class="card-body">
<!--      <h4 class="card-title">Covid-19</h4> -->
            <p class="card-text"></p>
            <a class="btn btn-primary">Covid-19</a>
          </div>
        </div>
      </div>

      <div class="col-md-3" style="float:left">
       <div class="card mb-2">
          <img class="card-img-top"
            src="bgh_bg.jpg" alt="Card image cap">
          <div class="card-body">
<!--      <h4 class="card-title">Covid-19</h4> -->
            <p class="card-text"></p>
            <a class="btn btn-primary">Covid-19</a>
          </div>
        </div>
      </div>

      <div class="col-md-3" style="float:left">
       <div class="card mb-2">
          <img class="card-img-top"
            src="bgh_bg.jpg" alt="Card image cap">
          <div class="card-body">
<!--      <h4 class="card-title">Covid-19</h4> -->
            <p class="card-text"></p>
            <a class="btn btn-primary">Covid-19</a>
          </div>
        </div>
      </div>
      
      <div class="col-md-3" style="float:left">
       <div class="card mb-2">
          <img class="card-img-top"
            src="bgh_bg.jpg" alt="Card image cap">
          <div class="card-body">
<!--      <h4 class="card-title">Covid-19</h4> -->
            <p class="card-text"></p>
            <a class="btn btn-primary">Covid-19</a>
          </div>
        </div>
      </div>

    </div>
    <!--/.Second slide-->

   

  </div>
  <!--/.Slides-->

</div>
<!--/.Carousel Wrapper-->
<!-- Card LAYOUT UPTO HERE -->

<!-- copyright -->
  <div class="copyright">
      <div class="row justify-content-center">
		    <h6>&copy; 2021 BGH, Bokaro General Hospital. All rights reserved | Developed by C&IT Department With ❤ For BGH</a>
			  </h6>
      </div>  
  
		</div>
<!-- //copyright -->

<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/popper.js/dist/popper.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>




<script>
      $('.dropdown-menu a.dropdown-toggle').on('click', function(e) 
      {
      if (!$(this).next().hasClass('show')) {
      $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
      }
      var $subMenu = $(this).next(".dropdown-menu");
      $subMenu.toggleClass('show');
      $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
      $('.dropdown-submenu .show').removeClass("show");
      });
  return false;
});  

</script>

</body>
</html>