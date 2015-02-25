Note regarding database connection parameters
---------------------------------------------

Most of the database connection function calls (mysqli_connect) in the
.php files included here use the 'root' username and a fictitious
'password' password. To use these scripts, you will have to change the
username and password for all the files to your actual database username
and password.

The scripts also use 'ijdb' as the database name in the mysqli_select_db
calls. Be sure to set the name to match that on your server.