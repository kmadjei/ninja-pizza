<?php
	
	//connect to the database template
	include('config/db_connect.php');

	$name = $email = $title = $ingredients = '';
	$errors = array('name' => '','email' => '', 'title' => '', 'ingredients' => '');

	//form validations when its submitted
	if(isset($_POST['submit'])){

		session_start();
		
		// check name
		if(empty($_POST['name'])){
			$errors['ename'] = 'A name is required';
		}

		// check email
		if(empty($_POST['email'])){
			$errors['email'] = 'An email is required';
		} else{
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors['email'] = 'Email must be a valid email address';
			}
		}

		// check title
		if(empty($_POST['title'])){
			$errors['title'] = 'A title is required';
		} else{
			$title = $_POST['title'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
				$errors['title'] = 'Title must be letters and spaces only';
			}
		}

		// check for ingredients
		if(empty($_POST['ingredients'])){
			$errors['ingredients'] = 'At least one ingredient is required';
		} else{
			$ingredients = $_POST['ingredients'];
			if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
				$errors['ingredients'] = 'Ingredients must be a comma separated list';
			}
		}

		# checks if errors exist
		if(array_filter($errors)){
			//echo 'errors in form';
		} else {

			// pass name to session superglobal
			$_SESSION['name'] = $_POST['name'];

			// Escapes special characters - mysqli_real_escape_string
			//create a legal SQL string that you can use in an SQL statement
			// get the form values
			$name = mysqli_real_escape_string($conn, $_POST['email']);
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$title = mysqli_real_escape_string($conn, $_POST['title']);
			$ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

			//  sql query to add to the pizza record
			$sql = "INSERT INTO pizzas(title,email,ingredients) VALUES('$title','$email','$ingredients')";

			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success -> redirect to the index page
				header('Location: index.php');
			} else {
				echo 'query error: '. mysqli_error($conn);
			}

		}

	} // end POST check

?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

	<section class="container grey-text">
		<h4 class="center">Add a Pizza</h4>
		<!-- 
			htmlspecialchars():
			- converts special characters to HTML entities. 
			- protect against Cross-site Scripting attacks (XSS)
		-->
		<form class="white" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
			<label for="name">Name</label>		
			<input type="text" id="name" name="email" pattern="^[a-zA-Z0-9]{5,15}$" value="<?php echo htmlspecialchars($email) ?>">
			<div class="red-text"><?php echo $errors['name']; ?></div>
			<label for="email">Your Email</label>		
			<input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email) ?>">
			<div class="red-text"><?php echo $errors['email']; ?></div>
			<label>Pizza Title</label>
			<input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
			<div class="red-text"><?php echo $errors['title']; ?></div>
			<label>Ingredients (comma separated)</label>
			<input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
			<div class="red-text"><?php echo $errors['ingredients']; ?></div>
			<div class="center">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>

	<?php include('templates/footer.php'); ?>

</html>