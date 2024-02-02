<?php

namespace domain\Services\StockLogService;

use App\Models\StockLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StockLogService
{
    protected $log;

    public function __construct()
    {
        $this->log = new StockLog();
    }



    /**
     * store
     *
     * @param  mixed $data
     * @return void
     */
    public function store($data)
    {
        return $this->log->create($data);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function get($id)
    {
        return $this->log->findOrFail($id);
    }

    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $log = $this->log->findOrFail($id);
        $log->delete();
        return $log;
    }

    /**
     * status
     *
     * @param  mixed $id
     * @return void
     */

    public function status($id)
    {
        $log = $this->log->findOrFail($id);
        if ($log->status == 0) {
            $log->status = 1;
        } else {
            $log->status = 0;
        }
        $log->update();
        return $log;
    }

    public function search($data)
    {
        return $this->log->search($data);
    }

    public function restoreStockLog($id)
    {
        return $this->log->onlyTrashed()->where('id', $id)->restore();
    }

    public function permanentDelete($id)
    {
        $log = $this->log->withTrashed()->findOrFail($id);
        return $log->forceDelete();
    }
    public function getLatestStockLog()
    {
        $count = $this->log->count();
        if ($count > 0) {
            $log = $this->log->latest('id')->first(['id', 'name', 'address', 'contact', 'email',]);
            return $log;
        } else {
        }
    }
    public function fillDateWithUpdatedAt()
    {
        $stock_logs = $this->log->where('date', null)->get();
        foreach ($stock_logs as $logs) {
                $logs->update([
                    'date' => $logs->created_at,
                ]);
        }
    }
}
