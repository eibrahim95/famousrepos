<?php
namespace App\Classes;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Psr7\Query;

class GithubApi
{
    private $endpoint = "https://api.github.com/search/repositories";
    protected $query;

    /**
     * GithubApi constructor.
     * @param Query $query
     */
    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    /**
     * @param $start_date
     * @param null $count
     * @param null $lang
     * @param int $page
     * @return Response
     */
    function search($start_date, $count=null, $lang=null, $page=1){
        $per_page = $count?:100;
        $query = 'created:>'.$start_date;
        $query = $lang ? $query . '+language:'.$lang : $query;
        $params = [
            'q' => $query,
            'sort' => 'stars',
            'order' => 'desc',
            'per_page' => $per_page,
            'page' => $page,
            'language' => $lang
        ];
        $q = $this->query->build($params,false);
        return Http::get($this->endpoint, $q);

    }
}
