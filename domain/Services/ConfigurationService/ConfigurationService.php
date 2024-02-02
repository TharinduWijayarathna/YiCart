<?php

namespace domain\Services\ConfigurationService;

use App\Models\BusinessDetail;
use Illuminate\Support\Facades\Auth;


class ConfigurationService
{
    protected $business_detail;
    public function __construct()
    {
        $this->business_detail = new BusinessDetail();
    }


    /**
     * store
     *
     * @param  mixed $data
     * @return void
     */
    public function store(array $data)
    {
        $data['created_by'] = Auth::user()->id;

        return $this->business_detail->create($data);
    }

    public function update($data, $id)
    {
        $configuration = $this->business_detail->findOrFail($id);
        $configuration->update($data);
    }

    public function delete(int $id)
    {
        return $this->business_detail->find($id)->delete();
    }

    public function removeLogo(int $id)
    {
        $details = $this->business_detail->find($id);
        $details->image_id = null;
        $details->save();
    }
}
