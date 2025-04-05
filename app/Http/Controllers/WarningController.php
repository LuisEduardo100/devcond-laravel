<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Warning;
use App\Models\Unit;


class WarningController extends Controller
{
    public function getMyWarnings(Request $req)
    {
        $array = ['error' => ''];

        $property = $req->input('property');
        if ($property) {
            $user = Auth::user();

            $unit = Unit::where('id', $property)
                ->where('id_owner', $user['id'])
                ->count();

            if ($unit > 0) {
                $warnings = Warning::where('id_unit', $property)
                    ->orderBy('date_created', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();

                foreach ($warnings as $warningKey => $warningValue) {
                    $warnings[$warningKey]['date_created'] = date('d/m/Y', strtotime($warningValue['date_created']));
                    $photoList = [];
                    $photos = explode(',', $warningValue['photos']);

                    foreach ($photos as $photo) {
                        if (!empty($photo)) {
                            $photoList[] = Storage::url($photo);
                        }
                    }

                    $warnings[$warningKey]['photos'] = $photoList;
                }

                $array['list'] = $warnings;
            } else {
                $array['error'] = 'Você não possui essa unidade.';
            }
        } else {
            $array['error'] = 'Informe a unidade.';
        }

        return $array;
    }
}
