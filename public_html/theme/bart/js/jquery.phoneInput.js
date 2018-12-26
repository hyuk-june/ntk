/**
*
* @bref 전화번호 입력 포멧
*
* @date 2018.06.15
*
* @author 권혁준(impactlife@naver.com)
**/

(function($){
    $.fn.phoneInput = function(){
        
        function changeFormat(ref){
            
            var str = $(ref).val();
            
            if(str.length > 13){
                str = str.substring(0, 13);
            }
            
            str = str.replace(/[^0-9]/g, '');
            var tmp = '';
            
            if( str.length < 4){
                return str;
            }else if(str.length < 7){
                tmp += str.substr(0, 3);
                tmp += '-';
                tmp += str.substr(3);
                return tmp;
            }else if(str.length < 11){
                tmp += str.substr(0, 3);
                tmp += '-';
                tmp += str.substr(3, 3);
                tmp += '-';
                tmp += str.substr(6);
                return tmp;
            }else{        
                tmp += str.substr(0, 3);
                tmp += '-';
                tmp += str.substr(3, 4);
                tmp += '-';
                tmp += str.substr(7);
                return tmp;
            }
            return str;
        }
        
        var ref = this;
        
        $(document).on('keyup', this, function(e){
            $(ref).val(changeFormat(ref));
        });
    }
})(jQuery);