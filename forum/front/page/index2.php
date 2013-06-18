<div class='well well-reply'>
<form id='addthread' method='post'>
	<legend>Create New Thread</legend>
	<input placeholder='Add thread title here..' class='fullwidth' type="text" name="title" id="title" required><BR>
	<textarea  class='fullwidth' name='content' id="content" noresize></textarea><BR>
	<Center><button  class='btn btn-small'> Create Thread </button></center>
</form>
</div>

<?php foreach($topics as $topic): $i=0;?>

	<div class='well '>
		Thread: <?=$topic['topic_title']?>
		<?php foreach($topic['reply'] as $reply):  ?>
			<?php 
				if($i==0){
					echo "<br><em>Date Created:" .$reply['reply_created'] . "</em><hr>"; 
					echo $reply['reply_content'] . "<br>";	
					$i++;
				}
				else{
					echo "<div class='well well-small'><h6>Reply #" . $i++ .": " . $reply['reply_title']."</h6>";
					echo $reply['reply_content'];	
					echo "<hr><em>Date Created:" .$reply['reply_created'] . "</em></div>"; 
				}
			?>
		<?php endforeach; ?>
		<form id='addreply' method='post'>
		<div class='well-reply'>
			<legend>Add New Reply</legend>
			<input type="hidden" name="topicid" value="<?=$topic['_id']?>"><BR>
			<input placeholder='Add reply title here'  class='fullwidth' type="text" name="replyTitle" id="replyTitle" required><BR>
			<textarea class='fullwidth' name='replyContent' id="replyContent" no-resize></textarea><BR>
			<Center><button  class='btn btn-small'>Add Reply</button></center>
		
		</div>
		</form>

	</div>

<?php endforeach; ?>
