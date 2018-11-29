<?php

class mesg {
  public $from = "";
  public $subject = "";
  public $date = "";
  public $body = [];
  public function __construct($message) {
		$message = explode("\n",$message,6);
    $this->from    = substr($message[1],6);
		$this->date    = substr($message[2],6);
		$this->subject = substr($message[3],9);
		$this->body    = nl2br($message[5]);
  }
}

class mbox {
  public $mcount = 0;
  public $messageArray= [];
  public function __construct($file) {
    $file = file_get_contents($file);
	  $this->splitMail($file);	
  }
	private function splitMail($file){
		$mail    = explode("From ",$file);
		$messages = [];
		$isForwardMessage = false;$aM="";
		foreach($mail as $m){
			if(strlen($m) == 0)
				continue;
      $aM = $isForwardMessage?$aM.$m:$m;
			if(substr($m,-1) == ">"){
				$isForwardMessage = true;
				$aM = $m;
				continue;
			}
			array_push($messages,$aM);
			$this->mcount+=1;
			$isForwardMessage = false;
		}
    $this->createMessageDictionary($messages);
	}
	private function createMessageDictionary($messages){
		foreach($messages as $message){
			$MessageObject = new mesg($message);
			array_push($this->messageArray,$MessageObject);
		}

	}

 
	public function printMessageOverview(){
		$mIndex = 0;
    foreach($this->messageArray as $message){
      $head    = "<div id='from'>".$message->from."</div>";
			$subject = "<div id='subject'>".$message->subject."</div>";
			echo "<div class='messageBox' id='$mIndex' onclick='getMail(event);'>"; 
			echo $head;
			echo $date;
			echo $subject;
			echo "</div>";
			$mIndex++;
		}
	}
	public function printMailBody($mailId){
		$message = $this->messageArray[$mailId];
		echo "<span>From: ".$message->from."</span><br>";
		echo "<span>Date: ".$message->date."</span><br>";
		echo "<span>Subject: ".$message->subject."</span><br><hr>";
		echo "<div>".$message->body."</div>";
	}
}


$mbox = new mbox("cs-ugrads.mbox");
