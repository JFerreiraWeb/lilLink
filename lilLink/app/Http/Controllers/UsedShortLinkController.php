<?php

namespace App\Http\Controllers;

use App\Models\UsedShortLink;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class UsedShortLinkController extends Controller
{

    public function index()
    {
        $linkList = $this->listLinks();
        return view('home', compact('linkList'));
    }

    public function redirect($short_link)
    {
        $shortLink = DB::table('list_short_url')->where('short_url', '=', $short_link);
        //check if we have a matching short_url
        if(!$shortLink->exists())
        {
            return redirect()->action([UsedShortLinkController::class, 'index'])->with('error', 'URL Not Found');
        }

        //check if we have a long url for the matching short_url
        $longLink = DB::table('used_short_url')->where('short_url_id', '=' , $shortLink->value('id'));

        if (!$longLink->exists())
        {
            return redirect()->action([UsedShortLinkController::class, 'index'])->with('error', 'URL Not Found');
        }

        //increment the number of visits
        $this->incrementNumberOfVisits($longLink);

        return redirect($longLink->value('long_url'));

    }

    protected function incrementNumberOfVisits($longLink)
    {
        DB::table('used_short_url')
            ->where('id', $longLink->value('id'))
            ->increment('visited_no',1);
    }

    public function shorten(Request $request)
    {

        //get only short_urls that have not been used yet.
        $usedUrls = DB::table('list_short_url')
            ->select('*')
            ->whereNotIn('id', function($query){
                $query->select('short_url_id')->from('used_short_url');
            })->first();

        //make check the private checkbox
        $private = false;
        if ($request->has('is_private')){
            $private = true;
        }

        //insert the used_short_url into the db.
        DB::table('used_short_url')->insert([
           'long_url' => $request['long_url'],
            'short_url_id' => $usedUrls->id,
            'description' => $request['url_description'],
            'visited_no' => 0,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            'is_private' => $private,
        ]);


        return redirect()->action([UsedShortLinkController::class, 'index'])->with('shorten-success', 'URL has been shortened - '. URL::to('/') . '/' . $usedUrls->short_url);
    }

    public function listLinks()
    {
        //get list of shortned links.
        return UsedShortLink::join('list_short_url', 'list_short_url.id', '=', 'used_short_url.short_url_id')
            ->select('used_short_url.long_url as long_url', 'list_short_url.short_url as short_url', 'used_short_url.updated_at')
            ->where('is_private', false)
            ->orderBy('used_short_url.updated_at', 'desc')
            ->get();
    }

}
