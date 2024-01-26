<?php
	include('conn.php');
	session_start();
	if (!isset($_SESSION['userid']) ||(trim ($_SESSION['userid']) == '')) {
	header('location:index.php');
    exit();
	}
	
	$uquery=mysqli_query($conn,"SELECT * FROM `user` WHERE userid='".$_SESSION['userid']."'");
	$urow=mysqli_fetch_assoc($uquery);

					
 
                    
?>
<!DOCTYPE html>
<html>
<head>
<title>chatME</title>
<link rel="stylesheet" href="css/home.css">
<script src="jquery-3.1.1.js"></script>
<script src="bootstrap.css"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
<script type="text/javascript">

$(document).keypress(function(e){ //using keyboard enter key
	displayResult();
	/* Send Message	*/	
	
		if(e.which === 13){ 
				if($('#msg').val() == ""){
				alert('Please write message first');
			}else{
				$msg = $('#msg').val();
				$id = $('#id').val();
				$.ajax({
					type: "POST",
					url: "send_message.php",
					data: {
						msg: $msg,
						id: $id,
					},
					success: function(){
						displayResult();
						$('#msg').val(''); //clears the textarea after submit
					}
				});
			}	

			/* $("form").submit(); 
			 alert('You press enter key!'); */
		} 
	}
); 


$(document).ready(function(){ //using send button
	displayResult();
	/* Send Message	*/	
		
		$('#send_msg').on('click', function(){
			if($('#msg').val() == ""){
				alert('Please write message first');
			}else{
				$msg = $('#msg').val();
				$id = $('#id').val();
				$.ajax({
					type: "POST",
					url: "send_message.php",
					data: {
						msg: $msg,
						id: $id,
					},
					success: function(){
						displayResult();
						$('#msg').val(''); //clears the textarea after submit
					}
				});
			}	
		});
	/* END */
	});
	
	function displayResult(){
		$id = $('#id').val();
		$.ajax({
			url: 'send_message.php',
			type: 'POST',
			async: false,
			data:{
				id: $id,
				res: 1,
			},
			success: function(response){
				$('#result').html(response);
			}
		});
	}
</script>

<style>
    .center-table {
        margin: auto;
		border:1px;
    }
	table.center-table {
        width: 80%; /* Set the desired width for your table */
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    table.center-table th,
    table.center-table td {
        padding: 10px;
        text-align: center;
    }

    table.center-table th {
        background-color: #f2f2f2;
    }

    table.center-table tbody tr:hover {
        background-color: #e0e0e0;
    }
</style>

</head>

<body>
<table id="chat_room" align="center">
	<tr>
	<th><h4>Hi, <a href="profile.php?userid=<?php echo $_SESSION['userid']; ?>"><?php echo $urow['your_name']; ?></a>  - <a href="logout.php" onclick="return confirm_logout();">Logout</a></h4></th>
	</tr>
	<?php
		$query=mysqli_query($conn,"select * from `chat_room`");
		$row=mysqli_fetch_array($query);
	?>
				<div>
				<tr>
				<td><?php echo $row['chat_room_name']; ?></td><br><br>
				</tr>
				</div>
			<tr>
				<td>
				<div id="result" style="overflow-y:scroll; height:300px; width: 605px;"></div>
				<form class="form">
					<!--<input type="text" id="msg">--><br/>
					<textarea id="msg" rows="4" cols="85"></textarea><br/>
					<input type="hidden" value="<?php echo $row['chat_room_id']; ?>" id="id">
					<button type="button" id="send_msg" class="button button2">Send</button>
						
						
				</form>
				</td>
			</tr>


			<?php
    $sqlUsers = "SELECT * FROM user";
    if ($resultUsers = mysqli_query($conn, $sqlUsers)) {
        if (mysqli_num_rows($resultUsers) > 0) {
            echo "<table class='table table-bordered table-striped center-table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>#</th>";
            echo "<th>username</th>";
            echo "<th>email</th>";
            echo "<th>phone</th>";
            echo "<th>Action</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($rowUsers = mysqli_fetch_array($resultUsers)) {
                echo "<tr>";
                echo "<td>" . $rowUsers['userid'] . "</td>";
                echo "<td>" . $rowUsers['username'] . "</td>";
                echo "<td>" . $rowUsers['email'] . "</td>";
                echo "<td>" . $rowUsers['phone'] . "</td>";
                echo "<td>";
                echo "<a href='chat.php?id=" . $rowUsers['userid'] . "' title='Start Chat' data-toggle='tooltip'><span class='fas fa-comment'></span></a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            mysqli_free_result($resultUsers);
        } else {
            echo "<p class='lead'><em>No user records were found.</em></p>";
        }
    } else {
        echo "ERROR: Could not execute $sqlUsers. " . mysqli_error($conn);
    }


?>



</table>
</body>
</html>