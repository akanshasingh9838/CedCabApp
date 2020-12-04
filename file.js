  $(document).ready(function(){
        $('#fare').hide();
         $('#book').hide();
        // $("#book").css("display", "none");
      
        $('#cabtype').change(function(){
           $('#book').hide();
          selectedCabType=$('#cabtype option:selected').text();
          if(selectedCabType == "CedMicro"){
            $('#luggage').attr("disabled",true);
            $('#luggage').val('0');
          }
          else{
             $('#luggage').attr("disabled",false);
          }
        });

        $('select[name="pickup"]').on('change',function(){
           $('#book').hide();
             $('#fare').hide();
          let selectedPickType=$(this).val();
          let drop_Childrens=$("select[name='drop']").children();
          $.each(drop_Childrens,function(index , value){
              if($(value).attr('value') === selectedPickType ){
                $(this).hide();
              }
              else{
                  $(this).show();
              }
          });
        });
        
         $('select[name="drop"]').on('change',function(){
           $('#book').hide();
             $('#fare').hide();
          let selectedDropType=$(this).val();
          let pick_Childrens=$("select[name='pickup']").children();
          $.each(pick_Childrens,function(index , value){
              if($(value).attr('value') === selectedDropType ){
                $(this).hide();
              }
              else{
                  $(this).show();
              }
          });
        });     
        var values=[];
        $('#button').click(function(){
          if($('#pickup').val()==null){
            alert("Select Pickup Value")
            return;
          }
          else{
          pickup=$('#pickup').val();
          }

          if($('#drop').val()==null){
            alert("Select drop Value")
            return;
          }
          else{
           drop=$('#drop').val();
          }

          if($('#cabtype').val()==null){
            alert("Select cabtype Value")
            return;
          }
          else{
            cabtype=$('#cabtype').val();
          }
        luggage=$('#luggage').val();
        if(luggage.length < 4) {

            $.ajax({
                url:'calculate.php',
                type:'POST',
                data:{pickup:pickup,drop:drop,cabtype:cabtype,luggage:luggage
                },
                success:function(result){
                    console.log(result);
                    $('#fare').show();
                    $('#fare').val("Your Total Fare would be:  "+result+ " Rs. ");
                    
                    $('#book').show();
                },
                error: function(){
                    alert("error");
                }
            });
        } else {
            alert('Input Weight should be less then 1000kg.');
        } 
        });

      });
      
      function onlynumber(button){
        var code=button.which;
        if(code>31 && (code<48 || code>57))
          return false;
        return true;
      }

      function onlytext(){
        // var code=button.which;
        if(event.keyCode>65 && event.keyCode<122 ) {

            return true;
        } else {

            return false;
        }
      }

      function checkdelete(){
        alert("This record will be deleted");
      }
      
      $(document).ready(function(){
        $('#updateinfo').click(function(e){
          //   alert('hi');
          e.preventDefault();
          var name = $('#name').val();
          var mobile = $('#mobile').val();
          $.ajax({
              url : 'userAjaxRequest.php',
              type : 'POST',
              data : {
                name : name,
                mobile : mobile,
                action : 'changeinfo'
              },
              success : function(msg)
              {   
                alert(msg);
                window.location.reload();
              },
              error: function(error)
              {
                alert('error');
              }
      
              });
         
         });

         $('#changepassword').click(function(e){           
            e.preventDefault();
            var oldpass = $('#oldpass').val();
            var newpass = $('#newpass').val();
            var repass = $('#repass').val();

            if (oldpass == "") {
                alert('Old pssword is required field !');
                return false;
            } else if (newpass == "") {
                alert('New pssword is required field !');
                return false;
            } else if (repass == "") {
                alert('Confirm pssword is required field !');
                return false;
            }

            if (newpass != repass){
                alert("Confirm Password Should be Same");
            }
           else{
            $.ajax({
                url : 'userAjaxRequest.php',
                type : 'POST',
                data : {
                  oldpass : oldpass,
                  newpass : newpass,
                  action : 'changepass'
                },
                success : function(msg)
                {   
                     if (msg == true) {
                        alert("Successfully Changed your password");
                        window.location.href = "login.php";
                     }
                     else if(msg == false){
                      alert("Your updated password is same as old one");
                     }
                     else{
                         alert("Incorrect Old Password");
                     }
                    // window.location.reload();
                },
                error: function(error)
                {
                    alert('error');
                }        
              });
           }
         
         });

        //  $('#updateInformation').click(function(){
        //   // alert('hi');
        //   // alert(id);
        //     $.ajax({
        //     url : 'userAjaxRequest.php',
        //     type : 'POST',
        //     data : {
        //         action : 'updateUserInfo'
        //     },
        //     // dataType: 'JSON',
        //     success : function(msg)
        //     {
        //       // alert(msg);
        //       console.log(msg);
        //       // console.log(msg[0]['name']);
        //       // $('#name').val(msg[0]['name']);
        //       // $('#mobile').val(msg[0]['mobile']);
        //         // window.location.reload();
        //     // $('#result').html(msg);
        //     },
        //     error: function(error)
        //     {
        //         alert('error');
        //     }
    
        //     });
        // });
        
         $('.sortUserAllRide').change(function(){
            // alert('hii');
            $('#userAllRide').hide();
            let selectData = $(this).val();
            // alert(selectData);
            $.ajax({
                url : 'userAjaxRequest.php',
                type : 'POST',
                data : {
                    sdata : selectData,
                    action : 'sorting'
                },
                dataType : 'JSON',
                success : function(msg) 
                {
                    // alert(msg);
                    console.log(msg);
                    // alert(msg[i]['ride_date']);
                    // console.log(msg['ride_date']);
                    // console.log(msg[0]['ride_date']);
                    
                    var html = "<table class='table table-bordered ml-5 mr-5'><tr><th>Sr.No.</th><th>Ride Date</th><th>Pickup Location</th><th>Drop Location</th><th>CabType</th><th>Distance Travelled</th><th>Luggage</th><th>Total Fare</th><th>Status</th></tr>";
                    sr = 1;
                    for (var i = 0; i < msg.length; i++) {
                        if (msg[i]['status']==1) {
                            status = "Pending..";
                        } else if (msg[i]['status'] == 2) {
                            // var status = document.write("Approved");
                            status = "Approved";
                        } else {
                            // var status = document.write('Cancelled');
                            status = "Cancelled";
                        }
    
                        html += "<tr><td>"+ sr++ +"</td><td>"+msg[i]['ride_date']+"</td><td>"+msg[i]['pickup']+"</td><td>"+msg[i]['dropup']+"</td><td>"+msg[i]['cab']+"</td><td>"+msg[i]['total_distance']+"</td><td>"+msg[i]['luggage']+"</td><td>"+msg[i]['total_fare']+"</td><td>"+status+"</td></tr>";
                    }
                    html += "</table>";
                    $('#allRideResult').html(html);
                },
                 error: function(error)
                  {
                      alert('error');
                  }
            });
            
            });

            $('.filterAllRide').change(function(){
              $('#userAllRide').hide();
              let selectData = $(this).val();
  
              $.ajax({
                  url : 'userAjaxRequest.php',
                  type : 'POST',
                  data : {
                      sdata : selectData,
                      action : 'filterAllRide'
                  },
                  dataType : 'JSON',
                  success : function(msg) 
                  {
                      // alert(msg);
                      console.log(msg);
                      // alert(msg[i]['ride_date']);
                      // console.log(msg['ride_date']);
                      // console.log(msg[0]['ride_date']);
                      
                      var html = "<table class='table table-bordered ml-5 mr-5'><tr><th>Sr.No.</th><th>Ride Date</th><th>Pickup Location</th><th>Drop Location</th><th>CabType</th><th>Total Distance</th><th>Luggage Weight</th><th>Total Fare</th><th>Status</th></tr>";
                      sr = 1;
                      for (var i = 0; i < msg.length; i++) {
                          if (msg[i]['status']==1) {
                              status = "Pending..";
                          } else if (msg[i]['status'] == 2) {
                              // var status = document.write("Approved");
                              status = "Approved";
                          } else {
                              // var status = document.write('Cancelled');
                              status = "Cancelled";
                          }
      
                          html += "<tr><td>"+ sr++ +"</td><td>"+msg[i]['ride_date']+"</td><td>"+msg[i]['pickup']+"</td><td>"+msg[i]['dropup']+"</td><td>"+msg[i]['cab']+"</td><td>"+msg[i]['total_distance']+"</td><td>"+msg[i]['luggage']+"</td><td>"+msg[i]['total_fare']+"</td><td>"+status+"</td></tr>";
                      }
                      html += "</table>";
                      $('#allRideResult').html(html);
                  }
              });
          });

            $('.sortUserPendingRide').change(function(){
            $('#userAllRide').hide();
            let selectData = $(this).val();
            // alert(selectData);
            $.ajax({
                url : 'userAjaxRequest.php',
                type : 'POST',
                data : {
                    sdata : selectData,
                    action : 'UserPendingsorting'
                },
                dataType : 'JSON',
                success : function(msg) 
                {
                    // alert(msg);
                    console.log(msg);
                    var html = "<table class='table table-bordered ml-5 mr-5'><tr><th>Sr.No.</th><th>Ride Date</th><th>Pickup Location</th><th>Drop Location</th><th>Cab Type</th><th>Distance Travelled</th><th>Luggage</th><th>Total Fare</th><th>Status</th></tr>";
                    sr = 1;
                    for (var i = 0; i < msg.length; i++) {
                        if (msg[i]['status']==1) {
                            status = "Pending..";
                        } else if (msg[i]['status'] == 2) {
                            // var status = document.write("Approved");
                            status = "Approved";
                        } else {
                            // var status = document.write('Cancelled');
                            status = "Cancelled";
                        }
    
                        html += "<tr><td>"+ sr++ +"</td><td>"+msg[i]['ride_date']+"</td><td>"+msg[i]['pickup']+"</td><td>"+msg[i]['dropup']+"</td><td>"+msg[i]['cab']+"</td><td>"+msg[i]['total_distance']+"</td><td>"+msg[i]['luggage']+"</td><td>"+msg[i]['total_fare']+"</td><td>"+status+"</td></tr>";
                    }
                    html += "</table>";
                    $('#allRideResult').html(html);
                },
                 error: function(error)
                  {
                      alert('error');
                  }
            });
            
            });


            $('.filterUserPendingRide').change(function(){
              $('#userAllRide').hide();
              let selectData = $(this).val();
  
              $.ajax({
                  url : 'userAjaxRequest.php',
                  type : 'POST',
                  data : {
                      sdata : selectData,
                      action : 'filterUserPendingRide'
                  },
                  dataType : 'JSON',
                  success : function(msg) 
                  {
                      // alert(msg);
                      console.log(msg);                      
                      var html = "<table class='table table-bordered ml-5 mr-5'><tr><th>Sr.No.</th><th>Ride Date</th><th>Pickup Location</th><th>Drop Location</th><th>CabType</th><th>Total Distance</th><th>Luggage Weight</th><th>Total Fare</th><th>Status</th></tr>";
                      sr = 1;
                      for (var i = 0; i < msg.length; i++) {
                          if (msg[i]['status']==1) {
                              status = "Pending..";
                          } else if (msg[i]['status'] == 2) {
                              // var status = document.write("Approved");
                              status = "Approved";
                          } else {
                              // var status = document.write('Cancelled');
                              status = "Cancelled";
                          }
      
                          html += "<tr><td>"+ sr++ +"</td><td>"+msg[i]['ride_date']+"</td><td>"+msg[i]['pickup']+"</td><td>"+msg[i]['dropup']+"</td><td>"+msg[i]['cab']+"</td><td>"+msg[i]['total_distance']+"</td><td>"+msg[i]['luggage']+"</td><td>"+msg[i]['total_fare']+"</td><td>"+status+"</td></tr>";
                      }
                      html += "</table>";
                      $('#allRideResult').html(html);
                  }
              });
          });


          $('.sortUserCompletedRide').change(function(){
            // alert('hii');
            $('#userAllRide').hide();
            let selectData = $(this).val();
            // alert(selectData);
            $.ajax({
                url : 'userAjaxRequest.php',
                type : 'POST',
                data : {
                    sdata : selectData,
                    action : 'sortUserCompletedRide'
                },
                dataType : 'JSON',
                success : function(msg) 
                {
                    // alert(msg);
                    console.log(msg);
                    // alert(msg[i]['ride_date']);
                    // console.log(msg['ride_date']);
                    // console.log(msg[0]['ride_date']);
                    
                    var html = "<table class='table table-bordered ml-5 mr-5'><tr><th>Sr.No.</th><th>Ride Date</th><th>Pickup Location</th><th>Drop Location</th><th>CabType</th><th>Distance Travelled</th><th>Luggage</th><th>Total Fare</th><th>Status</th></tr>";
                    sr = 1;
                    for (var i = 0; i < msg.length; i++) {
                        if (msg[i]['status']==1) {
                            status = "Pending..";
                        } else if (msg[i]['status'] == 2) {
                            // var status = document.write("Approved");
                            status = "Approved";
                        } else {
                            // var status = document.write('Cancelled');
                            status = "Cancelled";
                        }
    
                        html += "<tr><td>"+ sr++ +"</td><td>"+msg[i]['ride_date']+"</td><td>"+msg[i]['pickup']+"</td><td>"+msg[i]['dropup']+"</td><td>"+msg[i]['cab']+"</td><td>"+msg[i]['total_distance']+"</td><td>"+msg[i]['luggage']+"</td><td>"+msg[i]['total_fare']+"</td><td>"+status+"</td></tr>";
                    }
                    html += "</table>";
                    $('#allRideResult').html(html);
                },
                 error: function(error)
                  {
                      alert('error');
                  }
            });
            
            });

           $('.sortUserCancelledRide').change(function(){
            // alert('hii');
            $('#userAllRide').hide();
            let selectData = $(this).val();
            // alert(selectData);
            $.ajax({
                url : 'userAjaxRequest.php',
                type : 'POST',
                data : {
                    sdata : selectData,
                    action : 'sortUserCancelledRide'
                },
                dataType : 'JSON',
                success : function(msg) 
                {
                    // alert(msg);
                    console.log(msg);
                    // alert(msg[i]['ride_date']);
                    // console.log(msg['ride_date']);
                    // console.log(msg[0]['ride_date']);
                    
                    var html = "<table class='table table-bordered ml-5 mr-5'><tr><th>Sr.No.</th><th>Ride Date</th><th>Pickup Location</th><th>Drop Location</th><th>Distance Travelled</th><th>Luggage</th><th>Total Fare</th><th>Status</th></tr>";
                    sr = 1;
                    for (var i = 0; i < msg.length; i++) {
                        if (msg[i]['status']==1) {
                            status = "Pending..";
                        } else if (msg[i]['status'] == 2) {
                            // var status = document.write("Approved");
                            status = "Approved";
                        } else {
                            // var status = document.write('Cancelled');
                            status = "Cancelled";
                        }
    
                        html += "<tr><td>"+ sr++ +"</td><td>"+msg[i]['ride_date']+"</td><td>"+msg[i]['pickup']+"</td><td>"+msg[i]['dropup']+"</td><td>"+msg[i]['total_distance']+"</td><td>"+msg[i]['luggage']+"</td><td>"+msg[i]['total_fare']+"</td><td>"+status+"</td></tr>";
                    }
                    html += "</table>";
                    $('#allRideResult').html(html);
                },
                 error: function(error)
                  {
                      alert('error');
                  }
            });
            
            });

            $('.filterUserCompletedRide').change(function(){
              $('#userAllRide').hide();
              let selectData = $(this).val();
  
              $.ajax({
                  url : 'userAjaxRequest.php',
                  type : 'POST',
                  data : {
                      sdata : selectData,
                      action : 'filterUserCompletedRide'
                  },
                  dataType : 'JSON',
                  success : function(msg) 
                  {
                      // alert(msg);
                      console.log(msg);                      
                      var html = "<table class='table table-bordered ml-5 mr-5'><tr><th>Sr.No.</th><th>Ride Date</th><th>Pickup Location</th><th>Drop Location</th><th>CabType</th><th>Total Distance</th><th>Luggage Weight</th><th>Total Fare</th><th>Status</th></tr>";
                      sr = 1;
                      for (var i = 0; i < msg.length; i++) {
                          if (msg[i]['status']==1) {
                              status = "Pending..";
                          } else if (msg[i]['status'] == 2) {
                              // var status = document.write("Approved");
                              status = "Approved";
                          } else {
                              // var status = document.write('Cancelled');
                              status = "Cancelled";
                          }
      
                          html += "<tr><td>"+ sr++ +"</td><td>"+msg[i]['ride_date']+"</td><td>"+msg[i]['pickup']+"</td><td>"+msg[i]['dropup']+"</td><td>"+msg[i]['cab']+"</td><td>"+msg[i]['total_distance']+"</td><td>"+msg[i]['luggage']+"</td><td>"+msg[i]['total_fare']+"</td><td>"+status+"</td></tr>";
                      }
                      html += "</table>";
                      $('#allRideResult').html(html);
                  }
              });
          });




     $('.filterUserCancelledRide').change(function(){
              $('#userAllRide').hide();
              let selectData = $(this).val();
  
              $.ajax({
                  url : 'userAjaxRequest.php',
                  type : 'POST',
                  data : {
                      sdata : selectData,
                      action : 'filterUserCancelledRide'
                  },
                  dataType : 'JSON',
                  success : function(msg) 
                  {
                      // alert(msg);
                      console.log(msg);                      
                      var html = "<table class='table table-bordered ml-5 mr-5'><tr><th>Sr.No.</th><th>Ride Date</th><th>Pickup Location</th><th>Drop Location</th><th>CabType</th><th>Total Distance</th><th>Luggage Weight</th><th>Total Fare</th><th>Status</th></tr>";
                      sr = 1;
                      for (var i = 0; i < msg.length; i++) {
                          if (msg[i]['status']==1) {
                              status = "Pending..";
                          } else if (msg[i]['status'] == 2) {
                              // var status = document.write("Approved");
                              status = "Approved";
                          } else {
                              // var status = document.write('Cancelled');
                              status = "Cancelled";
                          }
      
                          html += "<tr><td>"+ sr++ +"</td><td>"+msg[i]['ride_date']+"</td><td>"+msg[i]['pickup']+"</td><td>"+msg[i]['dropup']+"</td><td>"+msg[i]['cab']+"</td><td>"+msg[i]['total_distance']+"</td><td>"+msg[i]['luggage']+"</td><td>"+msg[i]['total_fare']+"</td><td>"+status+"</td></tr>";
                      }
                      html += "</table>";
                      $('#allRideResult').html(html);
                  }
              });
          });

});