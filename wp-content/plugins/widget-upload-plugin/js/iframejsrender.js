jQuery(document).ready(function() {
  jQuery(document.body).on('change', '.e-controls-popover--typography select, .elementor-control-button_border_border select, .elementor-control-tag_border_border select' ,function(){
    jQuery('input[data-setting^=hidden_refresh]').trigger('input');
  })

  jQuery(document.body).on('change', '.e-controls-popover--typography input[type=number], .elementor-shadow-box input[type=number], ' +
    '.elementor-control-button_border_width input' ,function(){
    jQuery('input[data-setting^=hidden_refresh]').trigger('input');
  })

  jQuery(document.body).on('mouseup', '.e-controls-popover--typography .noUi-handle, .elementor-shadow-box .noUi-handle' ,function(){
    jQuery('input[data-setting^=hidden_refresh]').trigger('input');
  })

  jQuery(document.body).on('mouseup', '.pcr-picker' ,function(){
    jQuery('input[data-setting^=hidden_refresh]').trigger('input');
    refreshAccessabilityCheck();
  })

  jQuery(document.body).on('click', '.e-global__preview-items-container .e-global__typography' ,function(){
    jQuery('.elementor-control-popover-toggle-toggle').trigger('change');
  })

  jQuery(document.body).on('click', '.e-global__preview-items-container .e-global__color' ,function(){
    jQuery('.pcr-button').trigger('click');
    jQuery('.pcr-app').removeClass('visible');
    refreshAccessabilityCheck();
  })

  function refreshAccessabilityCheck() {
    var iframe = jQuery('#elementor-preview-iframe').contents().find("body");
    var iContentBody = iframe.find(".tota11y-toolbar-body");
    iContentBody.find('.tota11y-plugin-checkbox').each(function() {
      if (jQuery(this).is(":checked")) {
        jQuery(this).trigger('click');
        jQuery(this).prop('checked');
        iframe.find('.elementor-inline-editing').removeAttr('style');
        iframe.find('.tota11y-label-error').remove();
        iframe.find('.tota11y-label-success').remove();
        jQuery(this).trigger('click');
      }
    });
  }

  var menu = elementor.modules.layouts.panel.pages.menu.Menu;
  menu.addItem({
    name: 'custom-settings',
    icon: 'eicon-global-settings',
    title: elementor.translate('Eightfold Settings'),
    type: 'page',
    callback: function callback() {
      return $e.route('panel/custom-settings');
    }
  }, 'style');
});


elementor.hooks.addFilter( 'elementor_pro/forms/content_template/field/custom-upload', function( inputField, item, i, settings ) {
  var itemClasses = _.escape(item.css_classes),
    required = '',
    multiple = '',
    fieldName = 'form_field_';

  if (item.required) {
    required = 'required';
  }

  if (item.allow_multiple_upload) {
    multiple = ' multiple="multiple"';
    fieldName += '[]';
  }
  var background_color = '';
  if (settings.button_background_color != '') {
    background_color = 'background-color:'+settings.button_background_color;
  }

  return '<div class="elementor-field-subgroup"><div id="uploadFile"></div>' +
    '<div class="fileUpload"><div class="elementor-button e-form__buttons__wrapper__button-next"><span class="elementor-button-text elementor-size-' + settings.input_size + '">Upload</span></div>' +
    '<input size="1"  type="file" class="elementor-file-field elementor-field elementor-size-' + settings.input_size + ' ' + itemClasses + '" name="' + fieldName + '" id="form_field_' + i + '" ' + required + multiple + ' >' +
    '</div></div>';

} );

elementor.hooks.addFilter( 'elementor_pro/forms/content_template/field/custom_password', function( inputField, item, i, settings ) {
  var itemClasses = _.escape(item.css_classes),
    required = '',
    placeholder = '';

  if (item.required) {
    required = 'required';
  }

  if (item.placeholder) {
    placeholder = ' placeholder="' + item.placeholder + '"';
  }

  var infotext = '<span toggle="#password-field" class="far fa-eye field-icon toggle-password"></span><div id="pswd_info" class="elementor-field-type-html"> ' +
    '<ul>' +
    '<li id="capital" class="invalid">At least 8 characters in lengths</li> ' +
    '<li id="number" class="invalid">At least 1 numeric value</li> ' +
    '<li id="length" class="invalid">At least 1 upper case character</li> ' +
    '</ul></div>';

  return '<input size="1"' + placeholder + ' pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" type="password" class="elementor-field elementor-field-textual elementor-field-custompassword elementor-size-' + settings.input_size + ' ' + itemClasses + '" name="form_field_' + i + '" id="form_field_' + i + '" ' + required + ' >' + infotext;

} );

elementor.hooks.addFilter( 'elementor_pro/forms/content_template/field/google_address_field', function( inputField, item, i, settings ) {
  var itemClasses = _.escape(item.css_classes),
    required = '',
    placeholder = '';

  if (item.required) {
    required = 'required';
  }

  if (item.placeholder) {
    placeholder = ' placeholder="' + item.placeholder + '"';
  }

  return '<input ' + placeholder + ' type="text" id="autocomplete" class="elementor-field elementor-field-textual elementor-field-googleaddress elementor-size-' + settings.input_size + ' ' + itemClasses + '" name="form_field_' + i + '" id="form_field_' + i + '" ' + required + ' onFocus="geolocate()">';

} );


elementor.hooks.addFilter( 'editor/style/styleText', function ( panel, settings ) {
  var iframe = jQuery('#elementor-preview-iframe').contents().find("body");
  var iContentBody = iframe.find(".tota11y-toolbar-body");
  if (settings && (settings.model.attributes.widgetType == 'button' || settings.model.attributes.widgetType == 'image-box')) {
    return;
  }
  if (settings && settings.model.attributes.settings.changed.title_color) {
    iframe.find('.elementor-inline-editing').removeAttr('style');
    return;
  }
    iContentBody.find('.tota11y-plugin-checkbox').each(function () {
      if (jQuery(this).is(":checked")) {
        jQuery(this).prop('checked', false);
        jQuery(this).trigger('click');
        jQuery(this).prop('checked');
        jQuery(this).trigger('click');
      }
    });

} );