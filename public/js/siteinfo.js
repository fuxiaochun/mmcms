$(function(){
    var $domain = $('#domain');
    var $name = $('#name');
    var $keywords = $('#keywords');
    var $description = $('#description');

    $('#form').on('blur','input',function(){
        checkVal($(this));
    });
    $('#form').on('blur','textarea',function(){
        checkVal($(this));
    });
    function checkVal($el){
        if($el.val().trim() === ''){
            $el.siblings('i').addClass('show');
            return false;
        }else{
            $el.siblings('i').removeClass('show');
            return true;
        }
    }
    function validate(){
        var status = true;
        !checkVal($domain) && (status = false);
        !checkVal($name) && (status = false);
        !checkVal($keywords) && (status = false);
        !checkVal($description) && (status = false);
        return status;
    }
    $('.subBtn').on('click',function(){
        if(validate()){
            $('#form').submit();
        }
    });
});