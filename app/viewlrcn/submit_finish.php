<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                           <small><?php echo $sitename;?> - Submit CVs</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Register Users</li>
                    </ol>
                </section>

<section class="content">



<?php
//.$time
//Make sure that this appointment is not resubmitted again	and proposalm_upload='$document' 
$sqlConceptLogs="SELECT * FROM ".$prefix."musers where usrm_id='$usrm_id' and usrm_username='$usrm_username'";
$QueryConcept=$mysqli->query($sqlConceptLogs);
$totals_R=$QueryConcept->num_rows;
$rFListsmain=$QueryConcept->fetch_array();

if($totals_R){
$queryDistrictsMain="select * from ".$prefix."concepts where usrm_id='$usrm_id' and conceptm_email='$usrm_username'";
$R_DMain=$mysqli->query($queryDistrictsMain);	
$rFLisConcep=$R_DMain->fetch_array();

$refno=$rFLisConcep['referenceno'];

	$nameofpi=$rFListsmain['usrm_fname']." ".$rFListsmain['usrm_sname'];
	$email=$rFListsmain['usrm_email'];
	$phone=$rFListsmain['usrm_phone'];
	$NameofInstitution=$rFListsmain['usrm_NameofInstitution'];

$upmDate="update ".$prefix."concepts set sentNotify='Yes' where usrm_id='$usrm_id'";
$mysqli->query($upmDate);	
	
require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");

$mail = new PHPMailer(true); //important
$mail->IsSMTP(); // set mailer to use SMTP
$mail->Port = $usmtpportNo; // SMTP Port
$mail->CharSet =  "utf-8";
$mail->Host = $usmtpHost; // specify SMTP server//nemesis.eahd.or.ug mailhost02.cfi.co.ug
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->SMTPSecure = $emailSSL;
$mail->SMTPDebug = 0;


$mail->Username = "$emailUsername"; // SMTP username -- CHANGE --
$mail->Password = "$emailPassword"; // SMTP password -- CHANGE --
$mail->setFrom("$emailUsername", "Admin");
$mail->FromName = "$sitename"; //From Name -- CHANGE --


$mail->addBcc("$emailBcc",'$sitename');
$mail->addBcc('sgcigrants.uncst.go.ug','$sitename');


$mail->AddAddress($email, $nameofpi); //To Address -- CHANGE --
$mail->AddReplyTo("sgcigrants.uncst.go.ug", "$sitename"); //Reply-To Address -- CHANGE --

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "$sitename - Concept Received";
$body="
<p>Hello $nameofpi!<br>
This is an automatic Email sent from $sitename system. Your concept has been received.</p>

<p>Concept Title: $proposalTittle<br>
Name of PI: $nameofpi<br>
Name of Institution: $NameofInstitution<br>
Reference No: $refno</p>

<p>Thank you for responding to the $sitename call. We wish the best of Luck.<br>

Regards</p>

<p>$sitename<br>
$fulladdress
</p>

";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}
echo '<img src="img/ajax-loader1.gif">';
echo '<div class="spacer"></div>';
echo '<meta http-equiv="refresh" content="8; url=https://www.uncst.go.ug/pppinresearch/main.php?option=SubmitConcept" />';

$message="<p style='color:#09F!important;'>Congratulations: Your Concept was Submitted Successfully<br>
Thank you for submitting your Proposal. This is a confirmation that your Concept has been received. Please remember this code <span style=color:#F00>$refno</span>, which you will use as a reference in future as reference to track progress of your submission.<br>
Good Luck</p>";

}

if(!$totals_R){
$message="<p style='color:#09F!important;'>Sorry, there was a problem, please wait.</p>";	
echo '<img src="img/ajax-loader1.gif">';
echo '<div class="spacer"></div>';
echo '<meta http-equiv="refresh" content="5; url=https://www.uncst.go.ug/pppinresearch/main.php?option=SubmitConcept/" />';

}


?>


<form action="" method="post"  enctype="multipart/form-data" name="regForm" id="regForm" >


                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <!-- general form elements -->  
                            <div class="box box-primary">
                                <div class="box-header" style="border-bottom:1px solid #ccc;">
                                    <h3 class="box-title">Proposal Details - CVs</h3>
                                
                                </div><!-- /.box-header -->
                                <!-- form start -->
<div class="box-body">

<?php if($message){?><?php echo $message;?><?php }?>
<?php if($messagepdf){?><?php echo $messagepdf;?><?php }?>
 </div>
 
                           
                            </div><!-- /.box -->

                          </div>

                        <!-- right column -->
                        <div class="col-md-6">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Public - Private Partnerships (PPP) in Research and &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Innovation Grants</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
<div class="progress" style="margin-left:20px;">
<div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">100% Complete</div>
</div>

<p>Describe the problem that is to be investigated and the questions that will guide the research process.  Provide a brief overview of the body of knowledge related to the problem and indicate the knowledge gaps that the proposed research will fill.</p>
<p>To show the importance of the problem, this section should discuss: how the research relates to the country's development priorities; the scientific importance of the problem; the urgency and magnitude of the problem and how the research results will contribute to its solution; the special importance of the project for the private sector; and the need to build up research capacity in the proposed area of research.</p>
                                </div><!-- /.box-body -->
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
 
                 </form>
     
                 </section> 
