<?php

namespace App\Core;

use Throwable;

abstract class Controller {
  public function render(string $viewName, array $viewData = []): void {
    try {
      $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../Views');
      $twig = new \Twig\Environment($loader);

      $template = $twig->load("{$viewName}.twig");
      $templateRendering = $template->render($viewData);

      echo $templateRendering;
    } catch (Throwable $e) {
      exit('Page not found.');
    }
  }
}
