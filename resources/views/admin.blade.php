<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
    <title>Admin</title>
    <!-- Add a meta tag to include the CSRF token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <nav class="navbar">
        <div class="link-cont">
            <div class="link">
                <a href="reviewdelete.php">Reviews and Ratings</a>
            </div>
            <div class="link">
                <a href="movie.php">Movies</a>
            </div>
            <div class="link">
                <a href="dashboard.php">Log Out</a>
            </div>
        </div>
    </nav>

    <input type="text" id="searchInput" placeholder="Search users...">

    <div class="form-container">
        <form id="addUserForm">
            <input type="text" id="email" name="email" placeholder="Email" autocomplete="email">
            <input type="password" id="password" name="password" placeholder="Password" autocomplete="current-password">
            <input type="hidden" id="editUserId" name="editUserId"> <!-- Add this hidden field -->
            <input type="submit" value="Add">
        </form>
    </div>

    <div id="usersTable">
        <table class="users-table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="usersBody"></tbody>
        </table>
    </div>

    <script>
        //search function
        $('#searchInput').on('input', function() {
            var searchValue = $(this).val().toLowerCase();
            $('#usersBody tr').each(function() {
                var email = $(this).find('td:nth-child(1)').text().toLowerCase();

                if (email.includes(searchValue)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        $(document).ready(function() {
            loadUsers();
        });

        /* Users list */
        function loadUsers() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('users.get') }}", // Use the route defined in Laravel
                method: "POST",
                data: {
                    "getUsers": true,
                },
                dataType: "json",
                success: function(data) {
                    var tBody = "";

                    if (data.length > 0) {
                        data.forEach(function(user) {
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
                error: function(error) {
                    console.log(error);
                    alert("Oops, something went wrong!");
                }
            });
        }
    </script>
</body>

</html>
