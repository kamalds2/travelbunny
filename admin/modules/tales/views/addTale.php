<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">


						<form method="post" action="<?php echo SITEURL?>tales/createTale" style="border: 1px solid black; padding: 20px; border-radius: 10px;">

					    		Page_Title	<input type='text' name='tale_title' Required><br><br>
					    		Status <input type='radio' name='tale_status' value='Active'>Active
					    				<input type="radio" name='tale_status' value='InActive'>InActive<br><br>
					    		<button type='submit'>Submit</button>
					    		<button onclick="window.location.href='http://localhost/travel_bunny/admin/tales'">back</button>

					    </form>



</div>