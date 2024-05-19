window.onload = function() {
    // init isotope
    var $listing = $('.row').isotope({
        itemSelector: '.col',
        layoutMode: 'fitRows',
        getSortData: {
            name: '.card-header',
            visualizations: '[data-visualizations] parseInt'
        }
    });

    // bind filter button click
    $("#filters").on("click", "button", function() {
        var filterValue = $(this).attr('data-filter');
        if (filterValue === '*') {
            $listing.isotope({ filter: '*' });
        } else {
            $listing.isotope({
                filter: function() {
                    var etiquetas = $(this).attr('data-etiquetas').split(' ');
                    return etiquetas.includes(filterValue.substring(1)); // Remove the dot from filterValue
                }
            });
        }
    });

    // bind sort button click
    $("#sorts").on("click", "button", function() {
        var sortValue = $(this).attr('data-sort-by');
        var sortOrder = $(this).attr('data-sort-order') === 'asc';
        $listing.isotope({
            sortBy: sortValue,
            sortAscending: sortOrder
        });
    });

    // bind reset button click
    $(".reset-filters").on("click", function() {
        // reset filters and sort order
        $listing.isotope({
            filter: '*',
            sortBy: 'original-order'
        });
    });
};