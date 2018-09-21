(function() {

    tinymce.PluginManager.add('dfx_widget_button', function( editor, url ) {

        function showDialog() {
            editor.windowManager.open( {
                title: 'Insert Widget',
                body: [
                    {
                        type: 'listbox',
                        name: 'widget',
                        label: 'Widget',
                        'values': editor.settings.cptPostsList
                    }
                ],
                onsubmit: function( e ) {
                    editor.insertContent( '[widgets_on_pages id="' + e.data.sidebar + '" small="' + e.data.small + '" medium="' + e.data.medium + '" large="' + e.data.large + '" wide="' + e.data.wide + '"]');
                    // editor.insertContent( '[widgets_on_pages id="' + e.data.sidebar + '"]' );
                    //
                }
            });
        } // end showDialog

        editor.addButton( 'wop_tc_button', {
            tooltip: 'Add Turbo Sidebar',
            icon: 'icon dashicons-welcome-widgets-menus',
            onclick: showDialog,
        });
    });
})();