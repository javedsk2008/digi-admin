$( document ).ready(function() {
   // alert(22);
});

function get_subject_from_courseclass(id) {
  // alert(id);
    $.ajax({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url:"get_subject_from_courseclass",
        data: 'id=' + id,
        datatype: "text",
        async: false,
        success: function (data) {
            
           var selOpts = "<option value=''>Select</option>";
           $.each(data, function(k, v)
           {
                   selOpts += "<option value='"+v['su_id']+"'>"+v['su_name']+"</option>";
           });
           $("#fk_subject_id").html(selOpts);


        }
    });
}


function get_class_from_type(id) {
    //alert(id);
     $.ajax({
         headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         type: "post",
         url:"get_class_from_type",
         data: 'id=' + id,
         datatype: "text",
         async: false,
         success: function (data) {
             
            var selOpts = "<option value=''>Select</option>";
            $.each(data, function(k, v)
            {
                    selOpts += "<option value='"+v['cl_id']+"'>"+v['cl_name']+"</option>";
            });
            $("#fk_class_id").html(selOpts);
 
 
         }
     });
 }


 
function get_chapter_from_subject(id) {
        //alert(id);
         $.ajax({
             headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             type: "post",
             url:"get_chapter_from_subject",
             data: 'id=' + id,
             datatype: "text",
             async: false,
             success: function (data) {
                 
                var selOpts = "<option value=''>Select</option>";
                $.each(data, function(k, v)
                {
                        selOpts += "<option value='"+v['ch_id']+"'>"+v['ch_name']+"</option>";
                });
                $("#fk_chapter_id").html(selOpts);
     
     
             }
         });
     }

     function chech_onkeyup(onkeyupval,table_name,column_name,show_id,delete_prefix){     
               
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: "get",
                    url:"chech_onkeyup",
                    data: {onkeyupval:onkeyupval,table_name:table_name,column_name:column_name,show_id:show_id,delete_prefix:delete_prefix},
                    datatype: "text",
                    success: function(data){                
                           //alert(data); 
                           if(data == '0'){
                                $('.'+show_id).text('');
                           }else{
                                $('.'+show_id).text('Already Added');
                           }
                    }
                });
            
        }