<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
class CkeditorController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(): View
    {
        return view('ckeditor');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function upload(Request $request): JsonResponse
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload');
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension =  $originName->getClientOriginalExtension();
            $newFileName  = $fileName . '_' . time() . '.' . $extension;

            $originName->storeAs('upload/', $newFileName, 'public');
            
            $url = asset('storage/upload/' . $newFileName );
  
            return response()->json(['fileName' => $newFileName , 'uploaded'=> 1, 'url' => $url]);
        }
    }
}