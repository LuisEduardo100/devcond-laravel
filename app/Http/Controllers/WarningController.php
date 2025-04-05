<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

    public function addWarningFile(Request $req)
    {
        $array = ['error' => ''];

        $validator = Validator::make($req->all(), [
            'photo' => 'required|file|mimes:jpg,png'
        ]);

        if (!$validator->fails()) {
            $file = $req->file('photo')->store('photos', 'public');
            $array['photo'] = Storage::url($file);
        } else {
            $array['error'] = $validator->error()->first();
        }

        return $array;
    }

    public function setWarning(Request $req)
    {
        $array = ['error' => ''];

        try {
            $validator = Validator::make($req->all(), [
                'title' => 'required',
                'property' => 'required',
                'list' => 'required|array'
            ]);

            if (!$validator->fails()) {
                $title = $req->input('title');
                $property = $req->input('property');
                $list = $req->input('list');

                $newWarning = new Warning();
                $newWarning->id_unit = $property;
                $newWarning->title = $title;
                $newWarning->status = 'IN_REVIEW';
                $newWarning->date_created = date('d/m/Y');

                if ($list && is_array($list)) {
                    $photos = [];
                    foreach ($list as $photo) {
                        $url = explode('/', $photo);
                        $photos[] = end($url);
                    }
                    $newWarning->photos = implode(',', $photos);
                }

                $newWarning->save();
            } else {
                $array['error'] = $validator->errors()->first();
            }

            return $array;
        } catch (\Exception $e) {
            $array['error'] = $e->getMessage();
            return $array;
        }
    }
}
