<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportLegacyRequest;
use App\Services\LegacyStudentAdapterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class LegacyImportController extends Controller
{
    public function __construct(
        protected LegacyStudentAdapterService $adapter
    ) {
    }

    public function __invoke(ImportLegacyRequest $request): JsonResponse
    {
        $records = new Collection($request->input('students', []));

        $result = $this->adapter->import($records);

        return response()->json([
            'message' => 'Legacy import completed.',
            'result'  => $result,
        ]);
    }
}
