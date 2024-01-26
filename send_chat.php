<?php
	include ('conn.php');
	session_start();
	if(isset($_POST['msg'])){		
		$msg = addslashes($_POST['msg']);
		$selectedUserId = $_POST['selectedUserId'];
		$targetUser = $_POST['targetUser'];
		mysqli_query($conn,"insert into `chat` (chat_room_id, chat_msg, userid, chat_date) values ('$selectedUserId', '$msg' , '".$_SESSION['userid']."', '$date')") or die(mysqli_error());
	}
?>
<?php
	if(isset($_POST['res'])){
		$selectedUserId = $_POST['id'];
	?>
	<?php
		$query=mysqli_query($conn,"select * from `chat` left join `user` on user.userid=chat.userid where chat_room_id='$selectedUserId' order by chat_date asc") or die(mysqli_error());
		while($row=mysqli_fetch_array($query)){
	?>	
		<div>
			<?php echo $row['chat_date']; ?><br>
			<?php echo $row['your_name']; ?>: <?php echo $row['chat_msg']; ?><br>
		</div>
		<br>
	<?php
		}
	}	
?>

