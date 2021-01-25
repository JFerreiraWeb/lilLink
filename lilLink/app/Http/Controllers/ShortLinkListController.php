<?php

namespace App\Http\Controllers;

use App\Models\ShortLinkList;
use App\Models\UsedShortLink;
use Illuminate\Http\Request;
use SplFileObject;

class ShortLinkListController extends Controller
{

    public function getlist()
    {
        $file = "https://www.eff.org/files/2016/09/08/eff_short_wordlist_2_0.txt";
        $this->updateList($file);

        return redirect()->action([UsedShortLinkController::class, 'index'])->with('list-update-success', 'Short Url List Updated');
    }

    public function updateList($file)
    {
        $file = new SplFileObject($file);
        $obj = array();

        while(!$file->eof())
        {
            $shortLink = preg_split('/\s+/', $file->fgets());
            array_push($obj, ['externalId' => $shortLink[0], 'short_url' => $shortLink[1]]);
        }
        $file = null;

        ShortLinkList::upsert($obj, array());



    }
}
