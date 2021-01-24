<?php
namespace App\Repositories;

use App\Classes\GithubApi;
use App\Http\Requests\SearchApiRequest;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Pagination\LengthAwarePaginator;

class GithubApiResultsRepository
{
    protected $git_api;

    /**
     * GithubApiResultsRepository constructor.
     * @param GithubApi $git_api
     */
    public function __construct(GithubApi $git_api)
    {
        $this->git_api = $git_api;
    }

    /**
     * @param SearchApiRequest $request
     * @return array
     */
    public function results(SearchApiRequest $request){
        $start_date = $request->get('start_date');
        $count = $request->get('count');
        $lang = $request->get('lang');
        $page = $request->get('page');
        $records = ['items'=>[]];
        $total = 0;
        $incomplete_results = false;
        $success = false;
        try {
            $result = $this->git_api->search($start_date, $count, $lang, $page);
        }
        catch(ConnectionException $e){
            return ['success'=>false, 'data'=>$records, 'incomplete_results'=>$incomplete_results, 'total'=>$total];
        }
        if ($result->successful()){
            $records = $result->json();
            $total=$count?:$records['total_count'];
            $incomplete_results = $records['incomplete_results'];
            $success = true;
        }
        $data = new LengthAwarePaginator($records['items'], $total, $count?:100, $page, ['path'  => $request->url(),'query' => $request->query(),]);
        return ['success'=>$success, 'data'=> $data, 'incomplete_results'=>$incomplete_results, 'total'=>$total];
    }
}
