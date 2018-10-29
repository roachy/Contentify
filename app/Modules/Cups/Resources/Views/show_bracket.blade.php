    <?php $rows = $cup->slots // Inital value - not correct! ?>
    <?php $matches = $cup->matchesDetailed() ?>
    <?php $lastRound = '' ?>
	
	
@if($cup->type == 1)
<div class="bracket" style="min-width: {{ $cup->rounds() * 200 }}px">
    @for ($round = 1; $round < $cup->rounds(); $round++)
        <?php $rows = ceil($rows / 2) ?>
        <?php $roundMatches = $matches->where('round', $round) ?>

        <ul class="round round-{{ $round }}">
            @for ($row = 1; $row <= $rows; $row++)
                <?php $match = $roundMatches->where('row', $row)->pop(); ?>

                @if ($match)
                    <li class="spacer">&nbsp;</li>

                    <li class="match match-top <?php if ($match->winner_id and $match->winner_id == $match->left_participant_id) echo 'winner' ?>" data-id="{{ $match->left_participant_id }}"> 
                        @include('cups::participant', ['cup' => $cup, 'participant' => $match->left_participant])
                        <span class="score">{{ $match->left_score }}</span>
                    </li>
                    <li class="match match-spacer"><a href="{{ url('cups/matches/'.$match->id) }}">{{ trans('matches::vs') }}</a></li>
                    <li class="match match-bottom <?php if ($match->winner_id and $match->winner_id == $match->right_participant_id) echo 'winner' ?>" data-id="{{ $match->right_participant_id }}">
                        @include('cups::participant', ['cup' => $cup, 'participant' => $match->right_participant])
                        <span class="score">{{ $match->right_score }}</span>
                    </li>
                @else
                    <?php // Match not yet created ?>
                    
                    <li class="spacer">&nbsp;</li>

                    <li class="match match-top">-</li>
                    <li class="match match-spacer">{{ trans('matches::vs') }}</li>
                    <li class="match match-bottom ">-</li>
                @endif
               
                @if ($round == $cup->rounds() - 1)
                    <?php
                        // Last round (the final match)

                        $winner = '-';
                        if ($match and $match->winner_id == $match->left_participant_id) {
                            $winner = view('cups::participant', ['cup' => $cup, 'participant' => $match->left_participant]);
                        }
                        if ($match and $match->winner_id == $match->right_participant_id) {
                            $winner = view('cups::participant', ['cup' => $cup, 'participant' => $match->right_participant]);
                        }
                        $lastRound .= 
                            '<li class="spacer">&nbsp;</li>
                            <li class="match match-top winner"> '.$winner.'</li>';
                    ?>
                @endif
            @endfor
            <li class="spacer">&nbsp;</li>
        </ul>
    @endfor

    <ul class="round round-{{ $round + 1 }} round-last">
        {!! $lastRound !!}
        <li class="spacer">&nbsp;</li>
    </ul>
</div>
@endif

@if($cup->type == 2)
<div class="brackets">
	<table class="table">
		<tr>
			<th> Participant </th>
			<th> Matches Won </th>
		</tr>
		
		
		@foreach($cup->participants->reverse()  as $participant)
			<?php 
				$wins = App\Modules\Cups\Match::whereWinnerId($participant->id)
				->whereCupId($cup->id)
				->count(); 
			?>
			<tr>
				<td>{!! view('cups::participant', ['cup' => $cup, 'participant' => $participant]) !!}</td>
				<td>{{ $wins }}</td>
			</tr>
		@endforeach
		
	</table>
</div>
@endif
