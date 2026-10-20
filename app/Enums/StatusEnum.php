<?php
namespace App\Enums;
enum StatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DRAFT = 'draft';
    case CANCELLED = 'cancelled';
    case  COMPLETED = 'completed';
    case PUBLISHED = 'published';
}
