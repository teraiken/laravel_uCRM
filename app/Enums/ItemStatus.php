<?php

namespace App\Enums;

enum ItemStatus: int
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
            ItemStatus::Unavailable => '販売停止中',
            ItemStatus::Available  => '販売中',
        };
    }
}