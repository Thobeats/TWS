<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EINModel extends Model
{
    use HasFactory;

    private $token = "3932f3b0-cfab-11dc-95ff-0800200c9a663932f3b0-cfab-11dc-95ff-0800200c9a66";
    private $url = "https://www.hipaaspace.com/api/ein/getcode?";

    public function verifyEin($ein){
        $req = $this->url . "&q=$ein&rt=json&token=". $this->token;

        $response = Http::get($req);
        return $response->json();
    }
}
