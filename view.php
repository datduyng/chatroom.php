
	
<?php
session_start();
if(!$_SESSION["name"] || !$_SESSION['user_id']){
	if(!$_SESSION['user_id']) 
		$_SESSION['error'] = "Please login. No user ID";
	else
		$_SESSION['error'] = "Please login. No User name";
	header("Location: index.php");
}

if( isset($_POST['logout']) ){
	header('Location: logout.php');
}

?>
<!DOCTYPE html>
<html>
<style type="text/css">
	/* Chat containers */
.container-custome {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}

/* Darker chat container */
.darker {
  border-color: #ccc;
  background-color: #ddd;
}

/* Clear floats */
.container-custome::after {
  content: "";
  clear: both;
  display: table;
}

/* Style time text */
.time-right {
  float: right;
  color: #aaa;
}

/* Style time text */
.time-left {
  float: left;
  color: #999;
}

.col-centered {
    float: none;
    display: block;
    margin-left: auto;
    margin-right: auto;
}


.center-block {
    float: none !important
}

img {
  max-width:50%;
  max-height:50%;
}
</style>
<head>
	<title>MarkUpChat - A simple MVC based chat app</title>
	<a href="https://github.com/datduyng/markup_chat.git" target='_blank' class="github-corner" aria-label="View source on GitHub"><svg width="200" height="200" viewBox="0 0 250 250" style="fill:#151513; color:#fff; position: absolute; top: 0; border: 0; right: 0;" aria-hidden="true"><path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"></path><path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2" fill="currentColor" style="transform-origin: 130px 106px;" class="octo-arm"></path><path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z" fill="currentColor" class="octo-body"></path></svg></a><style>.github-corner:hover .octo-arm{animation:octocat-wave 560ms ease-in-out}@keyframes octocat-wave{0%,100%{transform:rotate(0)}20%,60%{transform:rotate(-25deg)}40%,80%{transform:rotate(10deg)}}@media (max-width:500px){.github-corner:hover .octo-arm{animation:none}.github-corner .octo-arm{animation:octocat-wave 560ms ease-in-out}}</style>
	<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
	<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>

<!--     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script type="text/javascript">
	/**
	 * Thanks to: http://stackoverflow.com/q/7616461/940217
	 * @return {number}
	 */
	String.prototype.hashCode = function(){
	    if (Array.prototype.reduce){
	        return this.split("").reduce(function(a,b){a=((a<<5)-a)+b.charCodeAt(0);return a&a},0);              
	    } 
	    var hash = 0;
	    if (this.length === 0) return hash;
	    for (var i = 0; i < this.length; i++) {
	        var character  = this.charCodeAt(i);
	        hash  = ((hash<<5)-hash)+character;
	        hash = hash & hash; // Convert to 32bit integer
	    }
	    return hash;
	}
</script>

</head>
<body>

	
	<div class="container"> 
		<h1> Welcome to Markup Chat! <?php echo $_SESSION['name']?></h1>
		<div class="row" style="display: flex; align-items: center;">
	        <div class="col-lg-8 center-block">
	        	<div class="center-block" id="messages_canvas" style='overflow-x: hidden;overflow-y:auto;height:60vh;'></div>
	        </div>
	    </div>
		<br>
		<div class="form-group col-lg-5 center-block">
			<form method='post' id='usrform'>
			  <textarea class="form-control" id="comment_id" rows="6" name='message' onkeypress="if(event.keyCode==13) {handleFormSubmit();}" placeholder="Type here. Markdown syntax is supported"></textarea>
			  <button type="submit" class="btn btn-default" id="send" name='send' value="Send">Send</button>
			  <br><br>
			  

			</form>

		</div>
		<div class="form-group">
			<form method='post'>
				<input type="submit" class="btn btn-default" value="Log out" name='logout'>
			</form>
		</div>
	</div>



	<script type="text/javascript">

