<?php

namespace App\Http;

use App\Services\RouterService;
use Closure;
use Exception;

/**
 * Classe responsável pelo comportamento de rotas da aplicação.
 * 
 * Determina as rotas, cria novas rotas e responde com métodos de uma controller.
 * A instância dessa classe deve ser única (TODO: Pattern Singleton).
 */
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
  private RouterService $routerService;

  public function __construct(string $url)
  {
    $this->request = new Request();
    $this->url = $url;
    $this->setPrefix();
    $this->routerService = new RouterService();
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

    $params['variables'] = [];

    $patternRegularVariable = '/{(.*?)}/';

    if (preg_match_all($patternRegularVariable, $route, $matches)) {
      $route = preg_replace($patternRegularVariable, '(.*?)', $route);
      $params['variables'] = $matches[1];
    }

    // TODO: corrigir a função e passar a utilizar
    // $this->routerService->getRouteParams($route);

    // rota com padrão de regex aplicado para tratamento da rota (essencial para casos dinâmicos, ex: /user/1 | /user/2)
    $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

    $this->routes[$patternRoute][$method] = $params;
  }

  /**
   * Método utilizado para definir uma nova rota de GET
   */
  public function get(string $route, array $params = [])
  {

    return $this->addRoute('GET', $route, $params);
  }

  /**
   * Método utilizado para definir uma nova rota de POST
   */
  public function post(string $route, array $params = [])
  {
    return $this->addRoute('POST', $route, $params);
  }

  /**
   * Método utilizado para definir uma nova rota de PUT
   */
  public function put(string $route, array $params = [])
  {
    return $this->addRoute('PUT', $route, $params);
  }

  /**
   * Método utilizado para definir uma nova rota de DELETE
   */
  public function delete(string $route, array $params = [])
  {
    return $this->addRoute('DELETE', $route, $params);
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

    foreach ($this->routes as $patternRoute => $methods) {
      if (preg_match($patternRoute, $uri, $matches)) {
        // verifica se a URI do navegador bate com uma patternRoute existente
        if (isset($methods[$httpMethod])) {
          unset($matches[0]);

          // coloca o valor informado na rota na posição correta de acordo com o atributo esperado na escrita da rota 
          // ex: em $routes há a rota /pagina/{idPagina}
          // $methods[$httpMethod]['variables'] passa a ser um associativo da chave idPagina com o valor /pagina/<idPaginaValor>
          $keys = $methods[$httpMethod]['variables'];
          $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
          $methods[$httpMethod]['variables']['request'] = $this->request;
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
  public function run(): Response
  {
    try {

      // obtém a rota atual
      $route = $this->getRoute();

      // Validação - Não há método registrado para responder essa rota em $routes
      if (!isset($route['controller'])) {
        throw new Exception("A URL não pode ser processada", 500);
      }

      $args = [];

      // retorna a execução do método
      return call_user_func_array($route['controller'], $args);
    } catch (Exception $e) {
      return new Response($e->getCode(), $e->getMessage());
    }
  }
}
