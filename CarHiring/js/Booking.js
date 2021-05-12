/**
 * @desc A closure that manages bookings.
 * @requires JQuery
 * @author William Duggan
 */
var Booking = (function () {
    "use strict";
    var pub = {};
    var bookings; //existing bookings

    /**
     * A function to start the various procedures that are involved in
     * ensuring only valid dates are chosen
     */
    function showAvailable() {
        $("#dateErrors").empty();
        var arriveDate = $("#arriveDatepicker");
        var departDate = $("#departDatepicker");

        checkDates();
        disableDateClash(arriveDate, departDate);
    }

    /**
     * Checks dates for basic problems.
     * Put error messages in place as necessary
     */
    function checkDates() {
        if ($("#departDatepicker").datepicker('getDate') < $("#arriveDatepicker").datepicker('getDate')) {
            $("#dateErrors").append("<p>You must pickup before you dropoff</p>");
        }
        if ($("#departDatepicker").val() === "" || $("#arriveDatepicker").val() === "") {
            $("#dateErrors").append("<p>You must select both pickup and dropoff dates</p>");
        }
        if ($("#arriveDatepicker").datepicker('getDate') < new Date()) {
            $("#dateErrors").append("<p>We only accept bookings in the future</p>");
        }
    }


    /**
     * Disables vehicles that are already booked for the chosen dates.
     * @param pickup The pickup date
     * @param dropoff The dropoff date
     */
    function disableDateClash(pickup, dropoff) {
        var existingBookingPickup, existingBookingDropoff;

        //reset the inputs to selectable etc
        $("#accommTypeLst li").css("background-color", 'inherit');
        $("#accommTypeLst input").attr("disabled", false);

        //check the proposed booking against all current bookings
        $.each(bookings, function (k, v) {
            existingBookingPickup = new Date(v.pickup.year, v.pickup.month - 1, v.pickup.day);//-1 cos months start at 0
            existingBookingDropoff = new Date(v.dropoff.year, v.dropoff.month - 1, v.dropoff.day);
            //see if there is a clash with a particular previous booking
            //disable checkbox if there is a clash
            if (pickup.datepicker('getDate') > existingBookingPickup && pickup.datepicker('getDate') < existingBookingDropoff ||
                dropoff.datepicker('getDate') > existingBookingPickup && dropoff.datepicker('getDate') < existingBookingDropoff) {
                $("#" + (v.number).replace(/\s+/g, '')).css('background-color', 'gray');
                $("#" + (v.number).replace(/\s+/g, '') + " input").prop("checked", false);
                $("#" + (v.number).replace(/\s+/g, '') + " input").attr("disabled", true);
            }
        });
    }


    /**
     * Returns true if all information is entered, false otherwise.
     * @return {boolean}
     */
    function validateBookingInformation() {
        var selectionMade = false;

        $("#dateErrors").empty();
        if ($("#guestName").val() === "") {
            $("#dateErrors").append("<p>We need your name please</p>");
            return false;
        }

        $('input[name="vehicle"]').each(function () {
            if ($(this).prop("checked") === true) {
                selectionMade = true;
            }
        });

        if (!selectionMade) {
            $("#dateErrors").append("<p>You need to select a vehicle</p>");
            return false;
        }
        return selectionMade;
    }

    /**
     * A function that calls the Ajax method
     */
    function callAjax(test) {
        //send booking to remove to server-side
        $.ajax({
            async: false,
            type: "POST",
            url: 'htaccess/addBooking.php',
            cache: false,
            data: test,
            datatype: 'JSON',
            contentType: "application/json; charset=utf-8",
            success: function (data) {
                alert("Booking added successfully");
                // location.reload();
            },
            error: function (data) {
                alert("Ajax cancellation failed");
            }
        });
    }

    /**
     * A function that makes the actual booking
     * Currently it is written to localStorage but later it will
     * be sent to the server and stored there
     * @return {boolean}
     */
    function makeBooking() {
        var newBooking = {};
        var registration;

        //find out which site is selected
        $('input[name="vehicle"]').each(function () {
            if ($(this).prop("checked") === true) {
                registration = $(this).parent().attr("id");
            }
        });

        //populate the newBooking object
        newBooking.number = registration;
        newBooking.name = $("#guestName").val();
        newBooking.pickup = {};
        newBooking.dropoff = {};
        newBooking.pickup.day = $("#arriveDatepicker").datepicker('getDate').getDate();
        newBooking.pickup.month = $("#arriveDatepicker").datepicker('getDate').getMonth() + 1;
        newBooking.pickup.year = $("#arriveDatepicker").datepicker('getDate').getFullYear();
        newBooking.dropoff.day = $("#departDatepicker").datepicker('getDate').getDate();
        newBooking.dropoff.month = $("#departDatepicker").datepicker('getDate').getMonth() + 1;
        newBooking.dropoff.year = $("#departDatepicker").datepicker('getDate').getFullYear();

        //Do final check and write to localStorage
        if (validateBookingInformation()) {
            window.localStorage.setItem('vehicleBookings', JSON.stringify(newBooking));
            var test = JSON.stringify(newBooking);
            console.log(test);
            callAjax(test);
            return true; //so the form will submit
        } else {
            return false; //supress form submission
        }
    }

    function addToBookings() {
        var newBooking;
        //get the data for the existing bookings and assign to global
        $.getJSON("./json/bookings.json", function (data) {
            bookings = data.bookings.booking;
            newBooking = JSON.parse(window.localStorage.getItem('vehicleBookings'));
            bookings.append(newBooking);
            alert(bookings);
        });
    }


    pub.setup = function () {
        //set up the jQueryUI datepickers and event handling
        var today = new Date();
        $("#checkAvail").click(showAvailable);
        $("#arriveDatepicker").datepicker().datepicker('setDate', today).mouseleave(showAvailable);
        $("#departDatepicker").datepicker().datepicker('setDate', new Date(today.getTime() + 86400000)).mouseleave(showAvailable);

        $("#bookingForm").submit(makeBooking);
        $("#makeBooking").mouseover(showAvailable);

        // addToBookings();
    };


    return pub;
}());

$(document).ready(Booking.setup);