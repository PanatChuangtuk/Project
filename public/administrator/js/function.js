function editor_ck(el_id)
{
  var options = {
    filebrowserImageBrowseUrl: '/administrator/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/administrator/laravel-filemanager/upload?type=Images',
    filebrowserBrowseUrl: '/administrator/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/administrator/laravel-filemanager/upload?type=Files'
  };
  CKEDITOR.replace(el_id, options);
}

(function (window, $) {
    $.fn.autoConvertToUrl = function (callback) {
      return this.each(function () {
        $(this).bind("input", function () {
          var txt = $(this).val();
          txt = txt
            .replace(/\s+$/gi, "-")
            .replace(/[^a-z0-9ก-๙\-\_]/gi, "-")
            .replace(/^\s*(.*?)\s*$/g, "$1")
            .replace(/\s+/g, "-")
            .replace(/\-+/g, "-")
            .toLowerCase();
          $(this).val(txt);
          if (typeof callback == "function") {
            callback.apply(this, [txt]);
          }
        });
      });
    };
  })(window, jQuery);
