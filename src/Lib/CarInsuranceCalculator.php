<?php 
declare(strict_types=1);

namespace Lib;
use Lib\Utils;
use Lib\CalculatorInterface;

class CarInsuranceCalculator extends Insurance implements CalculatorInterface
{
    const MIN_TIME = 15;
    const MAX_TIME = 20;
    const POLICY_RATE = 0.11;
    const DAY_OF_WEEK = 'Fri';
    const COMMISSION_RATE = 0.17;
    const FRIDAY_POLICY_RATE = 0.13;

    public function __construct(int $taxRate, int $instalments, float $estimatedValue) {
        $this->_taxRate = $taxRate;
        $this->_instalments = $instalments;
        $this->_estimatedValue = $estimatedValue;
    }

    private function isFriday(): bool {
        return (Utils::dayOfTheWeek() == self::DAY_OF_WEEK) 
            && (Utils::timeOfTheDay() >= self::MIN_TIME && Utils::timeOfTheDay() <= self::MAX_TIME);
    }

    public function calculate(): array {
        if($this->isFriday()) {
            $basePremium = $this->getEstimatedValue() * self::FRIDAY_POLICY_RATE;
            $policyRate = self::FRIDAY_POLICY_RATE * 100;
        } else {
            $basePremium = $this->getEstimatedValue() * self::POLICY_RATE;
            $policyRate = self::POLICY_RATE * 100;
        }

        $commission = $basePremium * self::COMMISSION_RATE;
        $tax = $basePremium * $this->getTaxRate();

        $grandTotal = $basePremium + $commission + $tax;
        $instalments = $this->getInstalments();
        $value = $this->getEstimatedValue();
        $taxRate = $this->getTaxRate() * 100;
        
        $commissionRate = self::COMMISSION_RATE * 100;
        return compact('basePremium', 'commission', 'tax', 'grandTotal', 'instalments', 'value', 'taxRate', 'policyRate', 'commissionRate');
    }
}