@extends('base')

@section('title')
Classement
@endsection

@section('content')
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
                    @foreach($ranking as $row)
                    <tr class="@if(Cookie::get ('followed_team')==$row['team_id'])table-primary @endif">
                    <td>{{ $row['rank'] }}</td>
                        
                        <td><a href="{{route('teams.show', ['teamId'=>$row['team_id']])}}"> {{$row['name']}} </a></td>

                        <td>{{$row['match_played_count']}}</td>
                
                        <td>{{$row['won_match_count']}}</td>
                
                        <td>{{$row['draw_match_count']}}</td>
                
                        <td>{{$row['lost_match_count']}}</td>
                
                        <td>{{$row['goal_for_count']}}</td>
                
                        <td>{{$row['goal_against_count']}}</td>
                
                        <td>{{$row['goal_difference']}}</td>
                
                        <td>{{$row['points']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endsection































<!--<!doctype html>
<html>
    <head>Matchs joués par l'équipe :</head>
    <body>
  
    <table>
       
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
       
        
            @foreach ($ranking as $user)
                <tr>
                   <td>{{ $user['rank'] }}</td>
                   <td>{{ $user['name'] }}</td>
                   <td>{{ $user['match_played_count'] }}</td>
                   <td>{{ $user['won_match_count'] }}</td>
                   <td>{{ $user['draw_match_count'] }}</td>
                   <td>{{ $user['lost_match_count'] }}</td>
                   <td>{{ $user['goal_for_count'] }}</td>
                   <td>{{ $user['goal_against_count'] }}</td>
                   <td>{{ $user['goal_difference'] }}</td>
                   <td>{{ $user['points'] }}</td>
                </th>
            @endforeach
    
          
    
</table>


</body>
</html>--->