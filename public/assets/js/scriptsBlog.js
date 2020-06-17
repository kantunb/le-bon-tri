$(document).ready(function () {
	$('.grid').isotope({
		itemSelector: '.grid-item',
		layoutMode: 'masonry'
	});

	const $grid = $('.grid').isotope();


	$('.filter-button-group').on('click', 'button', function () {
		var filterValue = $(this).attr('data-filter');
		$grid.isotope({
			filter: filterValue
		});
	});
})