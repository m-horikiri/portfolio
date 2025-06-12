<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Uploaded;
use App\Services\GoogleAdsService;
use Inertia\Inertia;

class SendApiController extends Controller
{
    protected $googleAdsService;

    public function __construct(GoogleAdsService $googleAdsService)
    {
        $this->googleAdsService = $googleAdsService;
    }

    public function listConversionActions(Request $request)
    {
        $conversionActions = $this->googleAdsService->getConversionActions($request->customer_id);
        return Inertia::render('GoogleAds/Data/Index', [
            'conversionActions' => $conversionActions,
        ]);
    }


    public function offlineConversionUploaded(Request $request)
    {
        $request->validate([
            'customer_id' => ['required', 'numeric']
        ]);
        $response = $this->googleAdsService->getUploaded($request->customer_id);
        return Inertia::render('GoogleAds/Data/Index', [
            'offlineCvUploaded' => $response,
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'media' => ['required', 'string'],
            'gclid' => ['required', 'string'],
            'conversion_time' => ['required', 'regex:/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}[\+\-]\d{2}:\d{2}$/'],
            'conversion_value' => ['required', 'numeric'],
            'conversion_action_id' => ['required', 'numeric'],
            'order_id' => ['required', 'string'],
            'validate_only' => ['numeric']
        ]);

        $response = $this->googleAdsService->uploadOfflineConversion(
            $request->media,
            $request->gclid,
            $request->conversion_time,
            $request->conversion_value,
            $request->conversion_action_id,
            $request->order_id,
            $request->validate_only
        );

        Uploaded::create([
            'status' => $response['status'],
            'validate_only' => (bool) $response['validate_only'],
            'name' => $request->name,
            'customer_id' => (int) $response['customer_id'],
            'gclid' => $response['gclid'],
            'conversion_action_id' => (int) $response['conversion_action_id'],
            'conversion_date_time' => $response['conversion_date_time'],
            'conversion_value' => (int) $response['conversion_value'],
            'order_id' => $response['order_id'],
        ]);

        return Inertia::location(route('uploaded'));
    }

    public function adjustment(Request $request)
    {
        $request->validate([
            'customer_id' => ['required', 'numeric'],
            'conversion_action_id' => ['required', 'numeric'],
            'order_id' => ['required', 'string'],
            'adjustment_type' => ['required', 'string'],
            'restatement_value' => ['numeric'],
            'adjustment_date_time' => ['required', 'regex:/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}[\+\-]\d{2}:\d{2}$/'],
        ]);

        $response = $this->googleAdsService->adjustmentUploadConversion(
            $request->customer_id,
            $request->conversion_action_id,
            $request->order_id,
            $request->adjustment_type,
            $request->restatement_value,
            $request->adjustment_date_time,
            $request->validate_only
        );

        $request->session()->flash('response', $response);

        return Inertia::location(route('uploaded'));
    }
}
