/**
 * Created by defrox on 19/05/17.
 */

jQuery(function ($) {
    $(document).ready(function () {
        $('#insert-download-file-button').click(download_file_button_window);
    });

    function download_file_button_window() {
        if (this.window === undefined) {
            this.window = wp.media({
                title: 'Insert Download File',
                multiple: false,
                button: {text: 'Insert File'}
            });

            var self = this; // Needed to retrieve our variable in the anonymous function below
            this.window.on('select', function () {
                var data = self.window.state().get('selection').first().toJSON();
                console.log(data);
                // var obj = self.window.state().get('selection').first().changed.compat.item;
                var obj = data.compat.item;
                // console.log(obj);
                var page = $(obj).find("[id$='download-url']").val();
                if (page == '') page = 'download';
                var returnUrl = $(obj).find("[id$='thankyou-url']").val();
                if (returnUrl == '') returnUrl = 'thank-you';
                var campaign_string = '';
                var campaign = $(obj).find("[id$='campaign']").val();
                if (campaign && campaign != '') campaign_string = '&utm_campaign=' + encodeURIComponent(campaign);
                var lang_string = '';
                var lang = $(obj).find("[id$='language']").val();
                if (lang && lang != '') lang_string = '&lang=' + encodeURIComponent(lang);
                // console.log("page: " + page + "\n" + "returnUrl: " + returnUrl + "\n" + "campaign: " + campaign + "\n" + "lang: " + lang);
                wp.media.editor.insert('<a href="/' + page + '?file=' + encodeURIComponent(data.url) + '&return=' + encodeURIComponent(returnUrl) + campaign_string + lang_string + '" title="' + data.title + '">' + data.filename + '</a>');
            });
        }

        this.window.open();
        return false;
    }
});