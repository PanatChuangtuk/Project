<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\{Product, ProductPrice, ProductModel};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{Storage, Auth, DB};
use App\Imports\ProductImport;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $status = $request->input('status');

        $productQuery = Product::query();

        if ($query) {
            $productQuery->where('name', 'LIKE', "%{$query}%");
        }

        if ($status) {
            $statusValue = ($status === 'active') ? 1 : 0;
            $productQuery->where('status', $statusValue);
        }

        $product = $productQuery
            ->paginate(10)
            ->appends([
                'query' => $query,
                'status' => $status,
            ]);

        return view('administrator.product.index', compact('product', 'query', 'status'));
    }

    public function add()
    {
        return view('administrator.product.add');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $models = ProductModel::all();
        $product_price = DB::table('product_price')
            ->join('member_group', 'product_price.member_group_id', '=', 'member_group.id')
            ->where('product_price.product_id', $id)
            ->get(['product_price.*', 'member_group.name as member_group_name']);

        return view('administrator.product.edit', compact('product', 'product_price', 'models'));
    }

    public function submit(Request $request)
    {
        $name = $request->input('name');
        $url = $request->input('url');
        $status = $request->input('status', 0);
        $filename = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = substr(Str::uuid(), 0, 5) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('file/product', $filename, 'public');
        }

        Product::create([
            'name' => $name,
            'url' => $url,
            'image' => $filename,
            'status' => $status,
            'created_at' => Carbon::now(),
            'created_by' => Auth::user()->id
        ]);

        return redirect()->route('administrator.product');
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $updatedBy = Auth::user()->id;
        $product->update([
            'product_model_id' => $request->model,
            'name' => $request->name,
            'code' => $request->sku,
            'description' => $request->size,
            'updated_at' => now(),
            'update_by' => $updatedBy
        ]);

        foreach ($request->price as $priceId => $price) {
            $productPrice = ProductPrice::find($priceId);
            $productPrice->price = $price;
            $productPrice->status = isset($request->status[$priceId]) ? 1 : 0;
            $productPrice->save();
        }

        return redirect()->route('administrator.product')->with('success', 'Product updated successfully');
    }
    public function destroy($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        $currentPage = $request->query('page', 1);

        return redirect()->route('administrator.product', ['page' => $currentPage])->with([
            'success' => 'Product deleted successfully!',
            'id' => $id
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids) > 0) {
            Product::whereIn('id', $ids)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Selected product have been deleted successfully.',
                'deleted_ids' => $ids
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No product selected for deletion.'
        ], 400);
    }

    public function deleteImage($id)
    {
        $product = Product::find($id);

        if ($product) {
            $oldImagePath = str_replace(asset('public'), 'file/product/', $product->image);

            if (Storage::disk('public')->exists('file/product/' . $oldImagePath)) {
                Storage::disk('public')->delete('file/product/' . $oldImagePath);
            }

            $product->update([
                'image' => null,
                'updated_by' => Auth::user()->id
            ]);

            return response()->json(['success' => 'Image deleted successfully']);
        }
    }

    public function importPage()
    {
        return view('administrator.product.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            $file = $request->file('file');

            Excel::import(new ProductImport, $file);

            return redirect()->back()->with('success', 'Data imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['file' => 'Error importing data: ' . $e->getMessage()]);
        }
    }

    public function exportPage()
    {
        $models = ['DAE', 'EDA'];

        return view('administrator.product.export', compact('models'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'model' => 'nullable|in:DAE,EDA',
        ]);

        $model = $request->input('model');

        if ($model) {
            $data = Product::where('model', 'like', "{$model}-%")->get();
        } else {
            $data = Product::all();
        }

        return Excel::download(new ProductExport($data), 'products.xlsx');
    }

    private function getDataByModel($model)
    {
        if ($model === 'DAE') {
            return Product::where('model', 'DAE')->get();
        } elseif ($model === 'EDA') {
            return Product::where('model', 'EDA')->get();
        }

        return collect();
    }
}
