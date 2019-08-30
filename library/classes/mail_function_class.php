<?php
require_once('phpmailer_class.php');

class sendMail extends PHPMailer{

	var $subject,$body,$fromEmail,$emaillist;
	
	function __construct($maillist,$subject,$message,$fromMail,$attachments='',$multiple_attachments=false,$remote_file=false)
	{
		 $this->maillist=explode(',', $maillist);
		 $this->subject=$subject;
		 $this->message=$message;
		 $this->fromMail=$fromMail;
		 $this->attachments=$attachments;
		 $this->multiple_attachments=$multiple_attachments;
		 $this->remote_file=$remote_file;

	}

	function sendMail()
	{ 
		$mail = new PHPMailer();
		$subject = $this->subject;
		$body = $this->message;
		//$body = preg_replace("[\]",'',$body);
		$mail->SetFrom($this->fromMail, " " );
		//$mail->SetFrom('no-reply@'.$_SERVER['HTTP_HOST'], '');
		$mail->addReplyTo($this->fromMail, " " );
		foreach ($this->maillist as $address) {
			$mail->AddBCC($address, "");
		}
		$mail->Subject    = $subject;
		$mail->AltBody    = "";
		$mail->MsgHTML($body);

		if(!empty($this->attachments) && ($this->multiple_attachments))
		{
			
			foreach ($this->attachments as $attachments_value) {

				if($this->remote_file)
					$mail->addStringAttachment(file_get_contents($attachments_value['tmp_name']),$attachments_value['name']); 		
				else
					$mail->AddAttachment($attachments_value['tmp_name'],$attachments_value['name']);
			}
		}else if(!empty($this->attachments))
		{
			if($this->remote_file)
				$mail->addStringAttachment(file_get_contents($this->attachments['tmp_name']),$this->attachments['name']);
			else	
		 		$mail->AddAttachment($this->attachments['tmp_name'],$this->attachments['name']);
		}

		return $mail->Send();
		
		
	}
	
} ?>