<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchApiRequest;
use App\Repositories\GithubApiResultsRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class MainController extends Controller
{
    protected $git_api_repo;

    /**
     * MainController constructor.
     * @param GithubApiResultsRepository $git_api_repo
     */
    public function __construct(GithubApiResultsRepository $git_api_repo)
    {
        $this->git_api_repo = $git_api_repo;
    }

    /**
     * @return Factory|View
     */
    public function index(){
        return view('main');
    }

    /**
     * @param SearchApiRequest $request
     * @return Factory|View
     */
    public function main(SearchApiRequest $request){
        $result = $this->git_api_repo->results($request);
        $data = $result['data'];
        $total = $result['total'];
        $success = $result['success'];
        $incomplete_results= $result['incomplete_results'];
        return view('main', compact('success','data', 'total', 'incomplete_results'));
    }
}
