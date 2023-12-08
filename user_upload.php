<?php
function connect_to_mysqli() {
  $database = "localhost"
  $username = "danieldavid";
  $password = "johnDoe1!";

  $my_connection = mysql_connect($database, $username, $password) 
    or die("MySQL connection: failed...". mysql_error());

  mysql_select_db("users") 
    or die("MySQL: database selection failed...");

  $sql_queries = mysql_query("SELECT * from users") 
    or die("SQL Query to select from table: Users, failed...");

  while ($rows = mysql_fetch_array($sql_queries, MYSQL_ASSOC)) {
    foreach ($rows as $key_name => $key_value) {
      # code...
    }
  }

  mysql_close($my_connection);
}

function organise_user_csv() {
  $csv_handler = fopen("users.csv", "r");
  $users_data = fgetcsv($csv_handler, 1024, ",");

  $lowercase_regex = "/^(?:([a-z]))$/";
  $valid_email_regex = "^(?:[a-z+])|(?:[\W+])$";
  $titlecase_regex = "/^(?:([A-Z]{1,1}))(?:(\w+))$/";
  $captured_arr = array();

  $cstdio_input = fgets(STDIN);
  $cstdio_output = "";
  fwrite(STDOUT, $cstdio_output);

  foreach ($user_data as $key_name => $key_value) {
    # code...
    preg_match($titlecase_regex, $key_value, captured_arr, PREG_OFFSET_CAPTURE);
    print_r($captured_arr);
  }

}

function build_commandline_directives($user_command, $user_param) {
  switch ($user_command) {
    case "--file":
      # code...check iterable argument columns
      break;

    case "--create_table":
      break;

    case "--dry_run":
      break;

    case "-u":
      break;

    case "-p":
      break;

    case "-h":
      break;

    case "--help":
      break;
    
    default:
      # code...
      break;
  }
}
