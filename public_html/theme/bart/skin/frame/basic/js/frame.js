$.fn.scrollEnd = function (callback, timeout) {
  $(this).scroll(function () {
    var $this = $(this);
    if ($this.data("scrollTimeout")) {
      clearTimeout($this.data("scrollTimeout"));
    }
    $this.data("scrollTimeout", setTimeout(callback, timeout));
  });
};

Bt.frame = {
  menuFix: function () {
    var bt_offset = $(".menubar").offset();
    $(window).scroll(function () {
      //console.log(bt_offset);
      if ($(document).scrollTop() >= bt_offset.top) {
        var h = $(".menubar").outerHeight();
        $("body").css("padding-top", h + "px");
        $(".menubar").addClass("fixed");
        $("#wing").addClass("fixed");
      } else {
        $("body").css("padding-top", 0);
        $(".menubar").removeClass("fixed");
        $("#wing").removeClass("fixed");
      }
    });
  },

  aniSlider: function (id, mode, left) {
    $(id).animate({ left: left });
  },

  showMask: function (is_show) {
    if (is_show) {
      $("#slide_mask").addClass("active");
    } else {
      $("#slide_mask").removeClass("active");
    }
  },

  enableDocScroll: function (is_enable) {
    if (is_enable) {
      $("html, body").removeClass("overflow-hidden");
    } else {
      $("html, body").addClass("overflow-hidden");
    }
  },

  slideToggle: function (id) {
    var left = $(id).position().left;
    var pos = $(id).width();
    if (left + pos > 0) {
      Bt.frame.showMask(false);
      Bt.frame.enableDocScroll(true);
      Bt.frame.aniSlider(id, "hide", -pos);
    } else {
      Bt.frame.showMask(true);
      Bt.frame.enableDocScroll(false);
      Bt.frame.aniSlider(id, "show", "0px");
      $(id).scrollTop(0);
    }
  },

  favorite: function (e) {
    var bookmarkURL = window.location.href;
    var bookmarkTitle = document.title;
    var triggerDefault = false;
    if (window.sidebar && window.sidebar.addPanel) {
      // Firefox version < 23
      window.sidebar.addPanel(bookmarkTitle, bookmarkURL, "");
    } else if (
      (window.sidebar &&
        navigator.userAgent.toLowerCase().indexOf("firefox") > -1) ||
      (window.opera && window.print)
    ) {
      // Firefox version >= 23 and Opera Hotlist
      var $this = $(this);
      $this.attr("href", bookmarkURL);
      $this.attr("title", bookmarkTitle);
      $this.attr("rel", "sidebar");
      $this.off(e);
      triggerDefault = true;
    } else if (window.external && "AddFavorite" in window.external) {
      // IE Favorite
      window.external.AddFavorite(bookmarkURL, bookmarkTitle);
    } else {
      // WebKit - Safari/Chrome
      alert(
        (navigator.userAgent.toLowerCase().indexOf("mac") != -1
          ? "Cmd"
          : "Ctrl") + "+D 키를 눌러 즐겨찾기에 등록하실 수 있습니다."
      );
    }
    return triggerDefault;
  },
};

$(document).ready(function () {
  $("nav .dropdown").hover(
    function () {
      $(this).addClass("open");
    },
    function () {
      $(this).removeClass("open");
    }
  );

  //모바일메뉴
  $("#btn_toggle_menu, #slide_mask").click(function () {
    Bt.frame.slideToggle("#slide_menu");
  });

  $("#btn_favorite").click(Bt.frame.favorite);

  Bt.frame.menuFix();
});
