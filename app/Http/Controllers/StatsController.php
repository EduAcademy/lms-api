<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\StatsServiceInterface;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    protected StatsServiceInterface $statsService;

    public function __construct(StatsServiceInterface $statsService)
    {
        $this->statsService = $statsService;
    }

    /**
     * Handles incoming requests.
     */
    public function __invoke(Request $request)
    {
        $result = $this->statsService->getStats();
        return $result;
    }
}
