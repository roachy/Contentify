<h1 class="page-title">{!! HTML::fonticon('trophy') !!} All Cups &nbsp;
</h1> 

<div class='container-fluid'>
	@foreach ($cups as $cup)
			<div class='col-md-6 text-center'>
					<h2>{{ $cup->title }}</h>
					<h3>{{ $cup->game->title }}</h3>
				<a href="{{ url('cups/'.$cup->id.'/'.$cup->slug) }}">
					@if ($cup->image)
						<div class="image" style="margin:0 auto;">
							<img height=200px width=200px class='img' src="{{ $cup->uploadPath().$cup->image }}" alt="{{ $cup->title }}">
						</div>
					@endif
					<br />
					<div class='well' style="background-color:#000">
						@if( $cup->countParticipants() >=  $cup->slots )
							<b style="color:red"> This is full and is no longer open to entries </b><br />
						@else
							<h4>{{ $cup->countParticipants() }} / {{ $cup->slots }}</h4>
						@endif
						<!-- Between check_in_at and start_at -->
                        <?php $participant = $cup->getParticipantOfUser(user()) ?>
                        @if ($participant)
                            @if (!$cup->hasParticipantCheckedIn($participant))
                                {{ trans('cups::in') }}
                            @else
								<b style="color:green"> You have entered into this cup </b>
							@endif
                        @else
                            {{ trans('cups::not_participating') }}
                        @endif                        
					 </div>
				</a>
			</div>
	@endforeach
</div>
</br>

<div class="text-center">
	{{ $cups->links() }}
</div>