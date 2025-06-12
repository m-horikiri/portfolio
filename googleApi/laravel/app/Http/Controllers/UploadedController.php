<?php

namespace App\Http\Controllers;

use App\Models\Uploaded;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UploadedController extends Controller
{
    // アップロード済情報一覧を表示
    public function index()
    {
        $uploadeds = Uploaded::all();
        return Inertia::render('GoogleAds/Uploaded/Index', ['uploadeds' => $uploadeds]);
    }

}
