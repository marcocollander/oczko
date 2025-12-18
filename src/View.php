<?php
declare(strict_types=1);

namespace App;

class View
{

  public function render(string $template, string $content, array $data = []): void
  {
    $contentFile = __DIR__ . '/../template/pages/' . basename($content) . '.php';
    if (!is_file($contentFile)) {
      http_response_code(500);
      echo "Błąd serwera — brak widoku: " . htmlspecialchars($content, ENT_QUOTES);
      exit;
    }

    // zmienne dostępne w szablonie
    $contentFileVar = $contentFile;
    extract($data, EXTR_SKIP);

    include __DIR__ . '/../template/' . $template . '.php';

  }

}
