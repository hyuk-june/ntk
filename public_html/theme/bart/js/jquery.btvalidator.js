/**
***************************************************************************
  프로그램 정보
***************************************************************************

* Title : 폼체크

* Date : 2010-10-01

* Update History :
  - 2011.04.12
  	기존에는 class="{...}" 형태로 사용했으나
  	jquery 가 addClass 등을 사용 할때 날려버림
  	그래서 btval="..." 형태로 바꿈. 중괄호도 없앰
  	
  - 2014.07.14
  	바트빌더에 사용하면서 이름바꿈 jquery.ESvalidator.js => jquery.btvalidator.js

* Author :
  - 권혁준

* E-Mail :
  - impactlife@naver.com

* Summary :

	jquery 필요함 - 테스트환경 jquery-1.3.2

	< 단점 >
	Native Code 인 addEventListener("submit", function, false)  이 메써드를 쓸수가 없다.
	이 메써드가 자신이 등록한 핸들러들을 반환해주지 않기 때문에 아무리 발광을 해도 어쩔 수가 없었다. 포기!
	그래서 onload 나 jQuery 의 bind 등으로만 추가할 수 있다.

    < 지원 태그목록 >
    label : string [캡션],
    required : true|false [필수입력사항],
    memberid : true|false [아이디형식],
    minlen : int [최소입력글자수],
    eqaul : string [target element name] [비밀번호확인 같이 다른값과 같아야 할때],
    korean : true|false [완성형한글],
    Korean2 : true|false [조합형한글 : 자음모음만 있는것도 가능],  @DEPRECATED
    email : string [이메일],
    numeric : true|flase [숫자만 입력가능]
    phone : string [전화번호 : 111-1111-1111 형식]
    groupcheck : true|false [radio, checkbox 에서 하나이상 필수 입력이 요구될때],
    jumin : true|false [주민번호 : '-' 포함도 가능]
    taxno : true|false [사업자번호 : '-' 포함도 가능]
    zipcode : true|false [우편번호 : 111-111 형식]
    focusid : string [체크후 임의로 포커스 이동할 아이디]
    unique : string [이미 존재하는 값인지 체크]
        ※ 중복확인하는 페이지의 url 을 입력하면 됩니다.(Ajax로 호출됩니다)
        ※ name 에 지정한 이름으로 해당 URL에  POST로 전송됩니다.
        ※ 중복확인하는 페이지에서는 전송된 값으로 DB에서 확인후
            사용해도 되면 echo "true"; 를
            사용할 수 없으면 echo "false";  를 뿌려주면 됩니다.
        ※ 결과는 폼전송확인버튼 클릭시 입력상자옆에 글자로 뿌려줍니다.

* Example :

<form name="formname" id='formname' action="http://www.naver.com" method="post">
    아이디 : <input type="text" name="mb_id" btval="label:'회원아이디',required:true,memberid:true,minlen:4,unique:'existcheck.php'" /><br />
    비밀번호 : <input type="text" name="mb_pw" btval="label:'비밀번호',required:true,minlen:4" /><br />
    비밀번호확인 : <input type="text" name="mb_pw2" btval="label:'비밀번호확인',equal:'mb_pw'" /><br />
    이름 : <input type="text" name="mb_name" btval="label:'이름',required:true,korean2:true" /><br />
    이메일 : <input type="text" name="mb_email" btval="label:'이메일',email:true" /><br />
    전화번호 : <input type="text" name="mb_tel" btval="label:'전화번호',required:true,phone:true" /><br />
	취미 : <input type="checkbox" name="mb_recemail[]" value="축구" btval="label:'취미',groupcheck:true" />축구,
	<input type="checkbox" name="mb_recemail[]" value="야구" />야구,
	<input type="checkbox" name="mb_recemail[]" value="농구" />농구
	<br />
	가입선물:
	<input type="radio" name="mb_gift" btval="label:'가입선물',groupcheck:true" value="된장" />된장,
	<input type="radio" name="mb_gift" value="고추장" />고추장,
	<input type="radio" name="mb_gift" value="쌈장" />쌈장
	<br />
	직업 : <select name="mb_job" btval="label:'직업',required:true">
		<option value=''>== 선택 ==</option>
		<option value='잡부'>잡부</option>
		<option value='후로그래머'>후로그래머</option>
		<option value='디자이너'>디자이너</option>
		</select><br />
	신체포기각서 : <input type="checkbox" name="mb_agree" btval="label:'신체포기각서',required:true" /> 동의합니다<br />
	주민번호 : <input type="text" name="mb_jumin" btval="label:'주민번호',required:true,jumin:true,minlen:13" /><br />
	사업자등록번호 : <input type="text" name="mb_taxno" btval="label:'사업자등록번호',required:true,taxno:true" /><br />
	우편번호 : <input type="text" name="mb_zipcode" btval="label:'우편번호',required:true,zipcode:true" /><br />
	<input type="submit" value='aaa' />
</form>
****************************************************************************
**/

