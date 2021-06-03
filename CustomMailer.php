<?php

// Author:		Ghost+
// GitHub:    https://github.com/RPGLE/CustomMailer/

ini_set('include_path', '/usr/local/zendphp7/share/ZendFramework2/library');
require_once('Zend/Loader/StandardAutoloader.php');

use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class MRWMailer {
    private $sendTo = array();
    private $sendFrom;
    private $subject;
    private $message;
    private $error = array();

    public function __construct($sendTo, $subject, $message, $sendFrom = null)
    {
        $this->sendTo = $sendTo;
        $this->sendFrom = ($sendFrom) ? $sendFrom : 'defaultEmailHere@email.com';
        $this->subject = $subject;
        $this->message = $message;
    }
    
	public function setTo($email, $name=""){
	    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
	        $this->toEmail[] = $email;
	        $this->toName[] = $name;
	    } else {
	    	$this->lastError = "Invalid to email: {$email}.";
	    }
	}

    public function getTo() {
        return $this->sendTo;
    }

    public function setFrom($email, $name)  {
        return $this->sendFrom = $email;
    }

    public function setSubject($subject) {
        return $this->subject = $subject;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function setMessage($message) {
        $this->message = $message;

        return $this;
    }

    public function getMessage() {
        return $this->message;
    }


    public function getFrom() {
        return $this->sendFrom;
    }
	
	public function sendHTMLEmail() {
		$success = false;
		
		//check for email validity
		if ($this->validateEmail($this->sendFrom) and $this->validateEmail($this->sendTo)) {			
			if (trim($this->message) <> "" and trim($this->subject) <> "") {					
				$loader = new Zend\Loader\StandardAutoloader(array('autoregister_zf' => true)); 
				$loader->register(); 
				$htmlMarkup = $this->message;
	        	$html = new MimePart($htmlMarkup);
				$html->type = "text/html";
				$body = new MimeMessage();
				$body->setParts(array($html));
				
				$myMessage = new Message();
				$myMessage->addTo($this->sendTo)
				          ->addFrom($this->sendFrom)
				          ->setSubject($this->subject)
				          ->setBody($body);
				 
				// Setup SMTP transport
				$transport = new SmtpTransport();
				$options   = new SmtpOptions(array('name' => 'office365.com',
				    							   'host' => 'host.serverdata.net',
				    							   'port' => 25
				    							   )
				    					 	);
				$transport->setOptions($options);
				$transport->send($myMessage); 
				$success = true;
			}
		}
		return $success;
	}	
	
	// Basic Email Format Checking...
	protected function validateEmail($email) {	
	  $valid = (!filter_var($email, FILTER_VALIDATE_EMAIL)) ? FALSE : TRUE;
	  
	  return $valid;
	}
	
}
?>
