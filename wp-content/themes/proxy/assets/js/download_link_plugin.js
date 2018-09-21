(function() {
    tinymce.PluginManager.add('download_link_mce_button', function(editor, url) {
        editor.addButton('download_link_mce_button', {
            icon: 'false',
        text: 'Donwload Link',
            onclick: function() {
            editor.windowManager.open({
                title: 'Insert Donwload Link',
                body: [{
                    type: 'textbox',
                    name: 'textboxDownloadLinkName',
                    label: 'Donwload Link Text',
                    value: ''
                }, {
                    type: 'listbox',
                    name: 'className',
                    label: 'Position',
                    values: [{
                        text: 'Top Tooltip',
                        value: 'top_tooltip'
                    }, {
                        text: 'Left Tooltip',
                        value: 'left_tooltip'
                    }, {
                        text: 'Right Tooltip',
                        value: 'right_tooltip'
                    }, {
                        text: 'Bottom Tooltip',
                        value: 'bottom_tooltip'
                    }]
                }, ],
                onsubmit: function(e) {
                    editor.insertContent(
                        '[tooltip class="' +
                        e.data.className +
                        '" title="' +
                        e.data.textboxtooltipName +
                        '"]' +
                        editor.selection
                            .getContent() +
                        '[/tooltip]'
                    );
                }
            });
        }
    });
    });
})();