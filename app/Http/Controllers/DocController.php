<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doc;
use Illuminate\Support\Facades\Storage;

class DocController extends Controller
{
    public function getAll()
    {
        $array = ['error' => ''];
        $docs = Doc::all();

        foreach ($docs as $docKey => $docValue) {
            $docs[$docKey]['file_url'] = Storage::url($docValue['file_url']);
        }

        $array['list'] = $docs;
        return $array;
    }
}
