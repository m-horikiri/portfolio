<?php

namespace App\Http\Controllers;

use App\Models\GoogleAdsData;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GoogleAdsDataController extends Controller
{
    // 登録情報一覧を取得
    public function index()
    {
        $datas = GoogleAdsData::all();
        return Inertia::render('GoogleAds/Data/Index', ['datas' => $datas]);
    }

    // 情報を追加
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'media' => 'required',
            'gclid' => 'required',
            'acceptanceTime' => 'required',
        ]);
        GoogleAdsData::create([
            'name' => $request->name,
            'media' => $request->media,
            'gclid' => $request->gclid,
            'acceptanceTime' => $request->acceptanceTime,
        ]);
        return Inertia::location(route('data'));
    }

    // 情報を削除
    public function destroy($id)
    {
        $data = GoogleAdsData::findOrFail($id);
        $data->delete();
        return Inertia::location(route('data'));
    }

}
