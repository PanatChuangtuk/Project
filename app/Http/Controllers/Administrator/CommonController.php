<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\{CommonContent, Common, Language};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Validator};

use App\Enum\CommonEnum;

class CommonController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $status = $request->input('status');

        $commonQuery = Common::with('content');

        if ($query) {
            $commonQuery->where('name', 'LIKE', "%{$query}%");
        }

        if ($status) {
            $statusValue = ($status === 'active') ? 1 : 0;
            $commonQuery->where('status', $statusValue);
        }

        $common = $commonQuery->paginate(10)->appends([
            'query' => $query,
            'status' => $status,
        ]);

        return view('administrator.common.index', compact('common', 'query', 'status'));
    }

    public function add()
    {
        $language = Language::get();
        $commonOptions = CommonEnum::cases();
        return view('administrator.common.add', compact('language', 'commonOptions'));
    }

    public function edit($id)
    {
        $language = Language::all();
        $commonOptions = CommonEnum::cases();
        $common = Common::find($id);
        $commonContent = CommonContent::where('common_id', $common->id)->get()->keyBy('language_id');

        return view('administrator.common.edit', compact('common', 'language', 'commonContent', 'commonOptions'));
    }

    public function submit(Request $request)
    {
        $languages = Language::all();
        $nameArray = $request->input('name');
        $type = $request->input('common_type');
        $contentArray = $request->input('content');
        $descriptionArray = $request->input('description');

        $rules = [];
        $messages = [];
        foreach ($languages as $language) {
            $rules['name.' . $language->id] = 'required_without_all:name.' . implode(',', $languages->pluck('id')->toArray());
            $messages['name.' . $language->id . '.required_without_all'] = "กรุณากรอกชื่อสำหรับภาษา " . $language->name;
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $common = Common::create([
            'name' => $nameArray[1] ?? $nameArray[2],
            'type' => $type,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        foreach ($languages as $language) {
            CommonContent::create([
                'common_id' => $common->id,
                'language_id' => $language->id,
                'name' => $nameArray[$language->id] ?? null,
                'content' => $contentArray[$language->id] ?? null,
                'description' => $descriptionArray[$language->id] ?? null,
            ]);
        }
        return redirect()->route('administrator.common');
    }

    public function update(Request $request, $id)
    {
        $languages = Language::all();
        $nameArray = $request->input('name');
        $contentArray = $request->input('content');
        $descriptionArray = $request->input('description');
        $updatedBy = Auth::user()->id;
        $type = $request->input('common_type');
        $common = Common::find($id);

        $common->update([
            'name' => $nameArray[1] ?? $nameArray[2],
            'type' => $type,
            'updated_by' => $updatedBy
        ]);

        foreach ($languages as $language) {
            $commonContent = CommonContent::where('common_id', $common->id)
                ->where('language_id', $language->id)
                ->first();
            if ($commonContent) {
                $commonContent->update([
                    'name' => $nameArray[$language->id] ?? null,
                    'content' => $contentArray[$language->id] ?? null,
                    'description' => $descriptionArray[$language->id] ?? null,
                    'updated_by' => $updatedBy
                ]);
            }
        }

        return redirect()->route('administrator.common');
    }

    public function destroy($id, Request $request)
    {
        $common = Common::findOrFail($id);
        $common->delete();

        $currentPage = $request->query('page', 1);

        return redirect()->route('administrator.common', ['page' => $currentPage])->with([
            'success' => 'Common deleted successfully!',
            'id' => $id
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids) > 0) {
            Common::whereIn('id', $ids)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Selected common have been deleted successfully.',
                'deleted_ids' => $ids
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No common selected for deletion.'
        ], 400);
    }
}
