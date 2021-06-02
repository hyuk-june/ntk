const Bt = {
  win: {
    open: function (url, wname, w, h, s, r) {
      var l = screen.availWidth / 2 - w / 2;
      var t = screen.availHeight / 2 - h / 2;

      if (s == "true" || s == true || s == undefined || s == "yes") s = "yes";
      else s = "no";

      if (r == "true" || r == true || r == undefined || r == "yes") r = "yes";
      else r = "no";

      var str =
        "left=" +
        l +
        ", top=" +
        t +
        ", width=" +
        w +
        ", height=" +
        h +
        ", scrollbars=" +
        s +
        ", resizable=" +
        r +
        ", toolbar=no, location=no";

      return window.open(url, wname, str);
    },
  },
  // 삭제 검사 확인
  cookie: {
    // 쿠키 입력 (그누보드에 브라우저 닫을때 삭제되는 함수가 없어서 따로 만듬)
    set_cookie: function (name, value, expirehours, domain) {
      document.cookie = name + "=" + escape(value) + "; path=/;";
      if (expirehours !== undefined) {
        var today = new Date();
        today.setTime(today.getTime() + 60 * 60 * 1000 * expirehours);
        document.cookie += "expires=" + today.toGMTString();
      }
      if (domain) {
        document.cookie += "domain=" + domain + ";";
      }
    },
  },
  str: {
    number_format: function (number, decimals, dec_point, thousands_sep) {
      // Strip all characters but numerical ones.
      number = (number + "").replace(/[^0-9+\-Ee.]/g, "");
      var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
        dec = typeof dec_point === "undefined" ? "." : dec_point,
        s = "",
        toFixedFix = function (n, prec) {
          var k = Math.pow(10, prec);
          return "" + Math.round(n * k) / k;
        };
      // Fix for IE parseFloat(0.55).toFixed(0) = 0;
      s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }
      if ((s[1] || "").length < prec) {
        s[1] = s[1] || "";
        s[1] += new Array(prec - s[1].length + 1).join("0");
      }
      return s.join(dec);
    },
  },
};
