<?php

namespace App\Http\Controllers\Vendor;

use App\Helpers\Message;
use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\StoreRequest;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            $isDefault = 0;
            if (!Vendor::where('is_default', 1)->exists()) {
                $isDefault = 1;
            } elseif (($data['is_default'] ?? false) == 1) {
                Vendor::where('is_default', 1)->update(['is_default' => 0]);
                $isDefault = 1;
            }

            $vendor = Vendor::create(array_merge($data, [
                'id_vendor' => MyHelper::generateId(),
                'id_user' => auth()->id(),
                'is_default' => $isDefault,
            ]));

            DB::commit();
            return response()->json(Message::formatResponse(true, 'Vendor created successfully', [
                'id_vendor' => $vendor->id_vendor
            ]));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(Message::formatResponse(false, 'Failed to create vendor', $e->getMessage()));
        }
    }
}
