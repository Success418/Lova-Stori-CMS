$(function() {

	$('.toggle.checked.checkbox').checkbox('check');
	$('.checkbox').checkbox();


	$(document).on('click', '.item.add', function() {
		if($('.basic.checkbox input:checked').length)
			$('.basic.checkbox input').prop('checked', false).change();

		$('#category-form').attr('action', location.origin + '/control/categories/add')
						   .toggleClass('disabled')[0].reset();
	})


	$(document).on('click', '.item.disabled', function(e) {
		e.preventDefault();
		return false;
	})


	$(document).on('click', '.item.edit:not(.disabled)', function(e) {
		$('#category-form').toggleClass('disabled');
	})


	$('.basic.checkbox input').on('change', function() {
		var checkedBox 		= $('.basic.checkbox input:checked');
		var editCondition   = checkedBox.length === 1;
		var deleteCondition = checkedBox.length > 0;
		var categoriesIds 	= [];


		if(!editCondition && !$('#category-form').hasClass('disabled'))
		{
			$('.basic.checkbox input:checked').not(this).prop('checked', false);
			editCondition = $('.basic.checkbox input:checked').length;
		}
		

		$('.item.edit').toggleClass('disabled', !editCondition);
		$('.item.delete').toggleClass('disabled', !deleteCondition);


		if(editCondition)
		{
			['name', 'order', 'description', 'id'].forEach((_name) => {
			    document.forms["category-form"].elements[_name].value = categories[parseInt($(this).val())][_name];
			})
		}
		else
		{
			$('#category-form').toggleClass('disabled', true)[0].reset();
		}
		

		$('#category-form').attr('action', location.origin + '/control/categories/update');

		checkedBox.each(function() {
			categoriesIds.push(parseInt($(this).val()));
		})

		categoriesIds = categoriesIds.length ? JSON.stringify(categoriesIds) : '';

		$('.item.delete')[0].href = location.origin + '/control/categories/delete/' + categoriesIds;
	})


	$('.categories .toggle.checkbox input').on('change', function() {
        var visible = $(this).prop('checked') ? 1 : 0;
        var id      = parseInt($(this).val());

        if(/^(0|1)$/.test(visible) && /^(\d+)$/.test(id))
        {
            //var data 		= Object.assign({csrf_token: csrf_hash}, {id, visible});
            var data 		= {id: id, visible: visible};
            var ajaxReqUrl  = location.origin + '/control/categories/update_visibility';
            
            $.post(ajaxReqUrl, data)
            .done((_data) => {
                /*if(isJson(_data))
                {
                    data = JSON.parse(_data);
                    window.csrf_hash = data.csrf_new_token;
                    $('#category-form input[name="csrf_token"]').val(csrf_hash);
                }*/
            })
        }
    })


    $('.categories.top.content .update').click(function() {
        $('.basic.checkbox input:checked').change()
    })

})