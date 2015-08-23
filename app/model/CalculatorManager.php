<?php
/**
 * Created by PhpStorm.
 * User: Tom�
 * Date: 23. 8. 2015
 * Time: 0:15
 */

namespace App\Model;

use Nette;


class CalculatorManager extends Nette\Object
{
    /**@var Nette\Database\Context*/
    private $database;

    /**Definice konstant pro operace*/
    const
        ADD = 1,
        SUBTRACT = 2,
        MULTIPLY = 3,
        DIVIDE = 4;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    /**
     * Sečte daná čísla a vrátí výsledek.
     * @param $x - první číslo
     * @param $y - druhé číslo
     * @return mixed - výsledek po sčítání
     */
    private function add($x, $y)
    {
        return $x + $y;
    }

    /**
     * Odečte daná čísla a vrátí výsledek.
     * @param $x - první číslo
     * @param $y - druhé číslo
     * @return mixed - výsledek po odečítání
     */
    private function subtract($x, $y)
    {
        return $x - $y;
    }

    /**
     * Vynásobí daná čísla a vrátí výsledek.
     * @param $x - první číslo
     * @param $y - druhé číslo
     * @return mixed - výsledek po násobení
     */
    private function multiply($x, $y)
    {
        return $x * $y;
    }

    /**
     * Vydělí daná čísla a vrátí výsledek.
     * @param $x - první číslo
     * @param $y - druhé číslo
     * @return float - výsledek po násobení
     */
    private function divide($x, $y)
    {
        return $x / $y;
    }

    /**
     * Getter pro operace.
     * @return array - asociativní pole konstant a jejich slovního pojmenování
     */
    public function getOperations()
    {
        return array(
            self::ADD => 'Sčítání',
            self::SUBTRACT => 'Odčtání',
            self::MULTIPLY => 'Násobení',
            self::DIVIDE => 'Dělení'
        );
    }

    /**
     * Zavolá danou operaci a vrátí výsledek.
     * @param $operation - určení operace
     * @param $x - první číslo
     * @param $y - druhé číslo
     * @return float|mixed|null - výsledek operace nebo null, pokud zadaná operace neexistuje
     */
    public function calculate($operation, $x, $y)
    {
        switch($operation)
        {
            case self::ADD:
                return $this->add($x, $y);
            case self::SUBTRACT:
                return $this->subtract($x, $y);
            case self::MULTIPLY:
                return $this->multiply($x, $y);
            case self::DIVIDE:
                return $this->divide($x, $y);
            default:
                return null;
        }
    }
}