<?php

namespace App\Enums;

enum PurchaseStatus: int
{
    // 教材に合わせるが、本来であれば0ではなく9とするのがベター
    case Unavailable = 0;
    case Available = 1;

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this)
        {
            PurchaseStatus::Unavailable => '販売停止中',
            PurchaseStatus::Available  => '販売中',
        };
    }
}