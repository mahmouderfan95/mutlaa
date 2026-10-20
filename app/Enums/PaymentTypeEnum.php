<?php
namespace App\Enums;
enum PaymentTypeEnum: string
{
    case COD = "cod";
    case VISA = "visa";
    case KNET = "knet";
}
