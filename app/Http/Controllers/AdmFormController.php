<?php

namespace App\Http\Controllers;

use App\Enums\AdmMailStatusEnum;
use App\Mail\AdmFormEmail;
use App\Models\AdmForm;
use App\Models\AdmFormItem;
use App\Services\AdmFormService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use mysql_xdevapi\Exception;

class AdmFormController extends Controller
{
    public function form(Request $request, $link_hash)
    {
        $admForm = AdmForm::query()
            ->where('link_hash', $link_hash)
            ->with('admFormItems')
            ->first();

        if(!$admForm) {
            return back()->with('adm_form_err', 'error');
        }

        $admFields = $admForm->fields();

        $itemData = [];

        foreach ($admFields as $admFieldName) {
            $itemData[$admFieldName] = $request->get($admFieldName);
        }

        $item = AdmFormItem::query()->create([
            'adm_form_id' => $admForm->id,
            'payload' => $itemData,
        ]);

        if($admForm->send_notify) {
            AdmFormService::sendEmailForItem($item);
        }

        return back()->with('adm_form_success', 'saved!');
    }
}
