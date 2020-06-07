<?php
//include connection file 
//include_once("connection.php");
//include_once('libs/fpdf.php');
require('.\fpdf182\fpdf.php');
require('.\phpmailer\phpmailer\src\PHPMailer.php');
require('.\phpmailer\phpmailer\src\SMTP.php');
require('.\phpmailer\phpmailer\src\Exception.php');

// The value of the ref number will be vased from the url and 
// has to be reffered here
// Inintialize URL to the variable 
//$url = 'http://bghmis.sailbsl.in/cas_mlcase_email.php?refno=Tonny'; 
$url = 'http://localhost/cas_mlcase_email.php?refno';   
// Use parse_url() function to parse the URL  
// and return an associative array which 
// contains its various components 
$url_components = parse_url($url); 
  
// Use parse_str() function to parse the 
// string passed via URL 
parse_str($url_components['query'], $params); 
      
// Display result 
echo ' Hi '.$params['refno']; 

$refno = $params['refno'];

// Upto here the parsing is done.............

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    //$this->Image('bgh_logo.jpg',10,-1,30);
    $this->Image('bgh_logo.jpg',10,5,30);

    $this->SetFont('Arial','B',13);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(80,10,'List of Medico Legal Cases at Bokaro General Hospital',1,0,'C');
    // Line break
    $this->Ln(20);
}
 
// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
 
//$db = new dbObj();
//$connString =  $db->getConnstring();
//$display_heading = array('id'=>'ID', 'employee_name'=> 'Name', 'employee_age'=> 'Age','employee_salary'=> 'Salary',);
 
$c = oci_connect("WARD", "hpv185e", "10.143.55.53/BGHWARD"); 
$display_heading= array('hospno', 'hospyr', 'reference_no', 'reference_date', 'entry_from', 'pat_name', 'pat_age', 'pat_age_yrs', 
                    'pat_gender',
                    'entry_by_doct', 'entry_date', 'entry_time');

//$result = mysqli_query($connString, "SELECT id, employee_name, employee_age, employee_salary FROM employee") or die("database error:". mysqli_error($connString));
//$header = mysqli_query($connString, "SHOW columns FROM employee");

$header = array('hospno', 'hospyr', 'reference_no', 'reference_date', 'entry_from', 'pat_name', 'pat_age', 'pat_age_yrs', 'pat_gender',
'entry_by_doct', 'entry_date', 'entry_time');
 

$query = "select rownum, hospno, hospyr, reference_no, reference_date, entry_from, pat_name, pat_age, pat_age_yrs, pat_gender,
entry_by_doct, entry_date, entry_time from CASUALTY_MEDICO_LEGAL_VW where reference_no=:EIDBV";
$s = oci_parse($c, $query);    
$myeid = $refno;
oci_bind_by_name($s, ":EIDBV", $myeid);

//$myendt = $endate;
//oci_bind_by_name($s,":EIDBV2", $myendt);
oci_execute($s);
/////////////


////////////


$pdf = new PDF();
//header
$pdf->AddPage('L');
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',8);

//foreach($header as $heading) 
//{
//        $pdf->Cell(40,12,$display_heading[$heading['Field']],1);
//}


while ($row = oci_fetch_array($s, OCI_RETURN_NULLS+OCI_ASSOC)) 
                        {     
                            $pdf->Ln();                                                   
                            foreach ($row as $item=>$value) 
                            {                       
                              
                                //  print $item .'\n';
                                //  print $value . '\n';
                                  if ($item=="PAT_NAME")
                                  {
                                        $pdf->Cell(50,8,$value,1);
                                  }
                                  else {
                                        $pdf->Cell(15,8,$value,1);
                                  }
                            //    $pdf->Cell(32,9,$item,1);
                                                                
                            }
                                
                        }


//$pdf->Cell(40,12,$column,1);

//$file_name = md5(rand()) . '.pdf';
//print $file_name;
//$pdf->Output();
//$file = $pdf->Output();
//file_put_contents($file_name, $file);


// random hash necessary to send mixed content
//$separator = md5(time());

//$eol = PHP_EOL;

// attachment name
//$filename = "_Desiredfilename.pdf";

