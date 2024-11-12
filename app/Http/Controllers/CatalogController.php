<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Language;

class CatalogController extends MainController
{
    function catalogIndex()
    {

        $locale = app()->getLocale();
        $language = Language::where('code', $locale)->first();
        $catalog = Catalog::select(
            'catalog.*',
            'catalog_content.*',
            'catalog_content.id as content_id',
            'catalog_content.name as content_name'
        )
            ->where('catalog.status', true)
            ->join('catalog_content', 'catalog_content.catalog_id', '=', 'catalog.id')
            ->where('catalog_content.language_id', $language->id)
            ->get();
        // dd($catalog);
        return view('download', compact('catalog'));
    }
    function downloadCatalog($lang, $id)
    {
        $language = Language::where('code', $lang)->first();
        $catalogContent =  Catalog::select(
            'catalog.*',
            'catalog_content.*',
            'catalog_content.id as content_id',
            'catalog_content.name as content_name'
        )
            ->where('catalog.status', true)
            ->where('catalog.id', $id)
            ->join('catalog_content', 'catalog_content.catalog_id', '=', 'catalog.id')
            ->where('catalog_content.language_id', $language->id)
            ->first();

        $filePath = public_path() . '/upload/file/catalog/file/' . strtolower($language->code) . '/' . $catalogContent->file;

        return response()->download($filePath, $catalogContent->file);
    }
}
