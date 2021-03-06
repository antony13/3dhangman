<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"  id='score_modal'>
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">X</button>
          <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i><div id='title_msg'></div></h4>
        </div>
        <div class="modal-body">
		<p>Your score is:</p>
		<center><?=$score;?></center>
        </div>
        <div class="modal-footer">
	  <button type="button" class="save_score btn btn-info" data-dismiss="modal">Save Score</button>
          <button type="button" class="close_score btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
</div>

<script type='text/javascript'>
$(document).ready(function() {

	/* Close modal only using the buttons */
	$('#score_modal').modal({
		backdrop: 'static',
		keyboard: false
	});
	var score = "<?=$score;?>"; //store score in JS var
	var msg = "<?=$msg;?>";
	$('#title_msg').html(msg);
	if (score <= 0)
	{
		$('.save_score').attr('disabled','disabled');
	}

        $('#score_modal').modal('show');
	var img = "assets/img/level"+<?=$_SESSION['img'];?>+".png";
	$("#user_input").attr("disabled", "disabled");
	$('#full_word').attr('disabled', 'disabled');
	$('#submit_full_word').attr('disabled', 'disabled');
	$('#hang_image' ).attr("src",img);
	$('.submit_form').remove();
	$('.word_submit').remove();
        $('#word_modal').modal('toggle');
	$('#word_modal').modal('hide');

	$('.save_score').click(function(){
		$('#modal_save_score').modal('show');
		$('.score').html("Score: " + score);
	});

	$('.close_score').click(function() {
		url = "<?=base_url();?>";
		window.location.href = url;
	});

	$('#submit_score').click(function(e) {
		var score = "<?=$score;?>"; //store score in JS var
		var pen_name = $('#pen_name').val();
		if (pen_name.length>0 && $.trim(pen_name)!='' && pen_name.length<=15)
		{
			$('body').Wload(); //enablig the loading image
			$('#modal_save_score').modal('toggle');
			$('#modal_save_score').modal('hide');
			$.ajax({
				type: 'POST',
				url: "<?=base_url();?>"+"score/setScore",
				data: {score:score, pen_name:pen_name},
				success : function(result) {
					if (result)
					{
						$('body').Wload('hide');//hide the loading image
						$('#modal_score').modal('show');
						$('#results_modal_body').html(result);
					}
				}//end of success
			});//end of ajax
		}//end if for length and whitespaces
		$('#pen_word').val('');
	}); //end of submit_score click function
});
</script>

