<?php
include_once './mbox-class.php'
?>
<html>
<head>
<style>
html,body{
  height:100%;
}
.wrapper{
  height:100%;
}
.chooser{
	display:inline-block;
  background-color:lightgrey;
	width:30%;
	height:100%;
  overflow:scroll;
  cursor:pointer
}
.viewer{
  color:white;
  float:right;
  background-color:blue;
	width:70%;
	height:100%;
  overflow:scroll;
}
.messageBox{
  border:3px solid black;
}
#from{
  text-align:center;
  font-weight:bold;
}
#subject{
  text-align:center;
  font-weight:bold;
} 
</style>
</head>
<body onload="mailGetter.init()">
  <div class="wrapper">
		<div class="chooser">
      <?php
				 $mbox->printMessageOverview(); 
       ?>
    </div>
		<div class="viewer"></div>
	</div>
<script>
	var mailGetter={
    conn:{},
    init:function(){
      this.conn = new XMLHttpRequest();
      this.conn.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200)
				  document.getElementsByClassName('viewer')[0].innerHTML= this.responseText;
		  }
	  },
	  get:function(mailId){
		  this.conn.open("GET","/~jgonzalez/mbox/mailHandler.php?mid="+mailId);
		  console.log("sending" + mailId);
		  this.conn.send();
	  }
	};
  var focusedElement;
  function getMail(e){
		var mailId = e.target.parentElement.id;
		//FOCUS FEATURE 
		if(focusedElement == null){
			e.target.parentElement.style.backgroundColor="darkgrey";
			focusedElement = e.target.parentElement;
		}else{
			focusedElement.style.backgroundColor="lightgrey";
			focusedElement = e.target.parentElement;
			e.target.parentElement.style.backgroundColor="darkgrey";
		}	
		//END OF FOCUS FEATURE
	  mailGetter.get(mailId);
  }
</script>
</body>
</html>
