$(function() {

	$('.toggle.checked.checkbox').checkbox('check');
	$('.basic.checkbox').checkbox('uncheck');
	$('.checkbox').checkbox();


	$('.categories-list.dropdown').dropdown({on: 'hover'});


	$('.basic.checkbox input').on('change', function() {
		var checkedBox 		= $('.basic.checkbox input:checked');
		var editCondition   = checkedBox.length === 1;
		var deleteCondition = checkedBox.length > 0;
		var pageId 		    = editCondition ? checkedBox.val() : '' ;
		var pagesIds 		= [];

		$('.item.edit').toggleClass('disabled', !editCondition);
		$('.item.delete').toggleClass('disabled', !deleteCondition);


		$('.item.edit')[0].href = location.origin + '/control/pages/edit/' + pageId;

		checkedBox.each(function() {
			pagesIds.push(parseInt($(this).val()));
		})

		pagesIds = pagesIds.length ? JSON.stringify(pagesIds) : '';

		$('.item.delete')[0].href = location.origin + '/control/pages/delete/' + pagesIds;
	})


	$(document).on('click', '.item.disabled', function(e) {
		e.preventDefault();
		return false;
	})



    $('.pages .visible.toggle.checkbox input').on('change', function() {
        var visible  = $(this).prop('checked') ? 1 : 0;
        var id       = parseInt($(this).val());

        if(/^(0|1)$/.test(visible) && /^(\d+)$/.test(id))
        {
            var data 		= {id: id, visible: visible};
            var ajaxReqUrl  = location.origin + '/control/pages/update_visibility';
            
            $.post(ajaxReqUrl, data)
            .done(function(data) {
                console.log(data.response);
            })
        }
    })




    $('.item.search input').on('keyup', function(e) {

    	var val = $(this).val().trim();

        if((e.keyCode === 13) && val.length > 1)
        {   
            val = encodeURIComponent(val);
            
            window.location.href = window.origin + '/control/pages/search/' + val;
        }
    })


    $('.item.search .search.link.icon').on('click', function() {
    	var val = $(this).siblings('input').val().trim();

        if(val.length > 1)
        {
            val = encodeURIComponent(val);

            window.location.href = window.origin + '/control/pages/search/' + val;
        }
    })

})