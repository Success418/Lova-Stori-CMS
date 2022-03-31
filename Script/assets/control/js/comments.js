$(function() {

	$('.toggle.checked.checkbox').checkbox('check');
	$('.basic.checkbox').checkbox('uncheck');
	$('.checkbox').checkbox();

	$('.basic.checkbox input').on('change', function() {
		var checkedBox 		= $('.basic.checkbox input:checked');
		var deleteCondition = checkedBox.length > 0;
		var postsIds 		= [];

		$('.item.delete').toggleClass('disabled', !deleteCondition);

		checkedBox.each(function() {
			postsIds.push(parseInt($(this).val()));
		})

		postsIds = postsIds.length ? JSON.stringify(postsIds) : '';

		$('.item.delete')[0].href = location.origin + '/control/comments/delete/' + postsIds;
	})


	$(document).on('click', '.item.disabled', function(e) {
		e.preventDefault();
		return false;
	})


	$('.comments .visible.toggle.checkbox input').on('change', function() {
        var visible = $(this).prop('checked') ? 1 : 0;
        var id      = parseInt($(this).val());

        if(/^(0|1)$/.test(visible) && /^(\d+)$/.test(id))
        {
            var data 		= {id: id, visible: visible};
            var ajaxReqUrl  = location.origin + '/control/comments/update_visibility';
            
            $.post(ajaxReqUrl, data);
        }
    })



	$('.comments .read').on('click', function() {
		var commentText = commentsTexts[$(this).data('id')];

		$('#comment-model .content').html(commentText)
								   .parent()
								   .modal('setting', 'duration', 0)
								   .modal('show');
	})

})