var wait=60;
var code = 9999;

function loadRegion(sel,selName,url){
    jQuery("#"+selName+" option").each(function(){
        jQuery(this).remove();
    });
    jQuery("#"+selName);
    if(jQuery("#"+sel).val()==0){
        return;
    }
    jQuery.getJSON(url,{pid:jQuery("#"+sel).val()},
        function(data){
            if(data){
                jQuery.each(data,function(idx,item){
                    jQuery("<option "+"id="+item.id+"value="+item.id+">"+item.name+"</option>").appendTo(jQuery("#"+selName));
                });
            }else{
                jQuery("#"+selName);
            }
        }
    );
}

function modifyLoadRegion(sel,selName,url,city){
    jQuery("#"+selName+" option").each(function(){
        jQuery(this).remove();
    });
    jQuery("<option value=0>"+city+"</option>").appendTo(jQuery("#"+selName));
    if(jQuery("#"+sel).val()==0){
        return;
    }
    jQuery.getJSON(url,{pid:jQuery("#"+sel).val()},
        function(data){
            if(data){
                jQuery.each(data,function(idx,item){
                    jQuery("<option "+"id="+item.id+"value="+item.id+">"+item.name+"</option>").appendTo(jQuery("#"+selName));
                });
            }else{
                jQuery("#"+selName);
            }
        }
    );
}

function sendVerifyCode(url){
    phoneNum = jQuery("#"+'phone').val();
    if( !phoneNum || phoneNum.length != 11 ){
        alert("请输入正确的手机号！");
        return;
    }
    wait=60;
    code = Math.round(Math.random()*9000)+1000;
    document.getElementById("rightCode").value=code;
    o = document.getElementById("btn");
    document.getElementById("isRightCode").innerHTML="";
    document.getElementById("code").value="";
    jQuery.getJSON(url,{phone:jQuery("#"+'phone').val(),code:code},
        function(data){
            if(data){
                if( data.error_code ){
                    alert(data.msg);
                }
            }else{
                alert("后台数据错误！");
            }
        }
    );
    time(o);
}

function time(o) {
    if (wait == 0) {
        o.removeAttribute("disabled");
        o.value="免费获取验证码";
        wait = 60;
    } else {
        o.setAttribute("disabled", true);
        o.value="重新发送(" + wait + ")";
        wait--;
        setTimeout(function() {
                time(o)
            },
            1000)
    }
}

function volidateCode(){
    correctCode = document.getElementById("rightCode").value;
    code =  parseInt(document.getElementById("code").value);
    codeStatus = document.getElementById("isRightCode");
    if( code == correctCode ){
        codeStatus.innerHTML="√";
    }else{
        codeStatus.innerHTML="×"
    }
}

function register(url){
    $name = $("input[name='name']").val();
    $phone = $("input[name='phone']").val();
    $verifyCode = $("input[name='code']").val();
    $rightCode = $("input[name='rightCode']").val();
    $province = $("#province  option:selected").text();
    $city = $("#city  option:selected").text();
    $accommodation = $('input[name="accommodation"]:checked ').val();
    if( $name && $phone && $verifyCode && $province && $city && ($verifyCode == $rightCode ) ){
        jQuery.getJSON(url,{name:$name, phone:$phone, province:$province, city:$city, accommodation:$accommodation},
            function(data){
                if(data){
                    alert(data.msg);
                }else{
                    alert("ajax无法连接到后台！");
                }
            }
        );
    }else{
        alert("请填写正确、完整的信息！");
    }
}

function modify(url){
    $id = $("input[name='id']").val();
    $name = $("input[name='name']").val();
    $phone = $("input[name='phone']").val();
    $province = $("#province  option:selected").text();
    $city = $("#city  option:selected").text();
    $accommodation = $('input[name="accommodation"]:checked ').val();

    if( $name && $phone && $province && $city ){
        jQuery.getJSON(url,{id:$id, name:$name, phone:$phone, province:$province, city:$city, accommodation:$accommodation},
            function(data){
                if(data){
                    alert(data.msg);
                }else{
                    alert("ajax无法连接到后台！");
                }
            }
        );
    }else{
        alert("请填写正确、完整的信息！");
    }
}