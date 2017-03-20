<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Redirect;
use Solarium;
use Config;
use View;

class SolrsController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Solarium\Client(Config::get('solr'));
    }

    public function ping()
    {
        $ping = $this->client->createPing();
        try {
            $result = $this->client->ping($ping);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        echo "success";
    }

    public function search(Request $request)
    {
        $content = $request->input('content');
        if ($content) {
            try {
                $query = $this->client->createSelect();
                $query->setQuery($content);
                $resultset = $this->client->select($query);
                return View::make('solr.search')->with(['results' => $resultset, 'title' => 'Solr - Searched Documents']);
            } catch(\Exception $e) {
                dd($e->getMessage());
            }
        }
        return Redirect::route('solr.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $temp = $this->client;
            $query = $temp->createQuery($temp::QUERY_SELECT);
            $resultset = $temp->execute($query);
            return View::make('solr.index')->with(['results' => $resultset, 'title' => 'Solr - List of Indexed Documents']);
        } catch(\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('solr.create')->with(['title' => 'Solr - Add Indexed Document']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        list ($status, $path) = $this->uploadFile($request);
        if ($status) {
            $full_path = "http://" . $request->getHost() . '/' . $path;

            $query = $this->client->createExtract();
            $query->addFieldMapping('content', 'text');
            $query->setUprefix('attr_');
            $query->setFile($full_path);
            $query->setCommit(true);
            $query->setOmitHeader(false);

            // add document
            $doc = $query->createDocument();
            $doc->id = $path;
            $query->setDocument($doc);

            // this executes the query and returns the result
            $result = $this->client->extract($query);
        }
        return Redirect::route('solr.index');
    }

    private function uploadFile($request)
    {
        if ($request->file('pdf-file')) {
            $filename = Carbon::now()->timestamp . '_' . $request->file('pdf-file')->getClientOriginalName();
            $path = Config::get('file.base_path');
            return [$request->file('pdf-file')->move($path, $filename), $path . $filename];
        }
        return false;
    }
}