$(document).ready(function () {
    // $("#withinTheDayDiv").hide();
    // $("#wholeDayDiv").hide();
    // $("#wholeWeekDiv").hide();

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

    //SETTING DATE FOR USER
    $('.radiobuttonsuser input[type="radio"]').change(function () {

        const withinDayDiv = document.getElementById('withinTheDayDivUser');
        const wholeDayDiv = document.getElementById('wholeDayDivUser');
        const wholeWeekDiv = document.getElementById('wholeWeekDivUser');
        const dateRangeDiv = document.getElementById('dateRangeDivUser');

        const eventDate = document.getElementById('event_date_withinDayUser');
        const startTimeWithinDay = document.getElementById('start_time_withinDayUser');
        const endTimeWithinDay = document.getElementById('end_time_withinDayUser');
        const WholeDay = document.getElementById('event_date_wholeDayUser');
        const WholeWeek = document.getElementById('event_date_wholeWeekUser');
        const dateRange = document.getElementById('date_range_User')

        if ($(this).is(':checked')) {

            if ($(this).val() === 'withinDay') {
                // console.log('labasDate');
                // $("#withinTheDayDiv").show();
                // $("#wholeDayDiv").hide();
                // $("#wholeWeekDiv").hide();

                dateRange.removeAttribute('required');
                WholeDay.removeAttribute('required');
                WholeWeek.removeAttribute('required');

                eventDate.value = "";
                startTimeWithinDay.value = "";
                endTimeWithinDay.value = "";

                withinDayDiv.style.display = 'block';
                wholeDayDiv.style.display = 'none';
                wholeWeekDiv.style.display = 'none';
                dateRangeDiv.style.display = 'none';

                startTimeWithinDay.setAttribute('required', true);
                endTimeWithinDay.setAttribute('required', true);
                eventDate.setAttribute('required', true);




            }
            else if ($(this).val() === 'wholeDay') {
                // console.log('wholeDayLangTalaga');
                startTimeWithinDay.removeAttribute('required');
                endTimeWithinDay.removeAttribute('required');
                eventDate.removeAttribute('required');
                dateRange.removeAttribute('required');
                WholeWeek.removeAttribute('required');

                WholeDay.value = "";

                wholeWeekDiv.style.display = 'none';
                withinDayDiv.style.display = 'none';
                wholeDayDiv.style.display = 'block';
                dateRangeDiv.style.display = 'none';

                WholeDay.setAttribute('required', true);
            }
            else if ($(this).val() === 'wholeWeek') {
                // console.log('wholeWeekNa')
                startTimeWithinDay.removeAttribute('required');
                endTimeWithinDay.removeAttribute('required');
                eventDate.removeAttribute('required');
                dateRange.removeAttribute('required');
                WholeDay.removeAttribute('required');

                WholeWeek.value = "";

                wholeWeekDiv.style.display = 'block';
                withinDayDiv.style.display = 'none';
                wholeDayDiv.style.display = 'none';
                dateRangeDiv.style.display = 'none';

                WholeWeek.setAttribute('required', true);
            }
            else {
                startTimeWithinDay.removeAttribute('required');
                endTimeWithinDay.removeAttribute('required');
                eventDate.removeAttribute('required');
                WholeWeek.removeAttribute('required');
                WholeDay.removeAttribute('required');

                dateRange.value = "";

                wholeWeekDiv.style.display = 'none';
                withinDayDiv.style.display = 'none';
                wholeDayDiv.style.display = 'none';
                dateRangeDiv.style.display = 'block';

                dateRange.setAttribute('required', true);
            }
            // console.log('Selected value:', $(this).val());
        }

    });

    //TRAPPING OF VENUES BASED ON THE INPUTED NUMBER OF PARTICIPANTS;
    $('#numParticipants').change(function () {
        const numParticipants = parseInt($(this).val());
        console.log(numParticipants);
        $('.card_capacity').each(function () {
            const capacity = parseInt($(this).data('capacity'));
            if (numParticipants <= capacity) {
                $(this).parent().show(); // Show the whole venue card
            } else {
                $(this).parent().hide(); // Hide the whole venue card
            }
        });
    });

    $("#createEvent_submit").on("click", function (e) {
        // alert('default')
        $('#spinner').addClass('spinner-border spinner-border-sm');
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
                $('#spinner').removeClass('spinner-border spinner-border-sm');
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
                $('#spinner').removeClass('spinner-border spinner-border-sm');
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!"
                });
            }
        });
        //Swal.fire('SweetAlert2 is working!')
    });//end create event

    //REQUEST APPROVAL TABLE
    $("#eventTable tbody").on("click", 'button.approveBtn ', function (e) {
        // alert('dshagd')
        var id = $(this).data("id");
        // alert(id);
        console.log(id);
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
                // console.log(data.venues);
                if (data.venues !== null) {
                    $('#createVenueModal').modal('show');
                    $('#eventApproveId').val(data.events.id);
                    $('#eventApproveName').val(data.events.event_name);
                    $('#eventApproveDesc').val(data.events.description);
                    $('#eventApproveParticipants').val(data.events.participants);
                    $('#eventApproveVenue').val(data.venues.name);
                }
                else {
                    $('#createVenueModal').modal('show');
                    $('#eventApproveId').val(data.events.id);
                    $('#eventApproveName').val(data.events.event_name);
                    $('#eventApproveDesc').val(data.events.description);
                    $('#eventApproveParticipants').val(data.events.participants);
                    $('#eventApproveVenue').val(data.rooms.name);
                }

                // $("#venueEditImage").html(
                // `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);
            },
            error: function (error) {
                console.log("error");
            },
        });

        // console.log(id)
        // //PDF
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


        // //EVENT APPROVE BUTTON
        $("#eventApprove").on("click", async function (e) {
            e.preventDefault();

            // console.log($('#eventAuthId').val())
            var user_id = $('#eventAuthId').val()
            // var eventAppId = $('#eventApproveId').val()
            // console.log(eventAppId);
            console.log(user_id);
            // console.log($('#eventApproveVenue').val())
            // alert('dshadahs')
            $("#approveRequestModal").modal('hide');
            const { value: password } = await Swal.fire({
                title: "Enter your passcode to confirm approval",
                input: "password",
                inputLabel: "Passcode",
                inputPlaceholder: "Enter your passcode",
                inputAttributes: {
                    maxlength: "256",
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

                        setTimeout(function () {
                            window.location.href = '/request';
                        }, 1500);

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

    // REQUEST REJECT TABLE
    $("#eventTable tbody").on("click", 'button.rejectBtn', function (e) {


        // alert('dshagd')
        var id = $(this).data("id");
        console.log(id);

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
                $('#rejectRequestModal').modal('show');
                $('#eventRejectId').val(data.events.id);
                $('#eventRejectName').val(data.events.event_name);
                $('#eventRejectDesc').val(data.events.description);
                $('#eventRejectParticipants').val(data.events.participants);
                $('#eventRejectVenue').val(data.venues.name);
                // $('#eventApprove').hide();
                // $('#eventReject').show();
                // $("#venueEditImage").html(
                // `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);
            },
            error: function (error) {
                console.log("error");
            },
        });

        // console.log(id)
        // //PDF
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
                $("#viewRejectAnotherTab").empty().append(pdfLink);
            },
            error: function (error) {
                console.log(error);
            },
        });

        // //EVENT APPROVE BUTTON
        $("#eventReject").on("click", async function (e) {
            e.preventDefault();

            // console.log($('#eventAuthId').val())
            var user_id = $('#eventAuthRejectId').val()
            // var eventAppId = $('#eventApproveId').val()
            // console.log(eventAppId);
            // console.log(user_id + 'hi');
            // console.log($('#eventApproveVenue').val())
            // alert('dshadahs')
            $("#rejectRequestModal").modal('hide');
            var reason = $('#eventRejectReason').val()
            // console.log(reason);
            const { value: password } = await Swal.fire({
                title: "Enter your passcode to confirm approval",
                input: "password",
                inputLabel: "Passcode",
                inputPlaceholder: "Enter your passcode",
                inputAttributes: {
                    maxlength: "256",
                    autocapitalize: "off",
                    autocorrect: "off"
                }
            });

            if (password) {
                console.log(password)
                const dataToSend = {
                    key1: password,
                    key2: user_id,
                    key3: reason
                };
                $.ajax({
                    type: "POST",
                    url: "/api/request/reject/" + id,
                    data: dataToSend,
                    headers: {
                        'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        console.log(data);

                        setTimeout(function () {
                            window.location.href = '/my/rejected';
                        }, 1500);

                        Swal.fire({
                            icon: "success",
                            title: "Request has been declined",
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

    });//end event status table END SECTION HEADS

    // $("#eventReject").on("click", function (e) {
    //     console.log('rejected')
    // });

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
        console.log(id);

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
                var originalSDate = new Date(data.events.start_date);
                var originalEDate = new Date(data.events.end_date);
                var origStime = moment(data.events.start_time, "HH:mm:ss")
                var origEtime = moment(data.events.end_time, "HH:mm:ss")
                var origCreatedDate = new Date(data.events.created_at);

                var formattedSTime = origStime.format("h:mm A");
                var formattedETime = origEtime.format("h:mm A");

                // var formattedCreatedTime = origCreatedDate.format("h:mm A");

                // Format the date using moment.js
                var formattedSDate = moment(originalSDate).format("MMMM D, YYYY");
                var formattedEDate = moment(originalEDate).format("MMMM D, YYYY");
                var formattedCreatedDate = moment(origCreatedDate).format("MMMM D, YYYY");

                var formattedCreatedTime = moment(origCreatedDate).format("h:mm A");

                // console.log(formattedCreatedTime);
                var dateType = data.events.type;
                var dType;
                if (dateType === 'within_day') {
                    dType = 'Within the Day';
                } else if (dateType === 'whole_day') {
                    dType = 'Whole Day';
                } else {
                    dType = 'Whole Week';
                }
                // console.log(dType);
                console.log(data.typeOfPlace);
                if (data.typeOfPlace === 'Room') {
                    $('#eventStatusVenue').val(data.rooms.name);
                } else if (data.typeOfPlace === 'Venue') {
                    $('#eventStatusVenue').val(data.venues.name);
                } else {
                    // Handle other cases if needed
                }
                $('#checkMoreModal').modal('show');
                $('#eventStatusText').text(data.msg);
                $('#eventDateRequestedText').text(formattedCreatedDate + ' ' + formattedCreatedTime);
                $('#eventStatusName').val(data.events.event_name);
                $('#eventStatusDesc').val(data.events.description);
                $('#eventStatusParticipants').val(data.events.participants);
                // $('#eventStatusVenue').val(data.venues.name);
                $('#eventStatusDateType').val(dType);
                $('#eventStatusStartDate').val(formattedSDate);
                $('#eventStatusEndDate').val(formattedEDate);
                $('#eventStatusSTime').val(formattedSTime);
                $('#eventStatusETime').val(formattedETime);


                var statusElement = $('#eventStatusText');
                // console.log(statusElement)
                // Get the value from the element's text content
                var statusValue = $('#eventStatusText').text();
                console.log(statusValue);
                statusElement.removeClass();
                // Apply styling based on the value
                // if (statusValue === 'APPROVED') {
                //     statusElement.addClass('badge badge-sm border border-success text-success');
                // } else {
                //     statusElement.addClass('badge badge-sm border border-warning text-warning');
                // }
                // $("#venueEditImage").html(
                // `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);
            },
            error: function (error) {
                console.log("error");
            },
        });

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
                // $('#checkStatusModal').modal('show');
                console.log(data.pendingMsg);
                $('#eventStatusText').text(data.pendingMsg);

                var statusElement = $('#eventStatusText');
                // console.log(statusElement)
                // Get the value from the element's text content
                var statusValue = $('#eventStatusText').text();
                console.log(statusValue);
                statusElement.removeClass();
                // Apply styling based on the value
                if (statusValue === 'REJECTED') {
                    statusElement.addClass('badge badge-sm border border-danger text-danger');
                } else if (statusValue === 'APPROVED') {
                    statusElement.addClass('badge badge-sm border border-success text-success');
                }
                else {
                    statusElement.addClass('badge badge-sm border border-warning text-warning');
                }

                $.each(data.dates, function (index, item) {
                    // console.log(item);
                    // console.log(index);
                    // console.log(item)
                    // console.log(data.msg);
                    var formattedDate = moment(item, 'YYYY-MM-DD HH:mm:ss').format('MMMM D, YYYY');
                    var formattedTime = moment(item, 'YYYY-MM-DD HH:mm:ss').format('h:mm A');
                    console.log(formattedTime);


                    if (data.msg && data.msg[index]) {
                        var statusValue = $('#eventStatusText').text();
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

                });



            },
            error: function (error) {
                console.log("error");
            },
        });
    });//end event status table

    $('#event_date_withinDayUser').change(function () {
        // Your code here
        // var selectedDate = $(this).val();
        // var selectedVenueID = $("input[name='event_venue']:checked").val();

        // console.log('Selected venue:', selectedVenueID);
        // console.log('Selected date:', selectedDate);
        // var venue = $('#event_venue').val()
        // console.log(venue);  


        // You can perform any other actions you need here
    });

    //Within the Day TRAPPING
    $('#end_time_withinDayUser').change(function () {
        var selectedDate = $('#event_date_withinDayUser').val();
        var selectedVenueID = $("input[name='event_venue']:checked").val();
        var selectedVenueType = $("input[name='event_place']:checked").val();

        var selectedStartTime = $('#start_time_withinDayUser').val();
        var selectedEndTime = $(this).val();
        console.log("date: " + selectedDate);
        console.log("venue id: " + selectedVenueID);
        console.log("StartTime: " +selectedStartTime);
        console.log("Endtime: " +selectedEndTime);
        console.log("venuetype: " +selectedVenueType);


        if (selectedVenueType === 'room') {
            $.ajax({
                url: '/api/check-event-conflict',
                type: 'POST',
                data: {
                    event_type: 'withinDay',
                    date: selectedDate,
                    start_time: selectedStartTime,
                    end_time: selectedEndTime,
                    room_id: selectedVenueID,
                    selectedVenueType: selectedVenueType
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.conflict) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            html: "There is an existing event with the <strong>same venue and time</strong>. Please check the calendar for available dates and time.",
                        });
                        // alert('');
                        $('#event_date_withinDayUser').val('');
                        $('#start_time_withinDayUser').val('');
                        $('#end_time_withinDayUser').val('');
                    }

                },
                error: function (xhr, status, error) {
                    console.error('Error checking event conflict:', error);
                }
            });
        }
        else {
            $.ajax({
                url: '/api/check-event-conflict',
                type: 'POST',
                data: {
                    event_type: 'withinDay',
                    date: selectedDate,
                    start_time: selectedStartTime,
                    end_time: selectedEndTime,
                    venue_id: selectedVenueID,
                    selectedVenueType: selectedVenueType
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response)
                    if (response.conflict) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            html: "There is an existing event with the <strong>same venue and time</strong>. Please check the calendar for available dates and time.",
                        });
                        // alert('');
                        $('#event_date_withinDayUser').val('');
                        $('#start_time_withinDayUser').val('');
                        $('#end_time_withinDayUser').val('');
                    }

                },
                error: function (xhr, status, error) {
                    console.error('Error checking event conflict:', error);
                }
            });
        }


    });

    $('#event_date_wholeDayUser').change(function () {
        var selectedVenueID = $("input[name='event_venue']:checked").val();
        var selectedWholeDay = $(this).val();
        console.log(selectedWholeDay);
        var selectedVenueType = $("input[name='event_place']:checked").val();
        if (selectedVenueType === 'room') {
            $.ajax({
                url: '/api/check-event-conflict',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: {
                    event_type: 'wholeDay',
                    date: selectedWholeDay,
                    room_id: selectedVenueID,
                    selectedVenueType: selectedVenueType
                },
                success: function (response) {
                    if (response.conflict) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            html: "There is an existing event with the <strong>same venue and time</strong>. Please check the calendar for available dates and time.",
                        });
                        // alert('');
                        $('#event_date_wholeDayUser').val('');
                    }

                },
                error: function (xhr, status, error) {
                    console.error('Error checking event conflict:', error);
                }
            });
        }
        else {
            $.ajax({
                url: '/api/check-event-conflict',
                headers: {
                    'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: {
                    event_type: 'wholeDay',
                    date: selectedWholeDay,
                    venue_id: selectedVenueID,
                    selectedVenueType: selectedVenueType
                },
                success: function (response) {
                    if (response.conflict) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            html: "There is an existing event with the <strong>same venue and time</strong>. Please check the calendar for available dates and time.",
                        });
                        // alert('');
                        $('#event_date_wholeDayUser').val('');
                    }

                },
                error: function (xhr, status, error) {
                    console.error('Error checking event conflict:', error);
                }
            });
        }
    });

    $('#event_date_wholeWeekUser').change(function () {
        var selectedVenueID = $("input[name='event_venue']:checked").val();
        var selectedVenueType = $("input[name='event_place']:checked").val();
        var selectedWeek = $(this).val();
        console.log(selectedWeek);
        if (selectedVenueType === 'room') {
            $.ajax({
                url: '/api/check-event-conflict',
                type: 'POST',
                data: {
                    event_type: 'wholeWeek',
                    date: selectedWeek,
                    room_id: selectedVenueID,
                    selectedVenueType: selectedVenueType
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.conflict) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            html: "There is an existing event with the <strong>same venue and time</strong>. Please check the calendar for available dates and time.",
                        });
                        // alert('');
                        $('#event_date_wholeWeekUser').val('');
                    }

                },
                error: function (xhr, status, error) {
                    console.error('Error checking event conflict:', error);
                }
            });
        }
        else {
            $.ajax({
                url: '/api/check-event-conflict',
                type: 'POST',
                data: {
                    event_type: 'wholeWeek',
                    date: selectedWeek,
                    venue_id: selectedVenueID,
                    selectedVenueType: selectedVenueType
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.conflict) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            html: "There is an existing event with the <strong>same venue and time</strong>. Please check the calendar for available dates and time.",
                        });
                        // alert('');
                        $('#event_date_wholeWeekUser').val('');
                    }

                },
                error: function (xhr, status, error) {
                    console.error('Error checking event conflict:', error);
                }
            });
        }


    });

    // $("#start_time_withinDayUser").on("click", function (e) {
    //     // $('#start_time_withinDayUser').val();
    //     // $('#end_time_withinDayUser').val();
    //     $('#event_date_withinDayUser').val();
    // })

    $("#start_time_withinDayUser").on("click change", function (e) {
        var eventDate = $('#event_date_withinDayUser').val();
        if (!eventDate) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                html: "Please select an event date first.",
            });
            $('#event_date_withinDayUser').focus();
            $(this).val('');
            return;
        }
        // Proceed with your logic here if the event date is selected
    });

    $("#end_time_withinDayUser").on("click change", function (e) {
        var eventDate = $('#event_date_withinDayUser').val();
        var startTime = $('#start_time_withinDayUser').val();
        if (!eventDate) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                html: "Please select an event date first.",
            });
            $('#event_date_withinDayUser').focus();
            $(this).val('');
            return;
        }
        if (!startTime) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                html: "Please select a start time first.",
            });
            $('#start_time_withinDayUser').focus();
            $(this).val('');
            return;
        }
        // Proceed with your logic here if the event date and start time are selected
    });



    // $('#date_range_User').change(function() {

    //     // dateRanges
    //     var selectedVenueID = $("input[name='event_venue']:checked").val();
    //     var selectedRange = $(this).val();
    //     var selectedVenueType = $("input[name='event_place']:checked").val();
    //     console.log(selectedRange);

    //     if (selectedVenueType === 'room'){
    //         $.ajax({
    //             url: '/api/check-event-conflict',
    //             type: 'POST',
    //             data: {
    //                 event_type:'dateRanges',
    //                 daterange: selectedRange,
    //                 room_id: selectedVenueID,
    //                 selectedVenueType: selectedVenueType
    //             },
    //             success: function(response) {
    //                 if (response.conflict) {
    //                     Swal.fire({
    //                         icon: "error",
    //                         title: "Oops...",
    //                         html: "There is an existing event with the <strong>same venue and time</strong>. Please check the calendar for available dates and time.",
    //                     });
    //                     // alert('');
    //                     $('#date_range_User').val('');
    //                 }

    //             },
    //             error: function(xhr, status, error) {
    //                 console.error('Error checking event conflict:', error);
    //             }
    //         });
    //     }
    //     else{
    //         $.ajax({
    //             url: '/api/check-event-conflict',
    //             type: 'POST',
    //             data: {
    //                 event_type:'dateRanges',
    //                 daterange: selectedRange,
    //                 venue_id: selectedVenueID,
    //                 selectedVenueType: selectedVenueType
    //             },
    //             success: function(response) {
    //                 if (response.conflict) {
    //                     Swal.fire({
    //                         icon: "error",
    //                         title: "Oops...",
    //                         html: "There is an existing event with the <strong>same venue and time</strong>. Please check the calendar for available dates and time.",
    //                     });
    //                     // alert('');
    //                     $('#date_range_User').val('');
    //                 }

    //             },
    //             error: function(xhr, status, error) {
    //                 console.error('Error checking event conflict:', error);
    //             }
    //         });
    //     }

    // });
    //end TRAPPING
    $('#radioForm input').change(function () {
        // alert($('input[name=btnradiotable]:checked', '#radioForm').val());

        // var value = $('input[name=btnradiotable]:checked', '#radioForm').val()
        // console.log(value);

        var filterValue = $(this).val();
        console.log(filterValue);

        $('#eventBody tr').show();

        if (filterValue !== 'all') {
            $('#eventBody tr').each(function () {
                var rowStatus = $(this).find('td:eq(7)').text().trim(); // Trim whitespace // td:eq(3) yung column!
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

    //complete profile 
    $("#completeProfileSubmit").on("click", function (e) {

        e.preventDefault();
        var data = $('#compeleteProfileForm')[0];
        console.log(data);
        let formData = new FormData($('#compeleteProfileForm')[0]);
        console.log(formData);

        for (var pair of formData.entries()) {
            console.log(pair[0] + ',' + pair[1]);
        }
        console.log(formData)
        $.ajax({
            type: "POST",
            url: "/api/users/storeCompleteProfile",
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
                Swal.fire({
                    icon: "success",
                    title: "Account approval is underway. Your patience is appreciated as we verify the details you've provided.",
                    showConfirmButton: false,
                    timer: 4500
                });
                // var $ctable = $('#ctable').DataTable();
                // $ctable.ajax.reload();
                // $ctable.row.add(data.customer).draw(false);
                // // $etable.row.add(data.client).draw(false);
                setTimeout(function () {
                    window.location.href = '/dashboard';
                }, 2500);
            },
            error: function (error) {
                console.log('error');
            }
        });

    });//end create

    $('#user_role').change(function () {
        var selectedValue = $(this).val();
        const orgDiv = document.getElementById('orgDivCompleteProfile');
        const deptDiv = document.getElementById('depDivCompleteProfile');
        const deptDivStaff = document.getElementById('depDivStaffCompleteProfile');
        const sectDiv = document.getElementById('sectDivCompleteProfile');
        const tupID = document.getElementById('tupIDdiv');
        const tupIDPhoto = document.getElementById('tupIDphotoDiv');
        const validID = document.getElementById('validIDphotoDiv');



        // Perform actions based on the selected value
        console.log(selectedValue);
        if (selectedValue === 'student') {
            orgDiv.style.display = 'block';
            deptDiv.style.display = 'block';
            sectDiv.style.display = 'block';
            tupID.style.display = 'block';
            tupIDPhoto.style.display = 'block';
            deptDivStaff.style.display = 'none';
            validID.style.display = 'none';
        }
        else if (selectedValue === 'professor') {
            orgDiv.style.display = 'none';
            deptDiv.style.display = 'none';
            sectDiv.style.display = 'none';
            deptDivStaff.style.display = 'none';
            validID.style.display = 'none';
            tupID.style.display = 'block';
            tupIDPhoto.style.display = 'block';
        }
        else if (selectedValue === 'staff') {
            deptDivStaff.style.display = 'block';
            orgDiv.style.display = 'none';
            deptDiv.style.display = 'none';
            sectDiv.style.display = 'none';
            validID.style.display = 'none';
            tupID.style.display = 'block';
            tupIDPhoto.style.display = 'block';
        }
        else {
            deptDivStaff.style.display = 'none';
            orgDiv.style.display = 'none';
            deptDiv.style.display = 'none';
            sectDiv.style.display = 'none';
            tupID.style.display = 'none';
            tupIDPhoto.style.display = 'none';
            validID.style.display = 'block';
        }
    });

    $("#pendingUsersTable tbody").on("click", 'button.approveAccounts ', function (e) {
        var id = $(this).data("id");
        // e.preventDefault();
        console.log(id);

        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/admin/getUser/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                var role = data.user.role;
                var newrole;
                if (role === 'student') {
                    newrole = 'Student';
                    $('#orgDeptRowDiv').css('display', 'block');
                    $('#orgDiv').css('display', 'block');
                    $('#sectionDiv').css('display', 'block');
                }
                else if (role === 'professor') {
                    newrole = 'Faculty';
                    $('#orgDiv').css('display', 'none');
                    $('#sectionDiv').css('display', 'none');
                }
                else if (role === 'staff') {
                    newrole = 'Staff/Admin';
                }
                else {
                    newrole = 'Outside the TUPT Campus'
                    $('#orgDeptRowDiv').css('display', 'none');
                    $('#sectionDiv').css('display', 'none');
                    $('#tupIDdiv').css('display', 'none');
                    // $('#userApproveTupID').css('display', 'none');

                }
                console.log(data);
                //     $('#createVenueModal').modal('show');
                $('#userApproveId').val(id);
                $('#userApproveLastname').text(data.user.lastname);
                $('#userApproveFirstname').text(data.user.firstname);
                $('#userApproveOrganization').text(data.user.organization);
                $('#userApproveDepartment').text(data.user.department);
                $('#userApproveRole').text(newrole);
                $('#userApproveSection').text(data.user.section);
                $('#userApproveTupID').text(data.user.tupID);
                $("#userApproveTupIDPhoto").html(
                    `<img src="/storage/${data.user.image}" width="400" height="400" style="border-radius: 20px;">`);
            },
            error: function (error) {
                console.log("error");
            },
        });

    });

    $("#approveAccount").on("click", function (e) {

        e.preventDefault();
        // var data = $('#roleUpdateForm')[0];
        var id = $("#userApproveId").val();
        console.log(id);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/admin/confirmPendingUsers/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                Swal.fire({
                    icon: "success",
                    title: "Account verified!",
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(function () {
                    window.location.href = '/admin/pendingUsers';
                }, 1500);
            },
            error: function (error) {
                console.log("error");
            },
        });

    });//end create

    $("#pendingUsersTable tbody").on("click", 'button.editRole ', function (e) {
        var id = $(this).data("id");
        console.log(id);
        // e.preventDefault();
        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/admin/getUser/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                if (data.user.role === 'professor' || data.user.role === 'staff') {
                    $('#orgDivCheckStatus').css('display', 'none');
                }
                else if (data.user.role === 'outsider') {
                    $('#orgDivCheckStatus').css('display', 'none');
                }
                else if (data.user.role === 'student') {
                    $('#orgDivCheckStatus').css('display', 'block');
                }
                //     $('#createVenueModal').modal('show');
                $('#userId').val(id);
                $('#userLastname').val(data.user.lastname);
                $('#userFirstname').val(data.user.firstname);
                $('#userOrganization').val(data.user.organization);
                $('#userDepartment').val(data.user.department);
                //     $("#venueEditImage").html(
                //         `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);
            },
            error: function (error) {
                console.log("error");
            },
        });
    });

    $("#roleUpdate").on("click", function (e) {

        e.preventDefault();
        // var data = $('#roleUpdateForm')[0];
        var id = $("#userId").val();
        console.log(id);
        let formData = new FormData($('#roleUpdateForm')[0]);
        // console.log(formData);

        // for (var pair of formData.entries()) {
        //     console.log(pair[0] + ',' + pair[1]);
        // }
        console.log(formData)
        $.ajax({
            type: "POST",
            url: "/api/admin/editRole/" + id,
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
                Swal.fire({
                    icon: "success",
                    title: "Role Updated!",
                    showConfirmButton: false,
                    timer: 1500
                });
                // var $ctable = $('#ctable').DataTable();
                // $ctable.ajax.reload();
                // $ctable.row.add(data.customer).draw(false);
                // // $etable.row.add(data.client).draw(false);
                setTimeout(function () {
                    window.location.href = '/admin/pendingUsers';
                }, 1500);
            },
            error: function (error) {
                console.log(error);
            }
        });

    });//end create

    // ADMIN SETTING DATE
    $('.radiobuttons input[type="radio"]').change(function () {
        const withinDayDiv = document.getElementById('withinTheDayDiv');
        const wholeDayDiv = document.getElementById('wholeDayDiv');
        const wholeWeekDiv = document.getElementById('wholeWeekDiv');
        const dateRangeDiv = document.getElementById('dateRangeDiv');

        const dateRange = document.getElementById('date_range');
        const eventDate = document.getElementById('event_date');
        const startTimeWithinDay = document.getElementById('start_time_withinDay');
        const endTimeWithinDay = document.getElementById('end_time_withinDay');
        const WholeDay = document.getElementById('event_date_wholeDay');
        const WholeWeek = document.getElementById('event_date_wholeWeek');
        if ($(this).is(':checked')) {

            if ($(this).val() === 'withinDay') {
                // console.log('labasDate');
                // $("#withinTheDayDiv").show();
                // $("#wholeDayDiv").hide();
                // $("#wholeWeekDiv").hide();
                WholeDay.removeAttribute('required');
                WholeWeek.removeAttribute('required');
                dateRange.removeAttribute('required');

                eventDate.value = "";
                startTimeWithinDay.value = "";
                endTimeWithinDay.value = "";

                withinDayDiv.style.display = 'block';
                wholeDayDiv.style.display = 'none';
                dateRangeDiv.style.display = 'none';
                wholeWeekDiv.style.display = 'none';

                startTimeWithinDay.setAttribute('required', true);
                endTimeWithinDay.setAttribute('required', true);
                eventDate.setAttribute('required', true);




            }
            else if ($(this).val() === 'wholeDay') {
                console.log('wholeDayLangTalaga');
                startTimeWithinDay.removeAttribute('required');
                endTimeWithinDay.removeAttribute('required');
                eventDate.removeAttribute('required');
                dateRange.removeAttribute('required');
                WholeWeek.removeAttribute('required');

                WholeDay.value = "";

                wholeWeekDiv.style.display = 'none';
                withinDayDiv.style.display = 'none';
                wholeDayDiv.style.display = 'block';
                dateRangeDiv.style.display = 'none';

                WholeDay.setAttribute('required', true);
            }
            else if ($(this).val() === 'wholeWeek') {
                console.log('wholeWeekNa')
                startTimeWithinDay.removeAttribute('required');
                endTimeWithinDay.removeAttribute('required');
                eventDate.removeAttribute('required');
                dateRange.removeAttribute('required');
                WholeDay.removeAttribute('required');

                WholeWeek.value = "";

                wholeWeekDiv.style.display = 'block';
                withinDayDiv.style.display = 'none';
                wholeDayDiv.style.display = 'none';
                dateRangeDiv.style.display = 'none';

                WholeWeek.setAttribute('required', true);
            }
            else {
                startTimeWithinDay.removeAttribute('required');
                endTimeWithinDay.removeAttribute('required');
                eventDate.removeAttribute('required');
                WholeWeek.removeAttribute('required');
                WholeDay.removeAttribute('required');

                dateRange.value = "";

                wholeWeekDiv.style.display = 'none';
                withinDayDiv.style.display = 'none';
                wholeDayDiv.style.display = 'none';
                dateRangeDiv.style.display = 'block';

            }
            // console.log('Selected value:', $(this).val());
        }

    });

    $("#createAdminEvent_submit").on("click", function (e) {
        console.log(data);
        e.preventDefault();
        // $('#serviceSubmit').show()
        var data = $('#createEventFormAdmin')[0];
        console.log(data);
        let formData = new FormData($('#createEventFormAdmin')[0]);
        console.log(formData);

        for (var pair of formData.entries()) {
            console.log(pair[0] + ',' + pair[1]);
        }
        console.log(formData)
        $.ajax({
            type: "POST",
            url: "/api/admin/postCreateMyEvent",
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
                setTimeout(function () {
                    window.location.href = '/admin/allEvents';
                }, 1500);

                Swal.fire({
                    icon: 'success',
                    title: 'Event has been Added!',
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

    //SELECT ROLE FOR ORG AND DEPT
    $('#official_role').change(function () {
        var selectedValue = $(this).val();
        const orgDiv = document.getElementById('selectOrgDiv');
        const deptDiv = document.getElementById('selectDeptDiv');

        // Perform actions based on the selected value
        console.log(selectedValue);
        if (selectedValue === 'org_adviser') {
            orgDiv.style.display = 'block';
            deptDiv.style.display = 'none';
        }
        else if (selectedValue === 'department_head') {
            orgDiv.style.display = 'none';
            deptDiv.style.display = 'block';
        }
        else {
            orgDiv.style.display = 'none';
            deptDiv.style.display = 'none';
        }
    });

    //ADMIN IN-TABLE VIEW OF REQUEST LETTER 
    $("#adminAllEvents tbody").on("click", 'a.viewRequestLetter ', function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        console.log(id);

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
                    text: "Request Letter",
                    target: "_blank",
                });
                // console.log(href)
                $("#viewRequestLetter").replaceWith(pdfLink); // Replace the existing link
                pdfLink[0].click();
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    $("#officialTable tbody").on("click", 'a.editOfficial ', function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        console.log(id);
        // $('#officialEditId').val(data.officials.id);
        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/admin/official/" + id + "/edit",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                var role = data.officials.role;
                console.log(role);
                $('#editOfficialModal').modal('show');
                if (role === 'org_adviser') {
                    $('#officialSelectOrgDiv').css('display', 'block');
                    $('#officialSelectDeptDiv').css('display', 'none');
                }
                else if (role === 'department_head') {
                    $('#officialSelectOrgDiv').css('display', 'none');
                    $('#officialSelectDeptDiv').css('display', 'block');
                }
                else {
                    $('#officialSelectOrgDiv').css('display', 'none');
                    $('#officialSelectDeptDiv').css('display', 'none');
                }
                // console.log(data.officials.id);
                $('#officialEditId').val(data.officials.id);
                $('#officialEditName').val(data.officials.name);
                $('#officialEditEmail').val(data.officials.email);
                $('#officialEditDepartment').val(data.officials.department_id);
                $('#officialEditOrganization').val(data.officials.organization_id);
                // $("#venueEditImage").html(
                //     `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);
            },
            error: function (error) {
                console.log("error");
            },
        });
    });

    $("#officialUpdate").on("click", function (e) {

        e.preventDefault();
        // var data = $('#roleUpdateForm')[0];
        var id = $("#officialEditId").val();
        console.log(id);
        let formData = new FormData($('#officialUpdateForm')[0]);
        // console.log(formData);

        for (var pair of formData.entries()) {
            console.log(pair[0] + ',' + pair[1]);
        }
        console.log(formData)
        $.ajax({

            type: "POST",
            url: "/api/admin/official/" + id,
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
                Swal.fire({
                    icon: "success",
                    title: "Official Updated!",
                    showConfirmButton: false,
                    timer: 1500
                });
                // var $ctable = $('#ctable').DataTable();
                // $ctable.ajax.reload();
                // $ctable.row.add(data.customer).draw(false);
                // // $etable.row.add(data.client).draw(false);
                setTimeout(function () {
                    window.location.href = '/admin/officials';
                }, 1500);
            },
            error: function (error) {
                console.log(error);
            }
        });

    });//end create
    // Approve Request

    //ROOM CRUD FOR ADMIN
    $("#roomSubmit").on("click", function (e) {

        e.preventDefault();
        // var data = $('#roleUpdateForm')[0];
        let formData = new FormData($('#roomForm')[0]);
        // console.log(formData);

        for (var pair of formData.entries()) {
            console.log(pair[0] + ',' + pair[1]);
        }
        console.log(formData)
        $.ajax({

            type: "POST",
            url: "/api/admin/storeRoom",
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
                Swal.fire({
                    icon: "success",
                    title: "Room Added!",
                    showConfirmButton: false,
                    timer: 1500
                });
                // var $ctable = $('#ctable').DataTable();
                // $ctable.ajax.reload();
                // $ctable.row.add(data.customer).draw(false);
                // // $etable.row.add(data.client).draw(false);
                setTimeout(function () {
                    window.location.href = '/admin/rooms';
                }, 1500);
            },
            error: function (error) {
                console.log(error);
            }
        });

    });

    $("#roomTable tbody").on("click", 'a.editBtn ', function (e) {
        var id = $(this).data("id");
        // e.preventDefault();
        console.log(id);

        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/admin/room/" + id + "/edit",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $('#editRoomModal').modal('show');
                $('#roomEditId').val(data.rooms.id);
                $('#roomEditName').val(data.rooms.name);
                $('#roomEditDesc').val(data.rooms.description);
                $('#roomEditCapacity').val(data.rooms.capacity);
                $("#roomEditImage").html(
                    `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);
            },
            error: function (error) {
                console.log("error");
            },
        });

    });

    $("#roomTable tbody").on("click", 'a.deleteBtn ', function (e) {
        var id = $(this).data("id");
        // e.preventDefault();
        console.log(id);

        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/admin/getUser/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                // $('#editRoomModal').modal('show');
                $('#roomEditId').val(data.rooms.id);
                $('#roomEditName').val(data.rooms.name);
                $('#roomEditDesc').val(data.rooms.description);
                $('#roomEditCapacity').val(data.rooms.capacity);
                $("#roomEditImage").html(
                    `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);
            },
            error: function (error) {
                console.log("error");
            },
        });

    });

    $("#roomUpdate").on("click", function (e) {
        e.preventDefault();
        var id = $("#roomEditId").val();
        let editformData = new FormData($("#roomUpdateForm")[0]);
        for (var pair of editformData.entries()) {
            console.log(pair[0] + ',' + pair[1]);
        }
        $.ajax({
            type: "POST",
            url: "/api/admin/room/" + id,
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
                    window.location.href = '/admin/rooms';
                }, 1500);

                Swal.fire({
                    icon: 'success',
                    title: 'Room Updated!',
                    showConfirmButton: false,
                    timer: 3000
                })

            },
            error: function (error) {
                console.log("error");
            },
        });
    });

    $("#requestRoomButton").on("click", function (e) {
        console.log('napindot')
        e.preventDefault();
        // event_venue
        $("#event_venue").css('display', 'block')
        $("#venuesButton").css('display', 'block')

        $("#roomDiv").css('display', 'block')
        $("#venueDiv").css('display', 'none')
        $("#requestRoomButton").css('display', 'none')
    });
    //END ROOMS CRUD FOR ADMIN

    //ORG ADVISER CRUD FOR ADMIN
    $("#orgAdviserTable tbody").on("click", 'a.editOrgAdviser ', function (e) {
        var id = $(this).data("id");
        // e.preventDefault();
        // console.log(id);

        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/admin/orgAdviser/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                console.log(id);
                $('#editOrgAdviserModal').modal('show');
                $('#orgAdviserEditId').val(id);
                $('#orgAdviserEditName').val(data.officials.name);
                $('#orgAdviserEditEmail').val(data.officials.email);
            },
            error: function (error) {
                console.log("error");
            },
        });

    });

    $("#orgAdviserUpdate").on("click", function (e) {
        var id = $('#orgAdviserEditId').val();
        console.log(id);
        // console.log('napindot')
        e.preventDefault();
        let formData = new FormData($('#orgAdviserUpdateForm')[0]);
        // console.log(formData);

        for (var pair of formData.entries()) {
            console.log(pair[0] + ',' + pair[1]);
        }

        console.log(formData)
        $.ajax({

            type: "POST",
            url: "/api/admin/orgAdviser/update/" + id,
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
                Swal.fire({
                    icon: "success",
                    title: "Organization Adviser Updated!",
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(function () {
                    window.location.href = '/admin/orgAdvisers';
                }, 1500);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $("#orgAdviserSubmit").on("click", function (e) {
        console.log('napindot')
        e.preventDefault();
        let formData = new FormData($('#orgAdviserForm')[0]);
        // console.log(formData);

        for (var pair of formData.entries()) {
            console.log(pair[0] + ',' + pair[1]);
        }
        console.log(formData)
        $.ajax({

            type: "POST",
            url: "/api/admin/storeOrgAdviser",
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
                Swal.fire({
                    icon: "success",
                    title: "Organization Adviser Added!",
                    showConfirmButton: false,
                    timer: 1500
                });
                // var $ctable = $('#ctable').DataTable();
                // $ctable.ajax.reload();
                // $ctable.row.add(data.customer).draw(false);
                // // $etable.row.add(data.client).draw(false);
                setTimeout(function () {
                    window.location.href = '/admin/orgAdvisers';
                }, 1500);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $("#orgAdviserTable tbody").on("click", 'a.deleteOrgAdviser', function (e) {
        // alert('dshagd')
        var id = $(this).data("id");
        console.log(id);
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
        //         var originalSDate = new Date(data.events.start_date);
        //         var originalEDate = new Date(data.events.end_date);
        //         var origStime = moment(data.events.start_time, "HH:mm:ss")
        //         var origEtime = moment(data.events.end_time, "HH:mm:ss")
        //         var origCreatedDate = new Date(data.events.created_at);

        //         var formattedSTime = origStime.format("h:mm A");
        //         var formattedETime = origEtime.format("h:mm A");

        //         // var formattedCreatedTime = origCreatedDate.format("h:mm A");

        //         // Format the date using moment.js
        //         var formattedSDate = moment(originalSDate).format("MMMM D, YYYY");
        //         var formattedEDate = moment(originalEDate).format("MMMM D, YYYY");
        //         var formattedCreatedDate = moment(origCreatedDate).format("MMMM D, YYYY");

        //         var formattedCreatedTime = moment(origCreatedDate).format("h:mm A");

        //         console.log(formattedCreatedTime);
        //         var dateType = data.events.type;
        //         var dType;
        //         if (dateType === 'within_day') {
        //             dType = 'Within the Day';
        //         } else if (dateType === 'whole_day') {
        //             dType = 'Whole Day';
        //         } else {
        //             dType = 'Whole Week';
        //         }
        //         // console.log(dType);
        //         // console.log(data);
        //         $('#adminAllEventStatus').modal('show');
        //         $('#eventStatusText').text(data.msg);
        //         $('#eventDateRequestedText').text(formattedCreatedDate +' '+ formattedCreatedTime);
        //         $('#eventStatusName').val(data.events.event_name);
        //         $('#eventStatusDesc').val(data.events.description);
        //         $('#eventStatusParticipants').val(data.events.participants);
        //         $('#eventStatusVenue').val(data.venues.name);
        //         $('#eventStatusDateType').val(dType);
        //         $('#eventStatusStartDate').val(formattedSDate);
        //         $('#eventStatusEndDate').val(formattedEDate);
        //         $('#eventStatusSTime').val(formattedSTime);
        //         $('#eventStatusETime').val(formattedETime);


        //         var statusElement = $('#eventStatusText');
        //         // console.log(statusElement)
        //         // Get the value from the element's text content
        //         var statusValue = $('#eventStatusText').text();

        //         statusElement.removeClass();
        //         // Apply styling based on the value
        //         if (statusValue === 'APPROVED') {
        //             statusElement.addClass('badge badge-sm border border-success text-success');
        //         } else {
        //             statusElement.addClass('badge badge-sm border border-warning text-warning');
        //         }
        //         // $("#venueEditImage").html(
        //         // `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);
        //     },
        //     error: function (error) {
        //         console.log("error");
        //     },
        // });

        // $.ajax({
        //     type: "GET",
        //     enctype: 'multipart/form-data',
        //     processData: false, // Important!
        //     contentType: false,
        //     cache: false,
        //     url: "/api/myEventStatus/" + id,
        //     headers: {
        //         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
        //             "content"
        //         ),
        //     },
        //     dataType: "json",
        //     success: function (data) {
        //         console.log(data);
        //         $('#adminStatusList').empty();
        //         // $('#checkStatusModal').modal('show');
        //         $('#eventStatusText').text(data.pendingMsg);

        //         var statusElement = $('#eventStatusText');
        //         // console.log(statusElement)
        //         // Get the value from the element's text content
        //         var statusValue = $('#eventStatusText').text();

        //         statusElement.removeClass();
        //         // Apply styling based on the value
        //         if (statusValue === 'APPROVED') {
        //             statusElement.addClass('badge badge-sm border border-success text-success');
        //         } else {
        //             statusElement.addClass('badge badge-sm border border-warning text-warning');
        //         }
        //         // $("#venueEditImage").html(
        //         // `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);

        //         // var status = 1;
        //         // $.each(data, function(index, item) {

        //         // });

        //         $.each(data.dates, function (index, item) {
        //             // console.log(item);
        //             console.log(index);
        //             console.log(item)
        //             console.log(data.msg);
        //             var formattedDate = moment(item, 'YYYY-MM-DD HH:mm:ss').format('MMMM D, YYYY');
        //             var formattedTime = moment(item, 'YYYY-MM-DD HH:mm:ss').format('h:mm A');
        //             console.log(formattedTime);


        //             if (data.msg && data.msg[index]) {
        //                 var msgItem = data.msg[index];

        //                 // Create a list item for each date and message
        //                 var listItem = `
        //                     <li class="rb-item">
        //                         <div class="timestamp">
        //                             ${formattedDate}<br> <span>${formattedTime}</span>
        //                         </div>
        //                         <div class="item-title">${msgItem}</div>
        //                     </li>
        //                 `;

        //                 $('#adminStatusList').prepend(listItem);
        //             }


        //         });



        //     },
        //     error: function (error) {
        //         console.log("error");
        //     },
        // });

    });//end event status table END ORG ADVISER

    //SECTION HEADS
    $("#sectionHeadTable tbody").on("click", 'a.editSectionHead ', function (e) {
        var id = $(this).data("id");
        // e.preventDefault();
        // console.log(id);

        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/admin/sectionHead/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                console.log(id);
                $('#editSectionHeadModal').modal('show');
                $('#sectionHeadEditId').val(id);
                $('#sectionHeadEditName').val(data.officials.name);
                $('#sectionHeadEditEmail').val(data.officials.email);
            },
            error: function (error) {
                console.log("error");
            },
        });

    });

    $("#sectionHeadUpdate").on("click", function (e) {
        var id = $('#sectionHeadEditId').val();
        console.log(id);
        // console.log('napindot')
        e.preventDefault();
        let formData = new FormData($('#sectionHeadUpdateForm')[0]);
        // console.log(formData);

        for (var pair of formData.entries()) {
            console.log(pair[0] + ',' + pair[1]);
        }

        console.log(formData)
        $.ajax({

            type: "POST",
            url: "/api/admin/sectionHead/update/" + id,
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
                Swal.fire({
                    icon: "success",
                    title: "Organization Adviser Updated!",
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(function () {
                    window.location.href = '/admin/sectionHeads';
                }, 1500);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $("#sectionHeadSubmit").on("click", function (e) {
        console.log('napindot')
        e.preventDefault();
        let formData = new FormData($('#sectionHeadForm')[0]);
        // console.log(formData);

        for (var pair of formData.entries()) {
            console.log(pair[0] + ',' + pair[1]);
        }
        console.log(formData)
        $.ajax({

            type: "POST",
            url: "/api/admin/storeSectionHead",
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
                Swal.fire({
                    icon: "success",
                    title: "Section Head Added!",
                    showConfirmButton: false,
                    timer: 1500
                });
                // var $ctable = $('#ctable').DataTable();
                // $ctable.ajax.reload();
                // $ctable.row.add(data.customer).draw(false);
                // // $etable.row.add(data.client).draw(false);
                setTimeout(function () {
                    window.location.href = '/admin/sectionHeads';
                }, 1500);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $("#sectionHeadTable tbody").on("click", 'a.deleteOrgAdviser', function (e) {
        // alert('dshagd')
        var id = $(this).data("id");
        console.log(id);
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
        //         var originalSDate = new Date(data.events.start_date);
        //         var originalEDate = new Date(data.events.end_date);
        //         var origStime = moment(data.events.start_time, "HH:mm:ss")
        //         var origEtime = moment(data.events.end_time, "HH:mm:ss")
        //         var origCreatedDate = new Date(data.events.created_at);

        //         var formattedSTime = origStime.format("h:mm A");
        //         var formattedETime = origEtime.format("h:mm A");

        //         // var formattedCreatedTime = origCreatedDate.format("h:mm A");

        //         // Format the date using moment.js
        //         var formattedSDate = moment(originalSDate).format("MMMM D, YYYY");
        //         var formattedEDate = moment(originalEDate).format("MMMM D, YYYY");
        //         var formattedCreatedDate = moment(origCreatedDate).format("MMMM D, YYYY");

        //         var formattedCreatedTime = moment(origCreatedDate).format("h:mm A");

        //         console.log(formattedCreatedTime);
        //         var dateType = data.events.type;
        //         var dType;
        //         if (dateType === 'within_day') {
        //             dType = 'Within the Day';
        //         } else if (dateType === 'whole_day') {
        //             dType = 'Whole Day';
        //         } else {
        //             dType = 'Whole Week';
        //         }
        //         // console.log(dType);
        //         // console.log(data);
        //         $('#adminAllEventStatus').modal('show');
        //         $('#eventStatusText').text(data.msg);
        //         $('#eventDateRequestedText').text(formattedCreatedDate +' '+ formattedCreatedTime);
        //         $('#eventStatusName').val(data.events.event_name);
        //         $('#eventStatusDesc').val(data.events.description);
        //         $('#eventStatusParticipants').val(data.events.participants);
        //         $('#eventStatusVenue').val(data.venues.name);
        //         $('#eventStatusDateType').val(dType);
        //         $('#eventStatusStartDate').val(formattedSDate);
        //         $('#eventStatusEndDate').val(formattedEDate);
        //         $('#eventStatusSTime').val(formattedSTime);
        //         $('#eventStatusETime').val(formattedETime);


        //         var statusElement = $('#eventStatusText');
        //         // console.log(statusElement)
        //         // Get the value from the element's text content
        //         var statusValue = $('#eventStatusText').text();

        //         statusElement.removeClass();
        //         // Apply styling based on the value
        //         if (statusValue === 'APPROVED') {
        //             statusElement.addClass('badge badge-sm border border-success text-success');
        //         } else {
        //             statusElement.addClass('badge badge-sm border border-warning text-warning');
        //         }
        //         // $("#venueEditImage").html(
        //         // `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);
        //     },
        //     error: function (error) {
        //         console.log("error");
        //     },
        // });

        // $.ajax({
        //     type: "GET",
        //     enctype: 'multipart/form-data',
        //     processData: false, // Important!
        //     contentType: false,
        //     cache: false,
        //     url: "/api/myEventStatus/" + id,
        //     headers: {
        //         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
        //             "content"
        //         ),
        //     },
        //     dataType: "json",
        //     success: function (data) {
        //         console.log(data);
        //         $('#adminStatusList').empty();
        //         // $('#checkStatusModal').modal('show');
        //         $('#eventStatusText').text(data.pendingMsg);

        //         var statusElement = $('#eventStatusText');
        //         // console.log(statusElement)
        //         // Get the value from the element's text content
        //         var statusValue = $('#eventStatusText').text();

        //         statusElement.removeClass();
        //         // Apply styling based on the value
        //         if (statusValue === 'APPROVED') {
        //             statusElement.addClass('badge badge-sm border border-success text-success');
        //         } else {
        //             statusElement.addClass('badge badge-sm border border-warning text-warning');
        //         }
        //         // $("#venueEditImage").html(
        //         // `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);

        //         // var status = 1;
        //         // $.each(data, function(index, item) {

        //         // });

        //         $.each(data.dates, function (index, item) {
        //             // console.log(item);
        //             console.log(index);
        //             console.log(item)
        //             console.log(data.msg);
        //             var formattedDate = moment(item, 'YYYY-MM-DD HH:mm:ss').format('MMMM D, YYYY');
        //             var formattedTime = moment(item, 'YYYY-MM-DD HH:mm:ss').format('h:mm A');
        //             console.log(formattedTime);


        //             if (data.msg && data.msg[index]) {
        //                 var msgItem = data.msg[index];

        //                 // Create a list item for each date and message
        //                 var listItem = `
        //                     <li class="rb-item">
        //                         <div class="timestamp">
        //                             ${formattedDate}<br> <span>${formattedTime}</span>
        //                         </div>
        //                         <div class="item-title">${msgItem}</div>
        //                     </li>
        //                 `;

        //                 $('#adminStatusList').prepend(listItem);
        //             }


        //         });



        //     },
        //     error: function (error) {
        //         console.log("error");
        //     },
        // });

    });//end event status table END SECTION HEADS

    //DEPT HEADS
    $("#departmentHeadTable tbody").on("click", 'a.editDepartmentHead ', function (e) {
        var id = $(this).data("id");
        // e.preventDefault();
        // console.log(id);

        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/admin/departmentHead/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                console.log(id);
                $('#editDepartmentHeadModal').modal('show');
                $('#departmentHeadEditId').val(id);
                $('#departmentHeadEditName').val(data.officials.name);
                $('#departmentHeadEditEmail').val(data.officials.email);
            },
            error: function (error) {
                console.log("error");
            },
        });

    });

    $("#departmentHeadUpdate").on("click", function (e) {
        var id = $('#departmentHeadEditId').val();
        console.log(id);
        // console.log('napindot')
        e.preventDefault();
        let formData = new FormData($('#departmentHeadUpdateForm')[0]);
        // console.log(formData);

        for (var pair of formData.entries()) {
            console.log(pair[0] + ',' + pair[1]);
        }

        console.log(formData)
        $.ajax({

            type: "POST",
            url: "/api/admin/departmentHead/update/" + id,
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
                Swal.fire({
                    icon: "success",
                    title: "Department Head Updated!",
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(function () {
                    window.location.href = '/admin/departmentHeads';
                }, 1500);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $("#departmentHeadSubmit").on("click", function (e) {
        console.log('napindot')
        e.preventDefault();
        let formData = new FormData($('#departmentHeadForm')[0]);
        // console.log(formData);

        for (var pair of formData.entries()) {
            console.log(pair[0] + ',' + pair[1]);
        }
        console.log(formData)
        $.ajax({

            type: "POST",
            url: "/api/admin/storeDepartmentHead",
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
                Swal.fire({
                    icon: "success",
                    title: "Department Head Added!",
                    showConfirmButton: false,
                    timer: 1500
                });
                // var $ctable = $('#ctable').DataTable();
                // $ctable.ajax.reload();
                // $ctable.row.add(data.customer).draw(false);
                // // $etable.row.add(data.client).draw(false);
                setTimeout(function () {
                    window.location.href = '/admin/departmentHeads';
                }, 1500);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $("#departmentHeadTable tbody").on("click", 'a.deleteOrgAdviser', function (e) {
        // alert('dshagd')
        var id = $(this).data("id");
        console.log(id);
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
        //         var originalSDate = new Date(data.events.start_date);
        //         var originalEDate = new Date(data.events.end_date);
        //         var origStime = moment(data.events.start_time, "HH:mm:ss")
        //         var origEtime = moment(data.events.end_time, "HH:mm:ss")
        //         var origCreatedDate = new Date(data.events.created_at);

        //         var formattedSTime = origStime.format("h:mm A");
        //         var formattedETime = origEtime.format("h:mm A");

        //         // var formattedCreatedTime = origCreatedDate.format("h:mm A");

        //         // Format the date using moment.js
        //         var formattedSDate = moment(originalSDate).format("MMMM D, YYYY");
        //         var formattedEDate = moment(originalEDate).format("MMMM D, YYYY");
        //         var formattedCreatedDate = moment(origCreatedDate).format("MMMM D, YYYY");

        //         var formattedCreatedTime = moment(origCreatedDate).format("h:mm A");

        //         console.log(formattedCreatedTime);
        //         var dateType = data.events.type;
        //         var dType;
        //         if (dateType === 'within_day') {
        //             dType = 'Within the Day';
        //         } else if (dateType === 'whole_day') {
        //             dType = 'Whole Day';
        //         } else {
        //             dType = 'Whole Week';
        //         }
        //         // console.log(dType);
        //         // console.log(data);
        //         $('#adminAllEventStatus').modal('show');
        //         $('#eventStatusText').text(data.msg);
        //         $('#eventDateRequestedText').text(formattedCreatedDate +' '+ formattedCreatedTime);
        //         $('#eventStatusName').val(data.events.event_name);
        //         $('#eventStatusDesc').val(data.events.description);
        //         $('#eventStatusParticipants').val(data.events.participants);
        //         $('#eventStatusVenue').val(data.venues.name);
        //         $('#eventStatusDateType').val(dType);
        //         $('#eventStatusStartDate').val(formattedSDate);
        //         $('#eventStatusEndDate').val(formattedEDate);
        //         $('#eventStatusSTime').val(formattedSTime);
        //         $('#eventStatusETime').val(formattedETime);


        //         var statusElement = $('#eventStatusText');
        //         // console.log(statusElement)
        //         // Get the value from the element's text content
        //         var statusValue = $('#eventStatusText').text();

        //         statusElement.removeClass();
        //         // Apply styling based on the value
        //         if (statusValue === 'APPROVED') {
        //             statusElement.addClass('badge badge-sm border border-success text-success');
        //         } else {
        //             statusElement.addClass('badge badge-sm border border-warning text-warning');
        //         }
        //         // $("#venueEditImage").html(
        //         // `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);
        //     },
        //     error: function (error) {
        //         console.log("error");
        //     },
        // });

        // $.ajax({
        //     type: "GET",
        //     enctype: 'multipart/form-data',
        //     processData: false, // Important!
        //     contentType: false,
        //     cache: false,
        //     url: "/api/myEventStatus/" + id,
        //     headers: {
        //         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
        //             "content"
        //         ),
        //     },
        //     dataType: "json",
        //     success: function (data) {
        //         console.log(data);
        //         $('#adminStatusList').empty();
        //         // $('#checkStatusModal').modal('show');
        //         $('#eventStatusText').text(data.pendingMsg);

        //         var statusElement = $('#eventStatusText');
        //         // console.log(statusElement)
        //         // Get the value from the element's text content
        //         var statusValue = $('#eventStatusText').text();

        //         statusElement.removeClass();
        //         // Apply styling based on the value
        //         if (statusValue === 'APPROVED') {
        //             statusElement.addClass('badge badge-sm border border-success text-success');
        //         } else {
        //             statusElement.addClass('badge badge-sm border border-warning text-warning');
        //         }
        //         // $("#venueEditImage").html(
        //         // `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);

        //         // var status = 1;
        //         // $.each(data, function(index, item) {

        //         // });

        //         $.each(data.dates, function (index, item) {
        //             // console.log(item);
        //             console.log(index);
        //             console.log(item)
        //             console.log(data.msg);
        //             var formattedDate = moment(item, 'YYYY-MM-DD HH:mm:ss').format('MMMM D, YYYY');
        //             var formattedTime = moment(item, 'YYYY-MM-DD HH:mm:ss').format('h:mm A');
        //             console.log(formattedTime);


        //             if (data.msg && data.msg[index]) {
        //                 var msgItem = data.msg[index];

        //                 // Create a list item for each date and message
        //                 var listItem = `
        //                     <li class="rb-item">
        //                         <div class="timestamp">
        //                             ${formattedDate}<br> <span>${formattedTime}</span>
        //                         </div>
        //                         <div class="item-title">${msgItem}</div>
        //                     </li>
        //                 `;

        //                 $('#adminStatusList').prepend(listItem);
        //             }


        //         });



        //     },
        //     error: function (error) {
        //         console.log("error");
        //     },
        // });

    });//end event status table END SECTION HEADS

    // $("#venuesButton").on("click", function (e) {
    //     console.log('napindot')
    //     e.preventDefault();
    //     $("#requestRoomButton").css('display', 'block')

    //     $("#roomDiv").css('display', 'none')
    //     $("#venueDiv").css('display', 'block')
    //     $("#venuesButton").css('display', 'none')
    // });

    //////////////// reject request ////////////////////////



    //VENUES RDB
    $('.radiobuttonsuser input[name="event_place"]').change(function () {
        const venueDiv = document.getElementById('venueDiv');
        const roomDiv = document.getElementById('roomDiv');
        const dateRangeDiv = document.getElementById('dateRangeDivUser');

        // const eventDate = document.getElementById('event_date');
        // const startTimeWithinDay = document.getElementById('start_time_withinDay');
        // const endTimeWithinDay = document.getElementById('end_time_withinDay');
        // const WholeDay = document.getElementById('event_date_wholeDay');
        // const WholeWeek = document.getElementById('event_date_wholeWeek');
        if ($(this).is(':checked')) {

            if ($(this).val() === 'venue') {
                console.log('venue');
                dateRangeDiv.style.display = 'none';
                venueDiv.style.display = 'block';
                roomDiv.style.display = 'none';

            }
            else {
                console.log('rroom');
                dateRangeDiv.style.display = 'none';
                venueDiv.style.display = 'none';
                roomDiv.style.display = 'block';

            }
            // console.log('Selected value:', $(this).val());
        }

    });

    //notification
    function fetchNotifications() {
        $.ajax({
            url: '/api/notif/request', // Update the URL to your endpoint
            method: 'GET',
            success: function (response) {
                $('#notificationList').empty(); // Clear existing notifications
                response.forEach(function (notification) {
                    var timeAgo = moment(notification.created_at).fromNow(); // Use moment.js to calculate time ago
                    var listItem = '<li class="mb-2">' +
                        '<a class="dropdown-item border-radius-md" href="javascript:;">' +
                        '<div class="d-flex py-1">' +
                        '<div class="my-auto">' +
                        '<img src="../assets/img/team-2.jpg" class="avatar avatar-sm border-radius-sm me-3">' +
                        '</div>' +
                        '<div class="d-flex flex-column justify-content-center">' +
                        '<h6 class="text-sm font-weight-normal mb-1">' +
                        '<span class="font-weight-bold">New request</span> from ' + notification.name +
                        '</h6>' +
                        '<p class="text-xs text-secondary mb-0 d-flex align-items-center">' +
                        '<i class="fa fa-clock opacity-6 me-1"></i>' + timeAgo +
                        '</p>' +
                        '</div>' +
                        '</div>' +
                        '</a>' +
                        '</li>';
                    $('#notificationList').append(listItem); // Append new notification to the list
                });
            }
        });
    }

    // Fetch notifications initially
    $("#dropdownMenuButton").on("click", function (e) {
        fetchNotifications();
        // Fetch notifications every minute
        // setInterval(fetchNotifications, 60000); // Update every minute (60000 milliseconds)
    });

    $("#termsConditions").on("click", function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Terms and Condition',
            html: `<div style="text-align: justify; text-justify: inter-word; padding: 20px;">CALENDASH Event Scheduling Terms and Conditions<br/><br/>
            These terms and conditions ("Terms") govern the scheduling of events in Technological University of the Philippines - Taguig ("TUP-T") by CALENDASH for the TUP-T students, faculty, and guests ("Users"). By engaging our services, the Users agree to abide by these Terms.<br/><br/>
            <b>1. Event Details:</b><br/>
            a. The Users agree to provide accurate and complete information regarding the event, including date, time, location, and any specific requirements.<br/>
            b. Once the event is approved by the school officials, any changes to the event details will not be tolerated.<br/><br/>
            <b>2. Booking and Approval:</b><br/>
            a. Events must be booked through the CALENDASH platform.<br/>
            b. Submission of event details does not guarantee approval. CALENDASH will seek approval from school officials, and only approved events will be scheduled.<br/>
            c. The specific dates and times allotted during which the venue is in use, including setup and teardown times must be followed.<br/><br/>
            <b>3. Cancellation:</b><br/>
            a. CALENDASH reserves the right to cancel or reschedule an event in consultation with school officials due to unforeseen circumstances.<br/><br/>
            <b>4. Responsibilities:</b><br/>
            a. The Users are responsible for obtaining any necessary permits or permissions for the event.<br/>
            b. CALENDASH is not liable for any damages, injuries, or losses incurred during the event unless caused by gross negligence or willful misconduct.<br/>
            c. Venue should be returned after use, including cleanliness and any specific requirements for repairs or maintenance.<br/><br/>
            <b>5. Approval Process:</b><br/>
            a. The approval process involves coordination with TUP-T officials. Users are advised to submit event request letter in advance to allow for the approval process.<br/><br/>
            <b>6. Termination:</b><br/>
            a. CALENDASH reserves the right to terminate or suspend services if Users breach any material provision of these Terms.<br/><br/>
            By engaging our services, the Users acknowledge that they have read, understood, and agreed to these Terms and Conditions. These Terms may be subject to change, and Users will be notified of any revisions.</div>`,
            showCloseButton: true,
            showConfirmButton: false,
            closeButtonHtml: '<i class="fas fa-times"></i>',
            customClass: {
                closeButton: 'swal-close-button',
            }
        });
    });

    // business manager && manager
    $("#pendingOutsidersTable tbody").on("click", 'button.approveAccounts ', function (e) {
        var id = $(this).data("id");
        // e.preventDefault();
        console.log(id);

        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/admin/getUser/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                var newrole = '';
                if (data.user.role === 'outsider') {
                    newrole = 'Outsider';
                }
                //     $('#createVenueModal').modal('show');
                $('#outsiderApproveId').val(id);
                $('#outsiderApproveLastname').text(data.user.lastname);
                $('#outsiderApproveFirstname').text(data.user.firstname);
                $('#outsiderApproveRole').text(newrole);
                $("#outsiderApproveTupIDPhoto").html(
                    `<img src="/storage/${data.user.image}" width="400" height="400" style="border-radius: 20px;">`);
            },
            error: function (error) {
                console.log("error");
            },
        });

    });

    $("#approveOutsiderAccount").on("click", function (e) {

        e.preventDefault();
        // var data = $('#roleUpdateForm')[0];
        var id = $("#outsiderApproveId").val();
        console.log(id);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/admin/confirmPendingUsers/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                Swal.fire({
                    icon: "success",
                    title: "Account verified!",
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(function () {
                    window.location.href = '/outsidelist';
                }, 1500);
            },
            error: function (error) {
                console.log("error");
            },
        });

    });//end create

    $('.radiobuttonsoutsider input[type="radio"]').change(function () {

        const withinDayDiv = document.getElementById('withinTheDayDivOutsider');
        const wholeDayDiv = document.getElementById('wholeDayDivOutsider');
        const wholeWeekDiv = document.getElementById('wholeWeekDivOutsider');
        const dateRangeDiv = document.getElementById('dateRangeDivOutsider');

        const eventDate = document.getElementById('event_date_withinDayOutsider');
        const startTimeWithinDay = document.getElementById('start_time_withinDayOutsider');
        const endTimeWithinDay = document.getElementById('end_time_withinDayOutsider');
        const WholeDay = document.getElementById('event_date_wholeDayOutsider');
        const WholeWeek = document.getElementById('event_date_wholeWeekOutsider');
        const dateRange = document.getElementById('date_range_Outsider')

        if ($(this).is(':checked')) {

            if ($(this).val() === 'withinDay') {
                // console.log('labasDate');
                // $("#withinTheDayDiv").show();
                // $("#wholeDayDiv").hide();
                // $("#wholeWeekDiv").hide();

                dateRange.removeAttribute('required');
                WholeDay.removeAttribute('required');
                WholeWeek.removeAttribute('required');

                eventDate.value = "";
                startTimeWithinDay.value = "";
                endTimeWithinDay.value = "";

                withinDayDiv.style.display = 'block';
                wholeDayDiv.style.display = 'none';
                wholeWeekDiv.style.display = 'none';
                dateRangeDiv.style.display = 'none';

                startTimeWithinDay.setAttribute('required', true);
                endTimeWithinDay.setAttribute('required', true);
                eventDate.setAttribute('required', true);


            } else if ($(this).val() === 'wholeDay') {
                // console.log('wholeDayLangTalaga');
                startTimeWithinDay.removeAttribute('required');
                endTimeWithinDay.removeAttribute('required');
                eventDate.removeAttribute('required');
                dateRange.removeAttribute('required');
                WholeWeek.removeAttribute('required');

                WholeDay.value = "";

                wholeWeekDiv.style.display = 'none';
                withinDayDiv.style.display = 'none';
                wholeDayDiv.style.display = 'block';
                dateRangeDiv.style.display = 'none';

                WholeDay.setAttribute('required', true);
            } else if ($(this).val() === 'wholeWeek') {
                // console.log('wholeWeekNa')
                startTimeWithinDay.removeAttribute('required');
                endTimeWithinDay.removeAttribute('required');
                eventDate.removeAttribute('required');
                dateRange.removeAttribute('required');
                WholeDay.removeAttribute('required');

                WholeWeek.value = "";

                wholeWeekDiv.style.display = 'block';
                withinDayDiv.style.display = 'none';
                wholeDayDiv.style.display = 'none';
                dateRangeDiv.style.display = 'none';

                WholeWeek.setAttribute('required', true);
            } else {
                startTimeWithinDay.removeAttribute('required');
                endTimeWithinDay.removeAttribute('required');
                eventDate.removeAttribute('required');
                WholeWeek.removeAttribute('required');
                WholeDay.removeAttribute('required');

                dateRange.value = "";

                wholeWeekDiv.style.display = 'none';
                withinDayDiv.style.display = 'none';
                wholeDayDiv.style.display = 'none';
                dateRangeDiv.style.display = 'block';

                dateRange.setAttribute('required', true);
            }
            // console.log('Selected value:', $(this).val());
        }

    });

    //TRAPPING OF VENUES BASED ON THE INPUTED NUMBER OF PARTICIPANTS BUSINESS MANAGER;
    $('#numParticipantsOutsider').change(function () {
        const numParticipants = parseInt($(this).val());
        console.log(numParticipants);
        let venuesAvailable = false; // Flag to track if any venue is available
        $('.card_capacity').each(function () {
            const capacity = parseInt($(this).data('capacity'));
            if (numParticipants <= capacity) {
                $(this).parent().show(); // Show the whole venue card
                venuesAvailable = true; // Set the flag to true if a venue is available
            } else {
                $(this).parent().hide(); // Hide the whole venue card
            }
        });

        // Display a message if no venue is available
        if (!venuesAvailable) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                html: "No venue available for that number of participants.",
            });
        }
    });

    //Within the Day TRAPPING FOR OUTSIDER
    $('#end_time_withinDayOutsider').change(function () {
        var selectedDate = $('#event_date_withinDayOutsider').val();
        var selectedVenueID = $("input[name='event_venueOutsider']:checked").val();

        var selectedStartTime = $('#start_time_withinDayOutsider').val();
        var selectedEndTime = $(this).val();
        console.log(selectedDate);
        console.log(selectedVenueID);
        console.log(selectedStartTime);
        console.log(selectedEndTime);

        $.ajax({
            url: '/api/check-event-conflict',
            type: 'POST',
            data: {
                event_type: 'withinDay',
                date: selectedDate,
                start_time: selectedStartTime,
                end_time: selectedEndTime,
                venue_id: selectedVenueID,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.conflict) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        html: "There is an existing event with the <strong>same venue and time</strong>. Please check the calendar for available dates and time.",
                    });
                    // alert('');
                    $('#event_date_withinDayOutsider').val('');
                    $('#start_time_withinDayOutsider').val('');
                    $('#end_time_withinDayOutsider').val('');
                }

            },
            error: function (xhr, status, error) {
                console.error('Error checking event conflict:', error);
            }
        });

    });

    $('#event_date_wholeDayOutsider').change(function () {
        var selectedVenueID = $("input[name='event_venueOutsider']:checked").val();
        var selectedWholeDay = $(this).val();
        console.log(selectedWholeDay);

        $.ajax({
            url: '/api/check-event-conflict',
            type: 'POST',
            data: {
                event_type: 'wholeDay',
                date: selectedWholeDay,
                venue_id: selectedVenueID,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.conflict) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        html: "There is an existing event with the <strong>same venue and time</strong>. Please check the calendar for available dates and time.",
                    });
                    // alert('');
                    $('#event_date_wholeDayOutsider').val('');
                }

            },
            error: function (xhr, status, error) {
                console.error('Error checking event conflict:', error);
            }
        });

    });

    $('#event_date_wholeWeekOutsider').change(function () {
        var selectedVenueID = $("input[name='event_venueOutsider']:checked").val();
        var selectedWeek = $(this).val();
        console.log(selectedWeek);
        $.ajax({
            url: '/api/check-event-conflict',
            type: 'POST',
            data: {
                event_type: 'wholeWeek',
                date: selectedWeek,
                venue_id: selectedVenueID,
                selectedVenueType: selectedVenueType
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.conflict) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        html: "There is an existing event with the <strong>same venue and time</strong>. Please check the calendar for available dates and time.",
                    });
                    // alert('');
                    $('#event_date_wholeWeekOutsider').val('');
                }

            },
            error: function (xhr, status, error) {
                console.error('Error checking event conflict:', error);
            }
        });
    });

    $("#start_time_withinDayOutsider").on("click change", function (e) {
        var eventDate = $('#event_date_withinDayOutsider').val();
        if (!eventDate) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                html: "Please select an event date first.",
            });
            $('#event_date_withinDayOutsider').focus();
            $(this).val('');
            return;
        }
        // Proceed with your logic here if the event date is selected
    });

    $("#end_time_withinDayOutsider").on("click change", function (e) {
        var eventDate = $('#event_date_withinDayOutsider').val();
        var startTime = $('#start_time_withinDayOutsider').val();
        if (!eventDate) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                html: "Please select an event date first.",
            });
            $('#event_date_withinDayOutsider').focus();
            $(this).val('');
            return;
        }
        if (!startTime) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                html: "Please select a start time first.",
            });
            $('#start_time_withinDayOutsider').focus();
            $(this).val('');
            return;
        }
        // Proceed with your logic here if the event date and start time are selected
    });
    //end trapping

    $("#createEvent_submit_outsider").on("click change", function (e) {
        // alert('toggled')
        $('#spinner_outsider').addClass('spinner-border spinner-border-sm');
        // console.log(data);
        e.preventDefault();
        // // $('#serviceSubmit').show()
        let formData = new FormData($('#createEventOutsiderForm')[0]);
        console.log(formData);

        for (var pair of formData.entries()) {
            console.log(pair[0] + ',' + pair[1]);
        }
        console.log(formData)
        $.ajax({
            type: "POST",
            url: "/api/outside/storeEvent",
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
                $('#spinner').removeClass('spinner-border spinner-border-sm');
                // var $ctable = $('#ctable').DataTable();
                // $ctable.ajax.reload();
                // $ctable.row.add(data.customer).draw(false);
                // // $etable.row.add(data.client).draw(false);
                setTimeout(function () {
                    window.location.href = '/outside/myRequest';
                }, 1500);

                Swal.fire({
                    icon: 'success',
                    title: 'Event has been Requested!',
                    showConfirmButton: false,
                    timer: 3000
                })
            },
            error: function (error) {
                $('#spinner_outsider').removeClass('spinner-border spinner-border-sm');
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!"
                });
            }
        });
    });

    $("#eventOutsiderTable tbody").on("click", 'button.approveBtnOutsider', function (e) {
        var id = $(this).data("id");
        // alert(id);
        console.log(id);
        e.preventDefault();

        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/show/outsiderEvent/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                // console.log(data.venues);

                $('#approveOutsiderRequestModal').modal('show');
                $('#eventApproveId').val(data.events.id);
                $('#eventApproveName').text(data.events.event_name);
                $('#eventApproveDesc').val(data.events.description);
                $('#eventApproveRequester').val(data.events.description);
                $('#eventApproveParticipants').text(data.events.participants);
                $('#eventApproveVenue').text(data.venues.name);
                $('#eventApproveRequester').text(data.users.name);
                $("#amount").focus();


                // $("#venueEditImage").html(
                // `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);
            },
            error: function (error) {
                console.log("error");
            },
        });

        $("#eventOutsiderApprove").on("click", async function (e) {
            e.preventDefault();

            var user_id = $('#eventOutsiderId').val()
            console.log(user_id);
            var amount = $("#amount").val();

            if (amount.trim() === '') {
                Swal.fire({
                    title: "Please Input Amount",
                    icon: "warning",
                    confirmButtonText: "OK",
                    didOpen: () => {
                        $("#amount").focus(); // Focus on the amount input field
                    }
                });
            } else {
                $("#approveOutsiderRequestModal").modal('hide');
                var formattedAmount = parseFloat(amount).toLocaleString('en-US', {
                    style: 'currency',
                    currency: 'PHP'
                });

                Swal.fire({
                    title: "Please Confirm",
                    html: "Total amount to be paid: <strong>" + formattedAmount + "</strong>",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Confirm Approval"
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        const { value: password } = await Swal.fire({
                            title: "Enter your passcode to confirm approval",
                            input: "password",
                            inputLabel: "Passcode",
                            inputPlaceholder: "Enter your passcode",
                            inputAttributes: {
                                maxlength: "256",
                                autocapitalize: "off",
                                autocorrect: "off"
                            }
                        });

                        if (password) {
                            console.log(password)
                            const dataToSend = {
                                key1: password,
                                key2: user_id,
                                amount: amount
                            };
                            console.log(dataToSend);
                            console.log(id);
                            $.ajax({
                                type: "POST",
                                url: "/api/outside/storeEventAmount/" + id,
                                data: dataToSend,
                                headers: {
                                    'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (data) {
                                    console.log(data);

                                    setTimeout(function () {
                                        window.location.href = '/outside/request';
                                    }, 1500);

                                    Swal.fire({
                                        title: "Success!",
                                        text: "Done! Waiting for the receipt.",
                                        icon: "success",
                                        timer: 1500
                                    });

                                },
                                error: function (error) {
                                    console.log('error');
                                    Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: "Wrong Credentials / Passcode!",
                                        footer: '<a href="#">Why do I have this issue?</a>'
                                    });

                                }
                            });

                            // Swal.fire(`Entered password: ${password}`);
                        }

                    }
                });
                // $("#amount").val('');

            }
        });

        // Perform other actions with the id
    });

    $("#eventOutsiderStatus tbody").on("click", 'button.checkMore ', function (e) {
        // alert('dshagd')
        var id = $(this).data("id");
        // e.preventDefault();
        console.log(id);

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
                var originalSDate = new Date(data.events.start_date);
                var originalEDate = new Date(data.events.end_date);
                var origStime = moment(data.events.start_time, "HH:mm:ss")
                var origEtime = moment(data.events.end_time, "HH:mm:ss")
                var origCreatedDate = new Date(data.events.created_at);

                var formattedSTime = origStime.format("h:mm A");
                var formattedETime = origEtime.format("h:mm A");

                // var formattedCreatedTime = origCreatedDate.format("h:mm A");

                // Format the date using moment.js
                var formattedSDate = moment(originalSDate).format("MMMM D, YYYY");
                var formattedEDate = moment(originalEDate).format("MMMM D, YYYY");
                var formattedCreatedDate = moment(origCreatedDate).format("MMMM D, YYYY");

                var formattedCreatedTime = moment(origCreatedDate).format("h:mm A");

                // console.log(formattedCreatedTime);
                var dateType = data.events.type;
                var dType;
                if (dateType === 'within_day') {
                    dType = 'Within the Day';
                } else if (dateType === 'whole_day') {
                    dType = 'Whole Day';
                } else {
                    dType = 'Whole Week';
                }
                // console.log(dType);
                console.log(data.typeOfPlace);
                if (data.typeOfPlace === 'Room') {
                    $('#eventStatusVenue').val(data.rooms.name);
                } else if (data.typeOfPlace === 'Venue') {
                    $('#eventStatusVenue').val(data.venues.name);
                } else {
                    // Handle other cases if needed
                }
                $('#checkMoreModal').modal('show');
                // $('#eventStatusText').text(data.penmsg);
                $('#eventDateRequestedText').text(formattedCreatedDate + ' ' + formattedCreatedTime);
                $('#eventStatusName').val(data.events.event_name);
                $('#eventStatusDesc').val(data.events.description);
                $('#eventStatusParticipants').val(data.events.participants);
                // $('#eventStatusVenue').val(data.venues.name);
                $('#eventStatusDateType').val(dType);
                $('#eventStatusStartDate').val(formattedSDate);
                $('#eventStatusEndDate').val(formattedEDate);
                $('#eventStatusSTime').val(formattedSTime);
                $('#eventStatusETime').val(formattedETime);

                // Apply styling based on the value
                // if (statusValue === 'APPROVED') {
                //     statusElement.addClass('badge badge-sm border border-success text-success');
                // } else {
                //     statusElement.addClass('badge badge-sm border border-warning text-warning');
                // }
                // $("#venueEditImage").html(
                // `<img src="/storage/${data.Venues.image}" width="100" class="img-fluid img-thumbnail">`);
            },
            error: function (error) {
                console.log("error");
            },
        });

        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/myOutsiderEventStatus/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $('#statusList').empty();
                // $('#checkStatusModal').modal('show');
                // console.log(data.pendingMsg);
                $('#eventStatusText').html(data.pendingMsg);

                var statusElement = $('#eventStatusText');
                // console.log(statusElement)
                // Get the value from the element's text content
                var statusValue = $('#eventStatusText').text();

                statusElement.removeClass();
                // Apply styling based on the value
                if (statusValue === 'REJECTED') {
                    statusElement.addClass('badge badge-sm border border-danger text-danger');
                } else if (statusValue === 'APPROVED') {
                    statusElement.addClass('badge badge-sm border border-success text-success');
                }
                else {
                    statusElement.addClass('badge badge-sm border border-warning text-warning');
                }

                $.each(data.dates, function (index, item) {
                    // console.log(item);
                    // console.log(index);
                    // console.log(item)
                    // console.log(data.msg);
                    var formattedDate = moment(item, 'YYYY-MM-DD HH:mm:ss').format('MMMM D, YYYY');
                    var formattedTime = moment(item, 'YYYY-MM-DD HH:mm:ss').format('h:mm A');
                    console.log(formattedTime);


                    if (data.msg && data.msg[index]) {
                        var statusValue = $('#eventStatusText').text();
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

                });



            },
            error: function (error) {
                console.log("error");
            },
        });
    });//end event status table


    // $("#eventOutsiderStatus tbody").on("click", 'button.uploadImg ', async function (e) {
    //     const { value: file } = await Swal.fire({
    //         title: "Select image",
    //         input: "file",
    //         inputAttributes: {
    //           "accept": "image/*",
    //           "aria-label": "Upload your profile picture"
    //         }
    //       });
    //       if (file) {
    //         const reader = new FileReader();
    //         reader.onload = (e) => {
    //             Swal.fire({
    //                 title: "Confirm Image Upload",
    //                 text: "Is this the image you want to upload?",
    //                 imageUrl: e.target.result,
    //                 imageWidth: 400,
    //                 imageHeight: 700,
    //                 imageAlt: "Uploaded image",
    //                 showCancelButton: true,
    //                 confirmButtonText: "Yes",
    //                 cancelButtonText: "Cancel"
    //             }).then((result) => {
    //                 if (result.isConfirmed) {
    //                     // Image confirmed, proceed with success alert
    //                     Swal.fire({
    //                         title: "Success!",
    //                         text: "Image uploaded successfully.",
    //                         icon: "success"
    //                     });
    //                 } else {
    //                     // Image not confirmed, show cancellation message
    //                     Swal.fire({
    //                         title: "Cancelled",
    //                         text: "Image upload cancelled.",
    //                         icon: "error"
    //                     });
    //                 }
    //             });
    //         //   Swal.fire({
    //         //     title: "Your uploaded picture",
    //         //     imageUrl: e.target.result,
    //         //     imageAlt: "The uploaded picture"
    //         //   });

    //         //   Swal.fire({
    //         //     icon: "success",
    //         //     title: "Your work has been saved",
    //         //     showConfirmButton: false,
    //         //     timer: 1500
    //         //   });
    //         };
    //         reader.readAsDataURL(file);
    //       }
    // })
    $("#eventOutsiderStatus tbody").on("click", 'button.uploadImg', async function (e) {
        var id = $(this).data("id");
        console.log(id);
        const { value: file } = await Swal.fire({
            title: "Select image",
            input: "file",
            inputAttributes: {
                "accept": "image/*",
                "aria-label": "Upload your profile picture"
            }
        });

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                Swal.fire({
                    title: "Confirm Image Upload",
                    text: "Is this the image you want to upload?",
                    imageUrl: e.target.result,
                    imageWidth: 400,
                    imageHeight: 700,
                    imageAlt: "Uploaded image",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Image confirmed, proceed with AJAX upload
                        const formData = new FormData();
                        formData.append('image', file);

                        $.ajax({
                            url: '/api/upload-receipt/' + id,
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                Swal.fire({
                                    title: "Success!",
                                    text: "Image uploaded successfully.",
                                    icon: "success"
                                });
                            },
                            error: function (xhr, status, error) {
                                Swal.fire({
                                    title: "Error",
                                    text: "Failed to upload image.",
                                    icon: "error"
                                });
                            }
                        });
                    } else {
                        // Image not confirmed, show cancellation message
                        Swal.fire({
                            title: "Cancelled",
                            text: "Image upload cancelled.",
                            icon: "error"
                        });
                    }
                });
            };

            reader.readAsDataURL(file);
        }
    });


    $("#eventOutsiderTable tbody").on("click", 'button.approveBtnOutsiderReceipt', async function (e) {
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/show/outsiderEvent/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                var img = data.events.receipt_image;
                var imageUrl = window.location.origin +'/storage/' + img;
                console.log(imageUrl);

                Swal.fire({
                    title: "Confirm Reciept Upload",
                    text: "This is the uploaded receipt",
                    imageUrl: imageUrl,
                    imageWidth: 400,
                    imageHeight: 700,
                    imageAlt: "Uploaded image",
                    showCancelButton: true,
                    confirmButtonText: "Approve",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Image confirmed, proceed with AJAX upload
                        
                        $.ajax({
                            url: '/api/approve-receipt/' + id,
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                Swal.fire({
                                    title: "Success!",
                                    text: "Event successfully approved!.",
                                    icon: "success"
                                });
                            },
                            error: function (xhr, status, error) {
                                Swal.fire({
                                    title: "Error",
                                    text: "Failed to upload image.",
                                    icon: "error"
                                });
                            }
                        });
                    } else {
                        // Image not confirmed, show cancellation message
                        Swal.fire({
                            title: "Cancelled",
                            text: "Image upload cancelled.",
                            icon: "error"
                        });
                    }
                });


            },
            error: function (error) {
                console.log("error");
            },
        });
    });

    /////// REJECTION OF OUTSIDER ///////////
    $("#eventOutsiderTable tbody").on("click", 'button.rejectBtnOutsider', async function (e) {
        var id = $(this).data('id');
        var user_id = $('#eventOutsiderId').val();
        console.log(user_id);
        // console.log(id);
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, reject it!"
          }).then(async(result) => {
            if (result.isConfirmed) {
            //   Swal.fire({
            //     title: "Deleted!",
            //     text: "Your file has been deleted.",
            //     icon: "success"
            //   });
            const { value: text, dismiss: action } = await Swal.fire({
                input: "textarea",
                inputLabel: "Reason of rejection",
                inputPlaceholder: "Type your message here...",
                inputAttributes: {
                  "aria-label": "Type your message here"
                },
                showCancelButton: true, // Add this line to show the cancel button
                confirmButtonText: "Reject",
                cancelButtonText: "Cancel"
              });

              if (text) {
                // User entered a reason for rejection
                const dataToSend = {
                    key1: text,
                    key2: user_id
                };
                
                $.ajax({
                    url: '/api/reject-outsider-event/' + id,
                    type: 'POST',
                    data: JSON.stringify(dataToSend),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        console.log(response);
                        Swal.fire({
                            title: "Success!",
                            text: "Event Rejected.",
                            icon: "success"
                        });
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: "Error",
                            text: "Failed to reject event.",
                            icon: "error"
                        });
                    }
                });
                // Proceed with rejection logic...
              } else {
                // User canceled the action
                Swal.fire({
                  title: "Cancelled",
                  text: "Action cancelled.",
                  icon: "error"
                });
              }
            }
          });
    })

    ///////////////////// change of passcode ///////////////
    $('#currentPasscode').on('keyup', function () {
        var currentInput = $(this).val();
        var user_id = $("#user_id").val();
        const dataToSend = {
            currentPasscode: currentInput,
            user_id: user_id
        };
    
        $.ajax({
            url: '/api/me/check-passcode',
            type: 'POST',
            data: JSON.stringify(dataToSend),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.message === 'Passcode matched!'){
                    $('#passcodeCheckResult').text(response.message);
                    $('#passcodeCheckResult').removeClass('text-danger');
                    $('#passcodeCheckResult').addClass('text-success');
                } 
                else{
                    $('#passcodeCheckResult').text(response.message);
                    $('#passcodeCheckResult').addClass('text-danger');
                    $('#passcodeCheckResult').removeClass('text-success');
                }
            },
            error: function (xhr, status, error) {
                $('#passcodeCheckResult').text('Failed to check passcode.');
            }
        });
    });
    
    $('#passcodeSubmit').on('click', function (e) {
        e.preventDefault();
        var user_id = $('#user_id').val();
        var passcode = $('#retypeNewPasscode').val();

        const dataToSend = {
            user_id: user_id,
            passcode: passcode,
        };
    
        $.ajax({
            url: '/api/me/update-passcode',
            type: 'POST',
            data: JSON.stringify(dataToSend),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response);
                // Handle success response
                setTimeout(function () {
                    window.location.href = '/me/change-passcode';
                }, 1500);

                Swal.fire({
                    icon: "success",
                    title: "Passcode Updated",
                    showConfirmButton: false,
                    timer: 1500
                  });
            },
            error: function (xhr, status, error) {
                // Handle error response
                console.error(xhr.responseText);
                $('#passcodeUpdateResult').text('Failed to update passcode');
            }
        });
    });
})