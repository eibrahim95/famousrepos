<?php

namespace Tests\Feature;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Tests\Classes\Repo;
use Tests\TestCase;

class GithubApiTest extends TestCase
{
    public function test_getMainPage(){
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText("Results will show here");
    }
    public function test_githubCallFailHandling(){
        Http::fake([
            'github.com/*' => Http::response([], 500),

        ]);
        $response = $this->get(route('search').'?start_date='.date('Y-m-d',strtotime("-1 days")).'&count='.'10');
        $response->assertStatus(200);
        $response->assertSeeText("There was a problem connecting to github api, pls try again later");
    }
    public function test_numberOfReposOption()
    {
        // not allowed value for count
        $response = $this->get(route('search').'?start_date='.date('Y-m-d',strtotime("-1 days")).'&count='.'1');
        $response->assertStatus(302);
        $response->assertSeeText(" Redirecting to ");

        // correct number of results viewed
        $items = ['total_count'=>50, "incomplete_results"=> true, 'items'=>Repo::factory()->count(50)->make()];
        Http::fake([
            'github.com/*' => Http::response($items, 200),

        ]);
        $response = $this->get(route('search').'?start_date='.date('Y-m-d',strtotime("-1 days")). '&count='.'50');
        $response->assertStatus(200);
        $response->assertSeeText("Result (50)");
    }
    public function test_showIncompleteResultsWarning(){
        // if incomplete_results : true is returned from github a warning should appear to let the user know
        $items = ['total_count'=>50, "incomplete_results"=> true, 'items'=>Repo::factory()->count(50)->make()];
        Http::fake([
            'github.com/*' => Http::response($items, 200),

        ]);
        $response = $this->get(route('search').'?start_date='.date('Y-m-d',strtotime("-1 days")));
        $response->assertStatus(200);
        $response->assertSeeText("These Results are not complete see ");

    }
    public function test_showPagination(){
        // 120 records should be 2 pages if no count is specified
        $items = ['total_count'=>120, "incomplete_results"=> false, 'items'=>Repo::factory()->count(120)->make()];
        Http::fake([
            'github.com/*' => Http::response($items, 200),

        ]);
        $response = $this->get(route('search').'?start_date='.date('Y-m-d',strtotime("-1 days")));
        $response->assertStatus(200);
        $this->assertEquals($response->getOriginalContent()->getData()['data']->lastPage(), 2);
    }
    public function test_testView(){
        $errors = new Collection([]);
        $v = $this->view('main', ['errors'=>$errors]);
        $v->assertSee('Results will show here');
        $v = $this->view('main', ['success'=>false, 'errors'=>$errors]);
        $v->assertSee('There was a problem connecting to github api, pls try again later');

    }
}
