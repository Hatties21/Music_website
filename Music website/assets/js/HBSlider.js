// Đồ thị

var HBSlider = {
  // Cấu hình và dữ liệu
  data: {
    config: {
      autoPlay: true,
      delay: 3
    },
    items: [],
    autoPlayFlag: null,
    current: 0
  },
  // Đặt tham số
  setConfig: function (config) {
    Object.assign(this.data.config, config)
  },
  // Thiết lập dữ liệu dự án phát sóng bánh xe
  setItems: function (items) {
    this.data.items = items;
  },
  // Chức năng khởi tạo
  init: function () {
    // Danh sách biểu đồ động cơ
    var sliderList = $(".slider-item-list");
    // Nút công tắc điện
    var sliderDots = $(".slider-dots-wrap");
    // Số hạng mục
    var count = this.data.items.length;
    // Tính toán chiều rộng danh sách bản đồ động cơ
    var itemWidth = 100 / count + '%';
    sliderList.css('width', count * 100 + '%');
    // Thêm vào
    for (var i = 0; i < count; i++) {
      var item = this.data.items[i];
      sliderList.append("<div class=\"slider-item\" style=\"width: " + itemWidth + "\"><a href=\"" + item.url + "\" class=\"img\" style=\"background-image: url(" + item.pic + ")\"><div class=\"slider-item-title\">" + item.title + "</div><\/a><\/div>");
      sliderDots.append("<span class=\"slider-dot\" id=\"slider-dot-" + (i + 1) + "\" onclick=\"HBSlider.go(" + (i + 1) + ")\"></span>");
    }
    // Chọn nút chuyển đổi đầu tiên
    $("#slider-dot-1").addClass('slider-dot-selected');
  },
  // Nhảy i(i:Số hạng mục, 1, -1)
  turn: function (i) {
    var count = this.data.items.length;
    var _i = this.data.current + i;
    if (_i < 0) {
      _i = _i + count;
    }
    if (_i >= count) {
      _i = _i - count;
    }
    this.data.current = _i;
    $(".slider-item-list").css('left', -100 * this.data.current + '%');
    $("span[id^=slider-dot-]").removeClass('slider-dot-selected');
    $("#slider-dot-" + (_i + 1)).addClass('slider-dot-selected');
    this.pause();
    this.play();
  },
  // Chơi
  play: function () {
    var self = this;
    if (this.data.config.autoPlay) {
      this.data.autoPlayFlag = setInterval(function () {
        self.turn(1);
      }, this.data.config.delay * 1000);
    }
  },
  // tạm ngừng
  pause: function () {
    clearInterval(this.data.autoPlayFlag);
  },
  // Nhảy đến i -i(1,2,3..)
  go: function (i) {
    var option = i - 1 - this.data.current;
    this.turn(option);
  }
};
