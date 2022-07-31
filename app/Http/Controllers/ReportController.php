<?php

namespace App\Http\Controllers;

use App\Http\Filters\AppFilter;
use App\Http\Requests\AppsFilterRequest;
use App\Http\Resources\ReportResource;
use App\Models\App;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Report Controller
 */
class ReportController extends Controller
{

    /**
     * Reports
     * @param AppsFilterRequest $request
     * @return AnonymousResourceCollection
     */
    public function reports(AppsFilterRequest $request): AnonymousResourceCollection
    {
        $filterable = new AppFilter($request);
        $data = App::with('device')->filter($filterable)->get();
        return ReportResource::collection($data);
    }
}
