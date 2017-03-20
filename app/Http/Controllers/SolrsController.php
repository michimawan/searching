<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
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
        // try {
        //     $temp = $this->client;
        //     $query = $temp->createSelect();
        //     $query->setQuery('content:"'.$request->input('content').'"');
        //     //dd($query);
        //     $resultset = $temp->select($query);
        //     return View::make('solr.search')->with(['results' => $resultset, 'title' => 'Solr - Searched Documents']);
        // } catch(Solarium\Exception $e) {
        //     return View::make('solr.search')->with('result', $e->message());
        // }
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
        } catch(Solarium\Exception $e) {
            return View::make('solr.index')->with('result', $e->message());
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
        $temp = $this->client;
        $update = $temp->createUpdate();
        $doc = $update->createDocument();
        $doc->id = $request->input('id');
        $doc->content = $request->input('content');
        $update->addDocument($doc);
        $update->addCommit();
        $result = $temp->update($update);
        return Redirect::to('solr.index');
    }
}