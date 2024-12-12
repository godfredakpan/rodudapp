

$('#password, #password-confirm').on('keyup', function () {
    if ($('#password').val() == $('#password-confirm').val()) {
      $('#message').html('Password match').css('color', 'green');
    } else
      $('#message').html('Password do not match').css('color', 'red');
  });

  $(document).ready(function(){

      $('#username').blur(function(){
       var error_username = '';
       var username = $('#username').val();
       var _token = $('input[name="_token"]').val();
       var filter = /^([a-zA-Z0-9_\.\-])+$/;
       if(!filter.test(username))
       {
        $('#error_username').html('<label class="text-danger">Invalid username</label>');
        $('#username').addClass('has-error');
        $('#submit').attr('disabled', 'disabled');
       }
       else
       {
        $.ajax({
         url:"/checkUsername",
         method:"POST",
         data:{username:username, _token:_token},
         success:function(result)
         {

          if(result == 'good')
          {
           $('#error_username').html('<label class="text-success"><i class="fa fa-thumbs-up"></i></label>');
           $('#username').removeClass('has-error');
           $('#submit').attr('disabled', false);
          }
          else
          {
           $('#error_username').html('<label class="text-danger">username does not exists !</label>');
           $('#username').addClass('has-error');
           $('#submit').attr('disabled', 'disabled');
          }
         }
        })
       }
      });

     });
