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

    // DATATABLE CHECK MORE DETAILS REQUEST
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


                var statusElement = $('#eventStatusText');
                // console.log(statusElement)
                // Get the value from the element's text content
                var statusValue = $('#eventStatusText').text();

                statusElement.removeClass();
                // Apply styling based on the value
                if (statusValue === 'APPROVED') {
                    statusElement.addClass('badge badge-sm border border-success text-success');
                } else {
                    statusElement.addClass('badge badge-sm border border-warning text-warning');
                }
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

    $("#eventStatus tbody").on("click", 'button.checkStatus ', function (e) {
        var id = $(this).data("id");
        // e.preventDefault();

        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/myEventStatus/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $('#statusList').empty();
                $('#checkStatusModal').modal('show');
                $('#eventStatusText').text(data.pendingMsg);

                var statusElement = $('#eventStatusText');
                // console.log(statusElement)
                // Get the value from the element's text content
                var statusValue = $('#eventStatusText').text();

                statusElement.removeClass();
                // Apply styling based on the value
                if (statusValue === 'APPROVED') {
                    statusElement.addClass('badge badge-sm border border-success text-success');
                } else {
                    statusElement.addClass('badge badge-sm border border-warning text-warning');
                }
                // $("#venueEditImage").html(
                // `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);

                // var status = 1;
                // $.each(data, function(index, item) {

                // });

                $.each(data.dates, function (index, item) {
                    // console.log(item);
                    console.log(index);
                    console.log(data.msg);
                    var formattedDate = moment(item, 'YYYY-MM-DD HH:mm:ss').format('MMMM D, YYYY');
                    var formattedTime = moment(item, 'YYYY-MM-DD HH:mm:ss').format('h:mm A');
                    console.log(formattedTime);

                    // Now, formattedDate contains the formatted date
                    
                    // var date = data.dates;
                    // console.log(date);

                    // $.each(date, function (index, item) {
                    //     // Assuming item is a date string, modify the format as needed
                    //     var formattedDate = moment(item, 'YYYY-MM-DD HH:mm:ss').format('MMMM D, YYYY h:mm A');

                    //     // Now, formattedDate contains the formatted date
                    //     console.log(formattedDate);
                    // });

                    // Use formattedDate as needed in your application
                    // var approvedDate = new Date(date);
                    // var formattedDate = approvedDate.toLocaleDateString('en-US', {
                    //     year: 'numeric',
                    //     month: 'long',
                    //     day: 'numeric'
                    // });
                    // console.log(formattedDate);
                    // var formattedTime = approvedDate.toLocaleTimeString('en-US', {
                    //     hour: 'numeric',
                    //     minute: 'numeric'
                    // });

                    // $.each(data.msg, function(msgIndex, msgItem) {
                    //     console.log(msg)
                    //     var listItem = `
                    //         <li class="rb-item">
                    //             <div class="timestamp">
                    //                 ${formattedDate}<br> <span>${formattedTime}</span>
                    //             </div>
                    //             <div class="item-title">${msgItem}</div>
                    //         </li>
                    //     `;
                    //     $('#statusList').prepend(listItem);
                    // });
                    if (data.msg && data.msg[index]) {
                        var msgItem = data.msg[index];
                
                        // Create a list item for each date and message
                        var listItem = `
                            <li class="rb-item">
                                <div class="timestamp">
                                    ${formattedDate}<br> <span>${formattedTime}</span>
                                </div>
                                <div class="item-title">${msgItem}</div>
                            </li>
                        `;
                
                        $('#statusList').prepend(listItem);
                    }

                    // console.log(msgItem);
                    // var listItem = `
                    //     <li class="rb-item">
                    //         <div class="timestamp">
                    //             ${formattedDate}<br> <span>${formattedTime}</span>
                    //         </div>
                    //         <div class="item-title">${msgItem}</div>
                    //     </li>
                    // `;
                    // $('#statusList').prepend(listItem);
                });


                //     var listItem = `
                //         <li class="rb-item">
                //             <div class="timestamp">
                //                 ${formattedDate}<br> <span>${formattedTime}</span>
                //             </div>
                //             <div class="item-title">${data.approvedSecHeadMsg}</div>
                //         </li>
                //     `;
                //     $('#statusList').prepend(listItem);

            },
            error: function (error) {
                console.log("error");
            },
        });
    });



    $('#radioForm input').change(function () {
        // alert($('input[name=btnradiotable]:checked', '#radioForm').val());

        // var value = $('input[name=btnradiotable]:checked', '#radioForm').val()
        // console.log(value);

        var filterValue = $(this).val();
        console.log(filterValue);

        $('#eventBody tr').show();

        if (filterValue !== 'all') {
            $('#eventBody tr').each(function () {
                var rowStatus = $(this).find('td:eq(5)').text().trim(); // Trim whitespace // td:eq(3) yung column!
                console.log(rowStatus);
                // Check if the row status matches the selected filter
                if (rowStatus !== filterValue.trim()) {
                    $(this).hide();
                }
            });
        }

        // Show or hide the "No Data" message based on the search results
        if ($('#eventBody tr:visible').length > 0) {
            $('#noDataMessage').hide();
        } else {
            $('#noDataMessage').show();
        }
    });

    // if (filterValue === 'PENDING') {
    //     $('#eventBody tr').each(function () {
    //         var rowStatus = $(this).find('td:eq(4)').text(); // Assuming status is in the 5th column
    //         // Check if the row status matches the selected filter
    //         if (rowStatus !== filterValue) {
    //             $(this).show();
    //         }
    //     });
    // }


    // $('#eventBody tr').each(function () {
    //     var rowText = $(this).text().toLowerCase();
    //     console.log(rowText);
    //     // If the row contains the search term and matches the selected course, show the row; otherwise, hide it
    //     if (rowText.includes(searchTerm) && (selectedCourse === 'all' || rowText.includes(selectedCourse))) {
    //         $(this).show();
    //     } else {
    //         $(this).hide();
    //     }
    // });

    // $("#searchEvent").on("keyup", function () {
    //     console.log('test')
    // });

    // if (filterValue === 'pending') {

    //     // alert('pending');
    // }
    // else if (filterValue === 'appByMe')
    // {
    //     // alert('appByMe');
    // }
    // else if (filterValue === 'appEvents')
    // {
    //     // alert('appEvents');
    // }
    // else
    // {
    //     // alert('all');
    // }






    // Handle the filter based on the selected radio button
    // if (filterValue === '1') {
    //     // Handle Pending filter
    // } else if (filterValue === '2') {
    //     // Handle Approved by Me filter
    // } else if (filterValue === '3') {
    //     // Handle Approved Events filter
    // } else if (filterValue === '4') {
    //     // Handle All filter
    // }


    // $('#btnradiotable1').on("click", function (e) {
    //     alert('dsasda');
    // })

    $('#eventApprovalForm input').change(function () {

        alert($('input[name=btnradiotable]:checked', '#eventApprovalForm').val());
        // alert('dshagd')
        var filterValue = $(this).attr('id').substring(14); // Extract the filter value from the radio button id

        // Handle the filter based on the selected radio button
        if (filterValue === '1') {
            alert(1);
            // Handle Pending filter
            // Perform actions, update UI, or make AJAX request as needed
        } else if (filterValue === '2') {
            alert(1);
            // Handle Approved by Me filter
            // Perform actions, update UI, or make AJAX request as needed
        } else if (filterValue === '3') {
            alert(1);
            // Handle Approved Events filter
            // Perform actions, update UI, or make AJAX request as needed
        } else if (filterValue === '4') {
            alert(1);
            // Handle All filter
            // Perform actions, update UI, or make AJAX request as needed
        }
        // e.preventDefault();

        // $.ajax({
        //     type: "GET",
        //     enctype: 'multipart/form-data',
        //     processData: false, // Important!
        //     contentType: false,
        //     cache: false,
        //     url: "/api/show/event/" + id,
        //     headers: {
        //         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
        //             "content"
        //         ),
        //     },
        //     dataType: "json",
        //     success: function (data) {
        //         var originalDate = new Date(data.events.event_date);
        //         var origStime = moment(data.events.start_time, "HH:mm:ss")
        //         var origEtime = moment(data.events.end_time, "HH:mm:ss")

        //         var formattedSTime = origStime.format("h:mm A");
        //         var formattedETime = origEtime.format("h:mm A");

        //         // Format the date using moment.js
        //         var formattedDate = moment(originalDate).format("MMMM D, YYYY");
        //         console.log(data);
        //         $('#checkMoreModal').modal('show');
        //         $('#eventStatusText').text(data.msg);
        //         $('#eventStatusName').val(data.events.event_name);
        //         $('#eventStatusDesc').val(data.events.description);
        //         $('#eventStatusParticipants').val(data.events.participants);
        //         $('#eventStatusVenue').val(data.venues.name);
        //         $('#eventStatusDate').val(formattedDate);
        //         $('#eventStatusSTime').val(formattedSTime);
        //         $('#eventStatusETime').val(formattedETime);
        //         // $("#venueEditImage").html(
        //         // `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);
        //     },
        //     error: function (error) {
        //         console.log("error");
        //     },
        // });
    });//end event status table






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