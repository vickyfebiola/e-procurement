<?php

namespace App\Http\Controllers\Product;

use App\Helpers\Message;
use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::selectRaw('id_product, product_name, description, price, id_vendor')
            ->with('vendor')
            ->whereHas('vendor', fn($q) => $q->where('id_user', auth()->id()))
            ->orderByDesc('updated_at')
            ->paginate(10);

        return response()->json(Message::formatResponse(true, 'Products is found', $products));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            // get data vendor
            $idVendor = $data['id_vendor'] ?? null;
            $vendor = Vendor::where('id_user', auth()->id())
                ->when($idVendor, function ($query, $idVendor) {
                    return $query->where('id_vendor', $idVendor);
                })
                ->when(!$idVendor, function ($query) {
                    return $query->where('is_default', 1);
                })
                ->first();

            if (!$vendor) {
                return response()->json(Message::formatResponse(false, 'Vendor not found'));
            }

            $product = Product::create(array_merge($data, [
                'id_product' => MyHelper::generateId(),
                'id_vendor' => $vendor->id_vendor,
            ]));

            DB::commit();
            return response()->json(Message::formatResponse(true, 'Product is successfully created', [
                'id_product' => $product->id_product,
            ]));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(Message::formatResponse(false, 'Failed to create product', $e->getMessage()));
        }
    }

    public function show($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                throw new \Exception('Product not found');
            }

            return response()->json(Message::formatResponse(true, 'Product found', $product));
        } catch (\Exception $e) {
            return response()->json(Message::formatResponse(false, 'Product not found', $e->getMessage()));
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        try {

            DB::beginTransaction();

            $product = Product::find($id);
            if (!$product) {
                throw new \Exception('Product not found');
            }

            $product->update($data);

            DB::commit();
            return response()->json(Message::formatResponse(true, 'Product updated successfully', [
                'id_product' => $product->id_product
            ]));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(Message::formatResponse(false, 'Failed to update product', $e->getMessage()));
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $idProducts = $request->id_products ?? [$id];
            Product::whereIn('id_product', $idProducts)->delete();

            DB::commit();
            return response()->json(Message::formatResponse(true, 'Product deleted successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(Message::formatResponse(false, 'Failed to delete product', $e->getMessage()));
        }
    }
}
