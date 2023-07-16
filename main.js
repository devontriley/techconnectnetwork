// Resource select anchor
const resourceSelect = jQuery( '.resource-select' );
if ( resourceSelect.length ) {
    resourceSelect.on( 'change', function(e) {
        const anchor = resourceSelect.val();
        console.log(anchor);
        const target = jQuery( '[id="'+ anchor + '"]' );

        if ( ! target.length ) return;

        target[0].scrollIntoView({ behavior: 'smooth' });
    });
}