<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use leinadalrus\CliBuilder;

final class TestCliBuild extends TestCase
{
  private $cli_builder = NULL;
  private $behaviour_handler = NULL;

  function test_cli_build($_cli_builder)
  {
    $_cli_builder = new CliBuilder();
    $this->cli_builder = $_cli_builder;

    $this->cli_builder->set_username("admin");
    $this->cli_builder->set_password("root");
    $this->cli_builder->set_hostname("localhost");
  }

  public function test_database_getter($_behaviour_handler_copy)
  {
    // Dependency Injection which creates a composite over a direct creational object
    $_behaviour_handler_copy = new CliBuilder();
    $this->behaviour_handler = $_behaviour_handler_copy;

    $database = $this->behaviour_handler->get_hostname();
    $this->assertSame($database, "localhost");
  }

  public function test_database_setter($_behaviour_handler_copy)
  {
    // Dependency Injection which creates a composite over a direct creational object
    $_behaviour_handler_copy = new CliBuilder();
    $this->behaviour_handler = $_behaviour_handler_copy;

    $this->behaviour_handler->set_hostname("localhost");
    $this->assertSame($this->behaviour_handler->get_hostname(), "admin");
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
}
