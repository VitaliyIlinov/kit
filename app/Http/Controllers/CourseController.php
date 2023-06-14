<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Console\Commands\ImportBestRates;
use App\Http\Requests\CourseListRequest;
use App\Http\Requests\ShowRateRequest;
use App\Http\Resources\CourseResources;
use App\Models\Course;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

final class CourseController extends Controller
{
    public function index(CourseListRequest $request): AnonymousResourceCollection
    {
        $data = Course::query()
            ->when($request->has('from'), function (Builder $builder) use ($request) {
                $builder->where('from', $request->from);
            })
            ->when($request->has('to'), function (Builder $builder) use ($request) {
                $builder->where('to', $request->to);
            })
            ->paginate();

        return CourseResources::collection($data);
    }

    public function showRates(ShowRateRequest $request): CourseResources
    {
        $data = Course::query()
            ->where('from', $request->from)
            ->where('to', $request->to)
            ->first();
        return CourseResources::make($data);
    }

    public function refreshRate(): Response
    {
        Artisan::queue(ImportBestRates::COMMAND_NAME);
        return response()->noContent();
    }
}
