/**
 * @desc A closure that manages the Admin page
 * @requires JQuery
 * @author William Duggan
 */
var Admin = (function () {
    "use strict";
    var pub = {};

    pub.setup = function () {
        var s = "<table><tr><th>Name</th><th>Vehicle</th><th>Pickup Date</th><th>Dropoff Date</th></tr>";
        var bookings = [];
        $.getJSON("./json/bookings.json", function (data) {
            bookings = data.bookings.booking;
            console.log(bookings);
            $.each(bookings, function (k, v) {
                console.log(v.number);
                s += "<tr><td>" + v.name +
                    "</td><td>" + v.number +
                    "</td><td>" + v.pickup.day + ":" + v.pickup.month + ":" + v.pickup.year +
                    "</td><td>" + v.dropoff.day + ":" + v.dropoff.month + ":" + v.dropoff.year + "</td>";
            });
            s += "</table>";
            $("#currentBookings").append(s);
        });
    };

    return pub;
}());

$(document).ready(Admin.setup);