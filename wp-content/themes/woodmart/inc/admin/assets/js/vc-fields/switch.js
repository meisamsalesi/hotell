(function ($) {
    const wdSwitcherBtnInit = function () {
        $('.xts-switcher-btn').each(function() {
            var $switcherBtn = $(this);

            if ( $switcherBtn.hasClass('wd-inited') ) {
                return;
            }

            $switcherBtn.on('click', function () {
                var $this = $(this);
                var value = '';

                if ($this.hasClass('xts-active')) {
                    value = $this.data('off');
                    $this.removeClass('xts-active');
                } else {
                    value = $this.data('on');
                    $this.addClass('xts-active');
                }

                $this.find('.switch-field-value').val(value).trigger('change');
            });

            $switcherBtn.addClass('wd-inited');
        });
    }

    $('#vc_ui-panel-edit-element').on('vcPanel.shown click > .vc_controls [data-vc-control="clone"]', function () {
        wdSwitcherBtnInit();
    });
})(jQuery);
