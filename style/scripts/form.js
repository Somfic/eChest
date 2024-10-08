$(document).ready(() => {
	let inputs = $('.form-input.floating');

	inputs.change((e) => {
		let input = $(e.target);
		checkChange(input);
	});

	inputs.each((i, e) => {
		let input = $(e);
		checkChange(input);
	});

	function checkChange(input) {
		if (input.val() == '') {
			input.parent().removeClass('not-empty');
		} else {
			input.parent().addClass('not-empty');
		}
	}
});
