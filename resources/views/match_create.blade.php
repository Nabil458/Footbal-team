@extends('base')

@section('title', 'Création d\'un match')

@section('content')
<form method="post" action="{{route('matches.store')}}">
@csrf
@if ($errors->any())
        <div class="alert alert-warning">
            L'équipe n'a pas pu être ajoutée &#9785;
        </div>
    @endif
    <div class="form-group">
      <label for="team0">Équipe à domicile</label>
      <select class="form-control" id="team0" name="team0">
      @foreach($ranking as $row)
     <option value="{{$row['team_id']}}" @if ( $row['team_id'] == old('team0') ) selected @endif>{{$row['name']}}</option>
     @endforeach
     </select>
     @error('team0')
      <div id="team0_feedback" class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror

    </div>
    <div class="form-group">
      <label for="team1">Équipe à l'extérieur</label>
      <select class="form-control" id="team1" name="team1">
      @foreach($ranking as $row)
     <option value="{{$row['team_id']}}" @if ( $row['team_id'] == old('team1') ) selected @endif>{{$row['name']}}</option>
     @endforeach
      </select>
      @error('team1')
      <div id="team1_feedback" class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <div class="form-group">
      <label for="date">Date</label>
      <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date') }}">
      @error('date')
      <div id="date_feedback" class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <div class="form-group">
      <label for="time">Heure</label>
      <input type="time" class="form-control @error('time') is-invalid @enderror" id="time" name="time" value="{{ old('time') }}">
      @error('time')
      <div id="time_feedback" class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <div class="form-group">
      <label for="score0">Nombre de buts de l'équipe à domicile</label>
      <input type="number" class="form-control @error('score0') is-invalid @enderror" id="score0" name="score0" min="0" value="{{ old('score0') }}">
      @error('score0')
      <div id="score0_feedback" class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <div class="form-group">
      <label for="score1">Nombre de buts de l'équipe à l'extérieur</label>
      <input type="number" class="form-control @error('score1') is-invalid @enderror" id="score1" name="score1" min="0" value="{{ old('score1') }}">
      @error('score1')
      <div id="score1_feedback" class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <button type="submit" class="btn btn-primary">Soumettre</button>
</form>
@endsection