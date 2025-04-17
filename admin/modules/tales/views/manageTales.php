<div style="display: flex; justify-content: center; align-items: center; height: 100vh; flex-direction: column;">
    <div class="addTal" style="align-items:center;">
        <button class="addTale" onclick="location.href='<?php echo SITEURL; ?>tales/addTale'">+ Add Tales</button>
    </div>
    
    <table style="border: 1px solid black; border-collapse: collapse; margin: 20px; width: 80%;">

        <thead>

            <tr style="background-color: #f2f2f2;">
                <th style="border: 1px solid black; padding: 10px;">Title</th>
                <th style="border: 1px solid black; padding: 10px;">Status</th>
                <th style="border: 1px solid black; padding: 10px;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $this->talesList = (Array)$this->talesList->tales;
                foreach ($this->talesList as $val) {
            ?>
            <tr>
                <td style="border: 1px solid black; padding: 10px;"><?php echo $val->tale_title; ?></td>
                <td style="border: 1px solid black; padding: 10px;"><?php echo $val->tale_status; ?></td>
                <td style="border: 1px solid black; padding: 10px;">
                    <div style="display: inline-block; margin-right: 10px;">
                      <button>
                        <a href="<?php echo SITEURL; ?>tales/editTale/<?php echo $val->tale_id; ?>" class="text-muted">edit</a>
                        </button>

                    </div>
                    <div style="display: inline-block;">
                       <button data-id="<?php echo $val->tale_id; ?>">
                        <a href="<?php echo SITEURL; ?>tales/deleteTale/<?php echo $val->tale_id; ?>" class="text-muted deleteTale">delete</a>
                      </button>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<?php/*<script type="text/javascript"> 

        $(document).on('click', '.deletePage', function() { 
            var delId = $(this).closest('button').data('id');
            console.log(delId);
            bootbox.confirm({
            title: "<strong>Confirmation</strong> Box",
                message: "Are you sure, you want to delete?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                  if(result) {            
                    jQuery.ajax({
                        type: "POST",             
                        url:"<?php echo SITEURL; ?>pages/deleteTale",
                        data: 'tale_id='+ delId,
                        success: function(data) {
                            document.location.reload();
                        }
                    });
                  }
                }
            });
        });
     

</script>*/?>
