<?php

namespace App\Enums;

enum PurchaseStatus: int
{
    // 教材に合わせるが、本来であれば0ではなく9とするのがベター
    case Canceled = 0;
    case NotCanceled = 1;

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this)
        {
            PurchaseStatus::Canceled => 'キャンセル済',
            PurchaseStatus::NotCanceled  => '未キャンセル',
        };
    }
}