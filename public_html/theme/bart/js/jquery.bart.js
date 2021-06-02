/**
 *
 * @bref 전화번호 입력 포멧
 *
 * @date 2018.06.15
 *
 * @author 권혁준(impactlife@naver.com)
 **/

(function ($) {
  $.fn.phoneInput = function () {
    function changeFormat(ref) {
      var str = $(ref).val();

      if (str.length > 13) {
        str = str.substring(0, 13);
      }

      str = str.replace(/[^0-9]/g, "");
      var tmp = "";

      if (str.length < 4) {
        return str;
      } else if (str.length < 7) {
        tmp += str.substr(0, 3);
        tmp += "-";
        tmp += str.substr(3);
        return tmp;
      } else if (str.length < 11) {
        tmp += str.substr(0, 3);
        tmp += "-";
        tmp += str.substr(3, 3);
        tmp += "-";
        tmp += str.substr(6);
        return tmp;
      } else {
        tmp += str.substr(0, 3);
        tmp += "-";
        tmp += str.substr(3, 4);
        tmp += "-";
        tmp += str.substr(7);
        return tmp;
      }
      return str;
    }

    var ref = this;

    $(document).on("keyup", this, function (e) {
      $(ref).val(changeFormat(ref));
    });
  };

  $.fn.dropdown = function (data) {
    let options = {
      show: false,
      trigger: "click",
      bgColor: "#fff",
      border: "1px solid #ddd",
      padding: "0.25rem",
      zIndex: 99,
      pos: "bottom",
      itemBgColor: "#fff",
      itemOverBgColor: "#3b82f6",
      itemColor: "#000",
      itemOverColor: "#fff",
    };

    const init = ($this) => {
      let isShow = false;

      if (typeof data !== "object") {
        data = {
          custOption: {},
          callback: null,
        };
      }

      // html data attribute and javascript object options
      // custOption = typeof custOption === "object" ? custOption : {};
      const opt = Object.assign({}, options, $this.data(), data.custOption);

      const fnShow = function (ref) {
        if (isShow) return;
        ref.stopPropagation();
        isShow = true;
        $item.show();
        $button.addClass("active");
      };

      const fnHide = function (ref) {
        if (!isShow) return;

        let isSelf = false;

        if (opt.trigger !== "click") {
          isSelf =
            $.inArray($this.get(0), $(ref.target).parents()) > 0 ||
            $this.get(0) === ref.target;
        }

        if (isSelf) return;

        isShow = false;
        $item.hide();
        $button.removeClass("active");
      };

      $this.css({ width: "fit-content" });

      isShow = opt.show;

      const $button = $(">:nth-child(1)", $this);
      const $item = $(">:nth-child(2)", $this);

      $this.css({ position: "relative" });
      $item.css({
        position: "absolute",
        background: opt.bgColor,
        zIndex: opt.zIndex,
        border: opt.border,
        transform: "1s ease",
        width: "fit-content",
        minWidth: "100%",
        listStyle: "none",
        padding: "0",
        margin: "0",
      });
      $("*", $item).css({ whiteSpace: "nowrap", padding: opt.padding });

      if (opt.pos === "bottom") {
        $item.css({ left: 0, top: "100%" });
      } else if (opt.pos === "left") {
        $item.css({ right: "100%", top: 0 });
      } else if (opt.pos === "right") {
        $item.css({ left: "100%", top: 0 });
      } else if (opt.pos === "leftTop") {
        $item.css({ right: "100%", bottom: "0" });
      } else if (opt.pos === "rightTop") {
        $item.css({ left: "100%", bottom: "0" });
      } else {
        $item.css({ left: 0, bottom: "100%" });
      }

      $("> *", $item).hover(
        function () {
          $(this).css({
            backgroundColor: opt.itemOverBgColor,
            color: opt.itemOverColor,
          });
        },
        function () {
          $(this).css({
            backgroundColor: opt.itemBgColor,
            color: opt.itemColor,
          });
        }
      );

      $("*", $button).css({ transition: "0.5s ease all" });

      if (!opt.show) $item.hide();

      const fnReset = function (ref) {
        ref.stopPropagation();
        isShow = false;
        $item.hide();
        $button.removeClass("active");
        if (typeof data.callback === "function") {
          data.callback($item.children().index(this), this);
        }
      };

      if (opt.trigger === "click") {
        $($this).on("click touchstart", (($this) => fnShow)($this));
        $(document).on("click touchstart", (($this) => fnHide)($this));
      } else {
        $this.on("mouseover touchstart", fnShow);
        $(document).on("mouseout", (($this) => fnHide)($this));
      }

      $("> *", $item).click(fnReset);
    };

    $these = $(this);

    $these.each((idx, ref) => {
      $this = $(ref);
      init($this);
    });
  };
})(jQuery);
