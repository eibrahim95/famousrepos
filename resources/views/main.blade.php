<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Famous Github Repos Discoverer</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap5 -->
    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito';
        }
        .pagination {
            justify-content: center;
        }
        table {
            table-layout: fixed;
        }
    </style>
</head>
<body >
<div class="container bg-secondary text-light">
    <div class="row">
        <div class="col-12">
            <h2><a class="text-light" href="{{route('home')}}">Famous Github Repos Discoverer</a></h2>
            <hr>
        </div>
        <div class="col-12 col-md-4">
            <h4 class="w-100">Input</h4>
            <hr>
            <form action="{{route('search')}}">
                <div class="mb-3">
                    <label for="start-date" class="form-label">Start Date</label>
                    <input type="date" class="form-control @if ($errors->has('start_date')) is-invalid @endif" id="start-date" placeholder="Start Date" required name="start_date"
                           value="{{old('start_date')?:(Request::get('start_date')?:date('Y-m-d',strtotime("-1 days")))}}">
                    @if ($errors->has('start_date'))
                        <div class="invalid-feedback bg-light">
                            @foreach ($errors->get('start_date') as $message)
                            <li>{{$message}}</li>
                            @endforeach
                        </div>
                        @endif
                </div>
                <div class="mb-3">
                    <label for="repos-count" class="form-label">Number Of Repos</label>
                    <select class="form-select @if ($errors->has('count')) is-invalid @endif" aria-label="Default select example" id="repos-count" name="count">
                        <option value="" selected>All</option>
                        <option value="10" @if(old('count') && old('count') == '10') selected
                                            @elseif(Request::get('count') && Request::get('count') == '10') selected
                                            @endif>10</option>
                        <option value="50"@if(old('count') && old('count') == '50') selected
                                @elseif(Request::get('count') && Request::get('count') == '50') selected
                            @endif>50</option>
                        <option value="100"@if(old('count') && old('count') == '100') selected
                                @elseif(Request::get('count') && Request::get('count') == '100') selected
                            @endif>100</option>
                    </select>
                    @if ($errors->has('count'))
                        <div class="invalid-feedback bg-light">
                            @foreach ($errors->get('count') as $message)
                                <li>{{$message}}</li>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="lang" class="form-label">Programming Language</label>
                    <input class="form-control" type="text" placeholder="All languages" id="lang" name="lang"
                    value="{{old('lang')?:(Request::get('lang')?:'')}}">
                </div>
                <div class="mb-3 text-center">
                    <input type="submit" class="btn btn-primary" value="Submit">
                </div>

            </form>
        </div>
        <div class="col-12 col-md-8">
            <h4 class="w-100">Result @isset($total)({{$total}})@endisset</h4>
            @if(isset($success) && $success == true)
            @isset($data)
            @if($incomplete_results)
                <label class="w-100 alert alert-warning">
                    These Results are not complete see :
                    <a href="https://docs.github.com/en/rest/reference/search#timeouts-and-incomplete-results" target="_blank">HERE</a> To know why.
                </label>
                @endif
            <hr>
            <div class="text-center">
                {!! $data->links() !!}
            </div>
            <table class="table text-light">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Created</th>
                    <th>Stars <i class="fa fa-star"></i></th>
                    <th>Language</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data->items() as $item)
                <tr>
                    <td><a class="text-light" href="{{$item['owner']['html_url']}}" target="_blank">{{$item['owner']['login']}}</a> /
                        <a class="text-light" href="{{$item['html_url']}}" target="_blank">{{$item['name']}}</a></td>
                    <td>{{Str::limit($item['description'], 50)}}</td>
                    <td>{{$item['created_at']}}</td>
                    <td>{{$item['stargazers_count']}}</td>
                    <td>{{$item['language']}}</td>
                </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-center">
            {!! $data->links() !!}
            </div>
                @else
                <p>Results will show here</p>
                @endisset

            @elseif(!isset($success))
                <p>Results will show here</p>
            @else
                <label class="w-100 alert alert-danger">There was a problem connecting to github api, pls try again later</label>
            @endif
        </div>
    </div>
</div>
</body>
</html>
