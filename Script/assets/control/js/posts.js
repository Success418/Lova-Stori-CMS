$(function() {

	$('.toggle.checked.checkbox').checkbox('check');
	$('.basic.checkbox').checkbox('uncheck');
	$('.checkbox').checkbox();

	$('.categories-list.dropdown').dropdown({on: 'hover'});


	$('.basic.checkbox input').on('change', function() {
		var checkedBox 		= $('.basic.checkbox input:checked');
		var editCondition   = checkedBox.length === 1;
		var deleteCondition = checkedBox.length > 0;
		var postId 		    = editCondition ? checkedBox.val() : '' ;
		var postsIds 		= [];

		$('.item.edit').toggleClass('disabled', !editCondition);
		$('.item.delete').toggleClass('disabled', !deleteCondition);


		$('.item.edit')[0].href = location.origin + '/control/posts/edit/' + postId;

		checkedBox.each(function() {
			postsIds.push(parseInt($(this).val()));
		})

		postsIds = postsIds.length ? JSON.stringify(postsIds) : '';

		$('.item.delete')[0].href = location.origin + '/control/posts/delete/' + postsIds;
	})


	$(document).on('click', '.item.disabled', function(e) {
		e.preventDefault();
		return false;
	})


	$('.posts .visible.toggle.checkbox input').on('change', function() {
        var visible = $(this).prop('checked') ? 1 : 0;
        var id      = parseInt($(this).val());

        if(/^(0|1)$/.test(visible) && /^(\d+)$/.test(id))
        {
            var data 		= {'id': id, 'visible': visible};
            var ajaxReqUrl  = location.origin + '/control/posts/update_visibility';
            
            $.post(ajaxReqUrl, data);
        }
    })


    $('.posts .pinned.toggle.checkbox input').on('change', function() {
        var pinned  = $(this).prop('checked') ? 1 : 0;
        var id      = parseInt($(this).val());

        if(/^(0|1)$/.test(pinned) && /^(\d+)$/.test(id))
        {
            var data 		= {'id': id, 'pinned': pinned};
            var ajaxReqUrl  = location.origin + '/control/posts/update_pin_status';
            
            $.post(ajaxReqUrl, data);
        }
    })


    $('.posts .recommended.toggle.checkbox input').on('change', function() {
        var recommended  = $(this).prop('checked') ? 1 : 0;
        var id           = parseInt($(this).val());

        if(/^(0|1)$/.test(recommended) && /^(\d+)$/.test(id))
        {
            var data        = {'id': id, 'recommended': recommended};
            var ajaxReqUrl  = location.origin + '/control/posts/update_recommendation';

            $.post(ajaxReqUrl, data);
        }
    })


    $('.item.search input').on('keyup', function(e) {

    	var val = $(this).val().trim();

        if((e.keyCode === 13) && val.length > 1)
        {   
            val = encodeURIComponent(val);
            
            window.location.href = window.origin + '/control/posts/search/' + val;
        }
    })


    $('.item.search .search.link.icon').on('click', function() {
    	var val = $(this).siblings('input').val().trim();

        if(val.length > 1)
        {
            val = encodeURIComponent(val);

            window.location.href = window.origin + '/control/posts/search/' + val;
        }
    })
})