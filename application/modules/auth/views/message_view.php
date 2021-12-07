<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <?php echo $this->session->flashdata('message');?>
        </div>
    </div>
    
</div>
