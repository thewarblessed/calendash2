$(document).ready(function () {
    // $("#viewAnotherTab").hide();

    $("#venueSubmit").on("click", function (e) {

        e.preventDefault();
        // $('#serviceSubmit').show()
        var data = $('#vForm')[0];
        console.log(data);
        let formData = new FormData($('#vForm')[0]);
        console.log(formData);

        for (var pair of formData.entries()) {
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
                'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (data) {
                console.log(data);

                // var $ctable = $('#ctable').DataTable();
                // $ctable.ajax.reload();
                // $ctable.row.add(data.customer).draw(false);
                // // $etable.row.add(data.client).draw(false);
                setTimeout(function () {
                    window.location.href = '/admin/venues';
                }, 1500);

                Swal.fire({
                    icon: 'success',
                    title: 'New Venue Added!',
                    showConfirmButton: false,
                    timer: 3000
                })
            },
            error: function (error) {
                console.log('error');
            }
        });
        //Swal.fire('SweetAlert2 is working!')
    });//end create

    $("#venueTable tbody").on("click", 'a.editBtn ', function (e) {
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
        for (var pair of editformData.entries()) {
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
                setTimeout(function () {
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
                        setTimeout(function () {
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

    $("#filterCapacity").on("input", function () {
        // let elements = document.querySelectorAll(".card-title");
        // let cards = document.querySelectorAll(".card_capacity");
        var filterValue = parseInt($(this).val());
        // let searchInput = parseInt($(this).val());
        // console.log(searchInput)
        // (!isNaN(venueCapacity) && venueCapacity <= filterValue)

        if (!isNaN(filterValue)) {
            // Hide all venues
            $("div.card_capacity").hide();

            // Show venues that match the filter capacity
            $("div.card_capacity").each(function () {
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

    $("#createEvent_submit").on("click", function (e) {
        console.log(data);
        e.preventDefault();
        // $('#serviceSubmit').show()
        var data = $('#createEventForm')[0];
        console.log(data);
        let formData = new FormData($('#createEventForm')[0]);
        console.log(formData);

        for (var pair of formData.entries()) {
            console.log(pair[0] + ',' + pair[1]);
        }
        console.log(formData)
        $.ajax({
            type: "POST",
            url: "/api/create/newEvent",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (data) {
                console.log(data);

                // var $ctable = $('#ctable').DataTable();
                // $ctable.ajax.reload();
                // $ctable.row.add(data.customer).draw(false);
                // // $etable.row.add(data.client).draw(false);
                setTimeout(function () {
                    window.location.href = '/myEvents';
                }, 1500);

                Swal.fire({
                    icon: 'success',
                    title: 'Event has been Requested!',
                    showConfirmButton: false,
                    timer: 3000
                })
            },
            error: function (error) {
                console.log('error');
            }
        });
        //Swal.fire('SweetAlert2 is working!')
    });//end create event

    //REQUEST APPROVAL TABLE
    $("#eventTable tbody").on("click", 'button.approveBtn ', function (e) {
        $('#eventReject').hide();
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
            url: "/api/show/event/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $('#createVenueModal').modal('show');
                $('#eventApproveId').val(data.events.id);
                $('#eventApproveName').val(data.events.event_name);
                $('#eventApproveDesc').val(data.events.description);
                $('#eventApproveParticipants').val(data.events.participants);
                $('#eventApproveVenue').val(data.venues.name);
                // $("#venueEditImage").html(
                // `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);
            },
            error: function (error) {
                console.log("error");
            },
        });

        console.log(id)
        //PDF
        $.ajax({
            type: "GET",
            url: "/api/show/letter/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                var pdfLink = $('<a>', {
                    href: "/storage/" + data,
                    text: "Click here to view Request Letter",
                    target: "_blank",
                });
                // console.log(href)
                $("#viewAnotherTab").empty().append(pdfLink);
            },
            error: function (error) {
                console.log(error);
            },
        });


        //EVENT APPROVE BUTTON
        $("#eventApprove").on("click", async function (e) {
            e.preventDefault();

            // console.log($('#eventAuthId').val())
            var user_id = $('#eventAuthId').val()
            // var eventAppId = $('#eventApproveId').val()
            // console.log(eventAppId);
            // console.log(user_id);
            // console.log($('#eventApproveVenue').val())
            // alert('dshadahs')
            $("#approveRequestModal").modal('hide');
            const { value: password } = await Swal.fire({
                title: "Enter your passcode to confirm approval",
                input: "password",
                inputLabel: "Passcode",
                inputPlaceholder: "Enter your passcode",
                inputAttributes: {
                maxlength: "10",
                autocapitalize: "off",
                autocorrect: "off"
                }
            });

            if (password) {   
                console.log(password)
                const dataToSend = {
                    key1: password,
                    key2: user_id
                };
                console.log(dataToSend);
                $.ajax({
                    type: "POST",
                    url: "/api/request/approve/" + id,
                    data: dataToSend,
                    headers: {
                        'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        console.log(data);
                        Swal.fire({
                            icon: "success",
                            title: "Request has been approved",
                            showConfirmButton: false,
                            timer: 1500
                          });

                    },
                    error: function (error) {
                        console.log('error');
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                            footer: '<a href="#">Why do I have this issue?</a>'
                          });
                        
                    }
                });

                // Swal.fire(`Entered password: ${password}`);
            }
        });


        
    });//end event table

    

     //CREATE OFFICIALS
     $("#officialSubmit").on("click", function (e) {

        e.preventDefault();
        // $('#serviceSubmit').show()
        var data = $('#officialForm')[0];
        console.log(data);
        let formData = new FormData($('#officialForm')[0]);
        console.log(formData);

        for (var pair of formData.entries()) {
            console.log(pair[0] + ',' + pair[1]);
        }
        console.log(formData)
        $.ajax({
            type: "POST",
            url: "/api/admin/storeOfficial/",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (data) {
                console.log(data);

                // var $ctable = $('#ctable').DataTable();
                // $ctable.ajax.reload();
                // $ctable.row.add(data.customer).draw(false);
                // // $etable.row.add(data.client).draw(false);
                setTimeout(function () {
                    window.location.href = '/admin/officials';
                }, 1500);

                Swal.fire({
                    icon: 'success',
                    title: 'New Official Added!',
                    showConfirmButton: false,
                    timer: 3000
                })
            },
            error: function (error) {
                console.log('error');
            }
        });
        //Swal.fire('SweetAlert2 is working!')
    });//end create official

    // CHECK MORE DATATABLE STATUS REQUEST
    $("#eventStatus tbody").on("click", 'button.checkMore ', function (e) {
        // alert('dshagd')
        var id = $(this).data("id");
        // e.preventDefault();

        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/show/event/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                var originalDate = new Date(data.events.event_date);
                var origStime = moment(data.events.start_time, "HH:mm:ss")
                var origEtime = moment(data.events.end_time, "HH:mm:ss")

                var formattedSTime = origStime.format("h:mm A");
                var formattedETime = origEtime.format("h:mm A");
                
                // Format the date using moment.js
                var formattedDate = moment(originalDate).format("MMMM D, YYYY");
                console.log(data);
                $('#checkMoreModal').modal('show');
                $('#eventStatusText').text(data.msg);
                $('#eventStatusName').val(data.events.event_name);
                $('#eventStatusDesc').val(data.events.description);
                $('#eventStatusParticipants').val(data.events.participants);
                $('#eventStatusVenue').val(data.venues.name);
                $('#eventStatusDate').val(formattedDate);
                $('#eventStatusSTime').val(formattedSTime);
                $('#eventStatusETime').val(formattedETime);
                // $("#venueEditImage").html(
                // `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);
            },
            error: function (error) {
                console.log("error");
            },
        });

        // console.log(id)
        // $.ajax({
        //     type: "GET",
        //     url: "/api/show/letter/" + id,
        //     headers: {
        //         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        //     },
        //     dataType: "json",
        //     success: function (data) {
        //         console.log(data);
        //         var pdfLink = $('<a>', {
        //             href: "/storage/" + data,
        //             text: "Click here to view Request Letter",
        //             target: "_blank",
        //         });
        //         // console.log(href)
        //         $("#viewAnotherTab").empty().append(pdfLink);
        //     },
        //     error: function (error) {
        //         console.log(error);
        //     },
        // });
    });//end event status table

    // $("#eventStatus tbody").on("click", 'button.checkMore ', function (e) {
        
    // });


    // Approve Request
    
    

    // document.getElementById("search").addEventListener("click", () => {
    //     //initializations
    //     let searchInput = document.getElementById("search-input").value;
    //     let elements = document.querySelectorAll(".product-name");
    //     let cards = document.querySelectorAll(".card");
    //     //loop through all elements
    //     elements.forEach((element, index) => {
    //       //check if text includes the search value
    //       if (element.innerText.includes(searchInput.toUpperCase())) {
    //         //display matching card
    //         cards[index].classList.remove("hide");
    //       } else {
    //         //hide others
    //         cards[index].classList.add("hide");
    //       }
    //     });
    //   });


})