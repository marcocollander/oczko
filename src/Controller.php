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
    $view = new View();
    $view->render('layout', 'home');
  }

  /**
   * @throws RandomException
   */
  public function login(): void
  {
    $view = new View();
    $method = Request::getMethod();

    if ($method === 'POST') {
      $this->db->login();
    } else {
      $view->render('layout', 'login', ['csrf' => Auth::generateCsrfToken()]);
    }
  }

  /**
   * @throws RandomException
   */
  public function register(): void
  {
    $view = new View();
    $method = Request::getMethod();

    if ($method === 'POST') {
      $this->db->register();
    } else {
      $view->render('layout', 'register', ['csrf' => Auth::generateCsrfToken()]);
    }
  }

  public function logout(): void
  {
    $this->db->logout();
  }
}
