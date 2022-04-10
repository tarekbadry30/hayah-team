$(document).ready(function() {
    $("#send_message").click(function(a) {
        $(`.error-label`).text('')
		let form=$(this).closest('form');
		let submit=$(this).val();
        a.preventDefault();
        var b = !1,
            c = $("#name").val(),
            d = $("#email").val(),
            e = $("#phone").val(),
            f = $("#message").val();
        if ($("#name,#email,#phone,#message").click(function() {
                $(this).removeClass("error_input")
            }), 0 == c.length) {
            var b = !0;
            $("#name").addClass("error_input")
        }
        else
            $("#name").removeClass("error_input");
        if (0 == d.length || "-1" == d.indexOf("@")) {
            var b = !0;
            $("#email").addClass("error_input")
        }
        else
            $("#email").removeClass("error_input");
        if (0 == e.length) {
            var b = !0;
            $("#phone").addClass("error_input")
        }
        else
            $("#phone").removeClass("error_input");
        if (0 == f.length) {
            var b = !0;
            $("#message").addClass("error_input")
        }
        else
            $("#message").removeClass("error_input");
        0 == b && ($("#send_message").attr({
            disabled: "true",
            value: "Sending..."
        }),
            $.ajax({
                url: form.attr('action'),
                method: 'post',
                data:$("#contact_form").serialize(),
                success: function (data,status,xhr) {   // success callback function
                    $("#send_message").removeAttr("disabled").attr("value", submit)

                    console.log('data',data,'status',status)
                },
                error: function (jqXhr, textStatus, errorMessage) { // error callback
                    $("#send_message").removeAttr("disabled").attr("value", submit)

                    let errors=jqXhr.responseJSON.errors;
                    console.log('errors',Object.keys(errors))
                    Object.keys(errors).forEach( function(key, value){
                        console.log(errors[key][0]);
                        $(`.${key}-container .error-label`).removeClass('d-none').text(errors[key][0]);
                    });

                    //,'textStatus',textStatus,'errorMessage',errorMessage)

                },
            }).done(function (data,response) {
                $("#send_message").removeAttr("disabled").attr("value", submit)

                if(data.success){
                   $("#name").val('');
                   $("#email").val('');
                   $("#phone").val('');
                   $("#message").val('');
                   $("#mail_success").fadeIn(500)
               }
                else
                   $("#mail_fail").fadeIn(500)
                $("#send_message").removeAttr("disabled").attr("value", submit)
            })

        )
    })
});
