<?php
/** Implementación del patron de diseño Strategy
 *  Se utiliza para encapsular la lógica de negocio en clases independientes
 * Mas información en: https://refactoring.guru/es/design-patterns/strategy
 */

 /** Interface que define la lógica de negocio */
interface IStrategy {
    public function get(): array;
}

/** Implementación de la clase que implementa la interfaz
 * los datos estan definidos en un arreglo
 */
class ArrayStrategy implements IStrategy {
    private array $data =  [
        'data 1',
        'data 2',
        'data 3',
    ];

    public function get(): array {
        return $this->data;
    }
}

/** Segunda clase que implementa la interfaz
 * los datos estan definidos en un archivo json obtenido a traves de una url
 */
class UrlStrategy implements IStrategy {
    private string $url;

    public function __construct(string $url){
        $this->url = $url;
    }

    public function get(): array {
        $data = file_get_contents($this->url);
        $array = json_decode($data, true);

        return array_map(fn($item) => 'title: ' . $item['title'], $array);
    }
}

/** Clase para el contexto que requiere una implementación de la interfaz IStrategy */
class InfoPrinter {
    private IStrategy $strategy;

    public function __construct(IStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function print(): void {
        $content = $this->strategy->get();

        foreach ($content as $item) {
            echo $item . PHP_EOL;
        }
    }
}

/** Ejemplo de uso */
$strategyArray = new ArrayStrategy();
$arrayPrinter = new InfoPrinter($strategyArray);
$arrayPrinter->print();

/** Alternativa de uso */
$strategyUrl = new UrlStrategy('https://jsonplaceholder.typicode.com/posts');
$urlPrinter = new InfoPrinter($strategyUrl);
$urlPrinter->print();