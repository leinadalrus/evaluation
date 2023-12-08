<?php
class InputHandleCommand
{
  private $database = "localhost";
  private $username = "danieldavid";
  private $password = "johnDoe1!";

  public function set_database($database)
  {
    $this->database = $database;
  }

  public function set_username($username)
  {
    $this->username = $username;
  }

  public function set_password($password)
  {
    $this->password = $password;
  }

  public function get_database()
  {
    return $this->database;
  }

  public function get_username()
  {
    return $this->username;
  }

  public function get_password()
  {
    return $this->password;
  }
}

function connect_to_mysqli()
{
  $behaviour_handle_command = new InputHandleCommand(); // TODO(destroy)

  $my_connection = mysqli_connect($behaviour_handle_command->get_database(),
    $behaviour_handle_command->get_username(),
    $behaviour_handle_command->get_password())
    or die("MySQL connection: failed..." . mysqli_error($my_connection));

  mysqli_select_db($my_connection, "users")
    or die("MySQL: database selection failed...");

  $sql_queries = mysqli_query($my_connection, "SELECT * from users")
    or die("SQL Query to select from table: Users, failed...");

  while ($rows = mysqli_fetch_array($sql_queries, MYSQL_ASSOC)) {
    foreach ($rows as $row => $column) {
      # code...
    }
  }

  mysqli_close($my_connection);
}

function organise_user_csv()
{
  $csv_handler = fopen("users.csv", "r");
  $users_data = fgetcsv($csv_handler, 1024, ",");

  $lowercase_regex = "/^(?:([a-z]))$/";
  $valid_email_regex = "^(?:[a-z+])|(?:[\W+])$";
  $titlecase_regex = "/^(?:([A-Z]{1,1}))(?:(\w+))$/";
  $captured_arr = array();

  $cstdio_input = fgets(STDIN);
  $cstdio_output = "";
  fwrite(STDOUT, $cstdio_output);

  foreach ($users_data as $key_name => $key_value) {
    # code...
    preg_match($titlecase_regex, $key_value, $captured_arr, PREG_OFFSET_CAPTURE);
    print_r($captured_arr);
  }
}

function create_table_with_csv()
{
  connect_to_mysqli();
}

function handle_stdio_filed_command($filepathn_name)
{
  $cstdio_output = file($filepathn_name);
  fwrite(STDOUT, $cstdio_output);

  do {
    $read_line = fgets(STDIN);
  } while ($read_line == "");

  return $read_line;
}

function build_commandline_directives($user_command, $user_param)
{
  $behaviour_handle_command = new InputHandleCommand(); // destroy later

  $command_slices = array(
    parse_str(
      implode("&", array_slice($user_command, 1)), $_GET
    ),
    array(
      parse_str(
        implode("&", array_slice($user_param, 1)), $_GET))
  );

  echo "Please run: `php --run --help` for additional arguments...";

  foreach ($command_slices as $commands => $params) {
    switch ($commands) {
      case "--file":
        # code...check iterable argument columns
        print_r("Params variable before STDIO handling: $params");
        handle_stdio_filed_command($params);
        print_r("Params variable AFTER STDIO handling: $params");
        break;

      case "--create_table":
        create_table_with_csv();
        break;

      case "--dry_run":
        organise_user_csv();
        break;

      case "-u":
        $username_beforehand = $behaviour_handle_command->get_username();
        print_r("Username before before switch: $username_beforehand");
        $behaviour_handle_command->set_username($params);
        print_r("Username before AFTER switch: $username_beforehand");
        break;

      case "-p":
        $password_ret_val = $behaviour_handle_command->get_password();
        print_r("Password before before switch: $password_ret_val");
        $behaviour_handle_command->set_password($params);
        print_r("Password before AFTER switch: $password_ret_val");
        break;

      case "-h":
        $database_hostname = $behaviour_handle_command->get_database();
        print_r("Database hostname before before switch: $database_hostname");
        $behaviour_handle_command->set_database($params);
        print_r("Database hostname before AFTER switch: $database_hostname");
        break;

      case "--help":
        $help_heredoc = <<<HERE
        Run this script with the PHP CLI, in your terminal.\n
        `php --run ...`e.g:\n
        `--file` : to run a specific file,\n
        `--create_table` : to create a MySQL table,\n
        `--dry_run` : to solely run the script without Database Table creation,\n
        `-u` : set your MySQLi username,\n
        `-p` : set your MySQLi password,\n
        `-h` : set your MySQLi database hostname.
        HERE;
        break;

      default:
        # code...
        break;
    }
  }
}
