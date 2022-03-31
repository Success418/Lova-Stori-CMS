$(function() {

	$(".post_category").dropdown({onChange: (val)=>
		{
			$('.post_subcategory').dropdown('restore defaults')
								  .dropdown('setup menu', subcategories[val]
								  						  ? subcategories[val]
								  						  : {});
		}
	})


	$('input[name="post_image"]').on('change', function() {
		var file    = $(this)[0].files[0];
		var reader  = new FileReader();

		if(/^image\/(jpeg|jpg|ico|png|svg)$/.test(file.type))
		{
			reader.addEventListener("load", function() {
				$('img.post_image').attr('src', reader.result);
			}, false);

			if(file)
			{
				reader.readAsDataURL(file);
				$('img.post_image').show()
								   .siblings('.placeholder').hide();

				try
				{
					$('input[name="post_image_changed"]').prop('checked', true);
				}catch(err){}
			}
		}
		else
		{
			$('.modal.post').modal('show')
							.modal('setting', 'duration', 0)
							.find('.content').html('<h4>File yang Anda pilih tidak diizinkan</h4>\
												   <p>Ekstensi file harus berupa jpeg, jpg, png, ico atau svg</p>');

			$(this).val('');
		}
	})


	$('form.post').on('submit', function(e) {
		var isAdding = /add$/i.test(location.href);

		if($('input[type="file"][name="post_image"]')[0].files.length === 0 && isAdding)
		{
			$('.modal.post').modal('show')
							.modal('setting', 'duration', 0)
							.find('.content').html('<h4>Gambar postingan tidak ada</h4>');

			e.preventDefault();
			return false;
		}
	})


	$('input[type="file"][name="post_image"]').on('change', function() {
		$('input[type="text"][name="post_image"]').val('');
	})


})