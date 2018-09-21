/*------------------------------------------------------------------------
# MD Slider - March 18, 2013
# ------------------------------------------------------------------------
# Websites:  http://www.megadrupal.com -  Email: info@megadrupal.com
--------------------------------------------------------------------------*/

(function($) {
  $(document).ready(function() {
    var url = $('.md-wrap').data('url');
    var mdSliderPanel = new MdSliderPanel(url);
    mdSliderPanel.init();
    
    // Create the first tab
    if ( $('#md-tabs').find('.md-tabs-head').find('li').length === 0 ) {
      $('#add_tab').click();
    }

    // Second submit button
    $('#secondpublish').click( function (e) {
      e.preventDefault();
      $('#publish').click();
    });
		
		// fake select
		fakeselect('#md-settings-posThumb', 'tp', 4);
		fakeselect('#md-settings-styleBorder', 'bs', 10);

    // Prepair data for submitting
    $('#post').submit(function (e) {
      //e.preventDefault();
      var string =  $.objectToString(mdSliderPanel.getSliderData());
      // Pack all data here
      $('#md-slider-data').val(string);
      // Prevent non-necessary input form being submitted
      $('.mdt-text, .mdt-input, .mdt-select, .mdt-textarea').attr('disabled', 'disabled');
    });
    
    
    // Show loading bar
    $('input[name="md-settings[showLoading]"]').change(function () { 
      if (this.value == 1) {
        $('.md-settings-sub-showLoading').show();
      }
      else {
        $('.md-settings-sub-showLoading').hide();
      }
    });

    // Show bullet
    $('#md-settings-showBullet').change(function () {
      if ($(this).is(':checked')) {
        $('.md-settings-posThumb').hide();
        $('.md-settings-sub-showBullet').show();
      }
      else {
        if ($('#md-settings-showThumb').is(':checked'))
          $('.md-settings-posThumb').show();
        $('.md-settings-sub-showBullet').hide();
      }
    });

    // Show thumbnail
    $('#md-settings-showThumb').change(function () {
      if ($(this).is(':checked')) { 
        $('.md-settings-sub-showThumb').not('.md-settings-posThumb').show();
        if ($('#md-settings-showBullet').is(':checked')) {
          $('.md-settings-sub-showThumb.md-settings-posThumb').hide();
        } else { 
          $('.md-settings-sub-showThumb.md-settings-posThumb').show();
        }
      } else { 
        $('.md-settings-sub-showThumb').hide();
      }
    });

    // 
    $('#videothumb-pick').click(function () {
      var self = this,
        send_attachment_bkp = wp.media.editor.send.attachment;

      wp.media.editor.send.attachment = function(props, attachment) {
        var thumbInput = $('#videothumb'),
           value = thumbInput.attr('src');
        if ( attachment.url && attachment.url !== '' ) {
          // Show the image
          thumbInput.attr('src', attachment.url);  
        }
        wp.media.editor.send.attachment = send_attachment_bkp;
      }
      wp.media.editor.open();
    });

    $('#md-settings-fullwidth').change(function () {
      var label = $('#md-settings-width').siblings('label');
      if ( $(this).is(':checked') ) {
        label.text('Effect zone width');
        $('.md-slidewrap').addClass('md-fullwidth').css('width', '');
        $('.md-slide-image').css('width', '');
        $('.md-settings-bgstyle').hide();

        if ($(this).hasClass('md-ajax-ready')) {
          mega_origin_background(); 
        } else {
          $(this).addClass('md-ajax-ready');
        }
      } else {
        label.text('Width');
        $('.md-slidewrap').removeClass('md-fullwidth').css('width', $('#md-settings-width').val());
        $('.md-slide-image').css('width', $('#md-settings-width').val());
        $('.md-settings-bgstyle').show();

        if ($(this).hasClass('md-ajax-ready')) {
          mega_resize_background(true);
        } else {
          $(this).addClass('md-ajax-ready');
        }
      }
    }).trigger('change');

    $('#md-settings-bgstyle').change(function () { 
      if ($(this).is(':checked') && !$('#md-settings-fullwidth').is(':checked')) {
        mega_resize_background(true);
      } else {
        mega_origin_background();
      }
    });
  });

  function mega_resize_background(crop) {
    var fids = [],
      mega_old = JSON.parse($('#mega-old').val()),
      data;
    // Gather all fid images
    $('#md-tabs').find('.md-tabcontent').each(function () { 
      fids.push(JSON.parse($('.panelsettings', this).val()).fid);
    });

    data = {
      action: 'mega_resize_bg',
      fid: fids,
      crop: crop,
      oldWidth: mega_old.width,
      oldHeight: mega_old.height,
      width: $('#md-settings-width').val(),
      height: $('#md-settings-height').val()
    };

    $.post(ajaxurl, data, function (res) {
      var fids = JSON.parse(res); 
      $('#md-tabs').find('.md-tabcontent').each(function () {
        var parent = $('.md-slide-image', this);
        parent.find('img').remove();
        parent.append($('<img>').attr('src', fids.shift()));
      });
    });
  }

  function mega_origin_background() {
    var fids = [],
      mega_old = JSON.parse($('#mega-old').val()),
      data;
    
    // Gather all fid images
    $('#md-tabs').find('.md-tabcontent').each(function () {
      var id = JSON.parse($('.panelsettings', this).val()).fid;
      fids.push(id);
    });

    data = {
      action: 'mega_delete_bg',
      fid: fids,
      width: $('#md-settings-width').val(),
      height: $('#md-settings-height').val()
    };
    
    $.post(ajaxurl, data, function (res) { 
      var respond = JSON.parse(res); 
      $('#md-tabs').find('.md-tabcontent').each(function () {
        var parent = $('.md-slide-image', this);
        parent.find('img').remove();
        parent.append($('<img>').attr('src', respond.shift()));
      });
    });
  }
	
	function fakeselect($select, $block, $optionnumber){
		var $block_html = '<div class="'+$block+'wrap clearfix">';
		var $tmpval = 0;
		for ($i = 0; $i <= $optionnumber; $i++) {
				$tmpval = $($select + " option:eq("+$i+")").val();
				if ($tmpval) {
						$block_html += '<div id="'+$block+$tmpval+'" class="slitem"></div>';
				}
		}
		$block_html += '</div>';

		$($select).parent().append($block_html);

		var $tmpselect = $($select + " option[selected]").val();
		$('#' + $block+$tmpselect).addClass('selected');

		$('.'+$block+'wrap .slitem').each(function() {
				$(this).click(function(){
						$('.'+$block+'wrap .selected').removeClass('selected');
						$(this).addClass('selected');
						$($select + " option[selected]").removeAttr("selected");
						tmpindex = $(this).attr('id').replace($block, "")
						$($select + " option[value="+tmpindex+"]").attr("selected", "selected");
				});
		});
		$($select).hide();
	}
})(jQuery);
