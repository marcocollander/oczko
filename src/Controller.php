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

  /**
   * @throws RandomException
   */
  public function run(): void
  {
    $path = Request::getPath();
    $method = Request::getMethod();
    $view = new View();

    switch ($path) {
      case '/':
        $view->render('layout', 'home');
        break;
      case '/login':
        if ($method === 'POST') {
          $this->db->login();
        } else {
          $view->render('layout', 'login', ['csrf' => Auth::generateCsrfToken()]);
        }
        break;
      case '/register':
        if ($method === 'POST') {
          $this->db->register();
        } else {
          $view->render('layout', 'register', ['csrf' => Auth::generateCsrfToken()]);
        }
        break;
      case '/logout':
        $this->db->logout();
        break;
      default:
        http_response_code(404);
        echo "404 Not Found";
    }
  }
}
