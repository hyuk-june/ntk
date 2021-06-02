<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$module_url.'/module.css" />');

include_once(G5_PATH.'/head.sub.php');

$Q = "SELECT DISTINCT fm_dir FROM ".$bt['fmgr_table']." ORDER BY fm_dir DESC";
$dirs = $bdb->fetchAll($Q);
?>

<div id="fmgr" class="flex">
    <header class="flex">
        <div class="mr-auto">
            <h1 class="font-size-3">파일매니저</h1>
        </div>
        <div class="mr-2">
            <select id="select_dir" class="form-control form-control-sm">
            <?php foreach($dirs as $item){?>
                <option value="<?php echo $item['fm_dir']?>"><?php echo $item['fm_dir']?></option>
            <?php }?>
            </select>
        </div>
        <div>
            <a href="#" class="btn btn-danger btn-sm" id="btn_close">닫기</a>
        </div>
    </header>
    <section class="flist">
        
    </section>
    <footer>
        <form id="frm_upload">
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <label class="input-group-text">파일선택</label>
                </div>
                <input type="file" multiple="multiple" name="attach[]" class="attch form-control required" required="required">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-sm btn-info">업로드</button>
                </div>
            </div>
        </form>
    </footer>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_url" tabindex="-1" role="dialog" aria-labelledby="modal_url_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_url_label">URL 복사</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group input-group-sm w-100 mb-1">
                    <div class="input-group-append">
                        <div class="input-group-text">이미지 URL</div>
                    </div>
                    <input type="text" id="copy_url" class="form-control" value="">
                </div>
                
                <div class="input-group input-group-sm w-100">
                    <div class="input-group-append">
                        <div class="input-group-text">이미지 태그</div>
                    </div>
                    <input type="text" id="copy_tag" class="form-control" value="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
<!--
var _attachFile = function(){
    
    var fele = null;
    var fdata = null;
    
    $(document).on('click', '#fmgr .btn-url', openURLbox);
    $(document).on('click', '#fmgr .btn-del', deleteItem);
    $('#copy_url, #copy_tag').focus(function(){
        $(this).select();
    })
    
    function setFileElement(ele){
        var files = $(ele).get(0).files;
        //console.log(files);
        var fname = $(ele).eq(0).attr('name');
        
        fdata = new FormData();
        $(files).each(function(i, file){
            fdata.append(fname, file);
        });
    }
    
    function upload(){
        $.ajax({
            url: g5_url + '/index.php?mtype=module&mid=_filemanager&act=upload',
            type: 'post',
            contentType: 'multipart/form-data',
            mimeType: 'multipart/form-data',
            data: fdata,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false
            
        }).done(function(result){
            
            //console.log(result);
            if(result.success === false){
                alert(result.message);
                return;
            }
            var data = result.data;
            for(var i=0; i<data.length; i++){
                appendFile(data[i]);
            }
            
        }).fail(function(jqXHR, textStatus, errorThrown){
            console.log(textStatus);
            alert(textStatus);
        });
    }
    
    function appendFile(file){
        var str = '<div class="card file-item">'
            + '<img src="' + g5_url + '/data/bart/file/' + file.fm_dir + '/thumb-' + file.fm_rname + '" class="card-img-top" alt="' + file.fm_name + '">'
            + '<div class="card-body">'
            + '<p class="card-text font-weight-bold pb-1 mb-1 border-bottom">'
            + file.fm_name
            + '</p>'
            + '<p class="flex p-1">'
            + '<a href="#" class="card-link btn-url mr-auto" data-url="' + file.fm_dir + '/' + file.fm_rname + '" data-name="' + file.fm_name + '" data-toggle="modal" data-target="#modal_url">URL 복사</a>'
            + '<a href="#" class="card-link btn-del" data-fm_idx="' + file.fm_idx + '">삭제</a>'
            + '</p>'
            + '</div>'
            + '</div>';
        var item = $(str);
        
        $('#fmgr .flist').append(item);
    }
    
    function loadList(dir){
        if(dir === undefined) return;
        dir = dir.trim();
        if(dir == '') return;
        
        $('#fmgr .flist').empty();
        
        $.ajax({
            url: g5_url + '/index.php?mtype=module&mid=_filemanager&act=list&dir=' + dir,
            type: 'get',
            dataType: 'json'
        }).done(function(result){
            if(result.success === false){
                alert(result.message);
                return;
            }
            
            var data = result.data;
            //console.log(data);
            
            for(var i=0; i<data.length; i++){
                appendFile(data[i]);
            }
            
        }).fail(function(jqXhr, textStatus){
            console.log(textStatus);
            alert(textStatus);
        })
    }
    
    function openURLbox(){
        var url = g5_url + '/data/bart/file/' + $(this).data('url');
        var tag = '<img src="' + url + '" alt="' + $(this).data('name') + '" class="img-fluid">';
        $('#copy_url').val(url);
        $('#copy_tag').val(tag);
    }
    
    function deleteItem(){
        if(!confirm('정말 삭제할까요?')) return;
        
        var index = $('.btn-del').index(this);
                
        var fm_idx = $(this).data('fm_idx');
        
        $.ajax({
            url: g5_url + '/index.php?mtype=module&mid=_filemanager&act=del&fm_idx=' + fm_idx,
            type: 'get',
            dataType: 'json'
            
        }).done(function(result){
            
            if(result.success === false){
                alert(result.message);
                return;
            }
            
            $('.file-item').eq(index).remove();
            
        }).fail(function(jqXhr, textStatus){
            
            console.log(textStatus);
            alert(textStatus);
        });
        //console.log($(this).data('fm_idx'));
    }
    
    return {
        setFileElement: setFileElement,
        upload: upload,
        loadList: loadList
    }
    
}

var af = _attachFile();

$(document).ready(function(){
    $('#frm_upload').submit(function(e){
        e.preventDefault();
        af.setFileElement('.attch');
        af.upload();
    });
    
    $('#btn_close').click(function(e){
        e.preventDefault();
        window.close();
    });
    
    $('#select_dir').change(function(){
        af.loadList($(this).val());
    });
    
    af.loadList($('#select_dir').val());
})
//-->
</script>
<?php
include_once(G5_PATH.'/tail.sub.php');