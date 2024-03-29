<?php

namespace App\Controllers;

use DateTime;
use View;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->token = 'UhAh0bmpYguaavD8_1tlBA1vAHy3hSnsXoGaLYOqAv09q2FhN8GZ8nbN2Oo-mbBsU78hyzHSozvUe-07VP9S3zx1XcFqOFKdh53byivad4mAY_XUNyzdrKQ0yOZ3SRg9VLAGMjdUS3o84bK0nbhmDjZTXT4wJpVm22LoYJK57TH9XvM5aPje-ove03eTMj_z2j2lSI68fRgsxU_0sU79Ci4I371_cwOlxRqxWRvPZbw8xgbAj_m1lYfT4cQm8ATd35d7m00UHdWbbnbBFKaZ5SpiG_KtL6xSVqAjGwXdcl4RuJi9EkgVxoxjDf2c9vZ00Tw7oRTY4o4I41lHqPe0-w';

        $this->outletKey = '1kfk2u28ef3ut1nm5o9tozdg65';
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $this->middleware('Auth');
        
        if (auth()->role != 'admin' && auth()->role != 'producer') {
            return abort(401);
        }
        
        $rounds = [];
        $matches = [];

        $season = get('league') == 344 || get('league') == 964 ? '2023' : '2022';

        if (get('league') && get('type') != 'standings') {
            $response = http()
                ->withHeaders([
                    'x-rapidapi-host' => 'v3.football.api-sports.io',
                    'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
                ])
                ->get('https://v3.football.api-sports.io/fixtures/rounds', [
                    'league' => request('league'),
                    'season' => $season
                ]);

            $rounds = json($response->body())->response;
        }

        if (get('round')) {
            $response = http()
                ->withHeaders([
                    'x-rapidapi-host' => 'v3.football.api-sports.io',
                    'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
                ])
                ->get('https://v3.football.api-sports.io/fixtures', [
                    'league' => request('league'),
                    'season' => $season,
                    'round' => get('round')
                ]);

            $matches = json($response->body())->response;
        }

        return view('export.index', compact('rounds', 'matches'));
    }

    public function standings($league)
    {
        $season = $league == 344 || $league == 964 ? '2023' : '2022';

        $response = http()
            ->withHeaders([
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
            ])
            ->get('https://v3.football.api-sports.io/standings', [
                'league' => $league,
                'season' => $season
            ]);

        $response = json($response->body())->response;

        for ($i = 0; $i < count($response[0]->league->standings[0]); $i++) { 
            $data[$i]['position'] = $response[0]->league->standings[0][$i]->rank;
            $data[$i]['team'] = $response[0]->league->standings[0][$i]->team->name;
            $data[$i]['played'] = $response[0]->league->standings[0][$i]->all->played;
            $data[$i]['points'] = $response[0]->league->standings[0][$i]->points;
        }

        return view('export.standings', compact('data'));
    }

    public function fixture($league, $round)
    {
        $season = $league == 344 || $league == 964 ? '2023' : '2022';

        $response = http()
            ->withHeaders([
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
            ])
            ->get('https://v3.football.api-sports.io/fixtures', [
                'round' => $round,
                'league' => $league,
                'season' => $season
            ]);

        $response = json($response->body())->response;

        $i = 0;

        foreach ($response as $item) {
            $data[$i]['local'] = $item->teams->home->name;
            $data[$i]['date'] = (new DateTime($item->fixture->date))->format('d-M');
            $data[$i]['datetime'] = (new DateTime($item->fixture->date))->format('Y-m-d H:i:s');
            $data[$i]['time'] = (new DateTime($item->fixture->date))->format('H:i');
            $data[$i]['away'] = $item->teams->away->name;
            
            if ($item->fixture->status->short == 'FT') {
                $result = $item->goals->home . '-' . $item->goals->away;

                $data[$i]['result'] = $result;
            }

            $i++;
        }

        array_multisort(array_column($data, 'datetime'), SORT_ASC, $data);

        return view('export.fixture', compact('data'));
    }

    public function lineups($fixture)
    {
        $response = http()
                ->withHeaders([
                    'x-rapidapi-host' => 'v3.football.api-sports.io',
                    'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
                ])
                ->get('https://v3.football.api-sports.io/fixtures/lineups', [
                    'fixture' => $fixture
                ]);

        $response = json($response->body())->response;

        $data['local']['team'] = $response[0]->team->name;
        $data['local']['formation'] = $response[0]->formation;

        for ($i = 0; $i <= 10; $i++) { 
            $data['local']['startXI'][$i]['number'] = $response[0]->startXI[$i]->player->number;
            $data['local']['startXI'][$i]['name'] = $response[0]->startXI[$i]->player->name;
        }

        for ($i = 0; $i < count($response[0]->substitutes); $i++) {
            $data['local']['substitutes'][$i]['number'] = $response[0]->substitutes[$i]->player->number;
            $data['local']['substitutes'][$i]['name'] = $response[0]->substitutes[$i]->player->name;
        }

        $data['local']['coach'] = $response[0]->coach->name;

        $data['away']['team'] = $response[1]->team->name;
        $data['away']['formation'] = $response[1]->formation;

        for ($i = 0; $i <= 10; $i++) { 
            $data['away']['startXI'][$i]['number'] = $response[1]->startXI[$i]->player->number;
            $data['away']['startXI'][$i]['name'] = $response[1]->startXI[$i]->player->name;
        }

        for ($i = 0; $i < count($response[1]->substitutes); $i++) {
            $data['away']['substitutes'][$i]['number'] = $response[1]->substitutes[$i]->player->number;
            $data['away']['substitutes'][$i]['name'] = $response[1]->substitutes[$i]->player->name;
        }

        $data['away']['coach'] = $response[1]->coach->name;

        $array = [count($data['away']['substitutes']), count($data['local']['substitutes'])];
        $max = max($array); 

        return view('export.lineups', compact('data', 'max'));
    }

    public function stats($fixture = '')
    {
        $response = http()
            ->withHeaders([
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
            ])
            ->get('https://v3.football.api-sports.io/fixtures/statistics', [
                'fixture' => $fixture
            ]);

        $response = json($response->body())->response;

        foreach ($response as $item) {
            $data[$item->team->name]['corners'] = $item->statistics[7]->value ?? 0;
            $data[$item->team->name]['shots'] = $item->statistics[2]->value ?? 0;
            $data[$item->team->name]['shots_on_goal'] = $item->statistics[4]->value ?? 0;
            $data[$item->team->name]['fouls'] = $item->statistics[6]->value ?? 0;
            $data[$item->team->name]['offside'] = $item->statistics[8]->value ?? 0;
            $data[$item->team->name]['possession'] = $item->statistics[9]->value;
            $data[$item->team->name]['yellows'] = $item->statistics[10]->value ?? 0;
            $data[$item->team->name]['reds'] = $item->statistics[11]->value ?? 0;
            $data[$item->team->name]['expected_goals'] = $item->statistics[16]->value ?? '-';
            $data[$item->team->name]['passes'] = $item->statistics[13]->value ?? 0;
            $data[$item->team->name]['successfulPasses'] = $item->statistics[14]->value ?? 0;
        }

        if (! isset($data)) {
            return 'No hay info para este partido';
        }

        $local = array_keys($data)[0];
        $away = array_keys($data)[1];

        return view('export.stats', compact('data', 'local', 'away'));
    }

    public function score($fixture)
    {
        $response = http()
            ->withHeaders([
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
            ])
            ->get('https://v3.football.api-sports.io/fixtures/lineups', [
                'fixture' => $fixture
            ]);

        $response = json($response->body())->response;

        $data['local']['team_id'] = $response[0]->team->id;
        $data['local']['team'] = $response[0]->team->name;
        $data['local']['logo'] = $response[0]->team->logo;

        $data['away']['team_id'] = $response[1]->team->id;
        $data['away']['team'] = $response[1]->team->name;
        $data['away']['logo'] = $response[1]->team->logo;

        $response = http()
            ->withHeaders([
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
            ])
            ->get('https://v3.football.api-sports.io/fixtures/events', [
                'fixture' => $fixture,
                'type' => 'Goal'
            ]);

        $response = json($response->body())->response;

        $i = 0;

        foreach ($response as $item) {
            $data['goals'][$i]['detail'] = $item->detail;
            $data['goals'][$i]['team'] = $item->team->name;
            $data['goals'][$i]['player'] = $item->player->name;
            $data['goals'][$i]['time'] = $item->time->elapsed;

            $i++;
        } 

        return view('export.score', compact('data'));
    }

    public function export()
    {
        $request = request();
        $request['copy'] = 1;

        if (request('league') == '344' || request('league') == '964') {
            $request['bolivia'] = 1;
        }

        $queryString = http_build_query($request);

        return redirect('/export?' . $queryString);
    }

    public function referees($fixture)
    {
        $response = http()
            ->withToken($this->token)
            ->get('https://api.performfeeds.com/soccerdata/matchstats/' . $this->outletKey . '/' . $fixture . '?detailed=yes&_rt=b&_fmt=json');

        $referees = json($response->body())->liveData->matchDetailsExtra->matchOfficial;

        return view('export.referees', compact('referees'));
    }
}
