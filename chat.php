<?php
    include('conn.php');
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['userid']) || trim($_SESSION['userid']) == '') {
        header('location:index.php');
        exit();
    }

    // Fetch the selected user ID from the URL
    $selectedUserId = isset($_GET['id']) ? $_GET['id'] : 0;

    // Fetch the username of the selected user from the database
    $selectedUserQuery = mysqli_query($conn, "SELECT * FROM `user` WHERE userid='" . $selectedUserId . "'");
    $selectedUserRow = mysqli_fetch_assoc($selectedUserQuery);
    $selectedUsername = $selectedUserRow['your_name'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with <?php echo $selectedUsername; ?></title>
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
					url: "send_chat.php",
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
					url: "send_chat.php",
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
			url: 'send_chat.php',
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
	<th><h4>Hi, Chat with <?php echo $selectedUsername; ?> 
	</tr>
	<?php
		 // Get the newly inserted ID
         $selectedUserId = mysqli_insert_id($conn);

         // Now you can use $selectedUserId for further operations
     	$query=mysqli_query($conn,"select * from `chat_room` where 'chat_room_id' = '2'");
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
                    <a href="home.php" class="button button2">Back</a>

						
				</form>
				</td>
			</tr>

</table>
</body>
</html>