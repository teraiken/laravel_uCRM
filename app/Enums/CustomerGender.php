<?php

namespace App\Enums;

enum CustomerGender: int
{
    // 教材に合わせるが、本来であれば0ではなく9とするのがベター
    case Male = 0;
    case Female = 1;
    case Others = 2;

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this)
        {
            CustomerGender::Male => '男性',
            CustomerGender::Female  => '女性',
            CustomerGender::Others  => 'その他',
        };
    }
}