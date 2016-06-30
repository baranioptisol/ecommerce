<h1>Laravel and Jcrop</h1>

<form action="{{ URL::route('imageform')}}" method="post">
	<label>My Image</label>
	<input type="file" name="image" />
	<input type="submit" value="Upload"/>
</form>