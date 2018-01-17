<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"  id='score_modal'>
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">X</button>
          <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i>End of Game</h4>
        </div>
        <div class="modal-body">
		<p>Your score is:</p>
		<center><?=$score;?></center>
        </div>
        <div class="modal-footer">
	  <button type="button" class="save_score btn btn-info" data-dismiss="modal">Save Score</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
		var score = "<?=$score;?>"; //store score in JS var
		$('#modal_save_score').modal('show');
		$('.score').html("Score: " + score);
	});

	$('#submit_score').click(function(e) {
		var score = "<?=$score;?>"; //store score in JS var
		var pen_name = $('#pen_name').val();
		if (pen_name.length>0 && $.trim(pen_name)!='')
		{
			$('#modal_save_score').modal('toggle');
			$('#modal_save_score').modal('hide');

			/*Prepend div with loading image */
			var base_url = '<?=base_url('assets/img/loading.gif');?>';
			var loading_image = "<div id='loading' style = 'width:100%;height:100%;z-index:10000;'><img src = '"+ base_url +"'></div>";

			$('.container').prepend(loading_image);
			$.ajax({
				type: 'POST',
				url: "<?=base_url();?>"+"score/setScore",
				data: {score:score, pen_name:pen_name},
				success : function(result) {
					if (result)
					{
						$('#loading').hide(); //hide the loading image
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

