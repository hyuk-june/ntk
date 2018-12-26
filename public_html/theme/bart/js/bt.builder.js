Bt.builder = {
    toggleWidgetController: function(){
        var ck = get_cookie('widget-controller');
        if(ck !== undefined && ck !== ''){
            Bt.builder.hideWidgetController();
            delete_cookie('widget-controller');
        }else{
            Bt.builder.showWidgetController();
            Bt.cookie.set_cookie('widget-controller', '1');
        }
    },
    
    showWidgetController: function(){
        $('.bt-widget-container, .bt-widget, .bt-frame').addClass('edit');
    },
    
    hideWidgetController: function(){
        $('.bt-widget-container, .bt-widget, .bt-frame').removeClass('edit');
    },
    
    openWidgetAppender: function(){
        var wg_skindir = $(this).data('wg_skindir');
        var wp_id = $(this).data('wp_id');
        var wg_id = $(this).data('wg_id');
        Bt.win.open(bt_url + '/adm/widget_append.php?wg_skindir=' + wg_skindir + '&wp_id=' + wp_id + '&wg_id=' + wg_id, 'wa_win', 800, 800);
    },
    openWidgetEditor: function(){
        var wg_idx = $(this).data('wg_idx');
        Bt.win.open(bt_url + '/adm/widget_setup.php?wg_idx=' + wg_idx, 'we_win', 700, 800);
    },
    
    openMyPhoto: function(event){
        event.preventDefault();
        Bt.win.open(g5_url + '/index.php?mtype=module&mid=_userphoto', 'myphoto_win', 380, 380, false);
    },
    
    openFrameSetup: function(){
        var url = encodeURIComponent(location.href.replace('#', ''));
        Bt.win.open(bt_url + '/adm/frame_setup.php?url=' + url + '&frame_skin=' + frame_skin, 'frame_win', 600, 800, false);
    }
}


$(function(){
    $('#btn_widget_controller').click(Bt.builder.toggleWidgetController);
    $('#btn_frame_controller').click(Bt.builder.openFrameSetup);
    $('.bt-widget-container > .control-header > .fa-plus').click(Bt.builder.openWidgetAppender);
    $('.bt-widget > .control-header > .fa-cog').click(Bt.builder.openWidgetEditor);
    $('.myphoto').click(Bt.builder.openMyPhoto);
    
    if(g5_is_admin){
        var ck = get_cookie('widget-controller');
        if(ck !== undefined && ck !== ''){
            Bt.builder.showWidgetController();
        }
    }
});