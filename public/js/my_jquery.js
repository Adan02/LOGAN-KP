$(".main_form").on('submit', function(e) {
    event.preventDefault();

    $.ajax({
        url:$(this).attr('action'),
        method:$(this).attr('method'),
        data:new FormData(this),
        processData:false,
        dataType:'json',
        contentType:false,
        beforeSend:function(){
            $('#success_message').removeClass('alert alert-success');
            $('#success_message').text("");
            $(document).find('span.error-text').text('');
            $('[class*="error"]').removeClass('error');
        },
        success:function(data){
            if(data.status == 0){
                // console.log(data.error)
                $.each(data.error, function(prefix, val){
                    $('span.'+prefix+'_error').text(val[0]);
                    $('[name="' + prefix + '"]').addClass('error');
                });
            }else{
                if ($('.main_form [name="_method"]').length){
                    if ($('[name="_method"]').val().toUpperCase() !== 'PUT') {
                        $('.main_form')[0].reset();
                    }
                }else{
                    $('.main_form')[0].reset();
                }
                $('#success_message').addClass('alert alert-success');
                $('#success_message').text(data.msg);
                $('#show-password').prop('checked',false);
                $('#password').addClass('hide-password');
                $('#datatables').DataTable().ajax.reload();
            }
        }
    });
});

$(window).resize(function(){
    $('#datatables').DataTable().columns.adjust();
    $('#datatables').DataTable().ajax.reload();
});