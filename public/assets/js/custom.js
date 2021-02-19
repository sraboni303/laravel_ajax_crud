(function ($){
    $(document).ready(function(){

        // Get Records        
        function getRecords(){
            $.ajax({
                url: 'all',
                success : function(output){
                    $('#main_content').html(output);
                }
                              
            });
        }
        getRecords();



        // Create Modal Show
        $('#create_btn').click(function(event){
            event.preventDefault();
            $('#create_modal').modal('show');
        });







        // View Modal Show
        $(document).on('click', '#view_btn', function(event){
            event.preventDefault();  
            let id = $(this).attr('view_id');  

            $.ajax({
                
                url : 'view/' + id,
                success : function(output){

                    $('#view_modal img#photo').attr('src', 'photos/' + output.photo);
                    $('#view_modal table tr td#email').html(output.email);
                    $('#view_modal table tr td#gender').html(output.gender);
                    $('#view_modal table tr td#location').html(output.location);
                    $('#view_modal table tr td#hobbies').html(output.hobbies);

                    $('#view_modal').modal('show'); 
                }
            });

            
        });








        

        // Form Submit
        $(document).on('submit', '#create_form', function(event){
            event.preventDefault();

            $.ajax({
                url: 'store',
                method : 'POST',
                data : new FormData(this),
                contentType : false,
                processData : false,
                success: function(){
                    $('#create_form')[0].reset();
                    $('#create_modal').modal('hide');
                    getRecords();
                }
            });


        });






        /**
         *  Delete
         */
        $(document).on('click', '#delete_btn', function(event){
            event.preventDefault();
            let id = $(this).attr('delete_id');
            // alert(id);

            swal({
                icon : 'warning',
                title : 'Delete',
                text : 'Are You Sure?',
                buttons : ['Cancel', 'Delete'],
                dangerMode : true,
            }).then( (done) => {
                if(done){
                    $.ajax({
                        url : 'delete/' + id,
                        success : function(output){
                            if(output){
                                getRecords();
                                swal({
                                    icon : 'success',
                                    title : 'Deleted',
                                    text : 'Data Deleted Successfully !!'
                                });
                            }

                        }
                    });
                    // alert('ok');
                }

            } );

        

        });



        /**
         *  Edit Single Profile
        */
       $(document).on('click', '#edit_btn', function(event){
           event.preventDefault();
           let id = $(this).attr('edit_id');

           $.ajax({
               url : 'edit/' + id,
               success : function(output){
                   $('#edit_modal #edit_form input#get_id').val(output.id);

                   $('#edit_modal #edit_form input#old_photo').val(output.photo);
                   
                   $('#edit_modal #edit_form input#edit_email').val(output.email);
                   $('#edit_modal #edit_form #gender').html(output.gender);
                   $('#edit_modal #edit_form #edit_location').html(output.location);
                   $('#edit_modal #edit_form #edit_hobbies').html(output.hobbies);
                   $('#edit_modal').modal('show');

                // alert(output.photo);

               }
           });
        
       });



       /**
        *  Update Single Profile
        */
       $('#edit_form').submit(function(event){
           event.preventDefault();
           $.ajax({
               url : 'update',
               method : 'POST',
               data : new FormData(this),
               contentType : false,
               processData : false,
               success : function(output){
                // alert(output);
                
                $('#edit_modal').modal('hide');
                getRecords();
               }
           });

       });




       /**
        *  Status Settings
        */
       $(document).on('click', '#status_btn', function(event){
           event.preventDefault();

           let id = $(this).attr('status_id');

           $.ajax({
               url: 'status/' + id,
               success : function(){
                getRecords();
               }
           });

       });



        




















    });
}) (jQuery)
