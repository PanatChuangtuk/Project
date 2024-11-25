<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\{ProductInformation, ProductModel};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth};

class ProductModelController extends Controller
{
    public function edit(Request $request, $id)
    {
        $request->all();
        $product_model = ProductModel::find($id);
        $product_info = ProductInformation::with('productAttribute')
            ->where('product_model_id', $product_model->id)
            ->get();

        return view('administrator.product_model.edit', compact('product_model', 'product_info'));
    }
    public function update(Request $request, $id)
    {
        $product_model = ProductModel::find($id);
        $updatedBy = Auth::user()->id;

        $product_model->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'status' => $request->has('status') ? 1 : 0,
            'updated_at' => now(),
            'update_by' => $updatedBy
        ]);
        foreach ($request->descriptionAttribute as $itemId => $description) {
            $product_info = ProductInformation::find($itemId);
            $product_info->detail = $description ?? null;
            $product_info->updated_by = $updatedBy;
            $product_info->save();
        }
        return redirect()->route('administrator.product.model')->with('success', 'Product model updated successfully');
    }
}
