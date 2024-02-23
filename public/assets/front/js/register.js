$(document).ready(function(){

    $(document).on('click', '#continue-button', function(){
        var email = $('#form_email').val();
        if(email === '' || is_email(email) === false){
            $("#form_email").focus();
            $('#form_email').after("<span class='email-error help-block with-errors'>Valid email is required.</span>");
        } else {
            $('.email-error').addClass("d-none");
            $('.show-hide-reg').removeClass("d-none");
            $('#continue-button').addClass("d-none");
            $('#submit-button').removeClass("d-none");
        }        
    });

    $(document).on('click', '#button-addon2', function(){
        $('#button-addon2 i').toggleClass("la-eye-slash la-eye");
        var input = $("#form_password");
        if (input.attr("type") === "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }          
    });

    $(document).on('click', '#submit-button', function(){
        var name = $('#form_name').val();
        var submit_form = false;
        if(name === ''){
            $("#form_name").focus();
            $('#form_name').after("<span class='name-error help-block with-errors'>Name is required.</span>");
        } else {
            submit_form = true;
            $('.name-error').addClass("d-none");
        }

        var password = $('#form_password').val();
        if(password === ''){
            submit_form = false;
            $("#form_password").focus();
            $('#form_password').parent().after("<span class='password-error help-block with-errors'>Password is required.</span>");
        } else {
            if(submit_form == true){
                submit_form = true;
            }
            $('.password-error').addClass("d-none");
        }

        if (!$('#check-pp').is(":checked")) {
            submit_form = false;
            $("#check-pp").focus();
            $('#check-pp').parent().after("<span class='cheked-error help-block with-errors'>Please check the checkbox before proceeding.</span>");
        } else {
            if(submit_form == true){
                submit_form = true;
            }
            $('.cheked-error').addClass("d-none");
        }

        if(submit_form == true){
            $("#register-form").submit();
        }
        
    });

});

function is_email(email) {
    const regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        return false;
    } else {
        return true;
    }
}