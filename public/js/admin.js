$(document).ready(function () {
    loadUsers();
});

/* Users list */
function loadUsers() {
    $.ajax({
        url: "adminact.php",
        method: "POST",
        data: {
            "getUsers": true,
        },
        dataType: "json",
        success: function (data) {
            var tBody = "";

            if (data.length > 0) {
                data.forEach(function (user) {
                    if (user['role'] === 'user') {
                        tBody += `<tr id="${user['id']}">`; // Added id attribute
                        tBody += `<td>` + user['email'] + `</td>`;
                        tBody += `<td>` + user['password'] + `</td>`;
                        tBody += `<td>` + user['role'] + `</td>`;
                        tBody += `<td>
                            <button onclick="updateUsers(${user['id']})">Edit</button>
                            <button onclick="deleteUsers(${user['id']})">Delete</button>
                        </td>`;
                        tBody += `</tr>`;
                    }
                });
            } else {
                tBody = `<tr><td colspan="4">No users found</td></tr>`;
            }

            $('#usersBody').html(tBody);
        },
        error: function (error) {
            console.log(error);
            alert("Oops, something went wrong!");
        }
    });
}

function updateUsers(id) {
    var email = $("#" + id + " td:eq(0)").text();
    var password = $("#" + id + " td:eq(1)").text();

    $("#editUserId").val(id); // Set the value of editUserId
    $("input[name='email']").val(email);
    $("input[name='password']").val(password);

    // Change the form submit button text to 'Update'
    $("input[type='submit']").val("Update");
}

$("#addUserForm").submit(function (event) {
    event.preventDefault();
    var editUserId = $("#editUserId").val();

    if (editUserId) {
        var datas = $(this).serializeArray();
        var data_array = {};

        $.map(datas, function (data, index) {
            data_array[data['name']] = data['value'];
        });

        $.ajax({
            type: "POST",
            url: "adminact.php",
            data: {
                "updateUsers": true,
                "id": editUserId,
                "datas": data_array,
            },
            success: function (result) {
                    // Reset the form and change the button text back to 'ADD'
                    $("input[type='submit']").val("ADD");
                    $("#editUserId").val("");
                    $("#addUserForm")[0].reset();
                    loadUsers();
            },
            error: function (error) {
                console.log(error);
                alert("Oops, something went wrong!");
            }
        });
    } else {
        var datas = $(this).serializeArray();
        var data_array = {};

        $.map(datas, function (data, index) {
            data_array[data['name']] = data['value'];
        });

        $.ajax({
            type: "POST",
            url: "adminact.php",
            data: {
                "addUsers": true,
                "datas": data_array,
            },
            success: function (result) {
                console.log(result);
                /* alert("Successful"); */
                loadUsers();
                $("#addUserForm")[0].reset();
            },
            error: function (error) {
                console.log(error);
                alert("Oops, something went wrong!");
            }
        });
    }
});

/* Delete */
function deleteUsers(userId) {
    $.ajax({
        url: "adminact.php",
        method: "POST",
        data: {
            "deleteUsers": true,
            "id": userId
        },
        success: function (result) {
            loadUsers();
        },
        error: function (error) {
            console.log(error);
            alert("Oops, something went wrong while deleting!");
        }
    });
}

$(document).ready(function() {

    // Function to get and display ratings
    function displayRatings() {
        $.ajax({
            type: 'POST',
            url: 'adminact.php', // URL to fetch ratings
            data: {
                getRatings: true
            },
            success: function(response) {
                var ratings = JSON.parse(response);
                if (ratings.length > 0) {
                    var table = '';

                    ratings.forEach(function(rating) {
                        table += '<tr>';
                        table += '<td>' + rating.id + '</td>';
                        table += '<td>' + rating.movie_title + '</td>';
                        table += '<td>' + rating.rating + '</td>';
                        table += '<td>' + rating.review + '</td>';
                        table += '<td><button onclick="deleteRating(' + rating.id + ')">Delete</button></td>';
                        table += '</tr>';
                    });

                    $('#ratingsBody').html(table); // Display ratings in the specified tbody
                } else {
                    $('#ratingsBody').html('<tr><td colspan="5">No ratings found</td></tr>');
                }
            },
            error: function() {
                $('#ratingsBody').html('<tr><td colspan="5">Error fetching ratings</td></tr>');
            }
        });
    }
    $(document).on('click', '#ratingsBody button', function() {
        var ratingId = $(this).closest('tr').find('td:first').text();
        deleteRating(ratingId);
    });
    // Function to delete a rating
    function deleteRating(id) {
        $.ajax({
            type: 'POST',
            url: 'adminact.php', // URL to delete rating
            data: {
                deleteRating: true,
                id: id
            },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    // Refresh the ratings after successful deletion
                    displayRatings();
                    alert('Rating deleted successfully!');
                } else {
                    alert('Failed to delete rating!');
                }
            },
            error: function() {
                alert('Error: Unable to delete rating!');
            }
        });
    }
    // Call the function to display ratings when the page loads
    displayRatings();
});