var avatars = [
	'https://github.com/datduyng/archives/blob/master/misc/cartoon_icons/batman.png?raw=true', 
	'https://github.com/datduyng/archives/blob/master/misc/cartoon_icons/bender.png?raw=true',
	'https://github.com/datduyng/archives/blob/master/misc/cartoon_icons/caveman_rock2.png?raw=true',
	'https://github.com/datduyng/archives/blob/master/misc/cartoon_icons/cheekscreature.png?raw=true', 
	'https://github.com/datduyng/archives/blob/master/misc/cartoon_icons/dino_green.png?raw=true',
	'https://github.com/datduyng/archives/blob/master/misc/cartoon_icons/elephant.png?raw=true',
	'https://github.com/datduyng/archives/blob/master/misc/cartoon_icons/mario.png?raw=true', 
	'https://github.com/datduyng/archives/blob/master/misc/cartoon_icons/masktoy.png?raw=true',
	'https://github.com/datduyng/archives/blob/master/misc/cartoon_icons/monster1.png?raw=true',
	'https://github.com/datduyng/archives/blob/master/misc/cartoon_icons/mortalkombat1.png?raw=true',
	'https://github.com/datduyng/archives/blob/master/misc/cartoon_icons/pinktoy.png?raw=true', 
	'https://github.com/datduyng/archives/blob/master/misc/cartoon_icons/rhinoceros.png?raw=true',
	'https://github.com/datduyng/archives/blob/master/misc/cartoon_icons/tyrannosaurus_rex.png?raw=true',
	'https://github.com/datduyng/archives/blob/master/misc/cartoon_icons/zebra.png?raw=true'
	];
		var from = 0;
		var to = 0;
		var FREQUENCY = 2000; 
		var today = new Date();
		var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
		var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
		var dateTime = date+' '+time;
		var prev_tstamp = dateTime;

		var yesterday = new Date();
		yesterday.setDate(yesterday.getDate()-1);
		var yesterday_date = yesterday.getFullYear()+'-'+(yesterday.getMonth()+1)+'-'+yesterday.getDate();
		var yesterday_time = yesterday.getHours() + ":" + yesterday.getMinutes() + ":" + yesterday.getSeconds();
		var yesterday_dateTime = yesterday_date+' '+yesterday_time;
		var username = <?php echo "'".$_SESSION['name']."'";?>;


		function handleFormSubmit(){
			var form = $('#usrform'); 
			var url = 'addMessage.php';
			$.ajax({
				type: "POST",
				url: url+"?"+$.param({
							  'message': $("#comment_id").val()}),
				dataType: "JSON",
				success: function(r){
					return;
				}

			});
			$('#comment_id').val("").focus().setSelectionRange(0,0);;
		}
		function fetchMessages(from, to){
			$.ajax({
				type: "POST",
				url: "fetchMessages.php?"+$.param({'room_id':0, 
							'from':from, 'to':to}),
				dataType: 'json', 
				success: function(r){
					var content = "";
					if(r.data.length > 0){
						for(var i=0; i<r.data.length; i++){
							if(r.data[i].content != null) {
								if(r.data[i].username == username){
									content += (
									"<div class='row'><div class='container-custome col-lg-8 center-block'>" + 
									"<img height='10%' width='10%' src=" + avatars[Math.abs(r.data[i].username.hashCode()%avatars.length)] +  " alt='Avatar'>" + 
									"<p>" + marked( r.data[i].content) + "</p>" + 
									"<span class='time-left'>"+ r.data[i].username + "</br>" + r.data[i].timestamp + "</span>" + 
									"</div></div>");
								}else{
									content += (
									"<div class='row'><div class='container-custome col-lg-8 center-block darker' style='align:right; padding-left: 50px;'>" + 
									"<img height='10%' width='10%' src=" + avatars[Math.abs( r.data[i].username.hashCode()%avatars.length)] +  " alt='Avatar'>" + 
									"<p style='text-indent: 10px'>" + marked( r.data[i].content) + "</p>" + 
									"<span class='time-right'>"+ r.data[i].username + "</br>" + r.data[i].timestamp + "</span>" + 
									"</div></div>");
								}

							}
						}					
						$('#messages_canvas').append(content);
						$('#messages_canvas').scrollTop($('#messages_canvas')[0].scrollHeight);
					}

				}
			});
		}
		fetchMessages(yesterday_dateTime, dateTime);



		$('#usrform').submit(function(e) {
			e.preventDefault();
			var form = $('#usrform'); 
			var url = 'addMessage.php';
			$.ajax({
				type: "POST",
				url: url+"?"+$.param({
							  'message': $("#comment_id").val()}),
				dataType: "JSON",
				success: function(r){
					return;
				}

			});
		});
		setInterval(function(i){
			var today = new Date();
			var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
			var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
			var dateTime = date+' '+time;

			var current_tstamp = dateTime;
			fetchMessages(prev_tstamp, current_tstamp);

			prev_tstamp = current_tstamp;
		}, FREQUENCY)

	</script>
</body>
</html>