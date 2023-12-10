<?php
declare(strict_types=1);

namespace leinadalrus;

class CliBuilder
{
  private $username = "admin";
  private $password = "root";
  private $hostname = "localhost";

  function __construct()
  {
  }

  function __destruct()
  {
  }

  public function get_hostname()
  {
    return $this->hostname;
  }

  public function get_username()
  {
    return $this->username;
  }

  public function get_password()
  {
    return $this->password;
  }

  public function set_username($_username)
  {
    $this->username = $_username;
  }

  public function set_password($_password)
  {
    $this->password = $_password;
  }

  public function set_hostname($_hostname)
  {
    $this->hostname = $_hostname;
  }

  public function connect_to_database()
  {
    $behaviour_handler = new CliBuilder();

    $my_connection = mysqli_connect($behaviour_handler->get_hostname(),
      $behaviour_handler->get_username(),
      $behaviour_handler->get_password())
      or die("MySQL connection: failed..." . mysqli_error($my_connection));

    mysqli_select_db($my_connection, "users")
      or die("MySQL: database selection failed...");

    echo "Create MySQLi table: 'users', and load infile 'users.csv'";

    mysqli_query($my_connection,
      "LOAD DATA INFILE \"users.csv\" 
      INTO TABLE users FIELDS TERMINATED BY \",\" 
      ENCLOSED BY '\"' LINES TERMINATED BY \"\n\" IGNORE 1 ROWS") 
      or die("SQL Query to select from table: Users, failed...");

    mysqli_close($my_connection);
  }

  public function organise_user_data()
  {
    $csv_handler = fopen("users.csv", "r");
    $users_data = fgetcsv($csv_handler, 1024, ",");

    $lowercase_regex = "/^(?:([a-z]))$/";
    $valid_email_regex = "^(?:[a-z+])|(?:[\W+])$";
    $titlecase_regex = "/^(?:([A-Z]{1,1}))(?:(\w+))$/";

    $captured_arr = array();

    foreach ($users_data as $key_name => $key_value) {
      # code...
      if ($key_name == "name" || $key_name == "surname")
        preg_match($titlecase_regex,
          $key_value,
          $captured_arr,
          PREG_OFFSET_CAPTURE);

      if ($key_name == "email") {
        preg_match($valid_email_regex,
          $key_value, $captured_arr,
          PREG_OFFSET_CAPTURE);
        preg_match($lowercase_regex,
          $key_value,
          $captured_arr,
          PREG_OFFSET_CAPTURE);
      }

      print_r($captured_arr);
    }

    return $captured_arr;
  }

  public function create_table()
  {
    $this->connect_to_database();
    $this->organise_user_data();
  }

  public function dry_run()
  {
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

    $permission_mode = "r";
    $filestream_type = "php://stdin";
    $filestream_stdin = fopen($filestream_type, $permission_mode);

    $command_arguments = array(
      "--file" => $filestream_stdin,
      "--create_table" => $this->create_table(),
      "--dry_run" => $this->dry_run($this->input_interface),
      "-u" => $this->set_username($filestream_type),
      "-p" => $this->set_password($filestream_type),
      "-h" => $this->set_hostname($filestream_type),
      "--help" => print_r($help_heredoc)
    );

    while (1) {
      if ($filestream_stdin !== false)
        printf($filestream_type);

      if (feof(STDIN))
        break;

      switch ($command_arguments) {
        case "--file":
          # code...check iterable argument columns
          print_r("Params variable before STDIO handling.");

          echo "Please type known file-name: $filestream_type";
          $filename_input = rtrim(fgets(STDIN));

          print_r("Params variable AFTER STDIO handling: $filename_input");
          break;

        case "--create_table":
          echo "Creating database table (with MySQLi...)";
          create_table_with_csv();
          break;

        case "--dry_run":
          echo "Running: --dry_run - command...organising user data...";
          organise_user_csv();
          break;

        case "-u":
          $username_beforehand = $this->get_username();
          print_r("Username before before switch: $username_beforehand");

          echo "Give us your new input for: username...";
          $end_user_input_username = rtrim(fgets(STDIN));
          $this->set_username($end_user_input_username);

          print_r("Username before AFTER switch: $username_beforehand");
          break;

        case "-p":
          $password_ret_val = $this->get_password();
          print_r("Password before before switch: $password_ret_val");

          echo "Give us your new input for: password...";
          $end_user_input_password = rtrim(fgets(STDIN));
          $this->set_username($end_user_input_password);

          $this->set_password($command_arguments);
          print_r("Password before AFTER switch: $password_ret_val");
          break;

        case "-h":
          $database_hostname = $this->get_hostname();
          print_r("Database hostname before before switch: $database_hostname");

          echo "Give us your new input for: hostname...";
          $end_user_input_hostname = rtrim(fgets(STDIN));
          $this->set_username($end_user_input_hostname);

          $this->set_hostname($command_arguments);
          print_r("Database hostname before AFTER switch: $database_hostname");
          break;

        case "--help":
          echo $help_heredoc;
          break;

        default:
          # code...
          break;
      }
    }
  }
}

function main()
{
  $behaviour_handler = new CliBuilder();
  $behaviour_handler->dry_run();
  return 0;
}

main();
