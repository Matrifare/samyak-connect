(function($, viewport){

    var highlightBoxes = function() {
        if( viewport.is("<=sm") ) {
            $("select").removeClass('chosen-select');
            $("select").css('height', '34px')
        }

        if( viewport.is("md") ) {
            // alert("medium");
        }

        if( viewport.is(">md") ) {
            // alert("large");
        }
    }

    // Executes once whole document has been loaded
    $(document).ready(function() {
        highlightBoxes();
        // console.log('Current breakpoint:', viewport.current());
    });

    $(window).resize(
        viewport.changed(function(){
            highlightBoxes();
            // console.log('Current breakpoint:', viewport.current());
        })
    );

})($, ResponsiveBootstrapToolkit);
