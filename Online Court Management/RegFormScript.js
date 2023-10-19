var loadFile = function(event) {
    var output = document.getElementById('pic');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
  $(function() {
    $( "#datepicker" ).datepicker({  maxDate: new Date() });$("input[type='image']").click(function() {
        $("input[id='my_file']").click();
    });
});
function load() {
    document.getElementById("details").style.display = "block";
    document.getElementById("reg").style.display = "none";
    document.getElementById("stat").style.display = "none";
}
function reg() {
    document.getElementById("details").style.display = "none";
    document.getElementById("reg").style.display = "block";
    document.getElementById("stat").style.display = "none";
}
function stat() {
    document.getElementById("details").style.display = "none";
    document.getElementById("reg").style.display = "none";
    document.getElementById("stat").style.display = "block";
}
$(function () {
    $("#name_error_message").hide();
    $("#mob_error_message").hide();
    $("#email_error_message").hide();
    $("#remail_error_message").hide();
    $("#fname_error_message").hide();
    $("#mname_error_message").hide();
    $("#add1_error_message").hide();
    $("#add2_error_message").hide();
    $("#post_error_message").hide();
    var error_name = false;
    var error_fname = false;
    var error_mname = false;
    var error_mob = false;
    var error_email = false;
    var error_remail = false;
    var error_add1 = false;
    var error_add2 = false;
    var error_post = false;

    $("#name").focusout(function () { check_name(); });
    $("#mob").focusout(function () { check_mob(); });
    $("#email").focusout(function () { check_email(); });
    $("#remail").focusout(function() { check_remail(); });
    $("#fname").focusout(function () { check_fname(); });
    $("#mname").focusout(function () { check_mname(); });
    $("#add1").focusout(function () { check_add1(); });
    $("#add2").focusout(function () { check_add2(); });
    $("#post").focusout(function () { check_post(); });
    function check_name() {
        var pattern = /^[A-Za-z][A-Za-z\'\-]+([\ A-Za-z][A-Za-z\'\-]+)*/;
        var name = $("#name").val();
        if (pattern.test(name) && name !== '') {
            $("#name_error_message").hide();
            $("#name").css("border-bottom", "2px solid #34F458");
        } else {
            $("#name_error_message").html("Should contain only Characters");
            $("#name_error_message").show();
            $("#name").css("border-bottom", "2px solid #F90A0A");
            error_name = true;
        }
    }
    function check_mob() {
        var pattern = /^(?:(?:\+|0{0,2})91(\s*|[\-])?|[0]?)?([6789]\d{2}([ -]?)\d{3}([ -]?)\d{4})$/;
        var mob = $("#mob").val();
        if (pattern.test(mob) && mob !== '') {
            $("#mob_error_message").hide();
            $("#mob").css("border-bottom", "2px solid #34F458");
        } else {
            $("#mob_error_message").html("Invalid mobile number");
            $("#mob_error_message").show();
            $("#mob").css("border-bottom", "2px solid #F90A0A");
            error_mob = true;
        }
    }
    function check_email() {
        var pattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var email = $("#email").val();
        if (pattern.test(email) && email !== '') {
            $("#email_error_message").hide();
            $("#email").css("border-bottom", "2px solid #34F458");
        } else {
            $("#email_error_message").html("Invalid Email");
            $("#email_error_message").show();
            $("#email").css("border-bottom", "2px solid #F90A0A");
            error_email = true;
        }
    }
    function check_remail() {
        var email = $("#email").val();
        var remail = $("#remail").val();
        if (email !== remail) {
           $("#remail_error_message").html("Emails did not Matched");
           $("#remail_error_message").show();
           $("#remail").css("border-bottom","2px solid #F90A0A");
           error_remail = true;
        } else {
           $("#remail_error_message").hide();
           $("#remail").css("border-bottom","2px solid #34F458");
        }
     }
     function check_fname() {
        var pattern = /^[A-Za-z][A-Za-z\'\-]+([\ A-Za-z][A-Za-z\'\-]+)*/;
        var fname = $("#fname").val();
        if (pattern.test(fname) && fname !== '') {
           $("#fname_error_message").hide();
           $("#fname").css("border-bottom","2px solid #34F458");
        } else {
           $("#fname_error_message").html("Should contain only Characters");
           $("#fname_error_message").show();
           $("#fname").css("border-bottom","2px solid #F90A0A");
           error_fname = true;
        }
     }
     function check_mname() {
        var pattern = /^[A-Za-z][A-Za-z\'\-]+([\ A-Za-z][A-Za-z\'\-]+)*/;
        var mname = $("#mname").val();
        if (pattern.test(mname) && mname !== '') {
           $("#mname_error_message").hide();
           $("#mname").css("border-bottom","2px solid #34F458");
        } else {
           $("#mname_error_message").html("Should contain only Characters");
           $("#mname_error_message").show();
           $("#mname").css("border-bottom","2px solid #F90A0A");
           error_mname = true;
        }
     }
     function check_add1() {
        var pattern = /^[a-zA-Z0-9\s\,\''\-]*$/;
        var add1 = $("#add1").val();
        if (pattern.test(add1) && add1 !== '') {
           $("#add1_error_message").hide();
           $("#add1").css("border-bottom","2px solid #34F458");
        } else {
           $("#add1_error_message").html("Should contain only Characters");
           $("#add1_error_message").show();
           $("#add1").css("border-bottom","2px solid #F90A0A");
           error_add1 = true;
        }
     }
     function check_add2() {
        var pattern = /^[a-zA-Z0-9\s\,\''\-]*$/;
        var add2 = $("#add2").val();
        if (pattern.test(add2) && add2 !== '') {
           $("#add2_error_message").hide();
           $("#add2").css("border-bottom","2px solid #34F458");
        } else {
           $("#add2_error_message").html("Should contain only Characters");
           $("#add2_error_message").show();
           $("#add2").css("border-bottom","2px solid #F90A0A");
           error_add2 = true;
        }
     }
     function check_post() {
        var pattern = /^[1-9][0-9]{5}$/;
        var post = $("#post").val();
        if (pattern.test(post) && post !== '') {
           $("#post_error_message").hide();
           $("#post").css("border-bottom","2px solid #34F458");
        } else {
           $("#post_error_message").html("Six digit code only allowed");
           $("#post_error_message").show();
           $("#post").css("border-bottom","2px solid #F90A0A");
           error_post = true;
        }
     }
    $("#btn3").click(function () {
        error_name = false;
        error_mob = false;
        error_email = false;
        error_remail = false;
        error_fname = false;
        error_mname = false;
        error_add1 = false;
        error_add2 = false;
        error_post = false;
        check_name();
        check_mob();
        check_email();
        check_remail();
        check_fname();
        check_mname();
        check_add1();
        check_add2();
        if (error_name === false && error_mob === false && error_email === false && error_remail === false 
            && error_fname === false && error_mname === false && error_add1 === false 
            && error_add2 === false && error_post === false ) {

            alert("Registration Successfull");
            return true;
        } else {
            alert("Please Fill the form Correctly");
            return false;
        }
    });
});