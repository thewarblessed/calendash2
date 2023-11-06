$(document).ready(function () {

    $("#venueSubmit").on("click", function (e) {

        e.preventDefault();
        // $('#serviceSubmit').show()
        var data = $('#vForm')[0];
        console.log(data);
        let formData = new FormData($('#vForm')[0]);
        console.log(formData);
    
        for(var pair of formData.entries()){
            console.log(pair[0] + ',' + pair[1]);
        }
        console.log(formData)   
        $.ajax({
            type: "POST",
            url: "/api/admin/storeVenue/",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'Authorization' :'Bearer ' + sessionStorage.getItem('token'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: "json",
            success: function(data) {
                console.log(data);
               
                // var $ctable = $('#ctable').DataTable();
                // $ctable.ajax.reload();
                // $ctable.row.add(data.customer).draw(false);
                // // $etable.row.add(data.client).draw(false);
                setTimeout(function() {
                    window.location.href = '/admin/venues';
                }, 1500);
                  
                Swal.fire({
                    icon: 'success',
                    title: 'New Venue Added!',
                    showConfirmButton: false,
                    timer: 3000
                  })        
            },
            error: function(error) {
                console.log('error');
            }
        });
        //Swal.fire('SweetAlert2 is working!')
    });//end create

    $("#venueTable tbody").on("click",'a.editBtn ',function (e) {
        // alert('dshagd')
        var id = $(this).data("id");
        // alert(id);
        e.preventDefault();
        
        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/admin/venue/" + id + "/edit",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $('#createVenueModal').modal('show');
                $('#venueEditId').val(data.Venues.id);
                $('#venueEditName').val(data.Venues.name);
                $('#venueEditDesc').val(data.Venues.description);
                $('#venueEditCapacity').val(data.Venues.capacity);
                $("#venueEditImage").html(
                `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);
            },
            error: function (error) {
                console.log("error");
            },
        });
    });//end venue table

    $("#venueUpdate").on("click", function (e) {
        e.preventDefault();
        var id = $("#venueEditId").val();
        let editformData = new FormData($("#venueUpdateForm")[0]);
        for(var pair of editformData.entries()){
            console.log(pair[0] + ',' + pair[1]);
        }
        $.ajax({
            type: "POST",
            url: "/api/admin/venue/" + id,
            data: editformData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                setTimeout(function() {
                    window.location.href = '/admin/venues';
                }, 1500);
                  
                Swal.fire({
                    icon: 'success',
                    title: 'Venue Updated!',
                    showConfirmButton: false,
                    timer: 3000
                  })   
                
            },
            error: function (error) {
                console.log("error");
            },
        });
    });//end update venue

    $("#venueTable tbody").on("click", 'a.deleteBtn', function (e) {
        e.preventDefault();

        var id = $(this).data("id");

        console.log(id);
        Swal.fire({
            title: 'Are you sure you want to delete this venue?',
            text: "You won't be able to undo this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "DELETE",
                    url: "/api/admin/venue/" + id,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    dataType: "json",
                    success: function (data) {
                        setTimeout(function() {
                            window.location.href = '/admin/venues';
                        }, 1500);
                        console.log(data);
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                          )
                    },
                    error: function (error) {
                        console.log("error");
                    },
                });
              
            }
          })
       
    });//end delete venue

    $("#filterCapacity").on("input", function() {
        var filterValue = parseInt($(this).val());
        // (!isNaN(venueCapacity) && venueCapacity <= filterValue)
        if (!isNaN(filterValue)) {
            // Hide all venues
            $("div.card_capacity").hide();
            
            // Show venues that match the filter capacity
            $("div.card_capacity").each(function() {
                var venueCapacity = parseInt($(this).data("capacity")); // Get the venue's capacity from the data attribute
                if (filterValue === venueCapacity || filterValue < venueCapacity) {
                    $(this).show();
                }
            });
        } else {
            // Show all venues if the filter input is not a valid number
            $("div.card_capacity").show();
        }
    });//end filter venue
    

})