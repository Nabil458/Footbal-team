@extends('base')

@section('title')
Matchs de l'équipe
@endsection

@section('content')


    <!--<table>
        @foreach ($result as $item)
            <tr>
                <td>{{$item['date']}}</td>

                <td>{{$item['name0']}}</td>

                <td>{{$item['score0']}} <span>-</span> {{$item['score1']}}</td>

                <td>{{$item['name1']}}</a>
                </td>
            </tr>
        @endforeach
    </table>-->
    <a class="btn btn-primary" href="{{ route('teams.follow', ['teamId'=>$result2['team_id']]) }}">Suivre</a><br><br>
    <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>N°</th> 
                        <th>Équipe</th>
                        <th>MJ</th>
                        <th>G</th>
                        <th>N</th>
                        <th>P</th>
                        <th>BP</th>
                        <th>BC</th>
                        <th>DB</th>
                        <th>PTS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>{{ $result2['rank'] }}</td>
            
            <td><a href="{{route('teams.show', ['teamId'=>$result2['team_id']])}}">{{$result2['name']}}</a></td>

            <td>{{$result2['match_played_count']}}</td>
    
            <td>{{$result2['won_match_count']}}</td>
    
            <td>{{$result2['draw_match_count']}}</td>
    
            <td>{{$result2['lost_match_count']}}</td>
    
            <td>{{$result2['goal_for_count']}}</td>
    
            <td>{{$result2['goal_against_count']}}</td>
    
            <td>{{$result2['goal_difference']}}</td>
    
            <td>{{$result2['points']}}</td>
                    </tr>
                   
                </tbody>
            </table>
    <table class="table table-striped">
    @foreach ($result as $item)
            <tr>
                <td>{{$item['date']}}</td>
                

                <td><a href="{{route('teams.show', ['teamId'=>$item['team0']])}}">{{$item['name0']}}</a>
                </td>

                <td>{{$item['score0']}} <span>-</span> {{$item['score1']}}</td>

                <td><a href="{{route('teams.show', ['teamId'=>$item['team1']])}}">{{$item['name1']}}</a>
                </td>
            </tr>
        @endforeach
        </table>
        @endsection


