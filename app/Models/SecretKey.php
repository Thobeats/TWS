<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecretKey extends Model
{
    use HasFactory;

  //  private $stripe_key = "sk_test_51JDQeGK8ulhDI3CCKmpB5jlLQTvsIQttmuc2F82BcEbh2hgyBMF0YH6fnu7DuLSsFRboWO8vsz5D2Pf995r5fuCZ00TauE4nrw";

    private $stripe_key = "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";
   // private $pk_key = "pk_test_51JDQeGK8ulhDI3CCfH8CtMRV3XUQq5YXGrLDVk5hnipMPMGdENm7AAEeHkuvZPiTrFBizZErg93qGxWVfeOOYTJf00Wm2TrPWt";

    private $pk_key = "pk_live_51NDrKkGQDXoy7rGv0BGikXyVPqDXDtw1O81wFh5LcADDVfNnAQX6KjVuhZePLytwsOpgivGdItkH8Tyy1uEHOLLc00Xu8qxR8M";

    public function getKey(){
        return $this->pk_key;
    }

    public function getSecret(){
        return $this->stripe_key;
    }
}