(function($){

	$.btvalidator = function() {
		this.form = null;
		this.error = {result:false,type:'print',msg:null}
	};

	$.extend($.btvalidator, {

		//===========================================================================
		// Prototype
		//===========================================================================
		prototype:{

			validCheck:function(f){
				this.form = f;
				var validator = this;
				var ele = f.elements;
				for(var i=0;i<ele.length;i++){
					if($(ele[i]).attr("disabled")) continue;
					if(ele[i].value == undefined) continue;
					ele[i].value = $.btvalidator.bothTrim(ele[i].value);
					if(!validator.valid(ele[i])) return false;
				}
				return true;
			},

			valid:function(ele){
				var validator = this;
				var btval = $(ele).attr('data-btval');
				
				if(btval !== undefined){
					try{
						var orule = eval('({' + btval + '})');
					}catch(e){
						this.error.result = false;
						this.error.type = 'print';
						//this.error.msg = '[' + $(ele).attr('name') + '] ' + bart.lang.system('invalid_expression');
						this.error.msg = $(ele).attr('name') + ' - 표현식에 오류가 있습니다';
						this.invalidProcess(ele, orule);
						return false;
					}
					//클래스안의 룰 개수만큼 루프
					for(var key in orule){
						if(key=='label' || key=='focusid' || (!orule.required && $(ele).val()=='')) continue;
						var mtdname = 'val' + $.btvalidator.ucfirst(key);
						var existMethod = this.hasMethod(mtdname);
						if(existMethod==undefined){
							this.error.result = false;
							//this.error.msg = bart.lang.system('invalid_attr') + ' [' + key + ']';
							this.error.msg = key + ' - 존재하지 않는 속성입니다';
						}else{
							$(ele.parentNode).removeClass('has-warning');	//Remove bootstrap.js warning
							validator[mtdname](ele, orule);
						}

						if(this.error.result){
							this.invalidProcess(ele, orule);
							return false;
						}
					}
				}
				return true;
			},

			hasMethod:function(methodname){
				return this && this[methodname] && this[methodname] instanceof Function;
			},

			//처리하고 싶은데로 변경하면 됨(지금은 걍 alert창)
			invalidProcess:function(ele, o){
				$('.msg_error').remove();
				if(this.error.type == 'print'){
					//$(ele).addClass('has-warning');
					$(ele.parentNode).append("<span class='msg_error'>" + this.error.msg + "</span>");
					$(ele.parentNode).addClass('has-warning'); 	//Add bootstrap.js warning
					if(o.focusid != undefined){
						$('#' + o.focusid).focus();
					}else{
						$(ele).focus();
					}
				}else{
					alert(this.error.msg);
					if(o.focusid != undefined){
						$('#' + o.focusid).focus();
					}else{
						$(ele).focus();
					}
				}
				this.initError();
			},

			initError:function(){
				this.error.result = false;
				this.error.type = 'print';
				this.error.msg = null;
			},

			valRequired:function(ele, o){
				if(!o.required) return;
                
                console.log($(ele).attr('type'));
				if($(ele).attr('type')=='checkbox' || $(ele).attr('type')=='radio'){
                    console.log($(ele).is(':checked'));
                    var name = $(ele).attr('name');
					if(!$('input[name="' + name + '"]').is(':checked')){
						this.error.result = true;
						this.error.type = 'print';
						//this.error.msg = '[' + o.label + '] ' + bart.lang.system('invalid_required');
						this.error.msg = o.label + ' - 필수 입력사항입니다';
					}
				}else{
					if($(ele).val()==''){
						this.error.result = true;
						this.error.type = 'print';
						this.error.msg = o.label + ' - 필수 입력사항입니다';
					}
				}
			},

			valEqual:function(ele, o){
				//alert($(ele).val() + ' : ' + $(this.form[o.equal]).val());
				if($(ele).val() != $(this.form[o.equal]).val()){
					this.error.result = true;
					this.error.type = 'print';
					//this.error.msg = '[' + o.label + '] ' + bart.lang.system('invalid_no_equal');
					this.error.msg = o.label + ' - 두 값이 일치하지 않습니다';
				}
			},

			valMinlen:function(ele, o){
				if(!o.required) return;
				if ($(ele).val().length < o.minlen){
					this.error.result = true;
					this.error.type = 'print';
					//this.error.msg = '[' + o.label + '] ' + bart.lang.system('invalid_minlen').replace('{:num:}', o.minlen);
					this.error.msg = o.label + ' - 최소 ' + o.minlen.toString() + '자 이상 입력해 주세요';
				}
			},
			
			valMaxlen:function(ele, o){
				if(!o.required) return;
				if ($(ele).val().length > o.maxlen){
					this.error.result = true;
					this.error.type = 'print';
					//this.error.msg = '[' + o.label + '] ' + bart.lang.system('invalid_maxlen').replace('{:num:}', o.maxlen);
					this.error.msg = o.label + ' - 최대 ' + o.maxlen + '이하로 입력해 주세요';
				}
			},

			valEmail:function(ele, o){
				if(!o.email) return;
				var pattern = /([0-9a-zA-Z_-]+)@([0-9a-zA-Z_-]+)\.([0-9a-zA-Z_-]+)/;
				if (!pattern.test($(ele).val())){
					this.error.result = true;
					this.error.type = 'print';
					//this.error.msg = '[' + o.label + '] ' + bart.lang.system('invalid_email');
					this.error.msg = o.label + ' - 올바른 이메일을 입력해 주세요';
				}
			},

			valKorean:function(ele, o){
				if(!o.korean) return;
				//var pattern = /[^가-힣]/;
				var pattern = /[\u3131-\u314e|\u314f-\u3163|\uac00-\ud7a3]/g;
				if(!pattern.test($(ele).val())){
					this.error.result = true;
					this.error.type = 'print';
					//this.error.msg = '[' + o.label + '] ' + bart.lang.system('invalid_korean');
					this.error.msg = o.label + ' - 한국어만 입력가능합니다';
				}
			},
			
			/*
			valKorean2:function(ele, o){
				if(!o.korean2) return;
				var pattern = /[^가-힣ㄱ-ㅎㅏ-ㅣ]/;
				if(pattern.test($(ele).val())){
					this.error.result = true;
					this.error.type = 'print';
					this.error.msg = '[' + o.label + '] 한글만 입력 가능합니다';
				}
			},*/

			valMemberid:function(ele, o){
				if(!o.memberid) return;
				var pattern = /^[^a-z0-9]|[^a-z0-9_]/;
				if (pattern.test($(ele).val())){
					this.error.result = true;
					this.error.type = 'print';
					//this.error.msg = '[' + o.label + '] ' + bart.lang.system('invalid_memberid');
					this.error.msg = o.label + ' - 회원아이디는 영문자,숫자,"_" 조합으로 입력해 주세요';
				}
			},

			valNospace:function(ele, o){
				if(!o.nospace) return;
				var pattern = /(\s)/g;
				if(pattern.test($(ele).val())){
					this.error.result = true;
					//this.error.msg = '[' + o.label + '] ' + bart.lang.system('invalid_space');
					this.error.msg = o.label + ' - 공백은 입력할 수 없습니다';
				}

			},

			valNumeric:function(ele, o){
				if(!o.numeric) return;
				var pattern = /[^0-9]/;
				if(pattern.test($(ele).val())){
					this.error.result = true;
					this.error.type = 'print';
					//this.error.msg = '[' + o.label + '] ' + bart.lang.system('invalid_numeric');
					this.error.msg = o.label + ' - 숫자만 입력해주세요';
				}

			},
            
            valNumeric_dot: function(ele, o){
                if(!o.numeric_dot) return;
                var pattern = /[^0-9\.]/;
                if(pattern.test($(ele).val())){
                    this.error.result = true;
                    this.error.type = 'print';
                    //this.error.msg = '[' + o.label + '] ' + bart.lang.system('invalid_numeric');
                    this.error.msg = o.label + ' - 숫자와 소수점 외는 입력할 수 없습니다';
                }
            },

			valAlpha:function(ele, o){
				if(!o.alpha) return;
				var pattern = /[^a-z]/i;
				if(pattern.test($(ele).val())){
					this.error.result = true;
					this.error.type = 'print';
					//this.error.msg = '[' + o.label + '] ' + bart.lang.system('invalid_alpha');
					this.error.msg = o.label + ' - 영문만 입력가능합니다';
				}
			},

			valAlpha_numeric:function(ele, o){
				if(!o.alpha_numeric) return;
				var pattern = /[^a-z0-9]/i;
				if(pattern.test($(ele).val())){
					this.error.result = true;
					this.error.type = 'print';
					//this.error.msg = '[' + o.label + '] ' + bart.lang.system('invalid_alpha_numeric');;
					this.error.msg = o.label + ' - 영문과 숫자만 입력가능합니다';
				}
			},

			valAlpha_numeric_:function(ele, o){
				if(!o.alpha_numeric_) return;
				var pattern = /[^a-z0-9_]/i;
				if(pattern.test($(ele).val())){
					this.error.result = true;
					this.error.type = 'print';
					//this.error.msg = '[' + o.label + '] ' + bart.lang.system('invalid_alpha_numeric_');
					this.error.msg = o.label + ' - 영문,숫자,"_"만 입력가능합니다';
				}
			},

			valPhone:function(ele, o){
				if(!o.phone) return;
				var pattern = /^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$/;
				if(!pattern.test($(ele).val())){
					this.error.result = true;
					this.error.type = 'print';
					//this.error.msg = '[' + o.label + '] ' + bart.lang.system('invalid_phone');
					this.error.msg = o.label + ' - 전화번호형식이 잘못되었습니다';
				}
			},

			valKorean_alpha_numeric:function(ele, o){
				if(!o.korean_alpha_numeric) return;
				//var pattern = /[^가-힣a-z0-9]/i;
				var pattern = /[\u3131-\u314e|\u314f-\u3163|\uac00-\ud7a30-9a-z]/g;
				if(pattern.test($(ele).val())){
					this.error.result = true;
					this.error.type = 'print';
					//this.error.msg = '[' + o.label + '] ' + bart.lang.system('invalid_korean_alpha_numeric');
					this.error.msg = o.label + ' - 한국어,영문,숫자만 입력가능합니다';
				}
			},

			//긁어 왔는데 누구님껀지..
			/*valTaxno:function(ele, o){
				if(!o.taxno) return;
				var value = $(ele).val().replace(/[^\d]/g, '');
				var sum = 0;
				var getlist = new Array(10);
				var chkvalue = new Array('1','3','7','1','3','7','1','3','5');
				for(var i=0; i<10; i++) { getlist[i] = value.substring(i, i+1); }
				for(var i=0; i<9; i++) { sum += getlist[i]*chkvalue[i]; }
				sum = sum + parseInt((getlist[8]*5)/10);
				sidliy = sum % 10;
				sidchk = 0;
				if(sidliy != 0) { sidchk = 10 - sidliy; }
				else { sidchk = 0; }
				if(sidchk != getlist[9]){
					this.error.result = true;
					this.error.type = 'print';
					this.error.msg = '[' + o.label + '] 잘못된 사업자등록번호입니다';
				}
			},*/

			valGroupcheck:function(ele, o){
				if(!o.groupcheck) return;
				var flag = false;
				ele = document.getElementsByName(ele.name);
				for(i=0;i<ele.length;i++) if(ele[i].checked) flag = true;

				if(!flag){
					this.error.result = true;
					this.error.type = 'print';
					//this.error.msg = '[' + o.label + '] ' + bart.lang.system('invalid_not_check');
					this.error.msg = o.label + ' - 적어도 하나의 항목은 선택해 주십시오';
				}
			},

			/*valZipcode:function(ele, o){
				if(!o.zipcode) return;
				var pattern = /^\d{3}-?\d{3}($)/;
				if(!pattern.test($(ele).val())){
					this.error.result = true;
					this.error.type = 'print';
					this.error.msg = '[' + o.label + '] 우편번호가 잘못된것 같습니다';
				}
			},*/

			valUnique:function(ele, o){
				var validator = this;
				var data = {};
				//data[$(ele).attr('name')] = encodeURIComponent($(ele).val());
				data[$(ele).attr('name')] = $(ele).val();
				//o.unique = o.unique;
				$.ajax({type:'post', async:false, url:o.unique, data:data, dataType:'json'})
				.success(function(data){
					if(data.success == undefined || data.success==false){
						validator.error.result = true;
						validator.error.type = 'print';
						//validator.error.msg = bart.lang.system('invalid_unique');
						if(data.message != undefined)
							validator.error.msg = o.label + ' - ' + data.message;
						else
							validator.error.msg = o.label + ' - 이미 사용중이거나 사용할 수 없는 값입니다';
					}
				})
				.fail(function(){
					validator.error.result = true;
					validator.error.type = 'print';
					//validator.error.msg = bart.lang.system('except_internal');
					validator.error.msg = '내부오류가 발생했습니다';
				});
			}
		},

		//===========================================================================
		// Static 메쏘드
		//===========================================================================
		setResult:function(){
			var obj = {};
			obj.result = true;
			obj.msg = msg;
		},

		bothTrim:function(value){
			var pattern = /(^\s*)|(\s*$)/g;
			return value.replace(pattern, '');
		},

		ucfirst:function(value){
			str = value.toString();
			var x = str.split(/\s+/g);
			for (var i = 0; i < x.length; i++) {
				var parts = x[i].match(/(\w)(\w*)/);
				x[i] = parts[1].toUpperCase() + parts[2].toLowerCase();
			}
			return x.join(' ');
		}
	});

	$.extend({
		validate:function(){
            
			v = new $.btvalidator();
			var oldEvent = [];

			$(document.forms).each(function(i, ele){

				if(ele.onsubmit!="" && ele.onsubmit!=null && ele.onsubmit!=undefined){
					oldEvent.push(ele.onsubmit);
					ele.onsubmit = null;
				}

				if($(ele).data("events") !== undefined){
					$.each($(ele).data("events"), function(i, event){
						$.each(event, function(j, h){
							oldEvent.push(h);
							$(ele).unbind("submit", h);
						});
					})
				}

				$(ele).submit(function(){

					var res = v.validCheck(ele);

					if(res){
						if(oldEvent.length > 0){
							for(var i=0; i<oldEvent.length;i++){
								return oldEvent[i].apply(ele);
							}
						}
					}else{
						return false;
					}
				});
			});
		}
	});
})(jQuery);

/*$(document).ready(function(){
	//기존에 onsubmit 에 핸들러가 추가되어 있을경우
	//이들을 읽고 나서 작동해야 하므로 딜레이를 조금 줌 (좀 불안하긴 하다)
	setTimeout(function(){
		$.validate();
	}, 300);
});*/
//-->