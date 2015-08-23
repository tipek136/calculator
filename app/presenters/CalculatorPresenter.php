<?php
/**
 * Created by PhpStorm.
 * User: Tom�
 * Date: 23. 8. 2015
 * Time: 15:36
 */

namespace App\Presenters;

use Nette;
use App\Model\CalculatorManager;
use Nette\Application\UI\Form;
use Nette\Forms\Rendering\DefaultFormRenderer;

class CalculatorPresenter extends BasePresenter
{
    /**@var mixed výsledek operace nebo null*/
    private $result = null;

    /**@var CalculatorManager*/
    private $calculatorManager;

    /**Definice konstant pro zprávy.*/
    const
        FORM_MSG_REQUIRED = "Toto pole je povinné!",
        FORM_MSG_NUM = "Musí být zadáno číslo!",
        FORM_MSG_ZERO_DIV = "Nulou nelze dělit!";

    /**
     * @param CalculatorManager $calculatorManager automaticky injektovaná třída modelu
     */
    public function __construct(CalculatorManager $calculatorManager)
    {
        $this->calculatorManager = $calculatorManager;
    }

    /**Vykreslovací metoda*/
    public function renderShow()
    {
        // Předání výsledku do šablony
        $this->template->result = $this->result;
    }

    /**
     * Vrátí formulář kalkulačky.
     * @return Form - formulář
     */
    protected function createComponentCalculatorForm()
    {
        $form = new Form;

        $form->addRadioList('operation', 'Operace:', $this->calculatorManager->getOperations())
            ->setDefaultValue(CalculatorManager::ADD)
            ->setRequired(self::FORM_MSG_REQUIRED);

        $form->addText('x', 'První číslo:')
            ->setType('number')
            ->addRule(Form::FLOAT, self::FORM_MSG_NUM)
            ->setDefaultValue(0)
            ->setRequired(self::FORM_MSG_REQUIRED);

        $form->addText('y', 'Druhé číslo:')
            ->setType('number')
            ->addRule(Form::FLOAT, self::FORM_MSG_NUM)
            ->setDefaultValue(0)
            ->setRequired(self::FORM_MSG_REQUIRED)
            ->addConditionOn($form['operation'], Form::EQUAL, CalculatorManager::DIVIDE)
            ->addRule(Form::PATTERN, self::FORM_MSG_ZERO_DIV, '^[^0]$');

        $form->addSubmit('send', 'Spočítat');

        $form->onSuccess[] = array($this, 'calculatorFormSucceeded');

        return $form;
    }

    /**
     * Po potvrzení formuláře pošle proměnné do modelu a získá výsledek.
     * @param $form - formulář
     * @param $values - hodnoty získané z formuláře
     */
    public function calculatorFormSucceeded($form, $values)
    {
        $this->result = $this->calculatorManager->calculate($values->operation, $values->x, $values->y);
    }
    
}