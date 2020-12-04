$(document).ready(function(){
    $('.approve').click(function(){
      var id = $(this).data('id');
      $.ajax({
        url : 'ajaxRequest.php',
        type : 'POST',
        data : {
          id : id,
          action : 'approveRide'
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

    $('.cancel').click(function(){
          var id = $(this).data('id');  
          $.ajax({
            url : 'ajaxRequest.php',
            type : 'POST',
            data : {
              id : id,
              action : 'cancelRide'
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
    
        $('.delete').click(function(){         
              var id = $(this).data('id');
              $.ajax({
                url : 'ajaxRequest.php',
                type : 'POST',
                data : {
                  id : id,
                  action : 'deleteRide'
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
        
        $('.unblock').click(function(){
                var id = $(this).data('id');           
                $.ajax({
                url : 'ajaxRequest.php',
                type : 'POST',
                data : {
                    id : id,
                    action : 'unblock'
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

           
            $('.editloc').click(function(){             
                    var id = $(this).data('id');             
                    $.ajax({
                    url : 'ajaxRequest.php',
                    type : 'POST',
                    data : {
                        id : id,
                        action : 'editlocation'
                    },
                    dataType: 'JSON',
                    success : function(msg)
                    {
                        console.log(msg[0]['name']);
                        $('#loc-name').val(msg[0]['name']);
                        $('#loc-dist').val(msg[0]['distance']);
                        $('#locid').val(msg[0]['id']);
                        
                        // window.location.reload();
                    // $('#result').html(msg);
                    },
                    error: function(error)
                    {
                        alert('error');
                    }
            
                    });
                });

               $('#updateloc').click(function(){
                    //   alert('hi');
                        var locName = $('#loc-name').val();
                        var dist = $('#loc-dist').val();
                        var locid = $('#locid').val();
                        // alert(id);
                    // console.log(locName, dist, locid);
                        $.ajax({
                        url : 'ajaxRequest.php',
                        type : 'POST',
                        data : {
                            id : locid,
                            dist : dist,
                            locname : locName,
                            action : 'updatelocation'
                        },
                        success : function(msg)
                        {
                            window.location.reload();
                        },
                        error: function(error)
                        {
                            alert('error');
                        }
                
                        });
                    });

                    $('#changepass').click(function(e){
                        //   alert('hi');
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
                            url : 'ajaxRequest.php',
                            type : 'POST',
                            data : {
                                oldpass : oldpass,
                                newpass : newpass,
                                action : 'changepass'
                            },
                            success : function(msg)
                            {   
                                 if (msg == true) {
                                     alert("Successfully Change your password");
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

                   
        $('.sortAllRide').change(function(){
            // alert('hii');
            $('#allRide').hide();
            let selectData = $(this).val();
            // alert($selectData);

            $.ajax({
                url : 'ajaxRequest.php',
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
                    
                    var html = "<table class='table table-bordered ml-5 mr-5'><tr><th>Sr.No.</th><th>Ride Date</th><th>Pickup Location</th><th>Drop Location</th><th>Cab Type</th><th>Total Distance</th><th>Luggage Weight</th><th>Total Fare</th><th>Status</th><th>Invoice</th></tr>";
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


        $('.filterAllRide').change(function(){
            // alert('hii');
            $('#allRide').hide();
            let selectData = $(this).val();
            // alert($selectData);

            $.ajax({
                url : 'ajaxRequest.php',
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
                    
                    var html = "<table class='table table-bordered ml-5 mr-5'><tr><th>Sr.No.</th><th>Ride Date</th><th>Pickup Location</th><th>Drop Location</th><th>Cab Type</th><th>Total Distance</th><th>Luggage Weight</th><th>Total Fare</th><th>Status</th><th>Invoice</th></tr>";
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
    
                        html += "<tr><td>"+ sr++ +"</td><td>"+msg[i]['ride_date']+"</td><td>"+msg[i]['pickup']+"</td><td>"+msg[i]['dropup']+"</td><td>"+msg[i]['cab']+"</td><td>"+msg[i]['total_distance']+"</td><td>"+msg[i]['luggage']+"</td><td>"+msg[i]['total_fare']+"</td><td>"+status+"</td><td><a href ='adminfunc.php?invoiceid= "+msg[i]['ride_id']+ " & invoice=invoice>Check Invoice</a>'</td></tr>";
                    }
                    html += "</table>";
                    $('#allRideResult').html(html);
                }
            });
        });

         $('.sortPendingRide').change(function(){
            // alert('hii');
            $('#allRide').hide();
            let selectData = $(this).val();
            // alert($selectData);

            $.ajax({
                url : 'ajaxRequest.php',
                type : 'POST',
                data : {
                    sdata : selectData,
                    action : 'sortPendingRide'
                },
                dataType : 'JSON',
                success : function(msg) 
                {
                    // alert(msg);
                    console.log(msg);
                    
                    var html = "<table class='table table-bordered ml-5 mr-5'><tr><th>Sr.No.</th><th>Ride Date</th><th>Pickup Location</th><th>Drop Location</th><th>Cab Type</th><th>Total Distance</th><th>Luggage Weight</th><th>Total Fare</th><th>Status</th><th>Action</th></tr>";
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
    
                        html += "<tr><td>"+ sr++ +"</td><td>"+msg[i]['ride_date']+"</td><td>"+msg[i]['pickup']+"</td><td>"+msg[i]['dropup']+"</td><td>"+msg[i]['cab']+"</td><td>"+msg[i]['total_distance']+"</td><td>"+msg[i]['luggage']+"</td><td>"+msg[i]['total_fare']+"</td><td>"+status+"</td><td><button class='approve' data-id='"+msg[i]['ride_id']+"' type='button'>Approve</button><button class ='cancel' data-id='"+ msg[i]['ride_id']+"' type='button' >Cancel</button><button class='delete' type='button' data-id='"+msg[i]['ride_id']+"'>Delete</button></td></tr>";
                    }
                    html += "</table>";
                    $('#allRideResult').html(html);
                }
            });
        });
        
         $('.sortCompletedRide').change(function(){
            // alert('hii');
            $('#allRide').hide();
            let selectData = $(this).val();
            // alert($selectData);

            $.ajax({
                url : 'ajaxRequest.php',
                type : 'POST',
                data : {
                    sdata : selectData,
                    action : 'sortCompletedRide'
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

            $('.sortCancelledRide').change(function(){
            // alert('hii');
            $('#allRide').hide();
            let selectData = $(this).val();
            // alert($selectData);

            $.ajax({
                url : 'ajaxRequest.php',
                type : 'POST',
                data : {
                    sdata : selectData,
                    action : 'sortCancelledRide'
                },
                dataType : 'JSON',
                success : function(msg) 
                {
                    // alert(msg);
                    console.log(msg);
                    // alert(msg[i]['ride_date']);
                    // console.log(msg['ride_date']);
                    // console.log(msg[0]['ride_date']);
                    
                    var html = "<table class='table table-bordered ml-5 mr-5'><tr><th>Sr.No.</th><th>Ride Date</th><th>Pickup Location</th><th>Drop Location</th><th>Cab Type</th><th>Total Distance</th><th>Luggage Weight</th><th>Total Fare</th><th>Status</th></tr>";
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

         $('.filterPendingRide').change(function(){
            // alert('hii');
            $('#allRide').hide();
            let selectData = $(this).val();
            // alert($selectData);

            $.ajax({
                url : 'ajaxRequest.php',
                type : 'POST',
                data : {
                    sdata : selectData,
                    action : 'filterPendingRide'
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

          $('.sortPendingUsersName').change(function(){
            // alert('hii');
            $('#allRide').hide();
            let selectData = $(this).val();
            // alert(selectData);

            $.ajax({
                url : 'ajaxRequest.php',
                type : 'POST',
                data : {
                    sdata : selectData,
                    action : 'sortPendingUsersName'
                },
                dataType : 'JSON',
                success : function(msg) 
                {
                    // alert(msg);
                    
                    var html = "<table class='table table-bordered ml-5 mr-5'><tr><th>Sr.No.</th><th>Username</th><th>Date</th><th>Action</th></tr>";
                    sr = 1;
                    for (var i = 0; i < msg.length; i++) {
                        html += "<tr><td>"+ sr++ +"</td><td>"+msg[i]['user_name']+"</td><td>"+msg[i]['dateofsignup']+"</td><td><button class = 'unblock' data-id='"+msg[i]['user_id']+"' type='button'>Unblock</button></td></tr>";
                    }
                    html += "</table>";
                    $('#allRideResult').html(html);
                }
            });
        });

        $('.sortApprovedUsersName').change(function(){
            // alert('hii');
            $('#allRide').hide();
            let selectData = $(this).val();
            // alert(selectData);

            $.ajax({
                url : 'ajaxRequest.php',
                type : 'POST',
                data : {
                    sdata : selectData,
                    action : 'sortApprovedUsersName'
                },
                dataType : 'JSON',
                success : function(msg) 
                {
                    // alert(msg);
                    
                    var html = "<table class='table table-bordered ml-5 mr-5'><tr><th>Sr.No.</th><th>Username</th><th>Date</th><th>Action</th></tr>";
                    sr = 1;
                    for (var i = 0; i < msg.length; i++) {
                        html += "<tr><td>"+ sr++ +"</td><td>"+msg[i]['user_name']+"</td><td>"+msg[i]['dateofsignup']+"</td><td><button class = 'unblock' data-id='"+msg[i]['user_id']+"' type='button'>Unblock</button></td></tr>";
                    }
                    html += "</table>";
                    $('#allRideResult').html(html);
                }
            });
        });

         $('.sortAllUsersName').change(function(){
            // alert('hii');
            $('#allRide').hide();
            let selectData = $(this).val();
            // alert(selectData);

            $.ajax({
                url : 'ajaxRequest.php',
                type : 'POST',
                data : {
                    sdata : selectData,
                    action : 'sortAllUsersName'
                },
                dataType : 'JSON',
                success : function(msg) 
                {
                    // alert(msg);
                    
                    var html = "<table class='table table-bordered ml-5 mr-5'><tr><th>Sr.No.</th><th>Username</th><th>Date of Signup</th><th>Mobile</th><th>Is Block</th><th>Is Admin</th></tr>";
                    sr = 1;
                    for (var i = 0; i < msg.length; i++) {
                        html += "<tr><td>"+ sr++ +"</td><td>"+msg[i]['user_name']+"</td><td>"+msg[i]['dateofsignup']+"</td><td>"+msg[i]['mobile']+"</td><td>"+msg[i]['isblock']+"</td><td>"+msg[i]['isadmin']+"</td></tr>";
                    }
                    html += "</table>";
                    $('#allRideResult').html(html);
                }
            });
        });

         $('.filterCancelledRide').change(function(){
            // alert('hii');
            $('#allRide').hide();
            let selectData = $(this).val();
            // alert($selectData);

            $.ajax({
                url : 'ajaxRequest.php',
                type : 'POST',
                data : {
                    sdata : selectData,
                    action : 'filterCancelledRide'
                },
                dataType : 'JSON',
                success : function(msg) 
                {
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