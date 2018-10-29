<style type="text/css">
	.well{background:#000;color#fff;}
</style> 

@if($users)
<div class="well">
<h4> Visitors to date </h4>
	@widget('Visitors::Visitors')
	<table class="table">
		<tbody>
			@foreach ($users as $user)
				<tr>
					<td><b>{!! link_to('users/'.$user->id.'/'.$user->slug, $user->username) !!}</b></td>
					<td><a class="btn btn-default" href="{!! url('messages/create/'.$user->username) !!}" title="{!! trans('users::send_msg') !!}">{!! HTML::fontIcon('envelope') !!}</a></td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endif
