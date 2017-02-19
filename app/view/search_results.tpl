<!DOCTYPE html>
<html lang="en">

<body>
	<div class="container">
		<div class="row">
			<h1>Search Results</h1>
		</div>
		<?php foreach ($track_listing as $track): ?>
			<div class="row">
				<div class="col-sm-2">
					<img class="img-responsive" src="<?php echo $track->album->images[0]->url ?>" alt="" width="64" height="64">
				</div>
				<div class="col-sm-8">
					<p>Song name: <?php echo $track->name ?></p>
					<p>Song Artist: <?php echo $track->artists[0]->name ?></p>
				</div>
				<div class="col-sm-2">
						<form>
							<button class="btn btn-default" type="submit">Propose vote</button>
						</form>
				</div>
			</div>
			<br line-height: 2px></br>
		<?php endforeach; ?>
	</div>
</body>