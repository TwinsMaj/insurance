<?php
declare(strict_types=1);

namespace Lib;
use Lib\Utils;
use Lib\CalculatorInterface;

class InsuranceReport
{
    protected $_calculator;

    public function __construct(CalculatorInterface $calculator) {
       $this->_calculator = $calculator;
    }

    public function instalmentSchedule() {
        $tableHead = "<th></th><th>Policy</th>";

        $insuranceMetaData = $this->_calculator->calculate();
        extract($insuranceMetaData);

        $tableBody = '<tr><td>Value</td><td>' . number_format($value, 2) .'</td></tr>';

        $basePremiumParts = Utils::divideEqually($basePremium, $instalments);
        $commissionParts = Utils::divideEqually($commission, $instalments);
        $taxParts = Utils::divideEqually($tax, $instalments);
        $grandTotalParts = Utils::divideEqually($grandTotal, $instalments);

        $tableBody .= '<tr><td>Base Premium (' . $policyRate. '%)</td><td>' . number_format($basePremium, 2) . '</td>';
        foreach($basePremiumParts as $part) {
            $part = number_format($part, 2);
            $tableBody .= "<td>{$part}</td>";
        }
        $tableBody .= '</tr>';

        $tableBody .= '<tr><td>Commission (' . $commissionRate. '%)</td><td>' . number_format($commission, 2) . '</td>';
        foreach($commissionParts as $part) {
            $part = number_format($part, 2);
            $tableBody .= "<td>{$part}</td>";
        }
        $tableBody .= '</tr>';

        $tableBody .= '<tr><td>Tax (' . $taxRate. '%)</td><td>' . number_format($tax, 2) . '</td>';
        foreach($taxParts as $part) {
            $part = number_format($part, 2);
            $tableBody .= "<td>{$part}</td>";
        }
        $tableBody .= '</tr>';

        $tableBody .= '<tr><td><b>Grand Total<b></td><td><b>' . number_format($grandTotal, 2) . '</b></td>';
        foreach($grandTotalParts as $part) {
            $part = number_format($part, 2);
            $tableBody .= "<td>{$part}</td>";
        }
        $tableBody .= '</tr>';



        for($i = 1; $i <= $instalments; ++$i) {
            $tableHead .= "<th>{$i} Instalment</th>";
        }

        return "<table border=\"1\">{$tableHead}{$tableBody}</table>";
    }
}