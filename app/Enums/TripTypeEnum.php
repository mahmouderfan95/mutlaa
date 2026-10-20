<?php
namespace App\Enums;
enum TripTypeEnum: string
{
    case UMRAH = "umrah";
    case HAJJ = "hajj";
    case EVENTS = "events";
    case OUTBOUND = "outbound";
    case HONEYMOON = "honeymoon";
}
