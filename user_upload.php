<?php
class CliBuilder
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
  behaviour_handler = new CliBuilder(); // TODO(destroy)

  $my_connection = mysqli_connect(behaviour_handler->get_database(),
    behaviour_handler->get_username(),
    behaviour_handler->get_password())
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

  echo "Testing to see Users.csv file-contents: $users_data";

  $lowercase_regex = "/^(?:([a-z]))$/";
  $valid_email_regex = "^(?:[a-z+])|(?:[\W+])$";
  $titlecase_regex = "/^(?:([A-Z]{1,1}))(?:(\w+))$/";

  $captured_arr = array();

  foreach ($users_data as $key_name => $key_value) {
    # code...
    if ($key_name == "name" || $key_name == "surname")
      preg_match($titlecase_regex, $key_value, $captured_arr, PREG_OFFSET_CAPTURE);

    if ($key_name == "email") {
      preg_match($valid_email_regex, $key_value, $captured_arr, PREG_OFFSET_CAPTURE);
      preg_match($lowercase_regex, $key_value, $captured_arr, PREG_OFFSET_CAPTURE);
    }

    print_r($captured_arr);
  }

  return $captured_arr;
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

function behaviour_handler_sentinel($behaviour_handler_self, $user_arguments)
{
  $behaviour_handler_self = new CliBuilder(); // destroy later
  $command_slices = array(
    parse_str(
      implode(" ", array_slice($user_arguments, 1)), $_GET
    ),
    array(
      parse_str(
        implode(" ", array_slice($user_arguments, 1)), $_GET))
  ); // change separator for `implode` into whitespace instead of ampsersand

  foreach ($command_slices as $command_args) {
    behaviour_handler_sentinel($behaviour_handler_self, $command_args);

    $command_args = strtolower($command_args);
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

    $parsed_args = array(
      "--file" => organise_user_csv(),
      "--create_table" => create_table_with_csv(),
      "--dry_run" => handle_stdio_filed_command($user_arguments),
      "-u" => $behaviour_handler_self->set_username($user_arguments),
      "-p" => $behaviour_handler_self->set_password($user_arguments),
      "-h" => $behaviour_handler_self->set_database($user_arguments),
      "--help" => $help_heredoc
    );

    foreach ($parsed_args as $ret_val) {
      print_r("Parsed Argument return-value before assignment: $ret_val");
      if ($user_arguments == $ret_val) {
        print_r("Sanitised User Argument before re-assignment: $user_arguments");
        $user_arguments = $ret_val;
        print_r("Sanitised User Argument AFTER re-assignment: $user_arguments");
      }
    }
  }

  print_r("User Command Arguments after Sentinel/Sanitisation handling: $user_arguments");
  return $user_arguments;
}

function build_commandline_directives($user_commands)
{
  behaviour_handler = new CliBuilder(); // destroy later
  $command_slices = behaviour_handler_sentinel(behaviour_handler, $user_commands);

  echo "Please run: `php --run --help` for additional arguments...";

  foreach ($command_slices as $command_args) {

    switch ($command_args) {
      case "--file":
        # code...check iterable argument columns
        print_r("Params variable before STDIO handling: $command_args");
        handle_stdio_filed_command($command_args);
        print_r("Params variable AFTER STDIO handling: $command_args");
        break;

      case "--create_table":
        create_table_with_csv();
        break;

      case "--dry_run":
        organise_user_csv();
        break;

      case "-u":
        $username_beforehand = behaviour_handler->get_username();
        print_r("Username before before switch: $username_beforehand");

        behaviour_handler->set_username($command_args);
        print_r("Username before AFTER switch: $username_beforehand");
        break;

      case "-p":
        $password_ret_val = behaviour_handler->get_password();
        print_r("Password before before switch: $password_ret_val");

        behaviour_handler->set_password($command_args);
        print_r("Password before AFTER switch: $password_ret_val");
        break;

      case "-h":
        $database_hostname = behaviour_handler->get_database();
        print_r("Database hostname before before switch: $database_hostname");

        behaviour_handler->set_database($command_args);
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

        echo $help_heredoc;
        break;

      default:
        # code...
        break;
    }
  }
}
