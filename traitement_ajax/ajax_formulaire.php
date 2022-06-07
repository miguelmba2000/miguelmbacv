<?php  

try
		{
			$pdo = new PDO('mysql:host=localhost;dbname=cv;charset=utf8', 'root', '');
		}
		catch (Exception $e)
		{
		        die('Erreur : ' . $e->getMessage());
		}

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require  '../PHPMailer/PHPMailer/src/Exception.php'; 
	require  '../PHPMailer/PHPMailer/src/PHPMailer.php'; 
	require  '../PHPMailer/PHPMailer/src/SMTP.php';
	$reponse=array();

if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) && isset($_POST['message'])){
   $nom=$_POST['nom']; 
   $prenom=$_POST['prenom']; 
   $Email =htmlspecialchars($_POST['mail']);  		
   $message=$_POST['message']; 

  

  $query = $pdo->Prepare('INSERT INTO messagerie  VALUES (NULL, :nom, :prenom,:mail,:message)');

    
    $query->bindValue(':nom',$nom, PDO::PARAM_STR);
   $query->bindValue(':prenom',$prenom, PDO::PARAM_STR);
   $query->bindValue(':mail',$Email, PDO::PARAM_STR);
    $query->bindValue(':message',$message, PDO::PARAM_STR);
    
    $query->CloseCursor();

    $query->execute();

	$message="insertion reussie";
	if($query){
		$reponse['code']=200;
		$reponse['results']=$message;
	  }
	  echo json_encode($reponse);

      $emetteur=htmlspecialchars($_POST['prenom']);
    	$toEmail = "mbamiguel2000@gmail.com";
	   	$mailHeaders = "From: Miguel Mba<". $Email .">\r\n";
	  	   
	   	$mail = new PHPMailer(true);
	   	try {
	   	    //Server settings
	   	    	$mail->SMTPDebug = 0;                     								 //Enable verbose debug output
	   	  		$mail->isSMTP();                                            //Send using SMTP
	   	      $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
	   	      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
	   	      $mail->Username   = 'mbamiguel2000@gmail.com';                     //SMTP username
	   	      $mail->Password   = 'iynoidtwsgjwllrr';                               //SMTP password
	   	      $mail->SMTPSecure = 'TLS';            											//Enable implicit TLS encryption
	   	      $mail->Port       = 587;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

	   	    //Recipients
	   	    $mail->setFrom('mbamiguel2000@gmail.com', 'Miguel developpeur web');
	   	    $mail->addAddress($Email, 'Miguel Mba');
	   	    $mail->addAddress($Email);               //Name is optional
	   	    $mail->addReplyTo('mbamiguel2000@gmail.com', $mailHeaders);
	   	    //$mail->addCC('cc@example.com');
	   	    //$mail->addBCC('bcc@example.com');

	   	    //Attachments
	   	   // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
	   	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

	   	    //Content
	   	    $mail->isHTML(true);                                  //Set email format to HTML
	   	    $mail->Subject = 'avez vous besoin de mon expertise?';
	   	    $mail->Body    = 'Merci de m\'avoir contacté.<br/><br/> <b>Que voulez vous que je fasses pour vous??</b>';
	   	    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	   	    $mail->send();

	   	    echo "Un mail a été envoyé à votre adresse E-mail";
	   	} 
	   	catch (Exception $e) {
	   		 echo "mauvaise connexion au servuer de messagerie";
	   	   $mail->ErrorInfo;
	   	}
  } 
 ?> 

 