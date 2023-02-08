<?php
namespace App\Enums;

enum StockTransactionStatus:string
{
    case Active = '1';
    case Inactive= '0';
}