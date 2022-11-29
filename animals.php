<?php
class Animal{
    public $name;
    public $health;
    public $power;
    public $alive;

    public function __construct(string $name, int $health, int $power){
        $this->name = $name;
        $this->health = $health;
        $this->power = $power;
        $this->alive = true;
    }

    public function calcDamage(){
        return $this->name . ' ' . $this->power * mt_rand(100, 300) / 200;
    }

    public function applyDamage(int $damage){
        $this->health -= $damage;

        if ($this->health < 0){
            $this->health = 0;
            $this->alive = false;
        }
    }
}

class Cat extends Animal{
    private $lifes;

    public function __construct(string $name, int $health, int $power){
        parent::__construct($name, $health, $power);
        $this->lifes = 9;
    }
}

class Dog extends Animal{
    public function __construct(string $name, int $health, int $power)
    {
        parent::__construct($name, $health, $power);
    }
}

class Mouse extends Animal{
    private $hiddenLevel;

    public function __construct(string $name, int $health, int $power){
        parent::__construct($name, $health, $power);
        $this->hiddenLevel = 0;
    }

    public function setHiddenLevel(float $level){
        $this->hiddenlevel = $level;
    }

    public function applyDamage(int $damage){
        if((mt_rand(1, 100) / 100) > $this->hiddenLevel){
            parent::applyDamage($damage);
        }
    }
}

class GameCore{
    private $units;

    public function __construct(){
        $this->units = [];
    }

    public function addUnit(Animal $unit){
        $this->units[] = $unit;
    }

    public function nextTick(){
        foreach($this->units as $unit) {
            $damage = $unit->calcDamage();
            $target = $this->getRandomUnit($unit);
            $targetPrevHealth = $target->health;
            $target->applyDamage($damage);
            echo "{$unit->name} beat {$target->name}, damage = $damage, 
                health{$targetPrevHealth} -> {$target->health} <br>";
            }
            $this->units = array_values(array_filter($this->units, function($unit){
                return $unit->alive;
            }));
        }


    private function getRandomUnit(Animal $exclude){
        $units = array_values(array_filter($this->units, function($unit) use ($exclude){
            return $unit !== $exclude;
        }));
        return $units[mt_rand(0, count($units) - 1)];
    }
}
$core = new GameCore();

$core->addUnit(new Cat('Murzik', 120, 6));
$core->addUnit(new Cat('Tom', 80, 5));
$core->addUnit(new Dog('Bobik', 200, 22));
$core->addUnit(new Dog('Sharik', 250, 20));
$core->addUnit(new Mouse('Jerry', 10, 3, 0.9));
$core->addUnit(new Mouse('Ratatuy', 10, 2, 0.95));

$core->nextTick();


