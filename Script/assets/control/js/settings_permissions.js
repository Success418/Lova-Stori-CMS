$(function() {

	permissions = JSON.parse(permissions);

	if(!permissions.hasOwnProperty('administrator'))
	{
		var properties = function()
		{
			return {
						posts: {
							index: 0,
							add: 0,
							delete: 0,
							update_visibility: 0,
							update_pin: 0,
							update: 0
						},
						pages: {
							index: 0,
							add: 0,
							delete: 0,
							update_visibility: 0,
							update: 0
						},
						users: {
							index: 0,
							add: 0,
							delete: 0,
							update_blocked: 0,
							update_active: 0,
							update_role: 0,
							update: 0,
						},
						categories: {
							index: 0,
							add: 0,
							delete: 0,
							update_visibility: 0,
							update: 0
						},
						subcategories: {
							index: 0,
							add: 0,
							delete: 0,
							update_visibility: 0,
							update: 0
						},
						comments: {
							index: 0,
							delete: 0,
							update_visibility: 0
						},
						newsletter: {
							index: 0,
							add: 0
						},
						profile: {
							index: 0,
							update: 0
						},
						settings: {
							index: 0,
							update: 0
						},
						trash: {
							index: 0,
							delete: 0,
							update: 0
						}
					}
		};

		permissions = {
			administrator: properties(),
			moderator: properties(),
			author: properties()
		};
	}
	else
	{
		for(var usersType in permissions)
		{
			var collectionSelector = 'form.permissions .cards.' + usersType + ' ';

			for(var collectionName in permissions[usersType])
			{
				var actionsSelector = collectionSelector + '.' + collectionName;
				var actions 	    = permissions[usersType][collectionName];

				for(var action in actions)
				{
					$(actionsSelector + ' .checkbox[data-name="' + action + '"]')
					.addClass(actions[action] ? 'checked' : '');
				}
			}
		}
	}

	$('form.permissions .menu .item').on('click', function() {
		var activeTab = $(this).data('tab');

		$('form.permissions .item[data-tab="' + activeTab + '"]')
			.addClass('active')
			.siblings('.item')
			.removeClass('active');

		$('form.permissions .cards.'+ activeTab)
			.addClass('active')
			.siblings('.cards')
			.removeClass('active');
	})

	

	$('.ui.checkbox').checkbox();
	$('.checked.checkbox').checkbox('check');


	$('form.permissions .cards h4').on('click', function() {
		var card = $(this).closest('.card');

		card.toggleClass('all')
			.find('input')
			.prop('checked', card.hasClass('all')).change();
	})


	$('form.permissions .checkbox').on('change', function() {
		var userType 	   = $(this).closest('.cards').data('tab');
		var collectionName = $(this).closest('.card')
								    .data('collection').toLowerCase();
		var propertyName   = $(this).data('name');
		var propertyValue  = $('input', this).prop('checked') ? 1 : 0;

		permissions[userType][collectionName][propertyName] = propertyValue;
	})

	$('form.permissions').on('submit', function() {
		$('#site_permissions').val(JSON.stringify(permissions));
	})

})