// encode data (puts attachment in proper format)
//$pdfdoc = $pdf->Output("", "S");
//$pdfdoc = $pdf->Output("", "S");

//$attachment = chunk_split(base64_encode($pdfdoc));
//$attachment = $pdfdoc;


$attachment='BGH_ML_CASE.pdf';
$pdf->output("F", $attachment);
//file_put_contents($attachment, $file);

//-------------------- Sending mail from here ------------------------------
$mail = new PHPMailer\PHPMailer\PHPMailer();
//Enable SMTP debugging. 
$mail->SMTPDebug = 0;                               
//Set PHPMailer to use SMTP.
$mail->isSMTP();            
//Set SMTP host name                          
$mail->Host = "smtp.gmail.com";
//Set this to true if SMTP host requires authentication to send email
$mail->SMTPAuth = true;                          
//Provide username and password     
$mail->Username = "citbgh@gmail.com";                 
$mail->Password = "citbgh@827001";                           
//If SMTP requires TLS encryption then set it
$mail->SMTPSecure = "tls";                           
//Set TCP port to connect to 
$mail->Port = 587;                                   

$mail->From = "citbgh@gmail.com.com";
$mail->FromName = "Computer and Information Technology BGH";

$mail->addAddress("singh.sharadk@gmail.com", "Recepient Name");

//Provide file path and name of the attachments
//$mail->addAttachment("file.txt", "File.txt");        
//$mail->addAttachment("README.MD"); //Filename is optional
$mail->addAttachment($attachment); //Filename is optional

$mail->isHTML(true);

$mail->Subject = "Subject Text";
$mail->Body = "<i>Mail body in HTML</i>";
$mail->AltBody = "This is the plain text version of the email content";

if(!$mail->send()) 
{
    echo "Mailer Error: " . $mail->ErrorInfo;
} 
else 
{
    echo "Message has been sent successfully";
}


//--------------------- sending mail as attachement up to here --------------------


//$pdf->"a.pdf";
//$nom_file="a.pdf";
//$pdf->Output("I", $nom_file);

// $file_name = md5(rand()) . '.pdf';
// $html_code = '<link rel="stylesheet" href="bootstrap.min.css">';
// $html_code .= fetch_customer_data($connect);
// $pdf = new Pdf();
// $pdf->load_html($html_code);
// $pdf->render();
// $file = $pdf->output();
// file_put_contents($file_name, $file);
/*
require 'class/class.phpmailer.php';
 $mail = new PHPMailer;
 $mail->IsSMTP();        //Sets Mailer to send message using SMTP
 $mail->Host = 'smtpout.secureserver.net';  //Sets the SMTP hosts of your Email hosting, this for Godaddy
 $mail->Port = '80';        //Sets the default SMTP server port
 $mail->SMTPAuth = true;       //Sets SMTP authentication. Utilizes the Username and Password variables
 $mail->Username = 'xxxxxxxxxx';     //Sets SMTP username
 $mail->Password = 'xxxxxxxxxx';     //Sets SMTP password
 $mail->SMTPSecure = '';       //Sets connection prefix. Options are "", "ssl" or "tls"
 $mail->From = 'info@webslesson.info';   //Sets the From email address for the message
 $mail->FromName = 'Webslesson.info';   //Sets the From name of the message
 $mail->AddAddress('web-tutorial@programmer.net', 'Name');  //Adds a "To" address
 $mail->WordWrap = 50;       //Sets word wrapping on the body of the message to a given number of characters
 $mail->IsHTML(true);       //Sets message type to HTML    
 $mail->AddAttachment($file_name);         //Adds an attachment from a path on the filesystem
 $mail->Subject = 'Customer Details';   //Sets the Subject of the message
 $mail->Body = 'Please Find Customer details in attach PDF File.';    //An HTML or plain text message body
 if($mail->Send())        //Send an Email. Return true on success or false on error
 {
  $message = '<label class="text-success">Customer Details has been send successfully...</label>';
 }
 unlink($file_name);
}
https://www.webslesson.info/2018/08/create-dynamic-pdf-send-as-attachment-with-email-in-php.html

*/



?>