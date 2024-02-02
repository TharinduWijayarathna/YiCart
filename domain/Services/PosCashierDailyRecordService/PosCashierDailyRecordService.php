<?php

namespace domain\Services\PosCashierDailyRecordService;

use App\Models\PosCashierDailyRecord;
use domain\Facades\PosCashierDailyRecordFacade\PosCashierDailyRecordFacade;
use Illuminate\Support\Facades\Auth;

/**
 * PosCashierDailyRecordService
 * php version 8
 *
 *
 * */
class PosCashierDailyRecordService
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->daily_record = new PosCashierDailyRecord();
    }

    /**
     * All
     * retrieve all the data from PosCashierDailyRecord model
     *
     * @return void
     */
    public function all()
    {
        return  $this->daily_record->all();
    }

    /**
     * Store
     * store data in database
     *
     * @param  array $data
     * @return void
     */
    public function store(float $start_amount)
    {
        $data['start_day_amount'] = $start_amount;
        $data['user_id'] = Auth::id();
        return $this->daily_record->create($data);
    }

    /**
     * Get
     * retrieve relevant data using daily_record_id
     *
     * @param  int  $daily_record_id
     * @return void
     */
    public function get()
    {
        return $this->daily_record->getDailyDetails(Auth::id());
    }

    /**
     * Update
     *
     * @param  float $end_amount
     * @return void
     */
    public function update(float $end_amount)
    {
        $id = Auth::id();
        $cashier = $this->daily_record->getDetailsForUpdate($id);
        if($cashier){
            $cashier->end_day_amount = $end_amount;
            $cashier->save();
            return $cashier;
        }
    }

    /**
     * Edit
     * merge data which retrieved from update function as an array
     *
     * @param  PosCashierDailyRecord $daily_record
     * @param  array $data
     * @return void
     */
    protected function edit(PosCashierDailyRecord $daily_record, array $data)
    {
        return array_merge($daily_record->toArray(), $data);
    }

    /**
     * Delete
     * delete specific data using daily_record_id
     *
     * @param  int   $daily_record_id
     * @return void
     */
    public function delete(int $daily_record_id)
    {
        return $this->daily_record->find($daily_record_id)->delete();
    }
}
