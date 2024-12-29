<?php
/** Implementación del patrón Decorator
 *  Se utiliza para agregar comportamiento a una clase
 */

 /** Interface que define la lógica de negocio */
interface IBudget {
    public function cost(): float;
}

/** Implementación de la clase base que implementa la interfaz */
class BasicBudget implements IBudget {
    private int $hours;
    private float $hourlyRate;

    public function __construct(int $hours, float $hourlyRate) {
        $this->hours = $hours;
        $this->hourlyRate = $hourlyRate;
    }

    public function cost(): float {
        return $this->hours * $this->hourlyRate;
    }
}


/** Decorador base */
class BudgetDecorator implements IBudget {
    private IBudget $budget;

    public function __construct(IBudget $budget) {
        $this->budget = $budget;
    }

    public function cost(): float {
        return $this->budget->cost();
    }
}


/** Decorador para el tipo extranjero */
class ForeignBudgetDecorator extends BudgetDecorator {
    const EXCHANGE_RATE = 1.5;

    public function cost(): float {
        return parent::cost() * self::EXCHANGE_RATE;
    }
}


/** Decorador para clientes preferenciales */
class CustomerBudgetDecorator extends BudgetDecorator {
    const DISCOUNT = 0.9;
    
    public function cost(): float {
        return parent::cost() * self::DISCOUNT;
    }
}

/** Uso del decorador base */
$budget = new BasicBudget(10, 100);
echo "Presupuesto Base: {$budget->cost()}" . PHP_EOL;

/** Uso del decorador para el tipo extranjero basandose en el decorador base */
$foreignBudget = new ForeignBudgetDecorator($budget);
echo "Presupuesto Extranjero: {$foreignBudget->cost()}" . PHP_EOL;

/** Aplicación de un tercer decorador basado en el decorador del tipo extranjero */
$customerBudget = new CustomerBudgetDecorator($foreignBudget);
echo "Presupuesto Personal: {$customerBudget->cost()}" . PHP_EOL;