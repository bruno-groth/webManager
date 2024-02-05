<?php

namespace App\Http;

use Closure;
use Exception;

class Router
{
  private string $url = '';
  private string $prefix = '';
  /**
   * Array de rotas
   * routes[$patternRoute][$method]
   * 
   * $patternRoute = rota com regex ('/' vira '/^\/$/')
   * $method = Controller::method() que responde
   */
  private array $routes = [];
  private Request $request;

  public function __construct(string $url)
  {
    $this->request = new Request();
    $this->url = $url;
    $this->setPrefix();
  }

  private function setPrefix(): void
  {
    $parsedUrl = parse_url($this->url);
    $this->prefix = $parsedUrl['path'] ?? '';
  }

  /**
   * Adiciona a rota no array de $routes da classe
   */
  private function addRoute(string $method, string $route, array $params = [])
  {
    // tratamento dos parâmetros, remove o índice numérico e transforma em índice nomeado "controller"
    foreach ($params as $key => $value) {
      if ($value instanceof Closure) {
        $params['controller'] = $value;
        unset($params[$key]);
        continue;
      }
    }

    // rota padrão com regex pra tratamento da rota (essencial para casos dinâmicos, ex: /user/1 | /user/2)
    $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

    $this->routes[$patternRoute][$method] = $params;
  }

  /**
   * Define uma rota de GET
   */
  public function get(string $route, array $params = [])
  {
    return $this->addRoute('GET', $route, $params);
  }

  /**
   * Retorna a URI desconsiderando prefixo padrão do projeto (/app)
   */
  private function getUri(): string
  {
    $uri = $this->request->uri;

    // Divide a URL em antes/depois do prefixo
    $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

    // retorna só o que estiver por último do xUri, ou seja, depois do prefixo /app/xxx
    return end($xUri);
  }

  /**
   * Método que Retorna os dados (?) da rota atual
   * Itera as rotas da classe buscando por uma que bata com a informada.
   * 
   * Caso a rota exista e ela tenha uma Controller configurada para responder ao método utilizado (GET/POST),
   * vai retornar o método da controller. Caso contrário, retorna erro pois nenhuma controller foi
   * encontrada para a rota e método solicitado.
   */
  private function getRoute()
  {
    $uri = $this->getUri();

    $httpMethod = $this->request->httpMethod;

    /**

     */
    foreach ($this->routes as $patternRoute => $methods) {
      // verifica se a URI do navegador bate com uma patternRoute existente
      if (preg_match($patternRoute, $uri)) {
        if ($methods[$httpMethod]) {
          return $methods[$httpMethod];
        }

        throw new Exception("Método não permitido", 405);
      }
    }
    throw new Exception("URL não encontrada.", 404);
  }

  /**
   * Executa a rota atual
   */
  public function run()
  {
    try {

      // obtém a rota atual
      $route = $this->getRoute();

      // echo '<pre>';
      // var_export($route);
      // echo '</pre>';
      return $route;
    } catch (Exception $e) {
      return new Response($e->getCode(), $e->getMessage());
    }
  }
}
