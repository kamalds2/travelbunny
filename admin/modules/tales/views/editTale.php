<div class="form" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    
    <form method="post" action="<?php echo SITEURL?>tales/updateTale" style="border: 1px solid black; padding: 20px; border-radius: 10px;">
        <input type="hidden" name="tale_id" value="<?php echo $this->tales[0]->tale_id; ?>">
        Tale_Title <input type="text" name="tale_title" value="<?php echo $this->tales[0]->tale_title; ?>" required><br><br>
        Status 
        <input type="radio" name="tale_status" value="Active" <?php if($this->tales[0]->tale_status == 'Active') echo "checked"; ?>>Active
        <input type="radio" name="tale_status" value="InActive" <?php if($this->tales[0]->tale_status != 'Active') echo "checked"; ?>>Inactive<br><br>
        <button type="submit">Submit</button>
        <button type="button" onclick="window.location.href='http://localhost/travel_bunny/admin/tales'">Back</button>
    </form>

</div>