+function ($) { "use strict";

  var Hish = function (element, options) {
    this.init(element, options)
  }

  Hish.prototype.init = function (element, options) {
    this.$element = $(element)

    this.loadStyles();
    this.loadWidgets();
    this.loadPopover();
    this.bindEvents();
  }

  Hish.prototype.bindEvents = function() {
    var _this = this;

    // checks for highlighted text
    _this.$element.mouseup(function(e) {
      _this.checkTextSelection(_this);
      e.stopPropagation();
    });

    // hides the popover if user clicks on unregistered elements
    $(document).mouseup(function(e) {
      _this.hide();
    });

    $('#hish-share-facebook').click(function(e) {
      var facebook_dialog_url = "https://www.facebook.com/sharer/sharer.php?quote=" + _this.getText() + "&u=" + document.URL;
      var facebook_popup = window.open(facebook_dialog_url,'facebook-share','height=600,width=500');
      if (window.focus) {facebook_popup.focus()}
      _this.hide();
    });

    $('#hish-share-twitter').click(function(e) {
      var twitter_intent_url = "https://twitter.com/intent/tweet?text=" + _this.getText() + "&url=" + document.URL;
      var twitter_popup = window.open(twitter_intent_url,'twitter-share','height=600,width=500');
      if (window.focus) {twitter_popup.focus()}
      _this.hide();
    });

    // prevent text from automatically unhighlighting upon sharing
    $('#hish-share-facebook').mousedown(function(e){
      e.preventDefault();
    })
    $('#hish-share-twitter').mousedown(function(e){
      e.preventDefault();
    })
  }

  Hish.prototype.getText = function() {
    var highlighted = window.getSelection().toString();
    var text = highlighted.length > 115 ? '' + window.getSelection().toString().substring(0, 112) + '...' : highlighted;
    text = '"' + text + '"';
    return text;
  }

  Hish.prototype.loadPopover = function() {
    if (!document.getElementById('hish-share-wrapper')) {
      $("<div id='hish-share-wrapper'>" +
          "<div id='hish-share-popover-inner'>" +
            "<div id='hish-share-facebook'><i class='icon-facebook icon-light'></i></div>" +
            "<div id='hish-share-twitter'><i class='icon-twitter icon-light'></i></div>" +
          "</div>" +
        "</div>"
      ).appendTo('body');
    }
  }

  Hish.prototype.loadStyles = function() {
    // font awesome css
    var head  = document.getElementsByTagName('head')[0];
    if (!document.getElementById('font_awesome')) {
      var font_awesome  = document.createElement('link');
      font_awesome.id   = 'font_awesome';
      font_awesome.rel  = 'stylesheet';
      font_awesome.type = 'text/css';
      font_awesome.href = 'http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css';
      font_awesome.media = 'all';
      head.appendChild(font_awesome);
    }

    // medium share css
    if (!document.getElementById('medium_share_css')) {
      var style = document.createElement('style');
      style.id = "medium_share_css";
      document.body.appendChild(style);
    }
  }

  Hish.prototype.loadWidgets = function() {
    var twitter_widget = "http://platform.twitter.com/widgets.js";
    if (!$("script[src='" + twitter_widget + "']").length) {
      $("<script type='text/javascript' src='" + twitter_widget + "'></script>").appendTo('body');
    }
  }

  Hish.prototype.show = function(x, y) {
    x = x - 40;
    y = y - 20 - 40;
    $("#hish-share-wrapper").css({ top: y+'px', left: x+'px' });
    $("#hish-share-wrapper").fadeIn(100);
  }

  Hish.prototype.hide = function() {
    $("#hish-share-wrapper").fadeOut(100);
  }

  Hish.prototype.checkTextSelection = function(popover) {
    var selected_text = "";
    if (typeof window.getSelection != "undefined") {
      selected_text = window.getSelection().toString();
    } else if (typeof document.selection != "undefined" && document.selection.type == "Text") {
      selected_text = document.selection.createRange().text;
    }

    if (selected_text && selected_text.length > 0) {
      // find the bounding box of the highlighted text
      var rect = window.getSelection().getRangeAt(0).getBoundingClientRect();

      /*
      document.body.scrollTop returns 0 on Firefox, making the popover open in a incorrect Y value

      e.g.: http://stackoverflow.com/questions/7435843/window-top-document-body-scrolltop-not-working-in-chrome-or-firefox
      */

      var isWebkit = 'WebkitAppearance' in document.documentElement.style;

      if(isWebkit) {
        var y = rect.bottom - rect.height + document.body.scrollTop + 6;
        var x = rect.left + rect.width / 2 + document.body.scrollLeft;
      } else {
        var y = rect.bottom - rect.height + document.documentElement.scrollTop + 6;
        var x = rect.left + rect.width / 2 + document.body.scrollLeft;
      }

      popover.show(x, y);
    } else {
      popover.hide();
    }
  }

  var old = $.fn.hish
  $.fn.hish = function (option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('hish')
      var options = typeof option == 'object' && option

      if (!data) $this.data('hish', (data = new Hish(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }
  $.fn.hish.Constructor = Hish

}(window.jQuery);

jQuery(document).ready(function($){
$('#bg_color_choice').wpColorPicker();});

jQuery(document).ready(function($){
$('#text_color_choice').wpColorPicker();});
