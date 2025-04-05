<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Billet;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BilletController extends Controller
{
    public function getAll(Request $req)
    {
        $array = ['error' => ''];

        $property = $req->input('property');
        if ($property) {
            $user = Auth::user();

            $unit = Unit::where('id', $property)
                ->where('id_owner', $user['id'])
                ->count();

            if ($unit > 0) {
                $billets = Billet::where('id_unit', $property)->get();

                foreach ($billets as $billetKey => $billetValue) {
                    $billets[$billetKey]['file_url'] = Storage::url($billetValue['file_url']);
                }

                $array['list'] = $billets;
            } else {
                $array['error'] = 'Propriedade não é sua';
                return $array;
            }
        } else {
            $array['error'] = 'Propriedade não informada';
            return $array;
        }

        return $array;
    }
}
