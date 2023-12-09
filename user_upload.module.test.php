<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use CliBuilder;

final class UserUploadTest extends TestCase
{
  private $behaviour_handler;

  public function test_database_getter($_behaviour_handler_copy)
  {
    // Dependency Injection which creates a composite over a direct creational object
    $_behaviour_handler_copy = new CliBuilder();
    $this->behaviour_handler = $_behaviour_handler_copy;

    $database = $this->behaviour_handler->get_database();
    $this->assertSame($database, "users");
  }

  public function test_database_setter($_behaviour_handler_copy)
  {
    // Dependency Injection which creates a composite over a direct creational object
    $_behaviour_handler_copy = new CliBuilder();
    $this->behaviour_handler = $_behaviour_handler_copy;

    $this->behaviour_handler->set_database("users");
    $this->assertSame($this->behaviour_handler->get_database(), "admin");
  }

  public function test_username_getter($_behaviour_handler_copy)
  {
    // Dependency Injection which creates a composite over a direct creational object
    $_behaviour_handler_copy = new CliBuilder();
    $this->behaviour_handler = $_behaviour_handler_copy;

    $username = $this->behaviour_handler->get_username();
    $this->assertSame($username, "admin");
  }

  public function test_username_setter($_behaviour_handler_copy)
  {
    // Dependency Injection which creates a composite over a direct creational object
    $_behaviour_handler_copy = new CliBuilder();
    $this->behaviour_handler = $_behaviour_handler_copy;

    $this->behaviour_handler->set_username("admin");
    $this->assertSame($this->behaviour_handler->get_username(), "admin");
  }

  public function test_password_getter($_behaviour_handler_copy)
  {
    // Dependency Injection which creates a composite over a direct creational object
    $_behaviour_handler_copy = new CliBuilder();
    $this->behaviour_handler = $_behaviour_handler_copy;

    $password = $this->behaviour_handler->get_password();
    $this->assertSame($password, "root");
  }

  public function test_password_setter($_behaviour_handler_copy)
  {
    // Dependency Injection which creates a composite over a direct creational object
    $_behaviour_handler_copy = new CliBuilder();
    $this->behaviour_handler = $_behaviour_handler_copy;

    $this->behaviour_handler->set_password("root");
    $this->assertSame($this->behaviour_handler->get_password(), "root");
  }

  public function test_build_cli_instr($_behaviour_handler_copy)
  {
  }
}