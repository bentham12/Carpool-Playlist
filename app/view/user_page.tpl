<!DOCTYPE html>
<html lang="en">

<body>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-3">
                <p class="lead">Collaborative Playlists</p>
                <div class="list-group">
          <?php if (isset($playlist)): ?>
					<?php foreach ($collabPlay as $playlist): ?>
					<?php if (isset($_SESSION['plID']) && $playlist->id == $_SESSION['plID']): ?>
						<a href="<?=BASE_URL?>/selectlist/<?php echo $playlist->id ?>" class="list-group-item active"><?php echo $playlist->name ?></a>
					<?php else: ?>
						<a href="<?=BASE_URL?>/selectlist/<?php echo $playlist->id ?>" class="list-group-item"><?php echo $playlist->name ?></a>
					<?php endif; ?>
					<?php endforeach; ?>
          <?php else: ?>
            <p>Looks like you don't have any collaborative playlists. :(</p> <!-- should create a way/link for them to make a collaborative playlist-->
          <?php endif; ?>
                </div>
            </div>

            <div class="col-md-9">

                <div class="thumbnail">
                    <img class="img-responsive" src="<?php echo $_SESSION['plURL'] ?>" alt="">
                    <div class="caption-full">
                        <h4 class="pull-right">$24.99</h4>
                        <h4><a href="#">Product Name</a>
                        </h4>
                        <p>See more snippets like these online store reviews at <a target="_blank" href="http://bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                        <p>Want to make these reviews work? Check out
                            <strong><a href="http://maxoffsky.com/code-blog/laravel-shop-tutorial-1-building-a-review-system/">this building a review system tutorial</a>
                            </strong>over at maxoffsky.com!</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                    </div>
                    <div class="ratings">
                        <p class="pull-right">3 reviews</p>
                        <p>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            4.0 stars
                        </p>
                    </div>
                </div>

                <div class="well">

                    <div class="text-left">
                        <p>Voting</p>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-sm-2">
                            <img class="img-responsive" src="http://placehold.it/128x128" alt="" width="64" height="64">
                        </div>
						<div class="col-sm-8">
                            <p>Song name</p>
							<p>Song Artist</p>
                        </div>
						<div class="col-sm-2">
							<div class="col-sm-6">
								<form>
									<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-ok"></i></button>
								</form>
							</div>
							<div class="col-sm-6">
								<form>
									<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-remove"></i></button>
								</form>
							</div>
							<p class="text-center">Vote info</p>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
