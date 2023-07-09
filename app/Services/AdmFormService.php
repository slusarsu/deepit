<?php

namespace App\Services;

use App\Enums\AdmMailStatusEnum;
use App\Mail\AdmFormEmail;
use App\Models\AdmFormItem;
use App\Models\Tag;
use Illuminate\Support\Facades\Mail;

class AdmFormService
{
    public static function sendEmailForItem($item): void
    {
        $email = siteSetting()->get('email') ?? env('MAIL_FROM_ADDRESS');
        try {
            Mail::to($email)->send(new AdmFormEmail($item->payload));
            AdmFormItem::query()->where('id', $item->id)->update([
                'status' => AdmMailStatusEnum::SENT->value
            ]);
        }catch (\Exception $e) {
            AdmFormItem::query()->where('id', $item->id)->update([
                'status' => AdmMailStatusEnum::ERROR_SENT->value
            ]);
        }
    }
}
