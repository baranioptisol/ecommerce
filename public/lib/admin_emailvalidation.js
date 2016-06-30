
        $(document).ready(function () {

        window.Parsley
          .addValidator('emailcheck', function (value, requirement) {
              user_id = $("#user_id").val();
              var response = false;
              $.ajax({
                  url: baseurl+"/useremailcheck",
                  data: {email: value,id:user_id},
                  dataType: 'json',
                  type: 'GET',
                  async: false,
                  success: function(data) {
                    console.log(data.total);
                     if (data.total == 0)
                          response = true;
                      else
                          response = false;
                  },
                  error: function(reason) {
                      console.log(reason);
                      response = false;
                  }
              });
              return response;
          },32)
          .addMessage('en', 'emailcheck', 'Email is already Exists.');
              
        });