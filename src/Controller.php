<?php
declare(strict_types=1);

namespace App;


use Random\RandomException;

class Controller
{
  private Database $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function index(): void
  {
    View::render('layout', 'home');
  }

  /**
   * @throws RandomException
   */
  public function login(): void
  {
    View::render('layout', 'login', ['csrf' => Auth::generateCsrfToken()]);
  }

  public function processLogin():void
  {
    $this->db->login();
  }

  /**
   * @throws RandomException
   */
  public function register(): void
  {
      View::render('layout', 'register', ['csrf' => Auth::generateCsrfToken()]);
  }

  public function processRegister():void
  {
    $this->db->register();
  }

  public function logout(): void
  {
    $this->db->logout();
  }
}
