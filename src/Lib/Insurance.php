<?php 
declare(strict_types=1);

namespace Lib;

Abstract class Insurance 
{
    protected $_taxRate;
    protected $_instalments;
    protected $_estimatedValue;

    protected function getTaxRate(): float {
        return $this->_taxRate / 100;
    }

    protected function getInstalments(): int {
        return $this->_instalments;
    }

    protected function getEstimatedValue(): float {
        return $this->_estimatedValue;
    }
}