$(function() {

	$('.checkbox').checkbox();

	$('.items .checkbox.all input').change(function() {
		var isChecked = $(this).prop('checked');

		$('.items tbody .basic.checkbox')
		.checkbox(isChecked ? 'check' : 'uncheck');
	})


	$('.basic.checkbox input').on('change', function() {
		var checkedBox 	= $('tbody .basic.checkbox input:checked');
		var condition 	= checkedBox.length > 0;
		var postsIds 	= [];

		$('.item.restore, .item.delete').toggleClass('disabled', !condition);

		checkedBox.each(function() {
			postsIds.push(parseInt($(this).val()));
		})

		postsIds = postsIds.length ? JSON.stringify(postsIds) : '';

		$('.items form input[name="ids"]').val(postsIds);
	})



	$(document).on('click', '.item.disabled', function(e) {
		e.preventDefault();
		return false;
	})



	$(document).on('click', '.items .delete, .items .restore', function() {
		var idsArr = $('.items form input[name="ids"]').val().trim();

		if(/\[(\d+,?)+\]/.test(idsArr))
		{
			$('.items form input[name="action"]')
			.val($(this).text().toLowerCase())
			.closest('form').submit();
		}
	})

})