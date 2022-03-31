$(function() {

	$('.toggle.checked.checkbox').checkbox('check');
	$('.basic.checkbox').checkbox('uncheck');
	$('.checkbox').checkbox();


	$('.basic.checkbox input').on('change', function() {
		var checkedBox 		= $('.basic.checkbox input:checked');
		var editCondition   = checkedBox.length === 1;
		var deleteCondition = checkedBox.length > 0;
		var userId 		    = editCondition ? checkedBox.val() : '' ;
		var usersIds 		= [];

		try
		{
			$('.item.user_role').toggleClass('disabled', !editCondition);
			$('.item.edit').toggleClass('disabled', !editCondition);
			$('.item.delete').toggleClass('disabled', !deleteCondition);

			checkedBox.each(function() {
				usersIds.push(parseInt($(this).val()));
			}),

			usersIds = usersIds.length ? JSON.stringify(usersIds) : '';

			$('.item.delete')[0].href = location.origin + '/control/users/delete/'+ usersIds + '/' + users;

			$('.item.edit')[0].href = location.origin + '/control/users/edit/' + userId;
		}
		catch(error){}
	})


	$('.users .status.toggle.checkbox input').on('change', function(e) {
        ;
        var status   = $(this).prop('checked') ? 1 : 0;
        var property = $(this).closest('.toggle.checkbox').hasClass('active')
        			   ? 'active'
        			   : 'blocked';
        var id       = parseInt($(this).val());

        if(/^(0|1)$/.test(status) && /^(\d+)$/.test(id))
        {
            var ajaxReqUrl  = location.origin + '/control/users/update_' + property + '/' + id + '/' + property + '/' + status;

            $.post(ajaxReqUrl)
            .done((_data) => {

            })
        }
    })


    $('.dropdown.user_role').on('change', function() {
    	var user_role   = $('input[name="user_role"]').val();
    	var user_id     = parseInt($('.basic.checkbox input:checked').val());
    	var data 		= {id: user_id, user_role: user_role};
        var ajaxReqUrl  = location.origin + '/control/users/update_role/' + user_id + '/' + user_role;

        if(user_role.toLowerCase() === users.slice(0, -1).toLowerCase())
        {
        	$('.modal.users').modal('show')
        					 .find('.content').html('<h4>Sudah menjadi anggota</h4>');
        	return false;
        }

        $.post(ajaxReqUrl, data)
        .done((_data) => {
            if(_data.response)
            	$('.basic.checkbox input:checked').closest('tr').remove();
        })
        .always(function() {
        	$('.dropdown.user_role').dropdown('restore default text');
        })
    })

})