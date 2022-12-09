<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Service;
use App\Models\Section;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use App\Models\Testimonial;
use App\Models\Partner;
use App\Models\UserContact;
use App\Models\ContactModel;
use App\Models\ServiceCategory;
use App\Models\Faq;
use App\Models\OurTeam;
use App\Models\PageModel;
use App\Models\PageSectionModel;
use App\Models\User;
use DB;
use App\Traits\PageComponentTrait;
use App\Models\Booking;


class ApiController extends Controller
{
    public function api_check(Request $req)
    {
        $api_key = $req->api_key;
        $my_api = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYzVmOTM1MWE4OThmNzM1OGFjZWM0NjcyYzhmODRlMjJhMzA1Y2I4MThmZTMxMWNhMWU1MzVkYWNjMjk1ZDdhNmY0NDVhM2Q1OWFjNGYxNjIiLCJpYXQiOjE2NjA2MjU5OTYuNDMzNDk2LCJuYmYiOjE2NjA2MjU5OTYuNDMzNTAxLCJleHAiOjE2OTIxNjE5OTYuNDAwNDE3LCJzdWIiOiIxNiIsInNjb3BlcyI6W119.m4-GQ2hTqpCUqpHnWQas86lvl3Oz0JwOA0fay_YyNg89p5iJ71hK-4Y3TXLd4lsnh-_pRJ0JhYoO16chsHjU9-iKo-DA3q754Mo6VrS4HjScHdK1xZyIr__NdKT_Hp2BQqRC-PtV6YcKxc13J9vD4hHC9xvcz9VDScruye2NpGBbG2SF1jMP7e7iquiLR4cFmt6uFQrNFiZy3DYfUHcZD146biqrzL0uAexLiYQCfgDdCUjwHr8M5jiH_6_c6OqXDePkRyfR9OSFNHV1vEJdVZhgPUtixg_FkLATMISwY8oS4ZvxMTUaP1geDl1euJPC8vTEb4-bumh9gUVZM2tVDlmLzFqS77fwYfjs0coeaI1wnfQEiWfMJsO3orxGEhME_bj6nLMMjUVKyEf8KGbUb-Bd5Pk7mROVVrCdQTrrkEueuABa-EJWu97uiUCrIVDlMWz35VTsHDaExbrh_Ve0rogiGPBu5ugbOHWrEVCLdssV7HAn2oHeHrk5NrmsHCb98HPegzUiC-irWFtqu_TzraM_FrZBqoX42bdoTFr1MbWa80oaWVitqLw4wUgBpyR35OumCs8Nrm3J7EXOVlbDwuVPfa_aPAg1mKa-6grRsu0K5WcW_Neggfqj5HIWjE2XL03DQd8oP_xRsK6-FQSnDeVKJiTFL_ksrk4_Jt1USrg';
        if($api_key == $my_api){
            echo "success ";
        }else{
            echo "faild";
        }
    }
}
