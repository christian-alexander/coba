const watchdog = new CKSource.Watchdog();
		
window.watchdog = watchdog;

watchdog.setCreator( ( element, config ) => {
    return CKSource.Editor
        .create( element, config )
        .then( editor => {
            return editor;
        } )
} );

watchdog.setDestructor( editor => {
    return editor.destroy();
} );

watchdog.on( 'error', handleError );

watchdog
    .create( document.querySelector( '.ckeditor' ), {
        
        toolbar: {
            items: [
                'bold',
                'italic',
                'underline',
                'link',
                'bulletedList',
                'numberedList',
                '|',
                'outdent',
                'indent',
                '|',
                'fontFamily',
                'fontColor',
                '|',
                'superscript',
                'subscript',
                '|',
                'undo',
                'redo'
            ]
        },
        language: 'en',
        licenseKey: '',
        
        
    } )
    .catch( handleError );

function handleError( error ) {
    console.error( 'Oops, something went wrong!' );
    console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
    console.warn( 'Build id: qlroa16soqee-j5nrbd8oxqxf' );
    console.error( error );
}