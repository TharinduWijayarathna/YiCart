<?php

namespace App\Http\Controllers;

use App\Http\Requests\Configuration\CreateConfigurationRequest;
use App\Models\BusinessDetail;
use domain\Facades\ConfigurationFacade\ConfigurationFacade;
use domain\Facades\ImageFacade\ImageFacade;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ConfigurationController extends ParentController
{
    public function index()
    {
        if (Auth::user()->user_role_id == 1) {
            return Inertia::render('Configuration/index');
        } else {
            return Inertia::render('Cart/index');
        }
    }

    public function store(CreateConfigurationRequest $request)
    {
        if ($request->has('image')) {
            $image = ImageFacade::store($request->file('image'));
            $request->merge(['image_id' => $image->id]);
        }
        return ConfigurationFacade::store($request->all());
    }

    public function get()
    {
        return BusinessDetail::first();
    }

    public function update(CreateConfigurationRequest $request, int $id)
    {
        try {
            if ($request->has('image')) {
                $image = ImageFacade::store($request->file('image'));
                $request->merge(['image_id' => $image->id]);
            }
            return ConfigurationFacade::update($request->all(), $id);
        } catch (\Throwable $th) {
            return response()->json([
                // 'message' => 'Product update failed'
                'message' => $th->getMessage(),
            ], 422);
        }
    }

    public function delete($id)
    {
        return ConfigurationFacade::delete($id);
    }

    public function removeLogo($id)
    {
        return ConfigurationFacade::removeLogo($id);
    }
}
